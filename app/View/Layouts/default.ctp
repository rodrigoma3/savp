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
			'fullcalendar/fullcalendar.min',
			// 'bootstrap-duallistbox/bootstrap-duallistbox.min',
			// 'daterangepicker/daterangepicker',
			'bootstrap-datetimepicker/bootstrap-datetimepicker.min',
			'bootstrap-wysihtml5/bootstrap3-wysihtml5.min',
			'datatables/dataTables.bootstrap',
			'select2/select2.min',
			'AdminLTE',
			'custom',
		));
	?>

	<?php
		echo $this->Html->script(array(
			'jquery-2.0.2.min',
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
	<script type="text/javascript">
		var lang = "<?php echo Configure::read('Config.language'); ?>";
	</script>
</head>
<body class="skin-black">
	<!-- header logo: style can be found in header.less -->
	<header class="header">
		<?php echo $this->Html->link(__('SAVP - SMS BG'), '/', array('class' => 'logo')); ?>
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
					<li>
						<?php if (Configure::read('Config.language') == 'pt-br') {
							echo $this->Html->link(
								$this->Html->image('flags-country/Brazil gray.ico', array('title' => __('Brazil'), 'class' => 'borderless', 'id' => 'flag-country')),
								array('controller' => null, 'action' => '#'),
								array('escape' => false)
							);
						} else {
							echo $this->Html->link(
								$this->Html->image('flags-country/Brazil.ico', array('title' => __('Brazil'), 'class' => 'borderless', 'id' => 'flag-country')),
								array('controller' => 'appSettings', 'action' => 'setLanguage', 'pt-br'),
								array('escape' => false)
							);
						} ?>
					</li>
					<li>
						<?php if (Configure::read('Config.language') == 'en-us') {
							echo $this->Html->link(
								$this->Html->image('flags-country/United States gray.ico', array('title' => __('United States'), 'class' => 'borderless', 'id' => 'flag-country')),
								array('controller' => null, 'action' => '#'),
								array('escape' => false)
							);
						} else {
							echo $this->Html->link(
								$this->Html->image('flags-country/United States.ico', array('title' => __('United States'), 'class' => 'borderless', 'id' => 'flag-country')),
								array('controller' => 'appSettings', 'action' => 'setLanguage', 'en-us'),
								array('escape' => false)
							);
						} ?>
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
					<?php if (in_array($this->Session->read('Auth.User.role'), $this->Session->read('perms')['diaries']['index'])): ?>
						<li class="<?php echo ($this->params['controller'] == 'diaries') ? 'active' : ''; ?>">
							<?php echo $this->Html->link('<i class="fa fa-calendar"></i> <span>'.__('Diary').'</span>', array('controller' => 'diaries', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					<?php endif; ?>
					<?php if (in_array($this->Session->read('Auth.User.role'), $this->Session->read('perms')['users']['patients'])): ?>
						<li class="<?php echo ($this->params['controller'] == 'users' && $this->params['action'] == 'patients' || (isset($this->request->pass[0]) && $this->request->pass[0] == 'patient') || ($this->params['action'] == 'view' && isset($user['User']['role']) && $user['User']['role'] == 'patient')) ? 'active' : ''; ?>">
							<?php echo $this->Html->link('<i class="fa fa-id-card"></i> <span>'.__('Patients').'</span>', array('controller' => 'users', 'action' => 'patients'), array('escape' => false)); ?>
						</li>
					<?php endif; ?>
					<?php if (in_array($this->Session->read('Auth.User.role'), $this->Session->read('perms')['destinations']['index'])): ?>
						<li class="<?php echo ($this->params['controller'] == 'destinations') ? 'active' : ''; ?>">
							<?php echo $this->Html->link('<i class="fa fa-map-marker"></i> <span>'.__('Destinations').'</span>', array('controller' => 'destinations', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					<?php endif; ?>
					<?php if (in_array($this->Session->read('Auth.User.role'), $this->Session->read('perms')['establishments']['index'])): ?>
						<li class="<?php echo ($this->params['controller'] == 'establishments') ? 'active' : ''; ?>">
							<?php echo $this->Html->link('<i class="fa fa-hospital-o"></i> <span>'.__('Establishments').'</span>', array('controller' => 'establishments', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					<?php endif; ?>
					<?php if (in_array($this->Session->read('Auth.User.role'), $this->Session->read('perms')['cities']['index'])): ?>
						<li class="<?php echo ($this->params['controller'] == 'cities') ? 'active' : ''; ?>">
							<?php echo $this->Html->link('<i class="fa fa-globe"></i> <span>'.__('Cities').'</span>', array('controller' => 'cities', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					<?php endif; ?>
					<?php if (in_array($this->Session->read('Auth.User.role'), $this->Session->read('perms')['cars']['index'])): ?>
						<li class="<?php echo ($this->params['controller'] == 'cars') ? 'active' : ''; ?>">
							<?php echo $this->Html->link('<i class="fa fa-ambulance"></i> <span>'.__('Cars').'</span>', array('controller' => 'cars', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					<?php endif; ?>
					<?php if (in_array($this->Session->read('Auth.User.role'), $this->Session->read('perms')['users']['index'])): ?>
						<li class="<?php echo ($this->params['controller'] == 'users' && $this->params['action'] != 'patients' && (!isset($this->params['pass'][0]) || $this->params['pass'][0] != 'patient') && ($this->params['action'] != 'view' || isset($user['User']['role']) && $user['User']['role'] != 'patient')) ? 'active' : ''; ?>">
							<?php echo $this->Html->link('<i class="fa fa-users"></i> <span>'.__('Users').'</span>', array('controller' => 'users', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					<?php endif; ?>
					<?php if (in_array($this->Session->read('Auth.User.role'), $this->Session->read('perms')['appSettings']['index'])): ?>
						<li class="<?php echo ($this->params['controller'] == 'appSettings') ? 'active' : ''; ?>">
							<?php echo $this->Html->link('<i class="fa fa-cogs"></i> <span>'.__('App Settings').'</span>', array('controller' => 'appSettings', 'action' => 'index'), array('escape' => false)); ?>
						</li>
					<?php endif; ?>
					<?php if (in_array($this->Session->read('Auth.User.role'), $this->Session->read('perms')['reports']['historic'])): ?>
						<li class="<?php echo ($this->params['controller'] == 'reports' && $this->params['action'] == 'historic') ? 'active' : ''; ?>">
							<?php echo $this->Html->link('<i class="fa fa-pie-chart"></i> <span>'.__('Historic').'</span>', array('controller' => 'reports', 'action' => 'historic'), array('escape' => false)); ?>
						</li>
					<?php endif; ?>
					<?php if (in_array($this->Session->read('Auth.User.role'), $this->Session->read('perms')['reports']['patients']) || in_array($this->Session->read('Auth.User.role'), $this->Session->read('perms')['reports']['kms'])): ?>
						<li class="treeview <?php echo ($this->params['controller'] == 'reports') ? 'active' : ''; ?>">
							<?php echo $this->Html->link('<i class="fa fa-bar-chart"></i> <span>'.__('Reports').'</span><i class="fa pull-right fa-angle-down"></i>', '#', array('escape' => false)); ?>
							<ul class="treeview-menu">
								<?php if (in_array($this->Session->read('Auth.User.role'), $this->Session->read('perms')['reports']['patients'])): ?>
									<li class="<?php echo ($this->params['controller'] == 'reports' && $this->params['action'] == 'patients') ? 'active' : ''; ?>">
										<?php echo $this->Html->link('<i class="fa fa-angle-double-right"></i>&nbsp;'.__('Patients'), array('controller' => 'reports', 'action' => 'patients'), array('escape' => false)); ?>
									</li>
								<?php endif; ?>
								<?php if (in_array($this->Session->read('Auth.User.role'), $this->Session->read('perms')['reports']['kms'])): ?>
									<li class="<?php echo ($this->params['controller'] == 'reports' && $this->params['action'] == 'kms') ? 'active' : ''; ?>">
										<?php echo $this->Html->link('<i class="fa fa-angle-double-right"></i>&nbsp;'.__('KMs'), array('controller' => 'reports', 'action' => 'kms'), array('escape' => false)); ?>
									</li>
								<?php endif; ?>
                            </ul>
						</li>
					<?php endif; ?>
				</ul>
			</section>
			<!-- /.sidebar -->
		</aside>

		<!-- Right side column. Contains the navbar and content of the page -->
		<aside class="right-side">
			<?php echo $this->Flash->render('auth'); ?>
			<?php echo $this->Flash->render(); ?>

			<?php echo $this->fetch('content'); ?>
		</aside><!-- /.right-side -->
	</div><!-- ./wrapper -->

	<?php //echo $this->element('sql_dump'); ?>

	<?php echo $this->Html->script(array(
		'jquery-ui-1.10.3.min',
		'bootstrap.min',
		'plugins/raphael/raphael-min',
		'plugins/morris/morris.min',
		'plugins/moment/moment.min',
		'plugins/sparkline/jquery.sparkline.min',
		'plugins/jvectormap/jquery-jvectormap-1.2.2.min',
		'plugins/jvectormap/jquery-jvectormap-world-mill-en',
		'plugins/fullcalendar/fullcalendar.min',
		// 'plugins/bootstrap-duallistbox/jquery.bootstrap-duallistbox',
		'plugins/jqueryKnob/jquery.knob',
		'plugins/input-mask/jquery.inputmask',
        'plugins/input-mask/jquery.inputmask.date.extensions',
        'plugins/input-mask/jquery.inputmask.extensions',
		'plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min',
		'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min',
		'plugins/iCheck/icheck.min',
		'plugins/datatables/jquery.dataTables',
		'plugins/datatables/dataTables.bootstrap',
		'plugins/select2/select2.min',
		'plugins/select2/i18n/'.Configure::read('Config.language'),
		'AdminLTE/app',
		'custom',
	)); ?>

</body>
</html>
