<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	 <!--
	 <script src="{{ asset('public/js/app.js') }}" ></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
	 -->
	@yield ('title')
	<link href="<?php echo e(asset('/public/css/all.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('/public/css/font-awesome.min.css')); ?>" rel="stylesheet">
	 
	@yield ('style')
	<script src="<?php echo e(asset('/public/js/jquery.min.js')); ?>"></script>
	<link rel="shortcut icon" href="{{url('/')}}/public/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="<?php echo e(asset('/public/css/bootstrap.min.css')); ?>">  
	<script src="<?php echo e(asset('/public/js/bootstrap.min.js')); ?>"></script>
	<link href="<?php echo e(asset('/public/plg/stylesheet/stylesheet.css')); ?>" rel="stylesheet">
	<script src="<?php echo e(asset('/public/plg/common.js')); ?>"></script>
	<link href="<?php echo e(asset('/public/css/custom.css')); ?>" rel="stylesheet"> 
</head>
<body  >
	 
		@include ('admin.layouts.header')
		@include ('admin.layouts.menu')
		<!-- Content Wrapper. Contains page content -->
		<div id="content">
		  <div class="page-header">
		    <div class="container-fluid">
			@yield ('content')
	    </div>
	    </div>
	    @include ('admin.layouts.footer')
	    </div>
		
		<div class="control-sidebar-bg"></div>
 	
	<!-- ./wrapper -->
	<!-- jQuery 3 -->
    <script src="<?php echo e(asset('/public/js/bootstrap-datetimepicker.min.js')); ?>"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo e(asset('/public/js/adminlte.min.js')); ?>"></script>
	@yield('script')

<script>
	//check danh gia trung bình
function checkdanhgiatrungbinh(){
  $.ajaxSetup({headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
  var urll="{{ url('ajax/checkdanhgiatrungbinh') }}";//alert(urll);
  $.ajax({
      url: urll,
      type: "GET",
      data: {'active' : 1},
      success:function (data) {
        //alert("YES");//alert(data['success']);
        str='';
        for(i=0;i<data.length;i++)
        str+=data[i];
        //alert(data[0]);
         if(str!=''){
              str="<div style='text-align:left'>"+str+"</div>";
              let timerInterval
              Swal.fire({
                title: 'Khảo sát chưa hài lòng',
                html: str,
                timer: 20000,
                timerProgressBar: true,
                onBeforeOpen: () => {
                },
                onClose: () => {
                  clearInterval(timerInterval)
                }
              }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                  console.log('I was closed by the timer')
                }
              })
         }
      },
      error:function () {//alert("NO");
          console.log("i cant's run. Please check bug!");
      }
  });
} 

checkdanhgiatrungbinh(); 
$(document).ready(function(){
  setInterval(function(){ 
    checkdanhgiatrungbinh();
  }, 10000);   
});

//end check danh gia trung bình
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
</body>
</html>
