<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo __('Stops for %s', $diary['Diary']['date'].' - '.$diary['Destination']['City']['name'].' - '.$diary['Destination']['time'].' - '.$diary['Car']['model'].' - '.$diary['Car']['car_plate']); ?>	</h1>
	<ol class="breadcrumb">
		<li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> '.__('Home'), '/', array('escape' => false)); ?></li>
		<li class="active"><?php echo __('Stops'); ?></li>
	</ol>
</section>
<?php $availableAccents = $diary['Car']['capacity'] - count($diary['Stop']); ?>
<!-- Main content -->
<section class="content">
	<h4 class="page-header"><small><?php echo __('Capacity: %s', $diary['Car']['capacity']).' - '.__('Available Accents: %s', $availableAccents).' - '.__('Driver: %s', $diary['Driver']['name']); ?></small></h4>
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-danger">
				<div class="box-body">
					<div class="row">
						<?php if ($availableAccents > 0): ?>
							<div class="col-xs-3">
								<?php echo $this->Html->link(__('Add Stop'), array('action' => 'add', 'diary' => $diary['Diary']['id']), array('class' => 'btn btn-success btn-block')); ?>
							</div>
						<?php endif; ?>
						<div class="col-xs-3">
							<?php echo $this->Form->create(
								'Stop',
								array(
									'role' => 'form',
									'inputDefaults' => array(
										'div' => 'form-group col-xs-6',
										'class' => 'form-control',
									)
								)
							); ?>
							<?php
								echo $this->Form->input('sequence', array('type' => 'hidden'));
							?>
							<?php echo $this->Form->button(__('Save Sequence'), array('type' => 'submit', 'class' => 'btn btn-primary btn-block')); ?>
							<?php echo $this->Form->end(); ?>
						</div>
						<div class="col-xs-3">
							<?php echo $this->Html->link(__('Print'), array('action' => 'printStops', 'diary' => $diary['Diary']['id']), array('class' => 'btn btn-info btn-block', 'target' => '_blank')); ?>
						</div>
					</div>
				</div>
			</div>

			<div class="box box-primary">
				<div class="box-body">
					<?php if (empty($diary['Stop'])): ?>
						<?php echo __('No scheduled stops'); ?>
					<?php else: ?>
						<?php $companions = Hash::combine($diary['Stop'], '{n}.companion_id', '{n}.Patient.name'); ?>
						<?php $diary['Stop'] = Hash::sort($diary['Stop'], '{n}.sequence', 'asc', 'numeric'); ?>
						<ul class="todo-list">
							<?php foreach ($diary['Stop'] as $stop): ?>
								<li data-stop="<?php echo $stop['id']; ?>">
									<!-- drag handle -->
									<span class="handle">
										<i class="fa fa-ellipsis-v"></i>
										<i class="fa fa-ellipsis-v"></i>
									</span>
									<!-- todo text -->
									<span class="text"><?php echo __('Name: %s', $stop['Patient']['name']);
									if (isset($companions[$stop['patient_id']]) && !empty($companions[$stop['patient_id']])) {
										echo ' '.__('(companion of the %s)', $companions[$stop['patient_id']]);
									}
									echo ' - '.__('Document: %s', $stop['Patient']['document']).' - '.__('Establishment: %s', $stop['Establishment']['name']); ?></span>
									<!-- Emphasis label -->
									<small class="label label-success"><i class="fa fa-clock-o"></i> <?php echo $stop['start_time']; ?></small>
									<small class="label label-danger"><i class="fa fa-clock-o"></i> <?php echo $stop['end_time']; ?></small>
									<!-- General tools such as edit or delete-->
									<div class="tools">
										<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $stop['id'], 'diary' => $diary['Diary']['id']), array('class' => 'btn btn-warning btn-sm')); ?>
										<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $stop['id'], 'diary' => $diary['Diary']['id']), array('class' => 'btn btn-danger btn-sm', 'confirm' => __('Are you sure you want to delete # %s?', $stop['id']))); ?>
									</div>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->
