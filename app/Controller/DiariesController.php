<?php
App::uses('AppController', 'Controller');
/**
 * Diaries Controller
 *
 * @property Diary $Diary
 */
class DiariesController extends AppController {

	public function isAuthorized($user = null) {
		if (parent::isAuthorized($user)) {
			return true;
		}

		if (isset($this->Diary->perms[$this->request->params['controller']][$this->action]) && in_array($user['role'], $this->Diary->perms[$this->request->params['controller']][$this->action])) {
			return true;
		}

		return false;
	}

	public function index() {
        if ($this->request->is('ajax')) {
			$this->autoRender = false;
			$result = array(
				'error' => 1,
				'data' => array(),
			);
			// CakeLog::write('info', print_r($this->request,true));

			if (isset($this->request->data['date']) && $this->request->data['date'] !== null) {
				$options = array(
					'conditions' => array(
						'date' => $this->request->data['date'],
					),
				);
				if ($this->Auth->user('role') == 'patient') {
					$options['conditions']['status'] = 'opened';
				}
				$diaries = $this->Diary->find('all', $options);
				// CakeLog::write('info', print_r($diaries,true));
				if (!empty($diaries)) {
					$cities = $this->Diary->Destination->City->find('list');
					// CakeLog::write('info', print_r($cities,true));
					$view = new View();
					$html = $view->loadHelper('Html');
					$form = $view->loadHelper('Form');
					foreach ($diaries as $diary) {
						$event = array(
							'destination' => $cities[$diary[$this->Diary->Destination->alias]['city_id']].' - '.$diary[$this->Diary->Destination->alias]['time'],
							'car' => $diary[$this->Diary->Car->alias]['model'].' - '.$diary[$this->Diary->Car->alias]['car_plate'],
							'title_free' => __('Available Accents'),
							'free' => $diary[$this->Diary->Car->alias]['capacity'] - count($diary[$this->Diary->Stop->alias]),
							'color' => 'success',
						);
						if ($diary[$this->Diary->alias]['status'] == 'opened') {
							if (in_array($this->Auth->user('role'), $this->Diary->perms['diaries']['delete'])) {
								if (in_array($this->Auth->user('role'), $this->Diary->perms['diaries']['delete'])) {
									$event['buttons'][] = $form->postLink(__('Delete'), array('action' => 'delete', $diary[$this->Diary->alias]['id']), array('class' => 'btn btn-danger btn-sm pull-right', 'confirm' => __('Are you sure you want to delete?')));
								}
							}
							if (in_array($this->Auth->user('role'), $this->Diary->perms['diaries']['edit'])) {
								if (in_array($this->Auth->user('role'), $this->Diary->perms['diaries']['edit'])) {
									$event['buttons'][] = $html->link(__('Edit'), array('action' => 'edit', $diary[$this->Diary->alias]['id']), array('class' => 'btn btn-warning btn-sm pull-right'));
								}
							}
						}
						if (in_array($diary[$this->Diary->alias]['status'], array('in_progress', 'closed'))) {
							if (in_array($this->Auth->user('role'), $this->Diary->perms['diaries']['close'])) {
								if (in_array($this->Auth->user('role'), $this->Diary->perms['diaries']['close'])) {
									$event['buttons'][] = $html->link(__('Close'), array('action' => 'close', $diary[$this->Diary->alias]['id']), array('class' => 'btn btn-primary btn-sm pull-right'));
								}
							}
						}
						if ($diary[$this->Diary->alias]['status'] == 'in_progress') {
							if (in_array($this->Auth->user('role'), $this->Diary->perms['diaries']['reopen'])) {
								$event['buttons'][] = $html->link(__('Reopen'), array('action' => 'reopen', $diary[$this->Diary->alias]['id']), array('class' => 'btn btn-default btn-sm pull-right'));
							}
							$event['color'] = 'warning';
						}
						if ($diary[$this->Diary->alias]['status'] == 'closed') {
							$event['color'] = 'danger';
						}
						if ($event['color'] == 'success' && $event['free'] == 0) {
							$event['color'] = 'info';
						}
						if (in_array($this->Auth->user('role'), $this->Diary->perms['diaries']['view'])) {
							$event['buttons'][] = $html->link(__('View'), array('action' => 'view', $diary[$this->Diary->alias]['id']), array('class' => 'btn btn-success btn-sm pull-right', 'div' => false));
						}
						if (in_array($this->Auth->user('role'), $this->Diary->perms['stops']['index']) && $diary[$this->Diary->alias]['status'] == 'opened') {
							$event['buttons'][] = $html->link(__('Schedule'), array('controller' => 'stops', 'action' => 'index', 'diary' => $diary[$this->Diary->alias]['id']), array('class' => 'btn btn-info btn-sm pull-right', 'div' => false));
						}
						$result['data'][] = $event;
					}
				}
				$result['error'] = 0;
			} elseif (isset($this->request->data['act']) && $this->request->data['act'] !== null) {
				switch ($this->request->data['act']) {
					case 'dates':
						$options = array(
							'conditions' => array(
								// $this->Diary->alias.'.status' => 'opened',
							),
						);
						if ($this->Auth->user('role') == 'patient') {
							$options['conditions']['status'] = 'opened';
						}
						$diaries = $this->Diary->find('all', $options);
						$dates = array();
						foreach ($diaries as $diary) {
							if (($diary[$this->Diary->Car->alias]['capacity'] - count($diary[$this->Diary->Stop->alias])) == 0) {
								if (!isset($dates[$diary[$this->Diary->alias]['date']]) || !in_array('full', $dates[$diary[$this->Diary->alias]['date']])) {
									$dates[$diary[$this->Diary->alias]['date']][] = 'full';
								}
							} elseif (!isset($dates[$diary[$this->Diary->alias]['date']]) || !in_array($diary[$this->Diary->alias]['status'], $dates[$diary[$this->Diary->alias]['date']])) {
								$dates[$diary[$this->Diary->alias]['date']][] = $diary[$this->Diary->alias]['status'];
							}
							// if (($diary[$this->Diary->Car->alias]['capacity'] - count($diary[$this->Diary->Stop->alias])) > 0) {
							// 	$result['data'][] = array(
							// 		'title' => __('Open diary'),
							// 		'date' => $diary[$this->Diary->alias]['date'],
							// 		'color' => 'blue',
							// 	);
							// }
						}
						foreach ($dates as $date => $statuses) {
							if (in_array('opened', $statuses)) {
								$result['data'][] = array(
									'title' => __('Open diary'),
									'date' => $date,
									'color' => 'green',
								);
							}
							if (in_array('full', $statuses)) {
								$result['data'][] = array(
									'title' => __('Full diary'),
									'date' => $date,
									'color' => 'blue',
								);
							}
							if (in_array('in_progress', $statuses)) {
								$result['data'][] = array(
									'title' => __('In Progress'),
									'date' => $date,
									'color' => 'orange',
								);
							}
							if (in_array('closed', $statuses)) {
								$result['data'][] = array(
									'title' => __('Close diary'),
									'date' => $date,
									'color' => 'red',
								);
							}
						}
						$result['error'] = 0;
						break;

					default:
						break;
				}
			}

			return json_encode($result);
		}
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->request->data[$this->Diary->alias]['status'] = 'opened';
			$this->Diary->create();
			if ($this->Diary->save($this->request->data)) {
				$this->Flash->success(__('The diary has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The diary could not be saved. Please, try again.'));
			}
		}
		if (isset($this->request->named['date']) && $this->request->named['date'] !== null) {
			$this->request->data[$this->Diary->alias]['date'] = $this->request->named['date'];
		}
		$options = array(
			'conditions' => array(
				$this->Diary->Driver->alias.'.role' => 'driver',
				$this->Diary->Driver->alias.'.enabled' => 1,
			),
		);
		$drivers = $this->Diary->Driver->find('all', $options);
		$drivers = Hash::combine($drivers, '{n}.Driver.id', array('%s - %s', '{n}.Driver.name', '{n}.Driver.document'));
		asort($drivers);
		$options = array(
			'conditions' => array(
				$this->Diary->Car->alias.'.enabled' => 1,
			),
		);
		$cars = $this->Diary->Car->find('all', $options);
		$cars = Hash::combine($cars, '{n}.Car.id', array('%s - %s', '{n}.Car.model', '{n}.Car.car_plate'));
		asort($cars);
		$options = array(
			'conditions' => array(
				$this->Diary->Destination->alias.'.enabled' => 1,
			),
		);
		$destinations = $this->Diary->Destination->find('all', $options);
		$destinations = Hash::combine($destinations, '{n}.Destination.id', array('%s - %s', '{n}.City.name', '{n}.Destination.time'));
		asort($destinations);
		$this->set(compact('destinations', 'cars', 'drivers'));
	}

	public function edit($id = null) {
        $this->Diary->id = $id;
		if (!$this->Diary->exists()) {
			$this->Flash->error(__('Invalid diary'));
            return $this->redirect(array('action' => 'index'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Diary->save($this->request->data)) {
				$this->Flash->success(__('The diary has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The diary could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Diary->read();
		}
		$options = array(
			'conditions' => array(
				$this->Diary->Driver->alias.'.role' => 'driver',
				$this->Diary->Driver->alias.'.enabled' => 1,
			),
		);
		$drivers = $this->Diary->Driver->find('all', $options);
		$drivers = Hash::combine($drivers, '{n}.Driver.id', array('%s - %s', '{n}.Driver.name', '{n}.Driver.document'));
		asort($drivers);
		$options = array(
			'conditions' => array(
				$this->Diary->Car->alias.'.enabled' => 1,
			),
		);
		$cars = $this->Diary->Car->find('all', $options);
		$cars = Hash::combine($cars, '{n}.Car.id', array('%s - %s', '{n}.Car.model', '{n}.Car.car_plate'));
		asort($cars);
		$options = array(
			'conditions' => array(
				$this->Diary->Destination->alias.'.enabled' => 1,
			),
		);
		$destinations = $this->Diary->Destination->find('all', $options);
		$destinations = Hash::combine($destinations, '{n}.Destination.id', array('%s - %s', '{n}.City.name', '{n}.Destination.time'));
		asort($destinations);
		$this->set(compact('destinations', 'cars', 'drivers'));
	}

	public function delete($id = null) {
        $this->Diary->id = $id;
		if (!$this->Diary->exists()) {
			$this->Flash->error(__('Invalid diary'));
            return $this->redirect(array('action' => 'index'));
		}
		if ($this->Diary->field('status') == 'opened') {
			$this->request->allowMethod('post', 'delete');
			if ($this->Diary->delete()) {
				$this->Flash->success(__('The diary has been deleted.'));
			} else {
				$this->Flash->error(__('The diary could not be deleted. Please, try again.'));
			}
		} else {
			$this->Flash->error(__('The diary can\'t be deleted.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function reopen($id = null) {
        $this->Diary->id = $id;
		if (!$this->Diary->exists()) {
			$this->Flash->error(__('Invalid diary'));
            return $this->redirect(array('action' => 'index'));
		}
		if ($this->Diary->field('status') == 'in_progress') {
			if ($this->Diary->saveField('status', 'opened')) {
				$this->Flash->success(__('The diary has been saved.'));
			} else {
				$this->Flash->error(__('The diary could not be saved. Please, try again.'));
			}
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function confirmDiary($id = null) {
        $this->Diary->id = $id;
		if (!$this->Diary->exists()) {
			$this->Flash->error(__('Invalid diary'));
            return $this->redirect(array('action' => 'index'));
		}
		if ($this->Diary->field('status') == 'opened') {
			$options = array(
				'conditions' => array(
					$this->Diary->Car->alias.'.id' => $this->Diary->field('car_id'),
				),
				'recursive' => -1,
			);
			$car = $this->Diary->Car->find('first', $options);
			if (!empty($car)) {
				$data = array(
					$this->Diary->alias => array(
						'status' => 'in_progress',
						'initial_km' => $car[$this->Diary->Car->alias]['km'],
					),
				);
				if ($this->Diary->save($data)) {
					$this->Flash->success(__('The diary has been saved.'));
					return $this->redirect(array('action' => 'close', $id));
				} else {
					$this->Flash->error(__('The diary could not be saved. Please, try again.'));
				}
			} else {
				$this->Flash->error(__('The diary could not be saved. Please, try again.'));
			}
		}
		return $this->redirect(array('controller' => 'stops', 'action' => 'index', 'diary' => $id));
	}

	public function view($id = null) {
        $this->Diary->id = $id;
		if (!$this->Diary->exists()) {
			$this->Flash->error(__('Invalid diary'));
            return $this->redirect(array('action' => 'index'));
		}
        $diary = $this->Diary->read();
		$options = array(
			'conditions' => array(
				$this->Diary->Destination->City->alias.'.id' => $diary[$this->Diary->Destination->alias]['city_id'],
			),
			'recursive' => -1,
		);
		$city = $this->Diary->Destination->City->find('first', $options);
		$this->set(compact('diary', 'city'));
	}

	public function close($id = null) {
		$this->Diary->id = $id;
		if (!$this->Diary->exists()) {
			$this->Flash->error(__('Invalid diary'));
			return $this->redirect(array('action' => 'index'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Diary->saveAll($this->request->data)) {
				$this->Flash->success(__('The diary has been saved.'));
			} else {
				$this->Flash->error(__('The diary could not be saved. Please, try again.'));
			}
		}
		$this->Diary->recursive = 2;
		$diary = $this->Diary->read();
		$this->request->data = $diary;
		$availableAccents = $diary[$this->Diary->Car->alias]['capacity'] - count($diary[$this->Diary->Stop->alias]);
		$options = array(
			'conditions' => array(
				$this->Diary->Driver->alias.'.enabled' => 1,
				$this->Diary->Driver->alias.'.role' => 'driver',
			),
			'fields' => array(
				'id',
				'name',
				'document',
			),
		);
		$drivers = $this->Diary->Driver->find('all', $options);
		$drivers = Hash::combine($drivers, '{n}.Driver.id', array('%s - %s', '{n}.Driver.name', '{n}.Driver.document'));
		asort($drivers);
		$options = array(
			'conditions' => array(
				$this->Diary->Car->alias.'.enabled' => 1,
			),
			'fields' => array(
				'id',
				'model',
				'car_plate',
			),
		);
		$cars = $this->Diary->Car->find('all', $options);
		$cars = Hash::combine($cars, '{n}.Car.id', array('%s - %s', '{n}.Car.model', '{n}.Car.car_plate'));
		asort($cars);
		$this->set(compact('diary', 'drivers', 'cars', 'availableAccents'));
	}

	public function printStops($id = null) {
		$this->Diary->id = $id;
		if (!$this->Diary->exists()) {
			$this->Flash->error(__('Invalid diary'));
			return $this->redirect('/');
		}
		$this->layout = 'login';
		$this->Diary->recursive = 2;
		$diary = $this->Diary->read();
		$this->set(compact('diary'));
	}
}
