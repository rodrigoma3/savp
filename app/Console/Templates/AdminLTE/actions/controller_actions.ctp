<?php
/**
 * Bake Template for Controller action generation.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.actions
 * @since         CakePHP(tm) v 1.3
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
?>

/**
 * <?php echo $admin ?>index method
 *
 * @return void
 */
	public function <?php echo $admin ?>index() {
		$this-><?php echo $currentModelName ?>->recursive = 0;
        $<?php echo $pluralName ?> = $this-><?php echo $currentModelName ?>->find('all');
		$this->set(compact('<?php echo $pluralName ?>'));
	}

/**
 * <?php echo $admin ?>view method
 *
 * @param string $id
 * @return void
 */
	public function <?php echo $admin ?>view($id = null) {
        $this-><?php echo $currentModelName; ?>->id = $id;
		if (!$this-><?php echo $currentModelName; ?>->exists()) {
<?php if ($wannaUseSession): ?>
			$this->Flash->error(__('Invalid <?php echo strtolower($singularHumanName); ?>'));
            return $this->redirect(array('action' => 'index'));
<?php else: ?>
            return $this->flash(__('Invalid <?php echo strtolower($singularHumanName); ?>'), array('action' => 'index'));
<?php endif; ?>
		}
        $<?php echo $singularName; ?> = $this-><?php echo $currentModelName; ?>->read();
		$this->set(compact('<?php echo $singularName; ?>'));
	}

<?php $compact = array(); ?>
/**
 * <?php echo $admin ?>add method
 *
 * @return void
 */
	public function <?php echo $admin ?>add() {
		if ($this->request->is('post')) {
			$this-><?php echo $currentModelName; ?>->create();
			if ($this-><?php echo $currentModelName; ?>->save($this->request->data)) {
<?php if ($wannaUseSession): ?>
				$this->Flash->success(__('The <?php echo strtolower($singularHumanName); ?> has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The <?php echo strtolower($singularHumanName); ?> could not be saved. Please, try again.'));
<?php else: ?>
				return $this->flash(__('The <?php echo strtolower($singularHumanName); ?> has been saved.'), array('action' => 'index'));
<?php endif; ?>
			}
		}
<?php
	foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
		foreach ($modelObj->{$assoc} as $associationName => $relation):
			if (!empty($associationName)):
				$otherModelName = $this->_modelName($associationName);
				$otherPluralName = $this->_pluralName($associationName);
				echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list');\n";
				$compact[] = "'{$otherPluralName}'";
			endif;
		endforeach;
	endforeach;
	if (!empty($compact)):
		echo "\t\t\$this->set(compact(".join(', ', $compact)."));\n";
	endif;
?>
	}

<?php $compact = array(); ?>
/**
 * <?php echo $admin ?>edit method
 *
 * @param string $id
 * @return void
 */
	public function <?php echo $admin; ?>edit($id = null) {
        $this-><?php echo $currentModelName; ?>->id = $id;
		if (!$this-><?php echo $currentModelName; ?>->exists()) {
<?php if ($wannaUseSession): ?>
			$this->Flash->error(__('Invalid <?php echo strtolower($singularHumanName); ?>'));
            return $this->redirect(array('action' => 'index'));
<?php else: ?>
            return $this->flash(__('Invalid <?php echo strtolower($singularHumanName); ?>'), array('action' => 'index'));
<?php endif; ?>
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this-><?php echo $currentModelName; ?>->save($this->request->data)) {
<?php if ($wannaUseSession): ?>
				$this->Flash->success(__('The <?php echo strtolower($singularHumanName); ?> has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The <?php echo strtolower($singularHumanName); ?> could not be saved. Please, try again.'));
<?php else: ?>
				return $this->flash(__('The <?php echo strtolower($singularHumanName); ?> has been saved.'), array('action' => 'index'));
<?php endif; ?>
			}
		} else {
			$this->request->data = $this-><?php echo $currentModelName; ?>->read();
		}
<?php
		foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
			foreach ($modelObj->{$assoc} as $associationName => $relation):
				if (!empty($associationName)):
					$otherModelName = $this->_modelName($associationName);
					$otherPluralName = $this->_pluralName($associationName);
					echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list');\n";
					$compact[] = "'{$otherPluralName}'";
				endif;
			endforeach;
		endforeach;
		if (!empty($compact)):
			echo "\t\t\$this->set(compact(".join(', ', $compact)."));\n";
		endif;
	?>
	}

/**
 * <?php echo $admin ?>delete method
 *
 * @param string $id
 * @return void
 */
	public function <?php echo $admin; ?>delete($id = null) {
        $this-><?php echo $currentModelName; ?>->id = $id;
		if (!$this-><?php echo $currentModelName; ?>->exists()) {
<?php if ($wannaUseSession): ?>
			$this->Flash->error(__('Invalid <?php echo strtolower($singularHumanName); ?>'));
            return $this->redirect(array('action' => 'index'));
<?php else: ?>
            return $this->flash(__('Invalid <?php echo strtolower($singularHumanName); ?>'), array('action' => 'index'));
<?php endif; ?>
		}
		$this->request->allowMethod('post', 'delete');
		if ($this-><?php echo $currentModelName; ?>->delete()) {
<?php if ($wannaUseSession): ?>
			$this->Flash->success(__('The <?php echo strtolower($singularHumanName); ?> has been deleted.'));
		} else {
			$this->Flash->error(__('The <?php echo strtolower($singularHumanName); ?> could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
<?php else: ?>
			return $this->flash(__('The <?php echo strtolower($singularHumanName); ?> has been deleted.'), array('action' => 'index'));
		} else {
			return $this->flash(__('The <?php echo strtolower($singularHumanName); ?> could not be deleted. Please, try again.'), array('action' => 'index'));
		}
<?php endif; ?>
	}
