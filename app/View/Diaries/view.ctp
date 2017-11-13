<section class="content-header">
	<h1>
		<?php echo __('View Diary'); ?>
	</h1>
	<ol class="breadcrumb">
		<li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> '.__('Home'), '/', array('escape' => false)); ?></li>
		<li><?php echo $this->Html->link(__('Diaries'), array('action' => 'index')); ?></li>
		<li class="active"><?php echo __('View Diary'); ?></li>
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
                        <dd><?php echo h($diary['Diary']['id']); ?>&nbsp;</dd>
                        <dt><?php echo __('Date'); ?></dt>
                        <dd><?php echo h($diary['Diary']['date']); ?>&nbsp;</dd>
                        <dt><?php echo __('Status'); ?></dt>
                        <dd><?php echo __(Inflector::humanize($diary['Diary']['status'])); ?>&nbsp;</dd>
                        <dt><?php echo __('Initial KM'); ?></dt>
                        <dd><?php echo h($diary['Diary']['initial_km']); ?>&nbsp;</dd>
                        <dt><?php echo __('Final KM'); ?></dt>
                        <dd><?php echo h($diary['Diary']['final_km']); ?>&nbsp;</dd>
                        <dt><?php echo __('Created'); ?></dt>
                        <dd><?php echo h($diary['Diary']['created']); ?>&nbsp;</dd>
                        <dt><?php echo __('Modified'); ?></dt>
                        <dd><?php echo h($diary['Diary']['modified']); ?>&nbsp;</dd>
						<?php if ($this->Session->read('Auth.User.role') != 'patient'): ?>
							<dt><?php echo __('Created By'); ?></dt>
							<dd><?php echo h($diary['Diary']['created_user_name']); ?>&nbsp;</dd>
							<dt><?php echo __('Modified By'); ?></dt>
							<dd><?php echo h($diary['Diary']['modified_user_name']); ?>&nbsp;</dd>
						<?php endif; ?>
    				<hr>
                    <h3><?php echo __('Destination'); ?></h3>
                        <dt><?php echo __('City'); ?></dt>
                        <dd><?php echo h($city['City']['name']); ?>&nbsp;</dd>
                        <dt><?php echo __('Time'); ?></dt>
                        <dd><?php echo h($diary['Destination']['time']); ?>&nbsp;</dd>
    				<hr>
                    <h3><?php echo __('Car'); ?></h3>
                        <dt><?php echo __('Manufacturer'); ?></dt>
                        <dd><?php echo h($diary['Car']['manufacturer']); ?>&nbsp;</dd>
                        <dt><?php echo __('Model'); ?></dt>
                        <dd><?php echo h($diary['Car']['model']); ?>&nbsp;</dd>
                        <dt><?php echo __('Year'); ?></dt>
                        <dd><?php echo h($diary['Car']['year']); ?>&nbsp;</dd>
                        <dt><?php echo __('Car Plate'); ?></dt>
                        <dd><?php echo h($diary['Car']['car_plate']); ?>&nbsp;</dd>
                        <dt><?php echo __('Capacity'); ?></dt>
                        <dd><?php echo h($diary['Car']['capacity']); ?>&nbsp;</dd>
                        <dt><?php echo __('Available Accents'); ?></dt>
                        <dd><?php echo ($diary['Car']['capacity'] - count($diary['Stop'])); ?>&nbsp;</dd>
    				<hr>
                    <h3><?php echo __('Driver'); ?></h3>
                        <dt><?php echo __('Name'); ?></dt>
                        <dd><?php echo h($diary['Driver']['name']); ?>&nbsp;</dd>
                        <dt><?php echo __('Document'); ?></dt>
                        <dd><?php echo h($diary['Driver']['document']); ?>&nbsp;</dd>
					</dl>
				</div><!-- /.box-body -->
				<?php if (in_array($this->Session->read('Auth.User.role'), $this->Session->read('perms')[$this->request->params['controller']]['index'])): ?>
					<div class="box-footer">
						<div class="row">
							<div class="col-xs-3">
								<?php echo $this->Html->link(__('List Diaries'), array('action' => 'index'), array('class' => 'btn btn-info btn-block')); ?>
							</div>
						</div>
					</div><!-- /.box-footer -->
				<?php endif; ?>
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->
