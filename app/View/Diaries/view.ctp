<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo __('View Diary'); ?>	</h1>
	<ol class="breadcrumb">
		<li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> '.__('Home'), '/', array('escape' => false)); ?></li>
		<li><?php echo $this->Html->link(__('Diaries'), array('action' => 'index')); ?></li>
		<li class="active"><?php echo __('View Diary'); ?></li>
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
			<?php echo h($diary['Diary']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date'); ?></dt>
		<dd>
			<?php echo h($diary['Diary']['date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Destination'); ?></dt>
		<dd>
			<?php echo $this->Html->link($diary['Destination']['time'], array('controller' => 'destinations', 'action' => 'view', $diary['Destination']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($diary['Diary']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Car'); ?></dt>
		<dd>
			<?php echo $this->Html->link($diary['Car']['car_plate'], array('controller' => 'cars', 'action' => 'view', $diary['Car']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Driver'); ?></dt>
		<dd>
			<?php echo $this->Html->link($diary['Driver']['name'], array('controller' => 'users', 'action' => 'view', $diary['Driver']['id'])); ?>
			&nbsp;
		</dd>
					</dl>
				</div><!-- /.box-body -->
				<div class="box-footer">
					<div class="row">
						<div class="col-xs-3">
							<?php echo $this->Html->link(__('List Diaries'), array('action' => 'index'), array('class' => 'btn btn-info btn-block')); ?>						</div>
					</div>
				</div><!-- /.box-footer -->
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->
