<?php
App::uses('AppController', 'Controller');
/**
 * Cars Controller
 *
 * @property Car $Car
 */
class CarsController extends AppController {

	public function isAuthorized($user = null) {
		if (parent::isAuthorized($user)) {
			return true;
		}

		if (isset($this->Car->perms[$this->request->params['controller']][$this->action]) && in_array($user['role'], $this->Car->perms[$this->request->params['controller']][$this->action])) {
			return true;
		}

		return false;
	}

	public function index() {
		$this->Car->recursive = 0;
		$cars = $this->Car->find('all');
		$enableds = array(
			0 => __('No'),
			1 => __('Yes'),
		);
		$ambulances = array(
			0 => __('No'),
			1 => __('Yes'),
		);
		$this->set(compact('cars', 'enableds', 'ambulances'));
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->Car->create();
			if ($this->Car->save($this->request->data)) {
				$this->Flash->success(__('The car has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The car could not be saved. Please, try again.'));
			}
		}
	}

	public function edit($id = null) {
		$this->Car->id = $id;
		if (!$this->Car->exists()) {
			$this->Flash->error(__('Invalid car'));
			return $this->redirect(array('action' => 'index'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Car->save($this->request->data)) {
				$this->Flash->success(__('The car has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The car could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Car->read();
		}
	}

	public function delete($id = null) {
		$this->Car->id = $id;
		if (!$this->Car->exists()) {
			$this->Flash->error(__('Invalid car'));
			return $this->redirect(array('action' => 'index'));
		}
		$car = $this->Car->read();
		if (empty($car[$this->Car->Diary->alias])) {
			$this->request->allowMethod('post', 'delete');
			if ($this->Car->delete()) {
				$this->Flash->success(__('The car has been deleted.'));
			} else {
				$this->Flash->error(__('The car could not be deleted. Please, try again.'));
			}
		} else {
			$this->Flash->error(__('The car can\'t be deleted.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
