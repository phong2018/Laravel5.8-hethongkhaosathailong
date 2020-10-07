<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- Sidebar user panel -->
		<div class="user-panel">
			<div class="pull-left image">
				<img src="https://via.placeholder.com/50" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				<p>{{ Auth::user()->fullname }}</p>
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>
		<!-- search form -->
		<form action="#" method="get" class="sidebar-form plghidden">
			<div class="input-group">
				<input type="text" name="q" class="form-control" placeholder="đang hoàn thiện ..." readonly>
				<span class="input-group-btn">
					<button type="#" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
					</button>
				</span>
			</div>
		</form>
		<!-- /.search form -->
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu" data-widget="tree">
			<li class="header plghidden">MENU CHÍNH</li>
			<!-- <li class="active treeview">
				<a href="#">
					<i class="fa fa-dashboard"></i> <span>DASHBOARD</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="active"><a href="home"><i class="fa fa-angle-double-right plgiconcir"></i> Admin page Home</a></li>
					
				</ul>
			</li> -->

			<li class="treeview" id="dossier3">
				<a href="#"  class='menulevel1'>
					 
					<i class="fa fa-file-text"></i>
					<span class='menulevel1'>Quản Lý Hồ Sơ</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><a href="<?php echo e(asset('/admin/sector')); ?>"><i class="fa fa-angle-double-right plgiconcir"></i> Danh Sách Hồ Sơ</a></li>
					<li><a href="<?php echo e(asset('/admin/procedure')); ?>"><i class="fa fa-angle-double-right plgiconcir"></i> Thêm Hồ Sơ Mới</a></li>
				</ul>
			</li>
			
			<li class="treeview" id="dossier2">
				<a href="#" class='menulevel1'>
	 				<i class="material-icons" style="font-size: 	16px;">create_new_folder</i>&nbsp
					<span class='menulevel1'>Thuộc Tính Hồ Sơ</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><a title='Lĩnh Vực: Tư pháp, hộ tịch, địa chính...' href="<?php echo e(asset('/admin/sector')); ?>"><i class="fa fa-angle-double-right plgiconcir"></i>Quản Lý Lĩnh Vực</a></li>
					
					<li><a  title='Quản lý Thủ tục hành chính' href="<?php echo e(asset('/admin/procedure')); ?>"><i class="fa fa-angle-double-right plgiconcir"></i>Quản Lý Thủ Tục</a></li>

					<li><a  title='Các bước: Hồ sơ mới, Đang xử lý, Hồ sơ lỗi, Hoàn thành...' href="<?php echo e(asset('/admin/step')); ?>"><i class="fa fa-angle-double-right plgiconcir"></i>Quản Lý Các Bước Hồ Sơ</a></li>
					
					
					
 

				</ul>
			</li>
			<li class="treeview" id="dossier3">
				<a href="#"  class='menulevel1'>
					<i class="fas fa-user"></i>
					<span class='menulevel1'> &nbsp Quản Lý Tài Khoản</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><a  title='Quản lý tài khoản sử dụng hệ thống' href="<?php echo e(asset('/admin/user')); ?>"><i class="fa fa-angle-double-right plgiconcir"></i>Tài Khoản</a></li>
		 
					<li><a  title='Vai trò: Quản trị, Giám sát, Nhân Viên & quyền Truy cập Menu' href="<?php echo e(asset('/admin/role')); ?>"><i class="fa fa-angle-double-right plgiconcir"></i>Quản Lý Vai Trò</a></li>
					<!--Vai trò này xem được những menu nào-->
					<li><a  title='Vị Trí chức vụ: Chủ tịch, phó chủ tịch, nhân viên..' href="<?php echo e(asset('/admin/position')); ?>"><i class="fa fa-angle-double-right plgiconcir"></i>Quản Lý Vị Trí</a></li>
					<li><a  title='Menu truy cập' href="<?php echo e(asset('/admin/menu')); ?>"><i class="fa fa-angle-double-right plgiconcir"></i>Quản Lý Menu truy cập</a></li>
					
				</ul>
			</li>
			<li class="treeview" id="dossier3">
				<a href="#"  class='menulevel1'>
					<i class="fas fa-cog"></i>
					<span class='menulevel1'> &nbsp Cài Đặt Hệ Thống</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><a  title='Quản lý tài khoản sử dụng hệ thống' href="<?php echo e(asset('/admin/setting/edit')); ?>"><i class="fa fa-angle-double-right plgiconcir"></i>Thiết Lập Chung</a></li>
					<li><a href="<?php echo e(asset('/admin/setting/backup')); ?>"><i class="fa fa-angle-double-right plgiconcir"></i> Sao Lưu/ Phục Hồi</a></li>
				</ul>
			</li>



			<li class="treeview plghidden" id="dossier212">
				<a href="#">
					<i class="fa fa-files-o"></i>
					<span>[*Quản Lý Hồ Sơ]</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><a href="<?php echo e(asset('/admin/sector')); ?>"><i class="fa fa-angle-double-right plgiconcir"></i> Lĩnh Vực</a></li>
					<li><a href="<?php echo e(asset('/admin/procedure')); ?>"><i class="fa fa-angle-double-right plgiconcir"></i> Thủ Tục</a></li>
					<li><a href="<?php echo e(asset('/admin/dossier')); ?>"><i class="fa fa-angle-double-right plgiconcir"></i> Hồ Sơ</a></li>
					<li><a href="<?php echo e(asset('/admin/steps')); ?>"><i class="fa fa-angle-double-right plgiconcir"></i> Quản Lý Trạng Thái Hồ Sơ</a></li>
					<li><a href="<?php echo e(asset('/admin/taskappoint')); ?>"><i class="fa fa-angle-double-right plgiconcir"></i> Phân Công Thụ Lý Hồ Sơ</a></li>
					<li><a href="<?php echo e(asset('/admin/process')); ?>"><i class="fa fa-angle-double-right plgiconcir"></i> Tình Trạng Hồ Sơ</a></li>
					<li>&nbsp;</li>
				</ul>
			</li>
			<li class="treeview plghidden" id="employee112">
				<a href="#">
					<i class="fa fa-files-o"></i>
					<span>[*Quản Lý Nhân Viên]</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><a href="<?php echo e(asset('/admin/employee')); ?>"><i class="fa fa-angle-double-right plgiconcir"></i> Danh Sách Nhân Viên</a></li>
					<li><a href="<?php echo e(asset('/admin/role')); ?>"><i class="fa fa-angle-double-right plgiconcir"></i> Danh Sách Quyền</a></li>
					<li><a href="<?php echo e(asset('/admin/position')); ?>"><i class="fa fa-angle-double-right plgiconcir"></i> Danh Sách Chức Vụ</a></li>
					<li><a href="<?php echo e(asset('/admin/assign')); ?>"><i class="fa fa-angle-double-right plgiconcir"></i> Phân Công Nhiệm Vụ</a></li>
					<li><a href="<?php echo e(asset('/admin/menu')); ?>"><i class="fa fa-angle-double-right plgiconcir"></i> Menu</a></li>
					<li><a href="<?php echo e(asset('/admin/menurole')); ?>"><i class="fa fa-angle-double-right plgiconcir"></i> Quyền Truy Cập Menu</a></li>
				</ul>
			</li>
			
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>