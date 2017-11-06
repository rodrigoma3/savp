<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo __('Diary'); ?>	</h1>
	<ol class="breadcrumb">
		<li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> '.__('Home'), '/', array('escape' => false)); ?></li>
		<li><?php echo $this->Html->link(__('Diaries'), array('action' => 'index')); ?></li>
		<li class="active"><?php echo __('Diary'); ?></li>
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
							<?php echo $this->Html->link(__('Open Diary'), array('action' => 'add'), array('class' => 'btn btn-success btn-block')); ?>						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6">
			<div class="box box-warning">
				<div class="box-body no-padding">
					<div id="calendarDiaryView"></div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>

		<div class="col-xs-6">
			<div class="box box-success" id="eventDiaryView">
				<div class="box-header">
                    <i class="fa fa-ambulance"></i>
                    <h3 class="box-title"></h3>
                </div>
				<div class="box-body">

				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->
