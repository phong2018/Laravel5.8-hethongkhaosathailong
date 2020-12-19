<?php
session_start();
if(!isset($_SESSION['success'])) $_SESSION['success']  = array();
if(!isset($_SESSION['error'])) $_SESSION['error']  = array();

function zip($sources= array(),$zipfilename='myarchive.zip'){
	$timeout = 5000;
	@set_time_limit($timeout);
	ini_set('max_execution_time', $timeout);
	
	$zip = new ZipArchive();
	
	if ($zip->open($zipfilename, ZipArchive::CREATE) !== TRUE) {
		$_SESSION['error'][] =  "Không thể nén tệp $zipfilename";
	}
	foreach($sources as $source){
		if(is_dir($source)){
			$dirlist = new RecursiveDirectoryIterator($source);
			$filelist = new RecursiveIteratorIterator($dirlist);
		}else{
			$filelist[$source] = $source;
		}
		
		foreach ($filelist as $key=>$value) {
			$basename = (string)pathinfo($key,PATHINFO_BASENAME);
			if($basename != ".." && $basename != "."){
				if(file_exists(realpath($key))) $zip->addFile(realpath($key), $key) or die ("LỖI: Không thể thêm tệp: $key vào $zipfilename");
			}
		}
		unset($filelist);
	}
	
	$zip->close();
	$_SESSION['success'][] = 'Thành công: Nén tệp <a href="http://'.$_SERVER['SERVER_NAME'].'/'.$zipfilename.'" target="_blank">'.$zipfilename.'</a>';

}

function unzip($sources = array(),$path = ''){
	foreach($sources as $source){
		$zip = new ZipArchive();
		if ($zip->open($source) === true) {
			if(empty($path)){
				$path = dirname($source).'/';
			}
			$zip->extractTo($path);
			$zip->close();
		} else {
			$_SESSION['error'][] =  "Giải nén $source không thành công.";
		}
		
		$_SESSION['success'][] =  "Giải nén $source thành công.";
		
	
	}
}

function processDel($str) {
    if (is_file($str)) {
        return @unlink($str);
    }elseif (is_dir($str)) {
        $scan = glob(rtrim($str,'/').'/{,.}*',GLOB_BRACE);
        foreach($scan as $index=>$path) {
			$basename = (string)pathinfo($path,PATHINFO_BASENAME);
			if($basename != ".." && $basename != "."){
            	processDel($path);
			}
        }
        return @rmdir($str);
    }
}

function delete($sources = array()){
	foreach($sources as $source) {
		processDel($source);
		$_SESSION['success'][] =  "Xóa $source thành công.";
	}
	

}

if(isset($_REQUEST['action'])){
	$_SESSION['success']  = array();
	$_SESSION['error']  = array();
	
	if($_REQUEST['action'] == 'zip'){
		$flag = 0;
		if(isset($_POST['file']) && !empty($_POST['file'])){
			$sources = $_POST['file'];
		}else{
			$_SESSION['error'][] = 'Dữ liệu nhập vào trống!';
			$flag = 1;
		}
		
		if(isset($_POST['name']) && !empty($_POST['name'])){
			$zipfilename = $_POST['name'].'-'.date('Y-m-d--H-i-s').'.zip';
		}else{
			$zipfilename = 'myarchive'.'-'.date('Y-m-d--H-i-s').'.zip';
		}
		
		if($flag == 0){
			zip($sources,$zipfilename);
		}
	}
	
	if($_REQUEST['action'] == 'unzip'){
		$flag = 0;
		if(isset($_POST['file']) && !empty($_POST['file'])){
			$sources = $_POST['file'];
		}else{
			$_SESSION['error'][] = 'Dữ liệu nhập vào trống!';
			$flag = 1;
		}
		
		if($flag == 0){
			unzip($sources,dirname(__FILE__));
		}
	}
	
	if($_REQUEST['action'] == 'delete'){
		$flag = 0;
		if(isset($_POST['file']) && !empty($_POST['file'])){
			$sources = $_POST['file'];
		}else{
			$_SESSION['error'][] = 'Source Folders is empty!';
		}
		
		delete($sources);
	}
	
}

?>

<html>
<head>
<title>Compress zip</title>
<style>
html,body{
	background: #F1F1F1;
}
.left{
	display: inline-block;
	width: 50%;
	text-align: left;
}
.right{
	display: inline-block;
	width: 50%;
	float: right;
	text-align: right;
}
#container{
	position: fixed;
    left: 25%;
    top: 10%;
    width: 50%;
    height: 80%;
    margin: auto;
}
#title{
	padding: 10px;
	font-size: 14px;
	font-weight: bold;
	background: #21A6FB;
	color: #FFF;
}
#content{
	background: #FBFBFB;
	height: 80%;
	overflow: auto;
}
#footer{
	background: #21A6FB;
	color: #FFF;
	padding: 10px;
}
.success{
	padding: 10px;
	line-height: 1.4;
	background: #C6F4B1;
}
.error{
	padding: 10px;
	line-height: 1.4;
	background: #FFC6C7;
}
</style>
<script>
function checkAll(ele) {
     var checkboxes = document.getElementsByTagName('input');
     if (ele.checked) {
         for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = true;
             }
         }
     } else {
         for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = false;
             }
         }
     }
}
</script>
</head>
<body>
<div id="container">
 <form name="filelist" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
  <div id="title">
    File lists
  </div>
  <div id="content">
    <?php
	  $base = dirname(__FILE__).'/';
	  if(isset($_REQUEST['dir']) && !empty($_REQUEST['dir'])){
		  $dir = $_REQUEST['dir'];
	  }else{
		  $dir = "";
	  }
	?>
    <?php if(!empty($dir)){ ?>
      <a id="base" href="<?php echo dirname($dir)== '.'? 'zip.php': 'zip.php?dir='.dirname($dir); ?>">...</a>
    <?php } ?>
    <?php
	  $filelists = scandir($base.$dir);
	  unset($filelists[0]);
	  unset($filelists[1]);
	  foreach($filelists as $source){
	?>
      <div>
        <input type="checkbox" name="file[]" value="<?php echo !empty($dir) ? $dir.'/'.$source : ''.$source; ?>">
        <?php if(!is_dir($base.$dir.'/'.$source)){ ?>
          <span><?php echo $source; ?></span>
        <?php }else{ ?>
          <a href="zip.php?dir=<?php echo !empty($dir) ? ($dir.'/'.$source) : (''.$source); ?>"><?php echo $source; ?></a>
        <?php } ?>
      </div>
    <?php } ?>
    <hr>
    <input type="checkbox" name="all" onchange="checkAll(this)">
	<div class="success">
      <?php foreach($_SESSION['success'] as $success) echo $success.'<br>'; unset($_SESSION['success']); ?>
    </div>
	<div class="error">
      <?php foreach($_SESSION['error'] as $error) echo $error.'<br>'; unset($_SESSION['error']); ?>
    </div>
  </div>
  <div id="footer">
    <div class="left">
      <input type="hidden" name="redirect" value="<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?>" />
      <input type="text" name="name" placeholder="ZIP File name">
    </div>
    <div class="right">
      <input type="radio" name="action" value="zip" checked="checked"><span>Compress</span>
      <input type="radio" name="action" value="unzip"><span>Extra</span>
      <input type="radio" name="action" value="delete"><span>Delete</span>
      <input type="submit" value="Submit">
    </div>
  </div>
 </form>
</div>
<?php

// current directory
echo getcwd() . "\n";

chdir('cvs');

// current directory
echo getcwd() . "\n";

?>
</body>
</html>