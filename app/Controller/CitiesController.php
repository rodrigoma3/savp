<?php
App::uses('AppController', 'Controller');
/**
 * Cities Controller
 *
 * @property City $City
 */
class CitiesController extends AppController {

	public function isAuthorized($user = null) {
		if (parent::isAuthorized($user)) {
			return true;
		}

		if (isset($this->City->perms[$this->request->params['controller']][$this->action]) && in_array($user['role'], $this->City->perms[$this->request->params['controller']][$this->action])) {
			return true;
		}

		return false;
	}

	public function index() {
		$this->City->recursive = 0;
        $cities = $this->City->find('all');
		$enableds = array(
			0 => __('No'),
			1 => __('Yes'),
		);
		$this->set(compact('cities', 'enableds'));
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->City->create();
			if ($this->City->save($this->request->data)) {
				$this->Flash->success(__('The city has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The city could not be saved. Please, try again.'));
			}
		}
	}

	public function edit($id = null) {
        $this->City->id = $id;
		if (!$this->City->exists()) {
			$this->Flash->error(__('Invalid city'));
            return $this->redirect(array('action' => 'index'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->City->save($this->request->data)) {
				$this->Flash->success(__('The city has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The city could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->City->read();
		}
	}

	public function delete($id = null) {
        $this->City->id = $id;
		if (!$this->City->exists()) {
			$this->Flash->error(__('Invalid city'));
            return $this->redirect(array('action' => 'index'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->City->delete()) {
			$this->Flash->success(__('The city has been deleted.'));
		} else {
			$this->Flash->error(__('The city could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
