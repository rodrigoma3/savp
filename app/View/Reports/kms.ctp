<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo __('KMs'); ?>
	</h1>
	<ol class="breadcrumb">
		<li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> '.__('Home'), '/', array('escape' => false)); ?></li>
		<li><?php echo __('Report'); ?></li>
		<li class="active"><?php echo __('KMs'); ?></li>
	</ol>
</section>


<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">

			<div class="box box-info">
				<div class="box-body">
					<div class="row">
						<div class="col-xs-12">
							<?php echo $this->Form->create(
								'Report',
								array(
									'role' => 'form',
									'inputDefaults' => array(
										'div' => 'form-group col-xs-2',
										'class' => 'form-control',
									)
								)
							); ?>
							<?php
								echo $this->Form->input('start_date');
								echo $this->Form->input('end_date');
								echo $this->Form->input('city_id', array('empty' => __('All'), 'div' => array('class' => 'form-group col-xs-3')));
								echo $this->Form->input('destination_id', array('empty' => __('All'), 'div' => array('class' => 'form-group col-xs-3')));
								echo $this->Form->input('car_id', array('empty' => __('All')));
							?>
							<?php echo $this->Form->end(array('class' => 'btn btn-info btn-block', 'div' => array('class' => 'form-group col-xs-2'), 'type' => 'submit', 'label' => __('Filter'))); ?>
						</div>
					</div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->

			<?php if (isset($kms)): ?>
				<div class="box box-solid">
					<div class="box-header">
                        <h3 class="box-title"><?php echo __('Detailed') ?></h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
					<div class="box-body table-responsive">
						<div class="row">
							<div class="col-xs-12">
								<table class="dataTables table table-bordered table-striped">
									<thead>
										<tr>
											<th><?php echo __('Date'); ?></th>
											<th><?php echo __('Car'); ?></th>
											<th><?php echo __('Initial KM'); ?></th>
											<th><?php echo __('Final KM'); ?></th>
											<th><?php echo __('Total KM'); ?></th>
											<th><?php echo __('City'); ?></th>
											<th><?php echo __('Destination'); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($kms as $km): ?>
											<tr>
												<td><?php echo h($km['diary_date']); ?>&nbsp;</td>
												<td><?php echo h($km['car_name']); ?>&nbsp;</td>
												<td><?php echo h($km['car_initial_km']); ?>&nbsp;</td>
												<td><?php echo h($km['car_final_km']); ?>&nbsp;</td>
												<td><?php echo h($km['car_total_km']); ?>&nbsp;</td>
												<td><?php echo h($km['city_name']); ?>&nbsp;</td>
												<td><?php echo h($km['destination_name']); ?>&nbsp;</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
									<tfoot>
										<tr>
											<th><?php echo __('Date'); ?></th>
											<th><?php echo __('Car'); ?></th>
											<th><?php echo __('Initial KM'); ?></th>
											<th><?php echo __('Final KM'); ?></th>
											<th><?php echo __('Total KM'); ?></th>
											<th><?php echo __('City'); ?></th>
											<th><?php echo __('Destination'); ?></th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div><!-- /.box-body -->
				</div><!-- /.box -->

				<div class="box box-solid">
					<div class="box-header">
                        <h3 class="box-title"><?php echo __('By City') ?></h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
					<div class="box-body table-responsive">
						<div class="row">
							<div class="col-xs-12">
								<table class="dataTables table table-bordered table-striped">
									<thead>
										<tr>
											<th><?php echo __('City'); ?></th>
											<th><?php echo __('Total KM'); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($byCities as $byCity): ?>
											<tr>
												<td><?php echo h($byCity['name']); ?>&nbsp;</td>
												<td><?php echo h($byCity['total_km']); ?>&nbsp;</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
									<tfoot>
										<tr>
											<th><?php echo __('City'); ?></th>
											<th><?php echo __('Total KM'); ?></th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div><!-- /.box-body -->
				</div><!-- /.box -->

				<div class="box box-solid">
					<div class="box-header">
                        <h3 class="box-title"><?php echo __('By Destination') ?></h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
					<div class="box-body table-responsive">
						<div class="row">
							<div class="col-xs-12">
								<table class="dataTables table table-bordered table-striped">
									<thead>
										<tr>
											<th><?php echo __('Destination'); ?></th>
											<th><?php echo __('Total KM'); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($byDestinations as $byDestination): ?>
											<tr>
												<td><?php echo h($byDestination['name']); ?>&nbsp;</td>
												<td><?php echo h($byDestination['total_km']); ?>&nbsp;</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
									<tfoot>
										<tr>
											<th><?php echo __('Destination'); ?></th>
											<th><?php echo __('Total KM'); ?></th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div><!-- /.box-body -->
				</div><!-- /.box -->

				<div class="box box-solid">
					<div class="box-header">
                        <h3 class="box-title"><?php echo __('By Car') ?></h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
					<div class="box-body table-responsive">
						<div class="row">
							<div class="col-xs-12">
								<table class="dataTables table table-bordered table-striped">
									<thead>
										<tr>
											<th><?php echo __('Car'); ?></th>
											<th><?php echo __('Total KM'); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($byCars as $byCar): ?>
											<tr>
												<td><?php echo h($byCar['name']); ?>&nbsp;</td>
												<td><?php echo h($byCar['total_km']); ?>&nbsp;</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
									<tfoot>
										<tr>
											<th><?php echo __('Car'); ?></th>
											<th><?php echo __('Total KM'); ?></th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div><!-- /.box-body -->
				</div><!-- /.box -->

				<?php if (count($byDay) > 1): ?>
					<div class="box box-solid">
						<div class="box-header">
							<h3 class="box-title"><?php echo __('By Day') ?></h3>
							<div class="box-tools pull-right">
								<button class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
								<button class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
							</div>
						</div>
						<div class="box-body chart-responsive">
							<div class="chart" id="ReportKMsByDayChart" style="height: 300px;" data-content='<?php echo json_encode($byDay); ?>'></div>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				<?php endif; ?>

				<?php if (count($byMonth) > 1): ?>
					<div class="box box-solid">
						<div class="box-header">
							<h3 class="box-title"><?php echo __('By Month') ?></h3>
							<div class="box-tools pull-right">
								<button class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
								<button class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
							</div>
						</div>
						<div class="box-body chart-responsive">
							<div class="chart" id="ReportKMsByMonthChart" style="height: 300px;" data-content='<?php echo json_encode($byMonth); ?>'></div>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				<?php endif; ?>

			<?php endif; ?>

		</div>
	</div>

</section><!-- /.content -->
