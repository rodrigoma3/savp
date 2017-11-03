<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo __('View Car'); ?>
	</h1>
	<ol class="breadcrumb">
		<li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> '.__('Home'), '/', array('escape' => false)); ?></li>
		<li><?php echo $this->Html->link(__('Cars'), array('action' => 'index')); ?></li>
		<li class="active"><?php echo __('View Car'); ?></li>
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
							<?php echo h($car['Car']['id']); ?>
							&nbsp;
						</dd>
						<dt><?php echo __('Manufacturer'); ?></dt>
						<dd>
							<?php echo h($car['Car']['manufacturer']); ?>
							&nbsp;
						</dd>
						<dt><?php echo __('Model'); ?></dt>
						<dd>
							<?php echo h($car['Car']['model']); ?>
							&nbsp;
						</dd>
						<dt><?php echo __('Year'); ?></dt>
						<dd>
							<?php echo h($car['Car']['year']); ?>
							&nbsp;
						</dd>
						<dt><?php echo __('Type'); ?></dt>
						<dd>
							<?php echo h($car['Car']['type']); ?>
							&nbsp;
						</dd>
						<dt><?php echo __('Car Plate'); ?></dt>
						<dd>
							<?php echo h($car['Car']['car_plate']); ?>
							&nbsp;
						</dd>
						<dt><?php echo __('Capacity'); ?></dt>
						<dd>
							<?php echo h($car['Car']['capacity']); ?>
							&nbsp;
						</dd>
						<dt><?php echo __('Enabled'); ?></dt>
						<dd>
							<?php echo h($car['Car']['enabled']); ?>
							&nbsp;
						</dd>
					</dl>
				</div><!-- /.box-body -->
				<div class="box-footer">
					<div class="row">
						<div class="col-xs-3">
							<?php echo $this->Html->link(__('List Cars'), array('action' => 'index'), array('class' => 'btn btn-info btn-block')); ?>
						</div>
					</div>
				</div><!-- /.box-footer -->
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->
