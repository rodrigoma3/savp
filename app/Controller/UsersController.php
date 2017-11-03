<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

	public function isAuthorized($user = null) {
		if (parent::isAuthorized($user))
			return true;

			switch($this->action) {
				case 'login':
				case 'logout':
					return true;
					break;
				case 'view':
				case 'delete':
				case 'edit':
				case 'add':
					if (in_array($user['role'], array('3'))) {
						return true;
					} else {
						return false;
					}
					break;
				case 'forgotPassword':
					return true;
					break;
				default:
					return false;
					break;
			}
	}

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('add');
	}

	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->User->id = $this->Auth->user('id');
				$this->User->saveField('last_access', date("Y-m-d H:i:s"));
				return $this->redirect($this->Auth->redirectUrl());
			}
            $this->Flash->error(__('Invalid email or password.'));
		}
		$this->layout = 'login';
	}

	public function logout() {
		$this->Flash->success(__('Good-Bye!'));
		return $this->redirect($this->Auth->logout());
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
        $users = $this->User->find('all');
		$this->set(compact('users'));
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
        $this->User->id = $id;
		if (!$this->User->exists()) {
			$this->Flash->error(__('Invalid user'));
            return $this->redirect(array('action' => 'index'));
		}
        $user = $this->User->read();
		$this->set(compact('user'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		}
		$cities = $this->User->City->find('list');
		$this->set(compact('cities'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
        $this->User->id = $id;
		if (!$this->User->exists()) {
			$this->Flash->error(__('Invalid user'));
            return $this->redirect(array('action' => 'index'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->User->read();
		}
		$cities = $this->User->City->find('list');
		$this->set(compact('cities'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
        $this->User->id = $id;
		if (!$this->User->exists()) {
			$this->Flash->error(__('Invalid user'));
            return $this->redirect(array('action' => 'index'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete()) {
			$this->Flash->success(__('The user has been deleted.'));
		} else {
			$this->Flash->error(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
