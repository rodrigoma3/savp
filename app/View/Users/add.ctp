<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo __('Add User'); ?>	</h1>
	<ol class="breadcrumb">
		<li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> '.__('Home'), '/', array('escape' => false)); ?></li>
		<li><?php echo $this->Html->link(__('Users'), array('action' => 'index')); ?></li>
		<li class="active"><?php echo __('Add User'); ?></li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-success">
				<?php echo $this->Form->create(
					'User',
					array(
						'role' => 'form',
						'inputDefaults' => array(
							'div' => 'form-group col-xs-6',
							'class' => 'form-control',
						)
					)
				); ?>				<div class="box-body">
					<div class="row">
							<?php
		echo $this->Form->input('name');
		echo $this->Form->input('document');
		echo $this->Form->input('phone');
		echo $this->Form->input('address');
		echo $this->Form->input('number');
		echo $this->Form->input('complement');
		echo $this->Form->input('neighborhood');
		echo $this->Form->input('telephone_to_message');
		echo $this->Form->input('name_for_message');
		echo $this->Form->input('city_id');
		echo $this->Form->input('email');
		echo $this->Form->input('password');
		echo $this->Form->input('role');
		echo $this->Form->input('enabled');
	?>
					</div>
				</div><!-- /.box-body -->
				<div class="box-footer">
					<div class="row">
													<?php echo $this->Form->end(array('class' => 'btn btn-success btn-block', 'div' => array('class' => 'col-xs-3'), 'type' => 'submit', 'label' => __('Submit'))); ?>											</div>
				</div><!-- /.box-footer -->
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->
