<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo __('Patients'); ?>	</h1>
	<ol class="breadcrumb">
		<li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> '.__('Home'), '/', array('escape' => false)); ?></li>
		<li class="active"><?php echo __('Patients'); ?></li>
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
							<?php echo $this->Html->link(__('Add Patient'), array('action' => 'add', 'type' => 'paciente'), array('class' => 'btn btn-success btn-block')); ?>
						</div>
					</div>
				</div>
			</div>

			<div class="box box-primary">
				<div class="box-body table-responsive">
					<table class="dataTables table table-bordered table-striped">
						<thead>
							<tr>
								<th><?php echo __('#'); ?></th>
								<th><?php echo __('Name'); ?></th>
								<th><?php echo __('Document'); ?></th>
								<th><?php echo __('City'); ?></th>
								<th><?php echo __('Email'); ?></th>
								<th><?php echo __('Enabled'); ?></th>
								<th class="actions"><?php echo __('Actions'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($users as $user): ?>
								<tr>
									<td><?php echo h($user['User']['id']); ?>&nbsp;</td>
									<td><?php echo h($user['User']['name']); ?>&nbsp;</td>
									<td><?php echo h($user['User']['document']); ?>&nbsp;</td>
									<td>
										<?php echo $this->Html->link($user['City']['name'], array('controller' => 'cities', 'action' => 'view', $user['City']['id'])); ?>
									</td>
									<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
									<td><?php echo $enableds[$user['User']['enabled']]; ?>&nbsp;</td>
									<td class="actions">
										<?php echo $this->Html->link(__('View'), array('action' => 'view', $user['User']['id']), array('class' => 'btn btn-info btn-sm')); ?>
										<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id']), array('class' => 'btn btn-warning btn-sm')); ?>
										<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $user['User']['id']), array('class' => 'btn btn-danger btn-sm', 'confirm' => __('Are you sure you want to delete # %s?', $user['User']['id']))); ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
						<tfoot>
							<tr>
								<th><?php echo __('#'); ?></th>
								<th><?php echo __('Name'); ?></th>
								<th><?php echo __('Document'); ?></th>
								<th><?php echo __('City'); ?></th>
								<th><?php echo __('Email'); ?></th>
								<th><?php echo __('Enabled'); ?></th>
								<th class="actions"><?php echo __('Actions'); ?></th>
							</tr>
						</tfoot>
					</table>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->
