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

		if (isset($this->User->perms[$this->request->params['controller']][$this->action]) && in_array($user['role'], $this->User->perms[$this->request->params['controller']][$this->action])) {
			if ($user['role'] !== 'admin') {
				if (in_array($this->action, array('view', 'edit', 'delete'))) {
					if (isset($this->request->pass[0])) {
						$options = array(
							'conditions' => array(
								$this->User->alias.'.id' => $this->request->pass[0],
							),
						);
						$u = $this->User->find('first', $options);
						if (!empty($u) && isset($u[$this->User->alias]['role']) && $u[$this->User->alias]['role'] == 'patient') {
							return true;
						}
					}
				} elseif (in_array($this->action, array('add'))) {
					if (isset($this->request->pass[0]) && $this->request->pass[0] == 'patient') {
						return true;
					}
				} else {
					return true;
				}
			} else {
				return true;
			}
		}

		return false;
	}

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('forgotPassword', 'register', 'updatePassword', 'index'));
	}

	public function login() {
		if ($this->Auth->loggedIn()) {
	        $this->Flash->success(__('You are logged in!'));
	        return $this->redirect($this->Auth->loginRedirect);
	    } elseif ($this->request->is('post')) {
			if ($this->Auth->login()) {
				if (!$this->Auth->user('enabled')) {
					$this->Flash->info(__('The user is disabled.'));
					return $this->redirect($this->Auth->logout());
				}
				$this->Session->write('perms', $this->User->perms);
				if ($this->request->data[$this->User->alias]['remember_me']) {
					$this->Cookie->write('remember_me', $this->request->data, true, '1 month');
				}
				$this->User->id = $this->Auth->user('id');
				$this->User->saveField('last_access', date("Y-m-d H:i:s"));
				return $this->redirect($this->Auth->loginRedirect);
			}
            $this->Flash->error(__('Invalid email or password.'));
		} elseif ($this->Cookie->check('remember_me')) {
			$cookie = $this->Cookie->read('remember_me');
			$options = array(
				'conditions' => array(
					$this->User->alias.'.email' => $cookie[$this->User->alias]['email'],
				),
			);
			$this->User->recursive = 2;
			$this->request->data = $this->User->find('first', $options);
			if (!empty($this->request->data)) {
				$this->request->data[$this->User->alias]['password'] = $cookie[$this->User->alias]['password'];
				if ($this->Auth->login()) {
					if (!$this->Auth->user('enabled')) {
						$this->Flash->info(__('The user is disabled.'));
						return $this->redirect($this->Auth->logout());
					} else {
						$this->User->id = $this->Auth->user('id');
						$this->User->saveField('last_access', date("Y-m-d H:i:s"));
						return $this->redirect($this->Auth->redirectUrl());
					}
				}
			}
			$this->Cookie->delete('remember_me');
		}
		$this->layout = 'login';
	}

	public function logout() {
		$this->Flash->success(__('Good-Bye!'));
		if ($this->Cookie->check('remember_me')) {
			$this->Cookie->delete('remember_me');
		}
		return $this->redirect($this->Auth->logout());
	}

	public function index() {
		$this->User->recursive = 0;
		$options = array(
			'conditions' => array(
				'role <>' => 'patient',
			),
		);
		$users = $this->User->find('all', $options);
		$enableds = array(
			0 => __('No'),
			1 => __('Yes'),
		);
		$this->set(compact('users', 'enableds'));
	}

	public function patients() {
		$this->User->recursive = 0;
		$options = array(
			'conditions' => array(
				'role' => 'patient',
			),
		);
		$users = $this->User->find('all', $options);
		$enableds = array(
			0 => __('No'),
			1 => __('Yes'),
		);
		$this->set(compact('users', 'enableds'));
	}

	public function view($id = null) {
        $this->User->id = $id;
		if (!$this->User->exists()) {
			$this->Flash->error(__('Invalid user'));
            return $this->redirect($this->Auth->loginRedirect);
		}
		$enableds = array(
			0 => __('No'),
			1 => __('Yes'),
		);
        $user = $this->User->read();
		$this->set(compact('user', 'enableds'));
	}

	public function add($id = null) {
		if (is_null($id)) {
			$this->Flash->error(__('Invalid option'));
			return $this->redirect($this->Auth->loginRedirect);
		}
		if ($this->request->is('post')) {
			$this->request->data[$this->User->alias]['token'] = $this->User->token();
			$this->request->data[$this->User->alias]['token_expiration_datetime'] = date('Y-m-d H:i:s', strtotime('+ '.Configure::read('AppSetting.token_expiration_time').' hours'));
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$user = $this->User->read();
				$options = array(
					'to' => $user[$this->User->alias]['email'],
					'template' => 'newUser',
					'user' => $user,
					'subject' => __('New User').' - '.Configure::read('AppSetting.system_name'),
					'link' => Router::url(array('action' => 'updatePassword', $user[$this->User->alias]['token']), true),
				);
				$res = $this->User->sendMail($options);
				if (isset($res['error']) && $res['error'] == 0) {
					$this->Flash->success(__('The user has been saved.'));
				} else {
					$this->Flash->warning(__('The user has been saved but could not send email with instructions. Please use the "forgot password" option to create your password.'));
				}
				if ($this->request->data[$this->User->alias]['role'] == 'patient') {
					return $this->redirect(array('action' => 'patients'));
				} else {
					return $this->redirect(array('action' => 'index'));
				}
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		}
		$role = $id;
		$this->request->data[$this->User->alias]['role'] = $id;
		$options = array(
			'conditions' => array(
				$this->User->City->alias.'.enabled' => 1,
			),
			'order' => array($this->User->City->alias.'.name'),
		);
		$cities = $this->User->City->find('list', $options);
		$this->set(compact('cities', 'role'));
	}

	public function register() {
		if ($this->request->is('post')) {
			$this->request->data[$this->User->alias]['token'] = $this->User->token();
			$this->request->data[$this->User->alias]['token_expiration_datetime'] = date('Y-m-d H:i:s', strtotime('+ '.Configure::read('AppSetting.token_expiration_time').'hours'));
			$this->request->data[$this->User->alias]['role'] = 'patient';
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$user = $this->User->read();
				$options = array(
					'to' => $user[$this->User->alias]['email'],
					'template' => 'newUser',
					'user' => $user,
					'subject' => __('New User').' - '.Configure::read('AppSetting.system_name'),
					'link' => Router::url(array('action' => 'updatePassword', $user[$this->User->alias]['token']), true),
				);
				$res = $this->User->sendMail($options);
				if (isset($res['error']) && $res['error'] == 0) {
					$this->Flash->success(__('Registered user. Follow the instructions sent to the informed email to access the system.'));
				} else {
					$this->Flash->warning(__('Registered user but could not send email with instructions. Please use the "forgot password" option to create your password.'));
				}
				return $this->redirect(array('action' => 'login'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		}
		$this->layout = 'login';
		$options = array(
			'conditions' => array(
				$this->User->City->alias.'.enabled' => 1,
			),
			'order' => array($this->User->City->alias.'.name'),
		);
		$cities = $this->User->City->find('list', $options);
		$this->set(compact('cities'));
	}

	public function edit($id = null) {
        $this->User->id = $id;
		if (!$this->User->exists()) {
			$this->Flash->error(__('Invalid user'));
            return $this->redirect($this->Auth->loginRedirect);
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The user has been saved.'));
				if ($this->User->field('role') == 'patient') {
					return $this->redirect(array('action' => 'patients'));
				} else {
					return $this->redirect(array('action' => 'index'));
				}
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->User->read();
			unset($this->request->data[$this->User->alias]['password']);
		}
		$role = $this->request->data[$this->User->alias]['role'];
		$options = array(
			'conditions' => array(
				$this->User->City->alias.'.enabled' => 1,
			),
		);
		$cities = $this->User->City->find('list', $options);
		$this->set(compact('cities', 'role'));
	}

	public function delete($id = null) {
		if ($id === '1') {
			$this->Flash->error(__('Prohibited action!'));
			return $this->redirect($this->Auth->loginRedirect);
		}
        $this->User->id = $id;
		if (!$this->User->exists()) {
			$this->Flash->error(__('Invalid user'));
            return $this->redirect($this->Auth->loginRedirect);
		}
		$role = $this->User->field('role');
		$this->loadModel('Stop');
		$options = array(
			'conditions' => array(
				'OR' => array(
					$this->Stop->alias.'.patient_id' => $id,
					$this->Stop->alias.'.companion_id' => $id,
					$this->Stop->alias.'.created_user_id' => $id,
					$this->Stop->alias.'.modified_user_id' => $id,
				),
			),
		);
		$stops = $this->Stop->find('count', $options);
		if ($stops == 0) {
			$this->loadModel('Diary');
			$options = array(
				'conditions' => array(
					'OR' => array(
						$this->Diary->alias.'.driver_id' => $id,
						$this->Diary->alias.'.created_user_id' => $id,
						$this->Diary->alias.'.modified_user_id' => $id,
					),
				),
			);
			$diaries = $this->Diary->find('count', $options);
			if ($diaries == 0) {
				$this->request->allowMethod('post', 'delete');
				if ($this->User->delete()) {
					$this->Flash->success(__('The user has been deleted.'));
				} else {
					$this->Flash->error(__('The user could not be deleted. Please, try again.'));
				}
			} else {
				$this->Flash->error(__('The user can\'t be deleted.'));
			}
		} else {
			$this->Flash->error(__('The user can\'t be deleted.'));
		}
		if ($role == 'patient') {
			return $this->redirect(array('action' => 'patients'));
		} else {
			return $this->redirect(array('action' => 'index'));
		}
	}

	public function profile() {
        $this->User->id = $this->Auth->user('id');
		if (!$this->User->exists()) {
			$this->Flash->error(__('Invalid user'));
            return $this->redirect('/');
		}
		$enableds = array(
			0 => __('No'),
			1 => __('Yes'),
		);
        $user = $this->User->read();
		$this->set(compact('user', 'enableds'));
	}

	public function editProfile() {
        $this->User->id = $this->Auth->user('id');
		if (!$this->User->exists()) {
			$this->Flash->error(__('Invalid user'));
            return $this->redirect($this->Auth->loginRedirect);
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(array('action' => 'profile'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->User->read();
			unset($this->request->data[$this->User->alias]['password']);
		}
		$options = array(
			'conditions' => array(
				$this->User->City->alias.'.enabled' => 1,
			),
		);
		$cities = $this->User->City->find('list', $options);
		$this->set(compact('cities'));
	}

	public function updatePassword($token = null) {
		$this->layout = 'login';
		if ($this->request->is(array('put', 'post'))) {
			$this->request->data[$this->User->alias]['token'] = null;
			$this->request->data[$this->User->alias]['token_expiration_datetime'] = null;
			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The password has been saved.'));
				$password = $this->request->data[$this->User->alias]['password'];
				$this->User->id = $this->request->data[$this->User->alias]['id'];
				$this->User->recursive = 2;
				$this->request->data = $this->User->read();
		        $this->request->data[$this->User->alias]['password'] = $password;
		        if ($this->Auth->login()) {
		        	$this->User->saveField('last_access', date('Y-m-d H:i:s'));
		        }
				return $this->redirect($this->Auth->loginRedirect);
			} else {
				$this->Flash->error(__('The password could not be saved. Please, try again.'));
			}
		} elseif (!is_null($token)) {
			$user = $this->User->find('first', array('conditions' => array($this->User->alias.'.token' => $token)));
			if (empty($user)) {
				$this->Flash->error(__('Invalid token'));
				return $this->redirect(array('action' => 'login'));
			} elseif (CakeTime::isPast($user[$this->User->alias]['token_expiration_datetime'])) {
				$this->User->id = $user[$this->User->alias]['id'];
				$this->User->saveField('token', '');
				$this->Flash->error(__('This token is expired.'));
				return $this->redirect(array('action' => 'forgotPassword'));
			}
			$this->request->data = $user;
			unset($this->request->data[$this->User->alias]['password']);
		} else {
			return $this->redirect(array('action' => 'login'));
		}
	}

	public function forgotPassword() {
		$this->layout = 'login';
		if ($this->request->is(array('put', 'post'))) {
			$options = array(
				'conditions' => array(
					$this->User->alias.'.email' => $this->request->data[$this->User->alias]['email'],
				),
			);
			$this->User->recursive = -1;
			$user = $this->User->find('first', $options);
			if (empty($user)) {
				$this->Flash->error(__('No user found with this email'));
			} elseif (!$user[$this->User->alias]['enabled']) {
				$this->Flash->error(__('Disabled user. Please contact the responsible industry.'));
			} else {
				$user[$this->User->alias]['token'] = $this->User->token();
				$user[$this->User->alias]['token_expiration_datetime'] = date('Y-m-d H:i:s', strtotime('+ '.Configure::read('AppSetting.token_expiration_time').' hours'));
				$data[$this->User->alias]['id'] = $user[$this->User->alias]['id'];
				$data[$this->User->alias]['token'] = $user[$this->User->alias]['token'];
				$data[$this->User->alias]['token_expiration_datetime'] = $user[$this->User->alias]['token_expiration_datetime'];
				if ($this->User->save($data)) {
					$options = array(
						'to' => $user[$this->User->alias]['email'],
						'template' => 'update_password',
						'subject' => __('Update password - %s', Configure::read('AppSetting.system_name')),
						'user' => $user,
						'link' => Router::url(array('action' => 'updatePassword', $user[$this->User->alias]['token']), true),
					);
					$res = $this->User->sendMail($options);
					if (isset($res['error']) && $res['error'] == 0) {
						$this->Flash->success(__('The password update email sent successfully.'));
					} else {
						$this->Flash->warning(__('Could not send email for password update. Please, try again in a few minutes.'));
					}
				} else {
					$this->Flash->error(__('Your password update permission could not be generated. Please, try again in a few minutes.'));
				}
			}
			return $this->redirect(array('action' => 'login'));
		}
	}
}
