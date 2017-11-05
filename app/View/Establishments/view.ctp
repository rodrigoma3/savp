<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo __('View Establishment'); ?>	</h1>
	<ol class="breadcrumb">
		<li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> '.__('Home'), '/', array('escape' => false)); ?></li>
		<li><?php echo $this->Html->link(__('Establishments'), array('action' => 'index')); ?></li>
		<li class="active"><?php echo __('View Establishment'); ?></li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-body">
					<dl class="dl-horizontal">
								<dt><?php echo __('#'); ?></dt>
		<dd>
			<?php echo h($establishment['Establishment']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($establishment['Establishment']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Phone'); ?></dt>
		<dd>
			<?php echo h($establishment['Establishment']['phone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address'); ?></dt>
		<dd>
			<?php echo h($establishment['Establishment']['address']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Number'); ?></dt>
		<dd>
			<?php echo h($establishment['Establishment']['number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Complement'); ?></dt>
		<dd>
			<?php echo h($establishment['Establishment']['complement']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Neighborhood'); ?></dt>
		<dd>
			<?php echo h($establishment['Establishment']['neighborhood']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo $this->Html->link($establishment['City']['name'], array('controller' => 'cities', 'action' => 'view', $establishment['City']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sequence'); ?></dt>
		<dd>
			<?php echo h($establishment['Establishment']['sequence']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Enabled'); ?></dt>
		<dd>
			<?php echo $enableds[$establishment['Establishment']['enabled']]; ?>
			&nbsp;
		</dd>
					</dl>
				</div><!-- /.box-body -->
				<div class="box-footer">
					<div class="row">
						<div class="col-xs-3">
							<?php echo $this->Html->link(__('List Establishments'), array('action' => 'index'), array('class' => 'btn btn-info btn-block')); ?>						</div>
					</div>
				</div><!-- /.box-footer -->
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->
