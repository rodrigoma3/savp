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

			<?php echo $this->Form->create(
				'Report',
				array(
					'role' => 'form',
					'inputDefaults' => array(
						'div' => 'form-group col-xs-6',
						'class' => 'form-control',
					)
				)
			); ?>

			<div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?php echo __('Fields'); ?></h3>
                </div>
				<div class="box-body">

				</div><!-- /.box-body -->
			</div><!-- /.box -->

			<div class="box box-danger">
                <div class="box-header">
                    <h3 class="box-title"><?php echo __('Conditions'); ?></h3>
                </div>
				<div class="box-body">

				</div><!-- /.box-body -->
			</div><!-- /.box -->

			<div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title"><?php echo __('Order'); ?></h3>
                </div>
				<div class="box-body">

				</div><!-- /.box-body -->
			</div><!-- /.box -->

			<div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title"><?php echo __('Group By'); ?></h3>
                </div>
				<div class="box-body">

				</div><!-- /.box-body -->
			</div><!-- /.box -->

			<div class="box box-success">
				<div class="box-body">
					<div class="row">
						<?php echo $this->Form->end(array('class' => 'btn btn-success btn-block', 'div' => array('class' => 'col-xs-3'), 'type' => 'submit', 'label' => __('Submit'))); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

</section><!-- /.content -->
