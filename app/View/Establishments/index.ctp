<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo __('Establishments'); ?>	</h1>
	<ol class="breadcrumb">
		<li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> '.__('Home'), '/', array('escape' => false)); ?></li>
		<li class="active"><?php echo __('Establishments'); ?></li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<?php if (in_array($this->Session->read('Auth.User.role'), $this->Session->read('perms')[$this->request->params['controller']]['add']) || in_array($this->Session->read('Auth.User.role'), $this->Session->read('perms')[$this->request->params['controller']]['sequence'])): ?>
				<div class="box box-danger">
					<div class="box-body">
						<div class="row">
							<?php if (in_array($this->Session->read('Auth.User.role'), $this->Session->read('perms')[$this->request->params['controller']]['add'])): ?>
								<div class="col-xs-3">
									<?php echo $this->Html->link(__('Add Establishment'), array('action' => 'add'), array('class' => 'btn btn-success btn-block')); ?>
								</div>
							<?php endif; ?>
							<?php if (in_array($this->Session->read('Auth.User.role'), $this->Session->read('perms')[$this->request->params['controller']]['sequence'])): ?>
								<div class="col-xs-3">
									<?php echo $this->Html->link(__('Update Sequence'), array('action' => 'sequence'), array('class' => 'btn btn-primary btn-block')); ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<div class="box box-primary">
				<div class="box-body table-responsive">
					<table class="dataTables table table-bordered table-striped">
						<thead>
							<tr>
								<th><?php echo __('#'); ?></th>
								<th><?php echo __('Name'); ?></th>
								<th><?php echo __('Phone'); ?></th>
								<th><?php echo __('City'); ?></th>
								<th><?php echo __('Sequence'); ?></th>
								<th><?php echo __('Enabled'); ?></th>
								<th class="actions"><?php echo __('Actions'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($establishments as $establishment): ?>
								<tr>
									<td><?php echo h($establishment['Establishment']['id']); ?>&nbsp;</td>
									<td><?php echo h($establishment['Establishment']['name']); ?>&nbsp;</td>
									<td><?php echo h($establishment['Establishment']['phone']); ?>&nbsp;</td>
									<td>
										<?php echo $this->Html->link($establishment['City']['name'], array('controller' => 'cities', 'action' => 'view', $establishment['City']['id'])); ?>
									</td>
									<td><?php echo h($establishment['Establishment']['sequence']); ?>&nbsp;</td>
									<td><?php echo $enableds[$establishment['Establishment']['enabled']]; ?>&nbsp;</td>
									<td class="actions">
										<?php if (in_array($this->Session->read('Auth.User.role'), $this->Session->read('perms')[$this->request->params['controller']]['view'])): ?>
											<?php echo $this->Html->link(__('View'), array('action' => 'view', $establishment['Establishment']['id']), array('class' => 'btn btn-info btn-sm')); ?>
										<?php endif; ?>
										<?php if (in_array($this->Session->read('Auth.User.role'), $this->Session->read('perms')[$this->request->params['controller']]['edit'])): ?>
											<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $establishment['Establishment']['id']), array('class' => 'btn btn-warning btn-sm')); ?>
										<?php endif; ?>
										<?php if (in_array($this->Session->read('Auth.User.role'), $this->Session->read('perms')[$this->request->params['controller']]['delete'])): ?>
											<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $establishment['Establishment']['id']), array('class' => 'btn btn-danger btn-sm', 'confirm' => __('Are you sure you want to delete # %s?', $establishment['Establishment']['id']))); ?>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
						<tfoot>
							<tr>
								<th><?php echo __('#'); ?></th>
								<th><?php echo __('Name'); ?></th>
								<th><?php echo __('Phone'); ?></th>
								<th><?php echo __('City'); ?></th>
								<th><?php echo __('Sequence'); ?></th>
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
