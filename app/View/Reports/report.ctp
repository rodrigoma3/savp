<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo __('Report'); ?>
	</h1>
	<ol class="breadcrumb">
		<li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> '.__('Home'), '/', array('escape' => false)); ?></li>
		<li class="active"><?php echo __('Report'); ?></li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
                <div class="box-body table-responsive">
					<?php debug($fields); ?>
					<?php debug($result); ?>
					<!-- <table class="dataTables table table-bordered table-striped">
						<thead>
							<tr>
								<?php foreach ($fields as $field): ?>
									<th><?php echo __(Inflector::humanize(str_replace('.', ' ', $field))); ?></th>
								<?php endforeach; ?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($patients as $patient): ?>
								<tr>
									<?php

									?>
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
								<?php foreach ($fields as $field): ?>
									<th><?php echo __(Inflector::humanize(str_replace('.', ' ', $field))); ?></th>
								<?php endforeach; ?>
							</tr>
						</tfoot>
					</table> -->
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->
