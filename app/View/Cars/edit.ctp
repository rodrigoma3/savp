<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo __('Edit Car'); ?>
	</h1>
	<ol class="breadcrumb">
		<li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> '.__('Home'), '/', array('escape' => false)); ?></li>
		<li><?php echo $this->Html->link(__('Cars'), array('action' => 'index')); ?></li>
		<li class="active"><?php echo __('Edit Car'); ?></li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-warning">
				<?php echo $this->Form->create(
					'Car',
					array(
						'role' => 'form',
						'inputDefaults' => array(
							'div' => 'form-group col-xs-6',
							'class' => 'form-control',
						)
					)
				); ?>
				<div class="box-body">
					<div class="row">
						<?php
							echo $this->Form->input('manufacturer');
							echo $this->Form->input('model');
							echo $this->Form->input('year');
							echo $this->Form->input('type');
							echo $this->Form->input('car_plate');
							echo $this->Form->input('capacity');
							echo $this->Form->input('km',array('min' => 1));
							echo $this->Form->input('enabled');
						?>
					</div>
				</div><!-- /.box-body -->
				<div class="box-footer">
					<div class="row">
						<?php echo $this->Form->end(array('class' => 'btn btn-warning btn-block', 'div' => array('class' => 'col-xs-3'), 'type' => 'submit', 'label' => __('Submit'))); ?>
					</div>
				</div><!-- /.box-footer -->
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->
