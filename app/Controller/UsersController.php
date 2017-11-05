<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

	public function isAuthorized($user = null) {
		if (parent::isAuthorized($user)) {
			return true;
		}

		switch($this->action) {
			case 'login':
			case 'logout':
			case 'register':
			case 'forgotPassword':
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
			default:
				return false;
				break;
		}
	}

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('register');
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
		$options = array(
			'conditions' => array(
				'role <>' => 'patient',
			),
		);
		$enableds = array(
			0 => __('No'),
			1 => __('Yes'),
		);
        $users = $this->User->find('all', $options);
		$this->set(compact('users', 'enableds'));
	}

/**
 * patients method
 *
 * @return void
 */
	public function patients() {
		$this->User->recursive = 0;
		$options = array(
			'conditions' => array(
				'role' => 'patient',
			),
		);
		$enableds = array(
			0 => __('No'),
			1 => __('Yes'),
		);
        $users = $this->User->find('all', $options);
		$this->set(compact('users', 'enableds'));
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
		$enableds = array(
			0 => __('No'),
			1 => __('Yes'),
		);
        $user = $this->User->read();
		$this->set(compact('user', 'enableds'));
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
		$role = '';
		if ($this->request->named['type'] !== null) {
			$this->request->data[$this->User->alias]['role'] = $this->request->named['type'];
			$role = $this->request->named['type'];
		}
		$cities = $this->User->City->find('list');
		$this->set(compact('cities', 'role'));
	}

/**
 * register method
 *
 * @return void
 */
	public function register() {
		if ($this->request->is('post')) {
			$this->request->data[$this->User->alias]['role'] = 'patient';
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$id = $this->User->id;
		        $this->request->data['User'] = array_merge(
		            $this->request->data['User'],
		            array('id' => $id)
		        );
		        unset($this->request->data['User']['password']);
		        $this->Auth->login($this->request->data['User']);
				$this->Flash->success(__('The user has been saved.'));
		        return $this->redirect($this->Auth->loginRedirect);
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		}
		$this->layout = 'login';
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
			unset($this->request->data[$this->User->alias]['password']);
		}
		$role = $this->request->data[$this->User->alias]['role'];
		$cities = $this->User->City->find('list');
		$this->set(compact('cities', 'role'));
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
