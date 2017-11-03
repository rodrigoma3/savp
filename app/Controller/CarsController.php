<?php
App::uses('AppController', 'Controller');
/**
 * Cars Controller
 *
 * @property Car $Car
 */
class CarsController extends AppController {

	public function isAuthorized($user = null) {
		if (parent::isAuthorized($user))
			return true;

			// switch($this->action) {
			// 	case 'index':
			// 	case 'view':
			// 	case 'add':
			// 	case 'edit':
			// 	case 'delete':
			// 		if (in_array($user['role'], array('motorista'))) {
			// 			return true;
			// 		} else {
			// 			return false;
			// 		}
			// 		break;
			// }
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Car->recursive = 0;
		$cars = $this->Car->find('all');
		$enableds = array(
			0 => __('No'),
			1 => __('Yes'),
		);
		$this->set(compact('cars', 'enableds'));
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Car->id = $id;
		if (!$this->Car->exists()) {
			$this->Flash->error(__('Invalid car'));
			return $this->redirect(array('action' => 'index'));
		}
		$car = $this->Car->read();
		$enableds = array(
			0 => __('No'),
			1 => __('Yes'),
		);
		$this->set(compact('car', 'enableds'));
	}

/**
 * add method
 *
 * @return void
 */
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

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
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

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Car->id = $id;
		if (!$this->Car->exists()) {
			$this->Flash->error(__('Invalid car'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Car->delete()) {
			$this->Flash->success(__('The car has been deleted.'));
		} else {
			$this->Flash->error(__('The car could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
