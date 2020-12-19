<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	@yield ('title')
    <link rel="stylesheet" href="<?php echo e(asset('/public/css/bootstrap-datetimepicker.min.css')); ?>">
	<link href="<?php echo e(asset('/public/css/app.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('/public/css/all.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('/public/css/icon.css')); ?>" rel="stylesheet"> 
	<link href="<?php echo e(asset('/public/css/font-awesome.min.css')); ?>" rel="stylesheet">
	<!-- Font Awesome 
	https://www.w3schools.com/icons/fontawesome_icons_intro.asp
	-->
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo e(asset('/public/css/AdminLTE.min.css')); ?>">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
	folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="<?php echo e(asset('/public/css/_all-skins.min.css')); ?>">
	<!-- Google Font
	https://www.w3schools.com/icons/fontawesome_icons_directional.asp
	 -->
	@yield ('style')

<script src="<?php echo e(asset('/public/js/jquery.min.js')); ?>"></script>
<link rel="stylesheet" href="<?php echo e(asset('/public/css/bootstrap.min.css')); ?>">  
<script src="<?php echo e(asset('/public/js/bootstrap.min.js')); ?>"></script>

<link href="<?php echo e(asset('/public/plg/stylesheet/stylesheet.css')); ?>" rel="stylesheet">
<script src="<?php echo e(asset('/public/plg/common.js')); ?>"></script>

</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">

		@include ('admin.layouts.header')
		@include ('admin.layouts.menu')

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper" style="padding: 1em">
			@yield ('content')
		</div>
		@include ('admin.layouts.footer')
		<div class="control-sidebar-bg"></div>
	</div>

	<!-- ./wrapper -->

	<!-- jQuery 3 -->
	
	<script src="<?php echo e(asset('/public/js/app.js')); ?>" defer></script>
    <script src="<?php echo e(asset('/public/js/bootstrap-datetimepicker.min.js')); ?>"></script>

	<!-- AdminLTE App -->
	<script src="<?php echo e(asset('/public/js/adminlte.min.js')); ?>"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$(function(){
				var r = $(location).attr('pathname');
				var sec = r.indexOf('admin/employee');
				var pro = r.indexOf('admin/role');
				var dos = r.indexOf('admin/position');
				var ste = r.indexOf('admin/assign');
				var tas = r.indexOf('admin/menu');
				var pcs = r.indexOf('admin/menurole');
				if (sec > 0 || pro > 0 || dos >0 || ste >0 || tas >0 || pcs >0) {
					$('li#employee').addClass('active');
				}else {
					$('li#dossier').addClass('active');
				}
			});

		});

	</script>
	@yield('script')
</body>
</html>
