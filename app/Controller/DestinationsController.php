<?php
App::uses('AppController', 'Controller');
/**
 * Destinations Controller
 *
 * @property Destination $Destination
 */
class DestinationsController extends AppController {

	public function isAuthorized($user = null) {
		if (parent::isAuthorized($user)) {
			return true;
		}

		if (isset($this->Destination->perms[$this->request->params['controller']][$this->action]) && in_array($user['role'], $this->Destination->perms[$this->request->params['controller']][$this->action])) {
			return true;
		}

		return false;
	}

	public function index() {
		$this->Destination->recursive = 0;
        $destinations = $this->Destination->find('all');
		$enableds = array(
			0 => __('No'),
			1 => __('Yes'),
		);
		$this->set(compact('destinations', 'enableds'));
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->Destination->create();
			if ($this->Destination->save($this->request->data)) {
				$this->Flash->success(__('The destination has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The destination could not be saved. Please, try again.'));
			}
		}
		$options = array(
			'conditions' => array(
				$this->Destination->City->alias.'.enabled' => 1,
			),
		);
		$cities = $this->Destination->City->find('list', $options);
		$this->set(compact('cities'));
	}

	public function edit($id = null) {
        $this->Destination->id = $id;
		if (!$this->Destination->exists()) {
			$this->Flash->error(__('Invalid destination'));
            return $this->redirect(array('action' => 'index'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Destination->save($this->request->data)) {
				$this->Flash->success(__('The destination has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The destination could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Destination->read();
		}
		$options = array(
			'conditions' => array(
				$this->Destination->City->alias.'.enabled' => 1,
			),
		);
		$cities = $this->Destination->City->find('list', $options);
		$this->set(compact('cities'));
	}

	public function delete($id = null) {
        $this->Destination->id = $id;
		if (!$this->Destination->exists()) {
			$this->Flash->error(__('Invalid destination'));
            return $this->redirect(array('action' => 'index'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Destination->delete()) {
			$this->Flash->success(__('The destination has been deleted.'));
		} else {
			$this->Flash->error(__('The destination could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
