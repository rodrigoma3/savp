<?php
App::uses('AppController', 'Controller');
/**
 * Stops Controller
 *
 * @property Stop $Stop
 */
class StopsController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		if ($this->request->is('post')) {
			$sequences = array();
			if (isset($this->request->data[$this->Stop->alias]['sequence']) && !empty($this->request->data[$this->Stop->alias]['sequence'])) {
				$sequences = explode(',', $this->request->data[$this->Stop->alias]['sequence']);
			}
			if (!empty($sequences)) {
				$data = array();
				$count = 1;
				foreach ($sequences as $sequence) {
					$data[] = array(
						$this->Stop->alias => array(
							'id' => $sequence,
							'sequence' => $count,
						),
					);
					$count++;
				}
				if (!empty($data)) {
					if ($this->Stop->saveMany($data)) {
						$this->Flash->success(__('The sequence of the stops has been saved.'));
					} else {
						$this->Flash->error(__('The sequence of the stops could not be saved.'));
					}
				}
			}
		}
		if (isset($this->request->named['diary']) && $this->request->named['diary'] !== null) {
			$options = array(
				'conditions' => array(
					$this->Stop->Diary->alias.'.id' => $this->request->named['diary'],
				),
			);
			$this->Stop->Diary->recursive = 2;
			$diary = $this->Stop->Diary->find('first', $options);
			$absents = array(
				0 => __('No'),
				1 => __('Yes'),
			);
			$this->set(compact('diary', 'absents'));
		} else {
			$this->Flash->error(__('Invalid diary'));
			return $this->redirect(array('controller' => 'diaries', 'action' => 'view'));
		}
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
        $this->Stop->id = $id;
		if (!$this->Stop->exists()) {
			$this->Flash->error(__('Invalid stop'));
            return $this->redirect(array('action' => 'index'));
		}
        $stop = $this->Stop->read();
		$absents = array(
			0 => __('No'),
			1 => __('Yes'),
		);
		$this->set(compact('stop', 'absents'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			if (isset($this->request->data[$this->Stop->alias]['companion_id']) && $this->request->data[$this->Stop->alias]['companion_id'] != 'empty') {
				if ($this->request->data[$this->Stop->alias]['companion_id'] == $this->request->data[$this->Stop->alias]['patient_id']) {
					unset($this->request->data[$this->Stop->alias]['companion_id']);
				} else {
					$companion = $this->request->data;
					$companion[$this->Stop->alias]['patient_id'] = $companion[$this->Stop->alias]['companion_id'];
					unset($companion[$this->Stop->alias]['companion_id']);
				}
			}
			if (isset($this->request->data[$this->Stop->alias]['establishment_id']) && $this->request->data[$this->Stop->alias]['establishment_id'] != null) {
				$options = array(
					'conditions' => array(
						$this->Stop->Establishment->alias.'.id' => $this->request->data[$this->Stop->alias]['establishment_id'],
					),
				);
				$establishment = $this->Stop->Establishment->find('first', $options);
				// if (!empty($establishment)) {
					if (isset($establishment[$this->Stop->Establishment->alias]['sequence']) && !empty($establishment[$this->Stop->Establishment->alias]['sequence']) && $establishment[$this->Stop->Establishment->alias]['sequence'] > 0) {
						$this->request->data[$this->Stop->alias]['sequence'] = $establishment[$this->Stop->Establishment->alias]['sequence'];
						$fields = array(
							$this->Stop->alias.'.sequence' => $this->Stop->alias.'.sequence + 1',
						);
						$conditions = array(
							$this->Stop->alias.'.sequence >=' => $establishment[$this->Stop->Establishment->alias]['sequence'],
						);
						$this->Stop->updateAll($fields, $conditions);
					}
				// }
			}
			$this->Stop->create();
			if ($this->Stop->save($this->request->data)) {
				if (isset($companion) && !empty($companion)) {
					$this->Stop->create();
					if ($this->Stop->save($companion)) {
						$this->Flash->success(__('The stop has been saved.'));
					} else {
						$this->Flash->warning(__('The stop has been saved but the companion could not be saved.'));
					}
				} else {
					$this->Flash->success(__('The stop has been saved.'));
				}
				return $this->redirect(array('action' => 'index', 'diary' => $this->request->data[$this->Stop->alias]['diary_id']));
			} else {
				$this->Flash->error(__('The stop could not be saved. Please, try again.'));
			}
		}
		if (isset($this->request->named['diary']) && $this->request->named['diary'] !== null) {
			$this->request->data[$this->Stop->alias]['diary_id'] = $this->request->named['diary'];
		} else {
			return $this->redirect(array('controller' => 'diaries', 'action' => 'view'));
		}
		$options = array(
			'conditions' => array(
				$this->Stop->Diary->alias.'.id' => $this->request->named['diary'],
			),
		);
		$diary = $this->Stop->Diary->find('first', $options);
		$options = array(
			'conditions' => array(
				'city_id' => $diary[$this->Stop->Diary->Destination->alias]['city_id'],
				'enabled' => 1,
			),
		);
		$establishments = $this->Stop->Establishment->find('list', $options);
		$options = array(
			'conditions' => array(
				'role' => 'patient',
				'enabled' => 1,
			),
		);
		$patients = $this->Stop->Patient->find('list', $options);
		$companions = array('empty' => __('none'));
		$companions += $this->Stop->Companion->find('list', $options);
		$this->set(compact('diaries', 'establishments', 'patients', 'companions'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
        $this->Stop->id = $id;
		if (!$this->Stop->exists()) {
			$this->Flash->error(__('Invalid stop'));
            return $this->redirect(array('action' => 'index'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Stop->save($this->request->data)) {
				$this->Flash->success(__('The stop has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The stop could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Stop->read();
		}
		$diaries = $this->Stop->Diary->find('list');
		$establishments = $this->Stop->Establishment->find('list');
		$patients = $this->Stop->Patient->find('list');
		$companions = $this->Stop->Companion->find('list');
		$this->set(compact('diaries', 'establishments', 'patients', 'companions'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$diary = null;
		if (isset($this->request->named['diary']) && $this->request->named['diary'] !== null) {
			$diary = $this->request->named['diary'];
		}
        $this->Stop->id = $id;
		if (!$this->Stop->exists()) {
			$this->Flash->error(__('Invalid stop'));
		} else {
			$this->request->allowMethod('post', 'delete');
			$companion = $this->Stop->field('companion_id');
			$patient = $this->Stop->field('patient_id');
			if ($this->Stop->delete()) {
				$fields = array(
					'companion_id' => NULL,
				);
				$conditions = array(
					'companion_id' => $patient,
				);
				$this->Stop->updateAll($fields, $conditions);
				if (!empty($companion) && $companion > 0) {
					if ($this->Stop->delete($companion)) {
						$this->Flash->success(__('The stop has been deleted.'));
					} else {
						$this->Flash->warning(__('The stop has been deleted but the companion could not be deleted.'));
					}
				} else {
					$this->Flash->success(__('The stop has been deleted.'));
				}
			} else {
				$this->Flash->error(__('The stop could not be deleted. Please, try again.'));
			}
		}
		if (is_null($diary)) {
			return $this->redirect(array('controller' => 'diaries', 'action' => 'view'));
		} else {
			return $this->redirect(array('action' => 'index', 'diary' => $diary));
		}
	}

	public function printStops() {
		$this->layout = 'login';
		if (isset($this->request->named['diary']) && $this->request->named['diary'] !== null) {
			$options = array(
				'conditions' => array(
					$this->Stop->Diary->alias.'.id' => $this->request->named['diary'],
				),
			);
			$this->Stop->Diary->recursive = 2;
			$diary = $this->Stop->Diary->find('first', $options);
			$this->set(compact('diary'));
		} else {
			die;
		}
	}
}
