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
		<?php echo "<?php echo __('{$pluralHumanName}'); ?>"; ?>
	</h1>
	<ol class="breadcrumb">
		<li><?php echo "<?php echo \$this->Html->link('<i class=\"fa fa-dashboard\"></i> '.__('Home'), '/', array('escape' => false)); ?>"; ?></li>
		<li class="active"><?php echo "<?php echo __('{$pluralHumanName}'); ?>"; ?></li>
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
							<?php echo "<?php echo \$this->Html->link(__('Add " . $singularHumanName . "'), array('action' => 'add'), array('class' => 'btn btn-success btn-block')); ?>"; ?>
						</div>
					</div>
				</div>
			</div>

			<div class="box box-primary">
				<div class="box-body table-responsive">
					<table class="dataTables table table-bordered table-striped">
						<thead>
							<tr>
								<?php foreach ($fields as $field): ?>
									<?php if ($field == 'id'): ?>
										<th><?php echo "<?php echo __('#'); ?>"; ?></th>
									<?php else: ?>
										<th><?php echo "<?php echo __('".Inflector::humanize($field)."'); ?>"; ?></th>
									<?php endif; ?>
								<?php endforeach; ?>
									<th class="actions"><?php echo "<?php echo __('Actions'); ?>"; ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							echo "<?php foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
							echo "\t<tr>\n";
								foreach ($fields as $field) {
									$isKey = false;
									if (!empty($associations['belongsTo'])) {
										foreach ($associations['belongsTo'] as $alias => $details) {
											if ($field === $details['foreignKey']) {
												$isKey = true;
												echo "\t\t<td>\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t</td>\n";
												break;
											}
										}
									}
									if ($isKey !== true) {
										echo "\t\t<td><?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;</td>\n";
									}
								}

								echo "\t\t<td class=\"actions\">\n";
								echo "\t\t\t<?php echo \$this->Html->link(__('View'), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn btn-info btn-sm')); ?>\n";
								echo "\t\t\t<?php echo \$this->Html->link(__('Edit'), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn btn-warning btn-sm')); ?>\n";
								echo "\t\t\t<?php echo \$this->Form->postLink(__('Delete'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn btn-danger btn-sm', 'confirm' => __('Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}']))); ?>\n";
								echo "\t\t</td>\n";
							echo "\t</tr>\n";

							echo "<?php endforeach; ?>\n";
							?>
						</tbody>
						<tfoot>
							<tr>
								<?php foreach ($fields as $field): ?>
									<?php if ($field == 'id'): ?>
										<th><?php echo "<?php echo __('#'); ?>"; ?></th>
									<?php else: ?>
										<th><?php echo "<?php echo __('".Inflector::humanize($field)."'); ?>"; ?></th>
									<?php endif; ?>
								<?php endforeach; ?>
									<th class="actions"><?php echo "<?php echo __('Actions'); ?>"; ?></th>
							</tr>
						</tfoot>
					</table>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->
