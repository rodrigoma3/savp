<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo __('Edit Profile'); ?>	</h1>
	<ol class="breadcrumb">
		<li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> '.__('Home'), '/', array('escape' => false)); ?></li>
		<li><?php echo __('Users'); ?></li>
		<li class="active"><?php echo __('Edit Profile'); ?></li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-warning">
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
							echo $this->Form->input('id');
							echo $this->Form->input('name');
							echo $this->Form->input('document');
							echo $this->Form->input('phone');
							echo $this->Form->input('address');
							echo $this->Form->input('number');
							echo $this->Form->input('complement');
							echo $this->Form->input('neighborhood');
							if ($this->Session->read('Auth.User.role') == 'patient') {
								echo $this->Form->input('telephone_to_message');
								echo $this->Form->input('name_for_message');
							}
							echo $this->Form->input('city_id');
							echo $this->Form->input('email');
						?>
					</div>
				</div><!-- /.box-body -->
				<div class="box-footer">
					<div class="row">
													<?php echo $this->Form->end(array('class' => 'btn btn-warning btn-block', 'div' => array('class' => 'col-xs-3'), 'type' => 'submit', 'label' => __('Submit'))); ?>											</div>
				</div><!-- /.box-footer -->
			</div><!-- /.box -->
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="box-header">
				<h3 class="box-title"><?php echo __('Update Password'); ?></h3>
			</div>
			<div class="box box-primary">
				<?php echo $this->Form->create(
					'User',
					array(
						'role' => 'form',
						'inputDefaults' => array(
							'div' => 'form-group col-xs-6 required',
							'class' => 'form-control',
						)
					)
				); ?>				<div class="box-body">
					<div class="row">
						<?php
						echo $this->Form->input('id');
						echo $this->Form->input('current_password', array('type' => 'password'));
						echo $this->Form->input('password');
						echo $this->Form->input('confirm_password', array('type' => 'password'));
						?>
					</div>
				</div><!-- /.box-body -->
				<div class="box-footer">
					<div class="row">
													<?php echo $this->Form->end(array('class' => 'btn btn-primary btn-block', 'div' => array('class' => 'col-xs-3'), 'type' => 'submit', 'label' => __('Submit'))); ?>											</div>
				</div><!-- /.box-footer -->
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->
