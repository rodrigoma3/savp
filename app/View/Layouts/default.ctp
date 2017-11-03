<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->meta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'));

		echo $this->Html->css(array(
			// 'cake.generic',
			'bootstrap.min',
			'font-awesome.min',
			'ionicons.min',
			'morris/morris',
			'jvectormap/jquery-jvectormap-1.2.2',
			'fullcalendar/fullcalendar',
			'daterangepicker/daterangepicker-bs3',
			'bootstrap-wysihtml5/bootstrap3-wysihtml5.min',
			'datatables/dataTables.bootstrap',
			'AdminLTE',
			'custom',
		));
	?>

	<!--[if lt IE 9]>
      <?php
		  echo $this->Html->script(array(
			'html5shiv',
			'respond.min',
		  ));
	  ?>
    <![endif]-->

	<?php
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body class="skin-black">
	<!-- header logo: style can be found in header.less -->
	<header class="header">
		<?php echo $this->Html->link(__('A.V. - Saúde BG'), '/', array('class' => 'logo')); ?>
		<!-- Header Navbar: style can be found in header.less -->
		<nav class="navbar navbar-static-top" role="navigation">
			<!-- Sidebar toggle button-->
			<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<div class="navbar-right">
				<ul class="nav navbar-nav">
					<!-- Notifications: style can be found in dropdown.less -->
					<li class="dropdown notifications-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-warning"></i>
							<span class="label label-danger">10</span>
						</a>
						<ul class="dropdown-menu">
							<li class="header">You have 10 notifications</li>
							<li>
								<!-- inner menu: contains the actual data -->
								<ul class="menu">
									<li>
										<a href="#">
											<i class="ion ion-ios7-people info"></i> 5 new members joined today
										</a>
									</li>
									<li>
										<a href="#">
											<i class="fa fa-warning danger"></i> Very long description here that may not fit into the page and may cause design problems
										</a>
									</li>
									<li>
										<a href="#">
											<i class="fa fa-users warning"></i> 5 new members joined
										</a>
									</li>

									<li>
										<a href="#">
											<i class="ion ion-ios7-cart success"></i> 25 sales made
										</a>
									</li>
									<li>
										<a href="#">
											<i class="ion ion-ios7-person danger"></i> You changed your username
										</a>
									</li>
								</ul>
							</li>
							<li class="footer"><a href="#">View all</a></li>
						</ul>
					</li>
					<!-- User Account: style can be found in dropdown.less -->
					<li class="dropdown user user-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="glyphicon glyphicon-user"></i>
							<span><?php echo (!empty($this->Session->read('Auth.User.name'))) ? $this->Session->read('Auth.User.name') : __('Usuário'); ?> <i class="caret"></i></span>
						</a>
						<ul class="dropdown-menu">
							<!-- User image -->
							<li class="user-header user-header-no-image bg-light-blue">
								<p>
									<?php echo (!empty($this->Session->read('Auth.User.email'))) ? $this->Session->read('Auth.User.email') : ''; ?>
									<small><?php echo __('Member since ').date('M. Y', strtotime($this->Session->read('Auth.User.created'))); ?></small>
								</p>
							</li>
							<!-- Menu Body -->
							<li class="user-body">
								<div class="col-xs-12 text-center">
									<a href="#"><?php echo __('Visit history'); ?></a>
								</div>
								<!-- <div class="col-xs-4 text-center">
									<a href="#">Sales</a>
								</div>
								<div class="col-xs-4 text-center">
									<a href="#">Friends</a>
								</div> -->
							</li>
							<!-- Menu Footer-->
							<li class="user-footer">
								<div class="pull-left">
									<?php echo $this->Html->link(__('Profile'), array('controller' => 'users', 'action' => 'profile'), array('class' => 'btn btn-default btn-flat')) ?>
								</div>
								<div class="pull-right">
									<?php echo $this->Html->link(__('Sign out'), array('controller' => 'users', 'action' => 'logout'), array('class' => 'btn btn-default btn-flat')) ?>
								</div>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</header>
	<div class="wrapper row-offcanvas row-offcanvas-left">
		<!-- Left side column. contains the logo and sidebar -->
		<aside class="left-side sidebar-offcanvas">
			<!-- sidebar: style can be found in sidebar.less -->
			<section class="sidebar">
				<!-- sidebar menu: : style can be found in sidebar.less -->
				<ul class="sidebar-menu">
					<li class="<?php echo ($this->params['controller'] == 'diaries') ? 'active' : ''; ?>">
						<?php echo $this->Html->link('<i class="fa fa-dashboard"></i> <span>'.__('Dashboard').'</span>', array('controller' => 'diaries', 'action' => 'index'), array('escape' => false)); ?>
					</li>
					<li class="<?php echo ($this->params['controller'] == 'diaries') ? 'active' : ''; ?>">
						<?php echo $this->Html->link('<i class="fa fa-calendar"></i> <span>'.__('Diary').'</span>', array('controller' => 'diaries', 'action' => 'index'), array('escape' => false)); ?>
					</li>
					<li class="<?php echo ($this->params['controller'] == 'users' && in_array($this->params['action'], array('add_patient', 'edit_patient', 'patients'))) ? 'active' : ''; ?>">
						<?php echo $this->Html->link('<i class="fa fa-id-card"></i> <span>'.__('Patients').'</span>', array('controller' => 'users', 'action' => 'patients'), array('escape' => false)); ?>
					</li>
					<li class="<?php echo ($this->params['controller'] == 'destinations') ? 'active' : ''; ?>">
						<?php echo $this->Html->link('<i class="fa fa-map-marker"></i> <span>'.__('Destinations').'</span>', array('controller' => 'destinations', 'action' => 'index'), array('escape' => false)); ?>
					</li>
					<li class="<?php echo ($this->params['controller'] == 'establishments') ? 'active' : ''; ?>">
						<?php echo $this->Html->link('<i class="fa fa-hospital-o"></i> <span>'.__('Establishments').'</span>', array('controller' => 'establishments', 'action' => 'index'), array('escape' => false)); ?>
					</li>
					<li class="<?php echo ($this->params['controller'] == 'users' && !in_array($this->params['action'], array('add_patient', 'edit_patient', 'patients'))) ? 'active' : ''; ?>">
						<?php echo $this->Html->link('<i class="fa fa-users"></i> <span>'.__('Users').'</span>', array('controller' => 'users', 'action' => 'index'), array('escape' => false)); ?>
					</li>
					<li class="<?php echo ($this->params['controller'] == 'cities') ? 'active' : ''; ?>">
						<?php echo $this->Html->link('<i class="fa fa-globe"></i> <span>'.__('Cities').'</span>', array('controller' => 'cities', 'action' => 'index'), array('escape' => false)); ?>
					</li>
					<li class="<?php echo ($this->params['controller'] == 'cars') ? 'active' : ''; ?>">
						<?php echo $this->Html->link('<i class="fa fa-truck"></i> <span>'.__('Cars').'</span>', array('controller' => 'cars', 'action' => 'index'), array('escape' => false)); ?>
					</li>
				</ul>
			</section>
			<!-- /.sidebar -->
		</aside>

		<!-- Right side column. Contains the navbar and content of the page -->
		<aside class="right-side">
			<?php echo $this->Flash->render(); ?>

			<?php echo $this->fetch('content'); ?>
		</aside><!-- /.right-side -->
	</div><!-- ./wrapper -->

	<?php //echo $this->element('sql_dump'); ?>

	<?php echo $this->Html->script(array(
		'jquery-2.0.2.min',
		'jquery-ui-1.10.3.min',
		'bootstrap.min',
		// 'plugins/raphael/raphael-min',
		// 'plugins/morris/morris.min',
		'plugins/sparkline/jquery.sparkline.min',
		'plugins/jvectormap/jquery-jvectormap-1.2.2.min',
		'plugins/jvectormap/jquery-jvectormap-world-mill-en',
		'plugins/fullcalendar/fullcalendar.min',
		'plugins/jqueryKnob/jquery.knob',
		'plugins/daterangepicker/daterangepicker',
		'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min',
		'plugins/iCheck/icheck.min',
		'plugins/datatables/jquery.dataTables',
		'plugins/datatables/dataTables.bootstrap',
		'AdminLTE/app',
		// 'AdminLTE/dashboard',
		'custom',
	)); ?>

</body>
</html>
