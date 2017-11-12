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
					),
					'url' => array(
						'action' => 'report',
					),
				)
			); ?>

			<div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?php echo __('Fields'); ?></h3>
                </div>
				<div class="box-body">
					<div class="row">
						<div class="col-xs-12">
							<?php echo $this->Form->input('fields', array('class' => 'form-control duallistbox', 'label' => false, 'multiple' => true)); ?>
						</div>
					</div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->

			<div class="box box-danger">
                <div class="box-header">
                    <h3 class="box-title"><?php echo __('Conditions'); ?></h3>
                </div>
				<div class="box-body">
					<div class="row">
						<div class="col-xs-12">
							<?php echo $this->Form->input('condition_field_list', array('options' => $flattenFields, 'div' => array('class' => 'form-group col-xs-4'))); ?>
							<?php echo $this->Form->input('condition_operator', array('options' => $conditionOperators, 'div' => array('class' => 'form-group col-xs-4'))); ?>
							<?php echo $this->Form->input('condition_field', array('options' => $flattenFields, 'div' => array('class' => 'form-group col-xs-4'))); ?>
							<?php echo $this->Form->input('condition_what', array('div' => array('class' => 'form-group col-xs-6'))); ?>
							<?php echo $this->Form->input('what_or_field', array('legend' => false, 'options' => array('what' => 'what', 'field' => 'field'), 'default' => 'what', 'type' => 'radio', 'div' => array('class' => 'form-group col-xs-2'))); ?>
							<div class="col-xs-4">
								<div class="row">
									<?php echo $this->Form->button(__('AND'), array('type' => 'button', 'id' => 'btnAddConditionFieldAnd', 'class' => 'btn btn-default', 'escape' => false)); ?>
									<?php echo $this->Form->button(__('OR'), array('type' => 'button', 'id' => 'btnAddConditionFieldOr', 'class' => 'btn btn-default', 'escape' => false)); ?>
									<?php echo $this->Form->button('(', array('type' => 'button', 'id' => 'btnAddConditionFieldPL', 'class' => 'btn btn-default', 'escape' => false)); ?>
									<?php echo $this->Form->button(')', array('type' => 'button', 'id' => 'btnAddConditionFieldPR', 'class' => 'btn btn-default', 'escape' => false)); ?>
								</div>
								<br>
								<div class="row">
									<?php echo $this->Form->button('<i class="fa fa-plus" aria-hidden="true"></i>', array('type' => 'button', 'id' => 'btnAddConditionField', 'class' => 'btn btn-info', 'escape' => false)); ?>
									<?php echo $this->Form->button(__('Clear'), array('type' => 'button', 'id' => 'btnClearConditionField', 'class' => 'btn btn-danger', 'escape' => false)); ?>
								</div>
								<br>
							</div>
							<?php echo $this->Form->input('conditions', array('type' => 'select', 'multiple' => true, 'div' => array('class' => 'form-group col-xs-12'))); ?>
						</div>
					</div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->

			<div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title"><?php echo __('Orders'); ?></h3>
                </div>
				<div class="box-body">
					<div class="row">
						<div class="col-xs-12">
							<?php echo $this->Form->input('order_field', array('options' => $flattenFields, 'div' => array('class' => 'form-group col-xs-4'))); ?>
							<?php echo $this->Form->input('order_direction', array('options' => array('ASC' => 'ASC', 'DESC' => 'DESC'), 'div' => array('class' => 'form-group col-xs-2'))); ?>
							<?php echo $this->Form->button('<i class="fa fa-plus" aria-hidden="true"></i>', array('type' => 'button', 'id' => 'btnAddOrderField', 'class' => 'btn btn-info', 'escape' => false)); ?>
							<?php echo $this->Form->button(__('Clear'), array('type' => 'button', 'id' => 'btnClearOrderField', 'class' => 'btn btn-danger', 'escape' => false)); ?>
							<?php echo $this->Form->input('order', array('type' => 'select', 'multiple' => true, 'div' => array('class' => 'form-group col-xs-12'))); ?>
						</div>
					</div>
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
