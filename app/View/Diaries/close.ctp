<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
        <?php echo $diary['Destination']['City']['name'].' - '.$diary['Diary']['date'].' - '.$diary['Destination']['time']; ?>
    </h1>
	<ol class="breadcrumb">
		<li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> '.__('Home'), '/', array('escape' => false)); ?></li>
		<li><?php echo $this->Html->link(__('Diaries'), array('action' => 'index')); ?></li>
		<li class="active"><?php echo __('Close'); ?></li>
	</ol>
</section>

<?php if ($diary['Diary']['status'] == 'in_progress'): ?>
    <?php echo $this->Form->create(
        'Diary',
        array(
            'role' => 'form',
            'inputDefaults' => array(
                'div' => 'form-group col-xs-6',
                'class' => 'form-control',
            )
        )
    ); ?>
<?php endif; ?>

<section class="content">
    <h4 class="page-header">
        <small>
            <?php echo __('Status: %s', Inflector::humanize($diary['Diary']['status'])).' - '.__('Capacity: %s', $diary['Car']['capacity']).' - '.__('Available Accents: %s', $availableAccents); ?>
        </small>
    </h4>

    <div class="row">
		<div class="col-xs-12">
			<div class="box box-danger">
				<div class="box-body">
					<div class="row">
						<?php if ($diary['Diary']['status'] == 'in_progress'): ?>
							<div class="col-xs-3">
								<?php echo $this->Form->button(__('Save'), array('type' => 'submit', 'class' => 'btn btn-primary btn-block')); ?>
							</div>
							<div class="col-xs-3">
								<?php echo $this->Html->link(__('Close Diary'), '#', array('class' => 'btn btn-danger btn-block', 'data-confirm' => __('Are you sure you want to close this diary?'), 'id' => 'DiaryBtnCloseDiary')); ?>
							</div>
						<?php endif; ?>
						<?php if (in_array($this->Session->read('Auth.User.role'), $this->Session->read('perms')[$this->request->params['controller']]['printStops'])): ?>
							<div class="col-xs-3">
								<?php echo $this->Html->link(__('Print'), array('action' => 'printStops', $diary['Diary']['id']), array('class' => 'btn btn-info btn-block', 'target' => '_blank')); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

    <div class="row">
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-body">
						<?php if ($diary['Diary']['status'] == 'in_progress'): ?>
							<div class="row">
								<?php echo $this->Form->input('Diary.id'); ?>
								<?php echo $this->Form->input('Diary.status', array('type' => 'hidden')); ?>
								<?php echo $this->Form->input('Diary.driver_id'); ?>
								<?php echo $this->Form->input('Diary.car_id'); ?>
								<?php echo $this->Form->input('Diary.initial_km', array('min' => 1)); ?>
								<?php echo $this->Form->input('Diary.final_km', array('min' => 1)); ?>
							</div>
						<?php else: ?>
							<div class="row invoice-info">
						        <div class="col-sm-4 invoice-col">
						            <b><?php echo __('Driver name: '); ?></b><?php echo $diary['Driver']['name']; ?><br>
						            <b><?php echo __('Driver document: '); ?></b><?php echo $diary['Driver']['document']; ?>
						        </div><!-- /.col -->
						        <div class="col-sm-4 invoice-col">
						            <b><?php echo __('Car model: '); ?></b><?php echo $diary['Car']['model']; ?><br>
						            <b><?php echo __('Car plate: '); ?></b><?php echo $diary['Car']['car_plate']; ?>
						        </div><!-- /.col -->
						        <div class="col-sm-4 invoice-col">
						            <b><?php echo __('Initial KM: '); ?></b><?php echo $diary['Diary']['initial_km']; ?><br>
						            <b><?php echo __('Final KM: '); ?></b><?php echo $diary['Diary']['final_km']; ?>
						        </div><!-- /.col -->
						    </div><!-- /.row -->
						<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

    <div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-body">
                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <?php if (empty($diary['Stop'])): ?>
                                <p>
                                    <?php echo __('No scheduled stops'); ?>
                                </p>
                            <?php else: ?>
                                <?php $companions = Hash::combine($diary['Stop'], '{n}.companion_id', '{n}.Patient.name'); ?>
                                <?php $diary['Stop'] = Hash::sort($diary['Stop'], '{n}.sequence', 'asc', 'numeric'); ?>
                                <table class="table table-striped center">
                                    <thead>
                                        <tr>
                                            <th class="center"><?php echo __('#'); ?></th>
                                            <th class="center"><?php echo __('Name'); ?></th>
                                            <th class="center"><?php echo __('Document'); ?></th>
                                            <th class="center"><?php echo __('Companion of the'); ?></th>
                                            <th class="center"><?php echo __('Establishment'); ?></th>
                                            <th class="center"><?php echo __('Start Time'); ?></th>
                                            <th class="center"><?php echo __('End Time'); ?></th>
                                            <th class="center"><?php echo __('Bedridden'); ?></th>
                                            <th class="center"><?php echo __('Absent'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $count = 1; ?>
                                        <?php foreach ($diary['Stop'] as $key => $stop): ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>
                                                <td><?php echo h($stop['Patient']['name']); ?></td>
                                                <td><?php echo h($stop['Patient']['document']); ?></td>
                                                <?php if (isset($companions[$stop['patient_id']]) && !empty($companions[$stop['patient_id']])): ?>
                                                    <td><?php echo h($companions[$stop['patient_id']]); ?></td>
                                                <?php else: ?>
                                                    <td>&nbsp;</td>
                                                <?php endif; ?>
                                                <td><?php echo h($stop['Establishment']['name']); ?></td>
                                                <td><?php echo h($stop['start_time']); ?></td>
                                                <td><?php echo h($stop['end_time']); ?></td>
												<?php if ($diary['Diary']['status'] == 'in_progress'): ?>
													<?php echo $this->Form->input('Stop.'.$key.'.id', array('value' => $stop['id'])); ?>
													<td><?php echo $this->Form->input('Stop.'.$key.'.bedridden', array('checked' => $stop['bedridden'], 'label' => false)); ?></td>
													<td><?php echo $this->Form->input('Stop.'.$key.'.absent', array('checked' => $stop['absent'], 'label' => false)); ?></td>
												<?php else: ?>
													<?php if ($stop['bedridden']): ?>
					                                    <td><i class="fa fa-check-square-o" aria-hidden="true" style="font-size: 20px;"></i></td>
					                                <?php else: ?>
					                                    <td><i class="fa fa-square-o" aria-hidden="true" style="font-size: 20px;"></i></td>
					                                <?php endif; ?>
													<?php if ($stop['absent']): ?>
					                                    <td><i class="fa fa-check-square-o" aria-hidden="true" style="font-size: 20px;"></i></td>
					                                <?php else: ?>
					                                    <td><i class="fa fa-square-o" aria-hidden="true" style="font-size: 20px;"></i></td>
					                                <?php endif; ?>
												<?php endif; ?>
                                            </tr>
                                            <?php $count++; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div>
    		</div>
		</div>
	</div>
</section>
<?php debug($diary); ?>

<?php if ($diary['Diary']['status'] == 'in_progress'): ?>
    <?php echo $this->Form->end(); ?>
<?php endif; ?>
