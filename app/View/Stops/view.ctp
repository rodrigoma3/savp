<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo __('View Stop'); ?>	</h1>
	<ol class="breadcrumb">
		<li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> '.__('Home'), '/', array('escape' => false)); ?></li>
		<li><?php echo $this->Html->link(__('Stops'), array('action' => 'index')); ?></li>
		<li class="active"><?php echo __('View Stop'); ?></li>
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
			<?php echo h($stop['Stop']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Patient'); ?></dt>
		<dd>
			<?php echo $this->Html->link($stop['Patient']['name'], array('controller' => 'users', 'action' => 'view', $stop['Patient']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Companion'); ?></dt>
		<dd>
			<?php echo $this->Html->link($stop['Companion']['name'], array('controller' => 'users', 'action' => 'view', $stop['Companion']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Diary'); ?></dt>
		<dd>
			<?php echo $this->Html->link($stop['Diary']['id'], array('controller' => 'diaries', 'action' => 'view', $stop['Diary']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Establishment'); ?></dt>
		<dd>
			<?php echo $this->Html->link($stop['Establishment']['name'], array('controller' => 'establishments', 'action' => 'view', $stop['Establishment']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Start Time'); ?></dt>
		<dd>
			<?php echo h($stop['Stop']['start_time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('End Time'); ?></dt>
		<dd>
			<?php echo h($stop['Stop']['end_time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Absent'); ?></dt>
		<dd>
			<?php echo $absents[$stop['Stop']['absent']]; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sequence'); ?></dt>
		<dd>
			<?php echo h($stop['Stop']['sequence']); ?>
			&nbsp;
		</dd>
					</dl>
				</div><!-- /.box-body -->
				<div class="box-footer">
					<div class="row">
						<div class="col-xs-3">
							<?php echo $this->Html->link(__('List Stops'), array('action' => 'index'), array('class' => 'btn btn-info btn-block')); ?>						</div>
					</div>
				</div><!-- /.box-footer -->
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->
