<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo __('Stops'); ?>	</h1>
	<ol class="breadcrumb">
		<li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> '.__('Home'), '/', array('escape' => false)); ?></li>
		<li class="active"><?php echo __('Stops'); ?></li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-danger">
				<div class="box-body">
					<div class="row">
						<div class="col-xs-3">
							<?php echo $this->Html->link(__('Add Stop'), array('action' => 'add'), array('class' => 'btn btn-success btn-block')); ?>						</div>
					</div>
				</div>
			</div>

			<div class="box box-primary">
				<div class="box-body table-responsive">
					<table class="dataTables table table-bordered table-striped">
						<thead>
							<tr>
																											<th><?php echo __('#'); ?></th>
																																				<th><?php echo __('Patient Id'); ?></th>
																																				<th><?php echo __('Companion Id'); ?></th>
																																				<th><?php echo __('Diary Id'); ?></th>
																																				<th><?php echo __('Establishment Id'); ?></th>
																																				<th><?php echo __('Start Time'); ?></th>
																																				<th><?php echo __('End Time'); ?></th>
																																				<th><?php echo __('Absent'); ?></th>
																																				<th><?php echo __('Sequence'); ?></th>
																										<th class="actions"><?php echo __('Actions'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($stops as $stop): ?>
	<tr>
		<td><?php echo h($stop['Stop']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($stop['Patient']['name'], array('controller' => 'users', 'action' => 'view', $stop['Patient']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($stop['Companion']['name'], array('controller' => 'users', 'action' => 'view', $stop['Companion']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($stop['Diary']['id'], array('controller' => 'diaries', 'action' => 'view', $stop['Diary']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($stop['Establishment']['name'], array('controller' => 'establishments', 'action' => 'view', $stop['Establishment']['id'])); ?>
		</td>
		<td><?php echo h($stop['Stop']['start_time']); ?>&nbsp;</td>
		<td><?php echo h($stop['Stop']['end_time']); ?>&nbsp;</td>
		<td><?php echo h($stop['Stop']['absent']); ?>&nbsp;</td>
		<td><?php echo h($stop['Stop']['sequence']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $stop['Stop']['id']), array('class' => 'btn btn-info btn-sm')); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $stop['Stop']['id']), array('class' => 'btn btn-warning btn-sm')); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $stop['Stop']['id']), array('class' => 'btn btn-danger btn-sm', 'confirm' => __('Are you sure you want to delete # %s?', $stop['Stop']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
						</tbody>
						<tfoot>
							<tr>
																											<th><?php echo __('#'); ?></th>
																																				<th><?php echo __('Patient Id'); ?></th>
																																				<th><?php echo __('Companion Id'); ?></th>
																																				<th><?php echo __('Diary Id'); ?></th>
																																				<th><?php echo __('Establishment Id'); ?></th>
																																				<th><?php echo __('Start Time'); ?></th>
																																				<th><?php echo __('End Time'); ?></th>
																																				<th><?php echo __('Absent'); ?></th>
																																				<th><?php echo __('Sequence'); ?></th>
																										<th class="actions"><?php echo __('Actions'); ?></th>
							</tr>
						</tfoot>
					</table>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->
