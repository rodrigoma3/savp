<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo __('Profile'); ?>	</h1>
	<ol class="breadcrumb">
		<li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> '.__('Home'), '/', array('escape' => false)); ?></li>
		<li><?php echo __('Users'); ?></li>
		<li class="active"><?php echo __('Profile'); ?></li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-body">
					<dl class="dl-horizontal">
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($user['User']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Document'); ?></dt>
		<dd>
			<?php echo h($user['User']['document']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Phone'); ?></dt>
		<dd>
			<?php echo h($user['User']['phone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address'); ?></dt>
		<dd>
			<?php echo h($user['User']['address']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Number'); ?></dt>
		<dd>
			<?php echo h($user['User']['number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Complement'); ?></dt>
		<dd>
			<?php echo h($user['User']['complement']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Neighborhood'); ?></dt>
		<dd>
			<?php echo h($user['User']['neighborhood']); ?>
			&nbsp;
		</dd>
		<?php if ($user['User']['role'] == 'patient'): ?>
			<dt><?php echo __('Telephone To Message'); ?></dt>
			<dd>
				<?php echo h($user['User']['telephone_to_message']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Name For Message'); ?></dt>
			<dd>
				<?php echo h($user['User']['name_for_message']); ?>
				&nbsp;
			</dd>
		<?php endif; ?>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo h($user['City']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($user['User']['email']); ?>
			&nbsp;
		</dd>
		<?php if ($user['User']['role']!= 'patient'): ?>
			<dt><?php echo __('Role'); ?></dt>
			<dd>
				<?php echo __(Inflector::humanize($user['User']['role'])); ?>
				&nbsp;
			</dd>
		<?php endif; ?>
					</dl>
				</div><!-- /.box-body -->
				<?php if (in_array($this->Session->read('Auth.User.role'), $this->Session->read('perms')[$this->request->params['controller']]['editProfile'])): ?>
					<div class="box-footer">
						<div class="row">
							<div class="col-xs-3">
								<?php echo $this->Html->link(__('Edit'), array('action' => 'editProfile'), array('class' => 'btn btn-info btn-block')); ?>
							</div>
						</div>
					</div><!-- /.box-footer -->
				<?php endif; ?>
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->
