<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
/*thư viện dùn để dump db to sql file*/
use Ifsnop\Mysqldump as IMysqldump;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Backup;
use App\Setting; 
use Illuminate\Support\Facades\File;

class BackupController extends Controller
{
    //
    public function index(){
    	
    	//echo env('DB_DATABASE').'<br>';
    	//echo env('DB_USERNAME').'<br>';
    	//echo env('DB_PASSWORD').'<br>';
    	//date_default_timezone_set('Asia/Kolkata');
		//$timestamp = date("Y-m-d H:i:s");
		//echo $timestamp;
        /*
            $today = getdate();
        $phut=$today['minutes'];
        $gio=$today['hours'];
        $thu=$today['wday'];
        $ngay=$today['mday'];
        
        echo 'phút:'.$phut.'<br>';
        echo 'gio:'.$gio.'<br>';
        echo 'thứ:'.$thu.'<br>';   
        echo 'ngay:'.$ngay.'<br>';  
        */
        
        //$bkt=explode(",",Setting::getconfig('config_backup_time'));
        //print_r($bkt); 
        
    	$bk = Backup::orderBy('id', 'DESC')->paginate(Setting::where("key","=",'config_dossier_limit')->first()->value);

    	$data=array();
    	/*số thứ tự bắt đầu*/
        if(isset($_GET['page'])){
            $data['startpage']=($_GET['page']-1)*Setting::getconfig('config_dossier_limit')+1;
        }
        else $data['startpage']=1;  

        return view('admin.backup.index',['bk'=>$bk,'data'=>$data]);

    }	
    
    public function create(){
    	try {
            Setting::taofilebackup();
            //------------
		    return redirect('admin/backup')->with('messenger', 'Backup thành công.');

		} catch (\Exception $e) {
		    //echo 'mysqldump-php error: ' . $e->getMessage();
		    return redirect('admin/backup')->with('messenger','mysqldump-php error: ' . $e->getMessage());
		}
		
    }
    public function restore1($id){
    	$bk=Backup::find($id);
    	echo $bk->url;

    }	

    
    public function restore($id){
        $mess='';$checkbk=1;
        while($checkbk==1 && $id>0){
            $bk=Backup::find($id);
            if(count($bk)>0)
            if(file_exists($bk->url)){
                /*xoa het bang tru bang backup*/
                DB::statement('SET FOREIGN_KEY_CHECKS = 0');
                $tables = DB::select('SHOW TABLES');
                $databasename='Tables_in_'.env('DB_DATABASE');
                foreach($tables as $value)
                if($value->$databasename!='backup')
                    Schema::dropIfExists($value->$databasename);
                DB::statement('SET FOREIGN_KEY_CHECKS = 1');
                //---------
                $sql_dump =file_get_contents($bk->url);
                try {$checkbk=DB::connection()->getPdo()->exec($sql_dump);}
                catch (Exception $e) {}
                //-----
                if($checkbk==1) $mess.='Phục hồi file Backup '.$bk->title.' bị Lỗi; ';
                else $mess.='Phục hồi file Backup '.$bk->title.' thành công; ';
            }
            else
                if($mess=='')/*nếu là lần đầu xét file ko có thì thoát luôn*/ 
                {$mess='Không tồn tại file Backup '.$bk->title;$checkbk=0;}
                else
                {$mess.='File Backup '.$bk->title.' không tồn tại; ';}
            //--------
            $id--;
        }
        return redirect('admin/backup')->with('messenger', $mess);    
    }
    public function Backupdelete($id){
  		$bk=Backup::find($id);
  		File::delete(base_path($bk->url));
    	$bk = Backup::where('id',$id)->delete();
		return redirect('admin/backup')->with('messenger', 'Xóa Backup thành công.');
    }
    public function Backupdownload($id){
        $bk=Backup::find($id);
        $filepath=base_path($bk->url);
        if(file_exists($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            flush(); // Flush system output buffer
            readfile($filepath);
           // exit;

        }
        else return redirect('admin/backup')->with('messenger', 'Không tồn tại file Backup.');
        
    }
    public function Backupupload(){
 

        return view('admin.backup.upload');
    } 

    public function storebackupupload(Request $request){

 


        
       /*---upload file*/
        if ($request->hasFile('fileuploadbackup')) {
            $file = $request->file('fileuploadbackup');
            $tenfile=$file->getClientOriginalName();   
            $target_file=public_path().'/avatars/'.$tenfile;
            $FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $path='storage/backups/';
            if($FileType=='sql'){
                $bk= new Backup;
                $bk->title='Upload-'.date('d-m-Y_H-i-s').'-backup.sql';
                $bk->url=$path.date('d-m-Y_H-i-s').'-'.Str::random(9).'-backup.sql';  
                $bk->save();  
                $target_file=$bk->url;
                move_uploaded_file($_FILES["fileuploadbackup"]["tmp_name"], $target_file);
                return redirect('admin/backup')->with('messenger', 'Upload Thành Công' );
            }
            else 
            return redirect('admin/backup')->with('messenger', 'File Backup không hợp lệ');


            

            
        }
    }

    
}


//DB::unprepared(File::get('public/backups/2019-05-17-02-59-40backup.sql'));
//$sql = mysqli_connect('localhost', 'phonglg', '1234', '');
//$sqlSource = file_get_contents('public/backups/2019-05-17-02-59-40backup.sql');

//mysqli_multi_query($sql,$sqlSource);

//$sql=file_get_contents('public/backups/2019-05-17-02-59-40backup.sql');
/*
foreach (explode(";\n", $sql) as $sql) {
	$sql = trim($sql);

	if ($sql) {
		//$this->db->query($sql);
		DB::connection()->getPdo()->exec($sql);
	}
}
*/