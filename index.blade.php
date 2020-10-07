<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	@yield ('title')

	<link href="<?php echo e(asset('/public/css/app.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('/public/css/custom.css')); ?>" rel="stylesheet">
	<!-- Font Awesome -->
	
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">


	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo e(asset('/public/css/AdminLTE.min.css')); ?>">
  	<!-- AdminLTE Skins. Choose a skin from the css/skins
  		folder instead of downloading all of them to reduce the load. -->
  	<link rel="stylesheet" href="<?php echo e(asset('/public/css/_all-skins.min.css')); ?>">

  	<!-- Google Font -->
  	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  	@yield ('style')
  	
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
	<script src="<?php echo e(asset('/public/js/jquery-3.3.1.min.js')); ?>"></script>

	<!-- Bootstrap 3.3.7 -->
	<script src="<?php echo e(asset('/public/js/app.js')); ?>" defer></script>
	<!-- Morris.js charts -->

	<!-- AdminLTE App -->
	<script src="<?php echo e(asset('/public/js/adminlte.min.js')); ?>"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			var r = $(location).attr('pathname');
			
		    if (r == '/admin/sector'||r == '/admin/sector/add'||r == '/admin/procedure'||r == '/admin/procedure/add'||r == '/admin/dossier'||r == '/admin/dossier/add'||r == '/admin/steps'||r == '/admin/steps/add') {
		    	$('li#dossier').addClass('active');
		    }else {
		    	$('li#employee').addClass('active');
		    }
		});
	</script>
	@yield('script')
</body>
</html>
