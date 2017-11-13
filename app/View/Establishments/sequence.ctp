<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo __('Sequence'); ?>	</h1>
	<ol class="breadcrumb">
		<li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> '.__('Home'), '/', array('escape' => false)); ?></li>
		<li><?php echo $this->Html->link(__('Establishment'), array('action' => 'index')); ?></li>
		<li class="active"><?php echo __('Sequence'); ?></li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<?php echo $this->Form->create(
				'Establishment',
				array(
					'role' => 'form',
					'inputDefaults' => array(
						'div' => 'form-group col-xs-6',
						'class' => 'form-control',
					)
				)
			); ?>

			<div class="box box-info">
				<div class="box-body">
					<div class="row">
						<div class="col-xs-12">
							<?php
								echo $this->Form->input('city_id');
							?>
							<?php echo $this->Form->button(__('Search'), array('type' => 'button', 'class' => 'btn btn-info', 'id' => 'EstablishmentBtnSearch')); ?>
						</div>
					</div>
				</div>
			</div>


			<div class="box box-primary">
				<div class="box-body">
					<div class="row">
						<div class="col-xs-3">
							<?php
								echo $this->Form->input('sequence', array('type' => 'hidden'));
							?>
							<?php echo $this->Form->button(__('Save Sequence'), array('type' => 'submit', 'class' => 'btn btn-primary btn-block')); ?>
						</div>
					</div>
				</div>
			</div>

			<?php echo $this->Form->end(); ?>

			<div class="box box-success">
				<div class="box-body">
					<ul class="todo-list">
						<p><?php echo __('No establishment'); ?></p>
					</ul>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->

<li class="item-list-model hide" data-establishment="">
	<!-- drag handle -->
	<span class="handle">
		<i class="fa fa-ellipsis-v"></i>
		<i class="fa fa-ellipsis-v"></i>
	</span>
	<!-- todo text -->
	<span class="text"></span>
	<!-- General tools such as edit or delete-->
	<div class="tools">

	</div>
</li>
