<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo __('App Setting'); ?>
	</h1>
	<ol class="breadcrumb">
		<li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> '.__('Home'), '/', array('escape' => false)); ?></li>
		<li class="active"><?php echo __('App Setting'); ?></li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-success">
				<?php echo $this->Form->create(
					'AppSetting',
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
							echo $this->Form->input('system_name');
							echo $this->Form->input('system_administrator_email', array('type' => 'email'));
							echo $this->Form->input('starting_address');
							echo $this->Form->input('token_expiration_time', array('type' => 'number', 'min' => 1, 'between' => '&nbsp;&nbsp;'.__('in hour')));
							echo $this->Form->input('email_host');
							echo $this->Form->input('email_port', array('type' => 'number', 'min' => 1));
							echo $this->Form->input('email_tls', array('type' => 'checkbox'));
							echo $this->Form->input('email_ssl', array('type' => 'checkbox'));
							echo $this->Form->input('email_timeout', array('type' => 'number', 'min' => 1));
							echo $this->Form->input('email_username');
							echo $this->Form->input('email_password', array('type' => 'password', 'placeholder' => __('Enter to change')));
							echo $this->Form->input('email_from_name');
							echo $this->Form->input('email_from_email', array('type' => 'email'));
							echo $this->Form->input('email_reply_to', array('type' => 'email'));
							echo $this->Form->input('email_cc');
							echo $this->Form->input('email_bcc');
						?>
					</div>
				</div><!-- /.box-body -->
				<div class="box-footer">
					<div class="row">
						<?php echo $this->Form->end(array('class' => 'btn btn-success btn-block', 'div' => array('class' => 'col-xs-3'), 'type' => 'submit', 'label' => __('Submit'))); ?>
						<div class="col-xs-3">
							<?php echo $this->Html->link(__('Email Test'), '#emailTestSending', array('class' => 'btn btn-primary btn-block', 'role' => 'button', 'data-toggle' => 'modal')); ?>
						</div>
					</div>
				</div><!-- /.box-footer -->
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->


<!-- Modal -->
<div id="emailTestSending" class="modal" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3><?php echo __('Test email sending'); ?></h3>
			</div>
			<?php echo $this->Form->create(
				'AppSetting',
				array(
					'role' => 'form',
					'inputDefaults' => array(
						'div' => 'form-group col-xs-6',
						'class' => 'form-control',
					),
				)
			); ?>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12">
						<?php echo $this->Form->input('to', array('type' => 'email')); ?>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<?php echo $this->Form->end(array('class' => 'btn btn-success btn-block', 'div' => array('class' => 'col-xs-3'), 'type' => 'submit', 'label' => __('Send'))); ?>
				<div class="col-xs-3">
					<?php echo $this->Form->button(__('Cancel'), array('data-dismiss' => 'modal', 'aria-hidden' => 'true', 'class' => 'btn btn-default btn-block')); ?>
				</div>
			</div>
		</div>
	</div>
</div>
