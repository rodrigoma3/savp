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
		<?php echo "<?php echo __('View {$singularHumanName}'); ?>"; ?>
	</h1>
	<ol class="breadcrumb">
		<li><?php echo "<?php echo \$this->Html->link('<i class=\"fa fa-dashboard\"></i> '.__('Home'), '/', array('escape' => false)); ?>"; ?></li>
		<li><?php echo "<?php echo \$this->Html->link(__('{$pluralHumanName}'), array('action' => 'index')); ?>"; ?></li>
		<li class="active"><?php echo "<?php echo __('View {$singularHumanName}'); ?>"; ?></li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-body">
					<dl class="dl-horizontal">
						<?php
						foreach ($fields as $field) {
							$isKey = false;
							if (!empty($associations['belongsTo'])) {
								foreach ($associations['belongsTo'] as $alias => $details) {
									if ($field === $details['foreignKey']) {
										$isKey = true;
										echo "\t\t<dt><?php echo __('" . Inflector::humanize(Inflector::underscore($alias)) . "'); ?></dt>\n";
										echo "\t\t<dd>\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t\t&nbsp;\n\t\t</dd>\n";
										break;
									}
								}
							}
							if ($isKey !== true) {
								if ($field == 'id') {
									echo "\t\t<dt><?php echo __('#'); ?></dt>\n";
								} else {
									echo "\t\t<dt><?php echo __('" . Inflector::humanize($field) . "'); ?></dt>\n";
								}
								echo "\t\t<dd>\n\t\t\t<?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>\n\t\t\t&nbsp;\n\t\t</dd>\n";
							}
						}
						?>
					</dl>
				</div><!-- /.box-body -->
				<div class="box-footer">
					<div class="row">
						<div class="col-xs-3">
							<?php echo "<?php echo \$this->Html->link(__('List {$pluralHumanName}'), array('action' => 'index'), array('class' => 'btn btn-info btn-block')); ?>"; ?>
						</div>
					</div>
				</div><!-- /.box-footer -->
			</div><!-- /.box -->
		</div>
	</div>

</section><!-- /.content -->
