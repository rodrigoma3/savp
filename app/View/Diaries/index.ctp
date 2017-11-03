<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo __('Diaries'); ?>	</h1>
	<ol class="breadcrumb">
		<li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> '.__('Home'), '/', array('escape' => false)); ?></li>
		<li class="active"><?php echo __('Diaries'); ?></li>
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
							<?php echo $this->Html->link(__('Add Diary'), array('action' => 'add'), array('class' => 'btn btn-success btn-block')); ?>						</div>
					</div>
				</div>
			</div>

			<div class="box box-primary">
				<div class="box-body table-responsive">
					<table class="dataTables table table-bordered table-striped">
						<thead>
							<tr>
																											<th><?php echo __('#'); ?></th>
																																				<th><?php echo __('Date'); ?></th>
																																				<th><?php echo __('Destination Id'); ?></th>
																																				<th><?php echo __('Status'); ?></th>
																																				<th><?php echo __('Car Id'); ?></th>
																																				<th><?php echo __('Driver Id'); ?></th>
																										<th class="actions"><?php echo __('Actions'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($diaries as $diary): ?>
	<tr>
		<td><?php echo h($diary['Diary']['id']); ?>&nbsp;</td>
		<td><?php echo h($diary['Diary']['date']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($diary['Destination']['time'], array('controller' => 'destinations', 'action' => 'view', $diary['Destination']['id'])); ?>
		</td>
		<td><?php echo h($diary['Diary']['status']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($diary['Car']['car_plate'], array('controller' => 'cars', 'action' => 'view', $diary['Car']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($diary['Driver']['name'], array('controller' => 'users', 'action' => 'view', $diary['Driver']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $diary['Diary']['id']), array('class' => 'btn btn-info btn-sm')); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $diary['Diary']['id']), array('class' => 'btn btn-warning btn-sm')); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $diary['Diary']['id']), array('class' => 'btn btn-danger btn-sm', 'confirm' => __('Are you sure you want to delete # %s?', $diary['Diary']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
						</tbody>
						<tfoot>
							<tr>
																											<th><?php echo __('#'); ?></th>
																																				<th><?php echo __('Date'); ?></th>
																																				<th><?php echo __('Destination Id'); ?></th>
																																				<th><?php echo __('Status'); ?></th>
																																				<th><?php echo __('Car Id'); ?></th>
																																				<th><?php echo __('Driver Id'); ?></th>
																										<th class="actions"><?php echo __('Actions'); ?></th>
							</tr>
						</tfoot>
					</table>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->
