<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo __('View Destination'); ?>	</h1>
	<ol class="breadcrumb">
		<li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> '.__('Home'), '/', array('escape' => false)); ?></li>
		<li><?php echo $this->Html->link(__('Destinations'), array('action' => 'index')); ?></li>
		<li class="active"><?php echo __('View Destination'); ?></li>
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
			<?php echo h($destination['Destination']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo $this->Html->link($destination['City']['name'], array('controller' => 'cities', 'action' => 'view', $destination['City']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Time'); ?></dt>
		<dd>
			<?php echo h($destination['Destination']['time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Enabled'); ?></dt>
		<dd>
			<?php echo h($destination['Destination']['enabled']); ?>
			&nbsp;
		</dd>
					</dl>
				</div><!-- /.box-body -->
				<div class="box-footer">
					<div class="row">
						<div class="col-xs-3">
							<?php echo $this->Html->link(__('List Destinations'), array('action' => 'index'), array('class' => 'btn btn-info btn-block')); ?>						</div>
					</div>
				</div><!-- /.box-footer -->
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->
