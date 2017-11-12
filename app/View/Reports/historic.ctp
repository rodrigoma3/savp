<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo __('Historic'); ?>
	</h1>
	<ol class="breadcrumb">
		<li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> '.__('Home'), '/', array('escape' => false)); ?></li>
		<li class="active"><?php echo __('Historic'); ?></li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?php echo __('As a patient'); ?></h3>
                </div>
				<div class="box-body table-responsive">
					<table class="dataTables table table-bordered table-striped">
						<thead>
							<tr>
                                <th><?php echo __('Date'); ?></th>
								<th><?php echo __('Start Time'); ?></th>
								<th><?php echo __('End Time'); ?></th>
                                <th><?php echo __('Bedridden'); ?></th>
                                <th><?php echo __('Absent'); ?></th>
								<th><?php echo __('Establishment'); ?></th>
                                <th><?php echo __('City'); ?></th>
								<th><?php echo __('Companion'); ?></th>
								<th><?php echo __('Companion Absent'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($patients as $patient): ?>
								<tr>
									<td><?php echo h($patient['Diary']['date']); ?>&nbsp;</td>
									<td><?php echo h($patient['Stop']['start_time']); ?>&nbsp;</td>
									<td><?php echo h($patient['Stop']['end_time']); ?>&nbsp;</td>
									<td><?php echo h($bedriddens[$patient['Stop']['bedridden']]); ?>&nbsp;</td>
									<td><?php echo h($absents[$patient['Stop']['absent']]); ?>&nbsp;</td>
									<td><?php echo h($patient['Establishment']['name']); ?>&nbsp;</td>
									<td><?php echo h($cities[$patient['Establishment']['city_id']]); ?>&nbsp;</td>
                                    <td><?php echo h(@$patient['Companion']['name'].' - '.@$patient['Companion']['document']); ?>&nbsp;</td>
                                    <td><?php echo h($absents[$patientCompanions[$patient['Stop']['diary_id']]]); ?>&nbsp;</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
						<tfoot>
							<tr>
                                <th><?php echo __('Date'); ?></th>
								<th><?php echo __('Start Time'); ?></th>
								<th><?php echo __('End Time'); ?></th>
                                <th><?php echo __('Bedridden'); ?></th>
                                <th><?php echo __('Absent'); ?></th>
								<th><?php echo __('Establishment'); ?></th>
                                <th><?php echo __('City'); ?></th>
								<th><?php echo __('Companion'); ?></th>
								<th><?php echo __('Companion Absent'); ?></th>
							</tr>
						</tfoot>
					</table>
				</div><!-- /.box-body -->
			</div><!-- /.box -->

			<div class="box box-danger">
                <div class="box-header">
                    <h3 class="box-title"><?php echo __('As a companion'); ?></h3>
                </div>
				<div class="box-body table-responsive">
					<table class="dataTables table table-bordered table-striped">
						<thead>
							<tr>
                                <th><?php echo __('Date'); ?></th>
                                <th><?php echo __('Patient'); ?></th>
								<th><?php echo __('Start Time'); ?></th>
								<th><?php echo __('End Time'); ?></th>
                                <th><?php echo __('Bedridden'); ?></th>
                                <th><?php echo __('Patient Absent'); ?></th>
								<th><?php echo __('Establishment'); ?></th>
                                <th><?php echo __('City'); ?></th>
                                <th><?php echo __('Absent'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($companions as $companion): ?>
								<tr>
									<td><?php echo h($companion['Diary']['date']); ?>&nbsp;</td>
                                    <td><?php echo h($companion['Patient']['name'].' - '.$companion['Patient']['document']); ?>&nbsp;</td>
									<td><?php echo h($companion['Stop']['start_time']); ?>&nbsp;</td>
									<td><?php echo h($companion['Stop']['end_time']); ?>&nbsp;</td>
									<td><?php echo h($bedriddens[$companion['Stop']['bedridden']]); ?>&nbsp;</td>
                                    <td><?php echo h($absents[$companionPatients[$companion['Stop']['diary_id']]]); ?>&nbsp;</td>
									<td><?php echo h($companion['Establishment']['name']); ?>&nbsp;</td>
									<td><?php echo h($cities[$companion['Establishment']['city_id']]); ?>&nbsp;</td>
                                    <td><?php echo h($absents[$companion['Stop']['absent']]); ?>&nbsp;</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
						<tfoot>
							<tr>
                                <th><?php echo __('Date'); ?></th>
                                <th><?php echo __('Patient'); ?></th>
								<th><?php echo __('Start Time'); ?></th>
								<th><?php echo __('End Time'); ?></th>
                                <th><?php echo __('Bedridden'); ?></th>
                                <th><?php echo __('Patient Absent'); ?></th>
								<th><?php echo __('Establishment'); ?></th>
                                <th><?php echo __('City'); ?></th>
                                <th><?php echo __('Absent'); ?></th>
							</tr>
						</tfoot>
					</table>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->
