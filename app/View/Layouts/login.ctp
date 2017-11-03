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
<html class="bg-black">
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
			// 'ionicons.min',
			// 'morris/morris',
			// 'jvectormap/jquery-jvectormap-1.2.2',
			// 'fullcalendar/fullcalendar',
			// 'daterangepicker/daterangepicker-bs3',
			// 'bootstrap-wysihtml5/bootstrap3-wysihtml5.min',
			// 'datatables/dataTables.bootstrap',
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
<body class="bg-black">

	<div class="row">
		<div class="col-md-12">
			<?php echo $this->Flash->render(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
	</div>

	<?php //echo $this->element('sql_dump'); ?>

	<?php echo $this->Html->script(array(
		'jquery-2.0.2.min',
		// 'jquery-ui-1.10.3.min',
		'bootstrap.min',
		// 'plugins/raphael/raphael-min',
		// 'plugins/morris/morris.min',
		// 'plugins/sparkline/jquery.sparkline.min',
		// 'plugins/jvectormap/jquery-jvectormap-1.2.2.min',
		// 'plugins/jvectormap/jquery-jvectormap-world-mill-en',
		// 'plugins/fullcalendar/fullcalendar.min',
		// 'plugins/jqueryKnob/jquery.knob',
		// 'plugins/daterangepicker/daterangepicker',
		// 'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min',
		// 'plugins/iCheck/icheck.min',
		// 'plugins/datatables/jquery.dataTables',
		// 'plugins/datatables/dataTables.bootstrap',
		// 'AdminLTE/app',
		// 'AdminLTE/dashboard',
		'custom',
	)); ?>

</body>
</html>
