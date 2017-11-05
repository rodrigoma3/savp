<?php
App::uses('AppController', 'Controller');
/**
 * Diaries Controller
 *
 * @property Diary $Diary
 */
class DiariesController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$options = array(
			'conditions' => array(

			),
		);
		if (empty($this->request->data[$this->Diary->alias]['range_date'])) {
			$this->request->data[$this->Diary->alias]['range_date'] = date('Y-m-01').' - '.date('Y-m-t');
		}
		if ($this->request->is('post')) {
			if ($this->request->data[$this->Diary->alias]['status'] != 'all') {
				$options['conditions']['status'] = $this->request->data[$this->Diary->alias]['status'];
			}
			if (!empty($this->request->data[$this->Diary->alias]['range_date'])) {
				$range = explode(' - ', $this->request->data[$this->Diary->alias]['range_date']);
				if (count($range) == 2) {
					$options['conditions']['date BETWEEN ? AND ?'] = array($range[0], $range[1]);
				}
			}
		}
		$this->Diary->recursive = 0;
        $diaries = $this->Diary->find('all', $options);
		$statuses = array(
			'all' => __('All'),
			'opened' => __('Opened'),
			'closed' => __('Closed'),
		);
		$cities = $this->Diary->Destination->City->find('list');
		$this->set(compact('diaries', 'statuses', 'cities'));
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view() {
        // $this->Diary->id = $id;
		// if (!$this->Diary->exists()) {
		// 	$this->Flash->error(__('Invalid diary'));
        //     return $this->redirect(array('action' => 'index'));
		// }
        // $diary = $this->Diary->read();
		// $this->set(compact('diary'));
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
						'status' => 'opened',
					),
				);
				$diaries = $this->Diary->find('all', $options);
				// CakeLog::write('info', print_r($diaries,true));
				if (!empty($diaries)) {
					$cities = $this->Diary->Destination->City->find('list');
					// CakeLog::write('info', print_r($cities,true));
					$view = new View();
					$html = $view->loadHelper('Html');
					foreach ($diaries as $diary) {
						$result['data'][] = array(
							'destination' => $cities[$diary[$this->Diary->Destination->alias]['city_id']].' - '.$diary[$this->Diary->Destination->alias]['time'],
							'car' => $diary[$this->Diary->Car->alias]['model'].' - '.$diary[$this->Diary->Car->alias]['car_plate'],
							'title_free' => __('Available Accents'),
							'free' => $diary[$this->Diary->Car->alias]['capacity'] - count($diary[$this->Diary->Stop->alias]),
							'button_schedule' => $html->link(__('Schedule'), array('controller' => 'stops', 'action' => 'index', $diary[$this->Diary->alias]['id']), array('class' => 'btn btn-success pull-right', 'div' => false)),
						);
					}
				}
				$result['error'] = 0;
			} elseif (isset($this->request->data['act']) && $this->request->data['act'] !== null) {
				switch ($this->request->data['act']) {
					case 'dates':
						$options = array(
							'conditions' => array(
								$this->Diary->alias.'.status' => 'opened',
							),
						);
						$diaries = $this->Diary->find('all', $options);
						foreach ($diaries as $diary) {
							if (($diary[$this->Diary->Car->alias]['capacity'] - count($diary[$this->Diary->Stop->alias])) > 0) {
								$result['data'][] = array(
									'title' => __('Open diary'),
									'date' => $diary[$this->Diary->alias]['date'],
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

/**
 * add method
 *
 * @return void
 */
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
		$options = array(
			'conditions' => array(
				$this->Diary->Driver->alias.'.enabled' => 1,
			),
		);
		$drivers = $this->Diary->Driver->find('all', $options);
		$drivers = Hash::combine($drivers, '{n}.Driver.id', array('%s - %s', '{n}.Driver.name', '{n}.Driver.document'));
		$options = array(
			'conditions' => array(
				$this->Diary->Car->alias.'.enabled' => 1,
			),
		);
		$cars = $this->Diary->Car->find('all', $options);
		$cars = Hash::combine($cars, '{n}.Car.id', array('%s - %s', '{n}.Car.model', '{n}.Car.car_plate'));
		$options = array(
			'conditions' => array(
				$this->Diary->Destination->alias.'.enabled' => 1,
			),
		);
		$destinations = $this->Diary->Destination->find('all', $options);
		$destinations = Hash::combine($destinations, '{n}.Destination.id', array('%s - %s', '{n}.City.name', '{n}.Destination.time'));
		$this->set(compact('destinations', 'cars', 'drivers'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
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
				$this->Diary->Driver->alias.'.enabled' => 1,
			),
		);
		$drivers = $this->Diary->Driver->find('all', $options);
		$drivers = Hash::combine($drivers, '{n}.Driver.id', array('%s - %s', '{n}.Driver.name', '{n}.Driver.document'));
		$options = array(
			'conditions' => array(
				$this->Diary->Car->alias.'.enabled' => 1,
			),
		);
		$cars = $this->Diary->Car->find('all', $options);
		$cars = Hash::combine($cars, '{n}.Car.id', array('%s - %s', '{n}.Car.model', '{n}.Car.car_plate'));
		$options = array(
			'conditions' => array(
				$this->Diary->Destination->alias.'.enabled' => 1,
			),
		);
		$destinations = $this->Diary->Destination->find('all', $options);
		$destinations = Hash::combine($destinations, '{n}.Destination.id', array('%s - %s', '{n}.City.name', '{n}.Destination.time'));
		$statuses = array(
			'opened' => __('Opened'),
			'closed' => __('Closed'),
		);
		$this->set(compact('destinations', 'cars', 'drivers', 'statuses'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
        $this->Diary->id = $id;
		if (!$this->Diary->exists()) {
			$this->Flash->error(__('Invalid diary'));
            return $this->redirect(array('action' => 'index'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Diary->delete()) {
			$this->Flash->success(__('The diary has been deleted.'));
		} else {
			$this->Flash->error(__('The diary could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
