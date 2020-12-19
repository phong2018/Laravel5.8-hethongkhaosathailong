<?php
	$flag = 0;
	foreach ($newdossier as $key) {
		$flag += 1;
	}

?>
 
<header class="main-header">
	
	<!-- Logo -->
	<a href="home" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini"><b>Admin</b></span>
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg"><b>Hồ Sơ 1 Cữa</b></span>
	</a>
	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top">
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>

		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">

				<!-- Messages: style can be found in dropdown.less-->
				<li class="dropdown messages-menu   plghidden">
					<a href="#" class="dropdown-toggle " data-toggle="dropdown">
						<i class="far fa-envelope"></i>
						<span class="label label-success">{{$flag}}</span>
					</a>
					<ul class="dropdown-menu">
						<li class="header">You have {{$flag}} dossier new</li>
						<li>
							<!-- inner menu: contains the actual data -->
							<ul class="menu">
								@foreach($newdossier as $ndo)
									<?php  $linkk = e(asset('admin/dossier/info/'));
									?>
									<li>
										<a href='<?php echo $linkk."/".$ndo["ID_Dossier"]; ?>'>
											<i class="fa fa-users text-aqua"></i> {{$ndo["dossier_owner"]}}
										</a>
									</li>
								@endforeach
							</ul>
						</li>
						<li class="footer"><a href="#">See All Dossier</a></li>
					</ul>
				</li>

				<!-- Notifications: style can be found in dropdown.less -->
				<li class="dropdown notifications-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="far fa-bell"></i>
						<span class="label label-warning">10</span>
					</a>
					<ul class="dropdown-menu">
						<li class="header">You have 10 notifications</li>
						<li>
							<!-- inner menu: contains the actual data -->
							<ul class="menu">
								<li>
									<a href="#">
										<i class="fa fa-users text-aqua"></i> 5 new members joined today
									</a>
								</li>
								<li>
									<a href="#">
										<i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
										page and may cause design problems
									</a>
								</li>
								<li>
									<a href="#">
										<i class="fa fa-users text-red"></i> 5 new members joined
									</a>
								</li>
								<li>
									<a href="#">
										<i class="fa fa-shopping-cart text-green"></i> 25 sales made
									</a>
								</li>
								<li>
									<a href="#">
										<i class="fa fa-user text-red"></i> You changed your username
									</a>
								</li>
							</ul>
						</li>
						<li class="footer"><a href="#">View all</a></li>
					</ul>
				</li>
				<!-- Tasks: style can be found in dropdown.less -->
				<li class="dropdown tasks-menu plghidden">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="far fa-flag"></i>
						<span class="label label-danger">9</span>
					</a>
					<ul class="dropdown-menu">
						<li class="header">You have 9 tasks</li>
						<li>
							<!-- inner menu: contains the actual data -->
							<ul class="menu">
								<li><!-- Task item -->
									<a href="#">
										<h3>
											Design some buttons
											<small class="pull-right">20%</small>
										</h3>
										<div class="progress xs">
											<div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
											aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
											<span class="sr-only">20% Complete</span>
										</div>
									</div>
								</a>
							</li>
							<!-- end task item -->
							<li><!-- Task item -->
								<a href="#">
									<h3>
										Create a nice theme
										<small class="pull-right">40%</small>
									</h3>
									<div class="progress xs">
										<div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
										aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
										<span class="sr-only">40% Complete</span>
									</div>
								</div>
							</a>
						</li>
						<!-- end task item -->
						<li><!-- Task item -->
							<a href="#">
								<h3>
									Some task I need to do
									<small class="pull-right">60%</small>
								</h3>
								<div class="progress xs">
									<div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"
									aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
									<span class="sr-only">60% Complete</span>
								</div>
							</div>
						</a>
					</li>
					<!-- end task item -->
					<li><!-- Task item -->
						<a href="#">
							<h3>
								Make beautiful transitions
								<small class="pull-right">80%</small>
							</h3>
							<div class="progress xs">
								<div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"
								aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
								<span class="sr-only">80% Complete</span>
							</div>
						</div>
					</a>
				</li>
				<!-- end task item -->
			</ul>
		</li>
		<li class="footer">
			<a href="#">View all tasks</a>
		</li>
	</ul>
</li>
<!-- User Account: style can be found in dropdown.less -->
<li class="dropdown user user-menu" style="padding-left: 1em">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<img src="https://via.placeholder.com/50" class="user-image" alt="User Image">
		<span class="hidden-xs">{{Auth::user()->fullname}}</span>
	</a>
	<ul class="dropdown-menu">
		<!-- User image -->
		<li class="user-header">
			<img src="https://via.placeholder.com/50" class="img-circle" alt="User Image">

			<p>
				<small>{{Auth::user()->address}}</small>
			</p>
		</li>
		<!-- Menu Footer-->
		<li class="user-footer">
			<div class="pull-left">
				<a href="#" class="btn btn-default btn-flat">Profile</a>
			</div>
			<div class="pull-right" aria-labelledby="navbarDropdown">
				<a class="dropdown-item" href="{{ route('logout') }}"
				onclick="event.preventDefault();
				document.getElementById('logout-form').submit();">
				{{ __('Logout') }}
			</a>

			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
				@csrf
			</form>
		</div>
	</li>
</ul>
</li>

</ul>
</div>
</nav>
</header>