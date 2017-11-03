<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php printf("<?php echo __('%s %s'); ?>", Inflector::humanize($action), $singularHumanName); ?>
	</h1>
	<ol class="breadcrumb">
		<li><?php echo "<?php echo \$this->Html->link('<i class=\"fa fa-dashboard\"></i> '.__('Home'), '/', array('escape' => false)); ?>"; ?></li>
		<li><?php echo "<?php echo \$this->Html->link(__('{$pluralHumanName}'), array('action' => 'index')); ?>"; ?></li>
		<li class="active"><?php printf("<?php echo __('%s %s'); ?>", Inflector::humanize($action), $singularHumanName); ?></li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-<?php echo (strpos($action, 'add') !== false) ? 'success' : 'warning'; ?>">
				<?php echo "<?php echo \$this->Form->create(
					'{$modelClass}',
					array(
						'role' => 'form',
						'inputDefaults' => array(
							'div' => 'form-group col-xs-6',
							'class' => 'form-control',
						)
					)
				); ?>"; ?>
				<div class="box-body">
					<div class="row">
						<?php
								echo "\t<?php\n";
								foreach ($fields as $field) {
									if (strpos($action, 'add') !== false && $field === $primaryKey) {
										continue;
									} elseif (!in_array($field, array('created', 'modified', 'updated'))) {
										echo "\t\techo \$this->Form->input('{$field}');\n";
									}
								}
								if (!empty($associations['hasAndBelongsToMany'])) {
									foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
										echo "\t\techo \$this->Form->input('{$assocName}');\n";
									}
								}
								echo "\t?>\n";
						?>
					</div>
				</div><!-- /.box-body -->
				<div class="box-footer">
					<div class="row">
						<?php if (strpos($action, 'add') !== false): ?>
							<?php echo "<?php echo \$this->Form->end(array('class' => 'btn btn-success btn-block', 'div' => array('class' => 'col-xs-3'), 'type' => 'submit', 'label' => __('Submit'))); ?>"; ?>
						<?php else: ?>
							<?php echo "<?php echo \$this->Form->end(array('class' => 'btn btn-warning btn-block', 'div' => array('class' => 'col-xs-3'), 'type' => 'submit', 'label' => __('Submit'))); ?>"; ?>
						<?php endif; ?>
					</div>
				</div><!-- /.box-footer -->
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->
