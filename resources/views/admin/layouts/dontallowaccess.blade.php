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
			<h1>Không được phép truy cập</h1>
			@if (session('status'))
			    <div class="alert alert-success">
			        {{ session('status') }}
			    </div>
			@endif
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
</body>
</html>
