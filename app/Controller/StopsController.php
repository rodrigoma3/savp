<?php
App::uses('AppController', 'Controller');
/**
 * Stops Controller
 *
 * @property Stop $Stop
 */
class StopsController extends AppController {

	public function isAuthorized($user = null) {
		if (parent::isAuthorized($user)) {
			return true;
		}

		if (isset($this->Stop->perms[$this->request->params['controller']][$this->action]) && in_array($user['role'], $this->Stop->perms[$this->request->params['controller']][$this->action])) {
			return true;
		}

		return false;
	}

	public function index() {
		if (isset($this->request->named['diary']) && $this->request->named['diary'] !== null) {
			$options = array(
				'conditions' => array(
					$this->Stop->Diary->alias.'.id' => $this->request->named['diary'],
				),
			);
			$this->Stop->Diary->recursive = 2;
			$diary = $this->Stop->Diary->find('first', $options);
			$diary[$this->Stop->alias] = Hash::sort($diary[$this->Stop->alias], '{n}.sequence', 'asc', 'numeric');
			$availableAccents = $diary[$this->Stop->Diary->Car->alias]['capacity'] - count($diary[$this->Stop->alias]);
			$stops = array();
			$companions = Hash::combine($diary[$this->Stop->alias], '{n}.id', '{n}.companion_id');
			$companions = array_filter($companions);
			$patients = Hash::combine($diary[$this->Stop->alias], '{n}.id', '{n}.patient_id');
			$patients = array_filter($patients);
			foreach ($diary[$this->Stop->alias] as $stop) {
				if (!in_array($stop['patient_id'], $companions)) {
					$s = array(
						'id' => $stop['id'],
						'start_time' => $stop['start_time'],
						'end_time' => $stop['end_time'],
						'bedridden' => $stop['bedridden'],
						'companion_stop_id' => '',
						$this->Stop->Establishment->alias => array(
							'name' => $stop[$this->Stop->Establishment->alias]['name'],
						),
						$this->Stop->Patient->alias => array(
							'name' => $stop[$this->Stop->Patient->alias]['name'],
							'document' => $stop[$this->Stop->Patient->alias]['document'],
						),
						$this->Stop->Companion->alias => array(

						),
					);
					if (isset($stop[$this->Stop->Companion->alias]) && !empty($stop[$this->Stop->Companion->alias])) {
						$s[$this->Stop->Companion->alias] = array(
							'name' => $stop[$this->Stop->Companion->alias]['name'],
							'document' => $stop[$this->Stop->Companion->alias]['document'],
						);
						$s['companion_stop_id'] = array_search($stop['companion_id'], $patients);
					}
					$stops[] = $s;
				}
			}
			$diary[$this->Stop->alias] = $stops;
			$absents = array(
				0 => __('No'),
				1 => __('Yes'),
			);
			$this->set(compact('diary', 'absents', 'availableAccents'));
		} else {
			$this->Flash->error(__('Invalid diary'));
			return $this->redirect(array('controller' => 'diaries', 'action' => 'view'));
		}
	}

	public function sequence() {
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
		return $this->redirect($this->referer());
	}

	public function add() {
		if ($this->request->is('post')) {
			$data = array();
			$sequenceUpdate = 0;
			$sequence = null;
			if (isset($this->request->data[$this->Stop->alias]['establishment_id']) && !empty($this->request->data[$this->Stop->alias]['establishment_id'])) {
				$options = array(
					'conditions' => array(
						$this->Stop->Establishment->alias.'.id' => $this->request->data[$this->Stop->alias]['establishment_id'],
					),
				);
				$establishment = $this->Stop->Establishment->find('first', $options);
				if (isset($establishment[$this->Stop->Establishment->alias]['sequence']) && !empty($establishment[$this->Stop->Establishment->alias]['sequence'])) {
					$this->request->data[$this->Stop->alias]['sequence'] = $establishment[$this->Stop->Establishment->alias]['sequence'];
					$sequence = $establishment[$this->Stop->Establishment->alias]['sequence'];
					$sequenceUpdate++;
				}
			}
			if (isset($this->request->data[$this->Stop->alias]['companion_id']) && !empty($this->request->data[$this->Stop->alias]['companion_id'])) {
				if ($this->request->data[$this->Stop->alias]['companion_id'] == $this->request->data[$this->Stop->alias]['patient_id']) {
					unset($this->request->data[$this->Stop->alias]['companion_id']);
				} else {
					$companion = $this->request->data;
					$companion[$this->Stop->alias]['patient_id'] = $companion[$this->Stop->alias]['companion_id'];
					unset($companion[$this->Stop->alias]['companion_id']);
					unset($companion[$this->Stop->alias]['bedridden']);
					$companion[$this->Stop->alias]['sequence'] = $companion[$this->Stop->alias]['sequence'] + 1;
					$data[] = $companion;
					$sequence++;
					$sequenceUpdate++;
				}
			}
			$data[] = $this->request->data;
			$this->Stop->create();
			if ($this->Stop->saveMany($data)) {
				$this->Flash->success(__('The stop has been saved.'));
				if ($sequenceUpdate > 0 && !is_null($sequence)) {
					$fields = array(
						$this->Stop->alias.'.sequence' => $this->Stop->alias.'.sequence + '.$sequenceUpdate,
					);
					$conditions = array(
						$this->Stop->alias.'.sequence >=' => $this->request->data[$this->Stop->alias]['sequence'],
						$this->Stop->alias.'.diary_id' => $this->request->data[$this->Stop->alias]['diary_id'],
						'NOT' => array(
							$this->Stop->alias.'.patient_id' => Hash::extract($data, '{n}.Stop.patient_id'),
						),
					);
					$this->Stop->recursive = -1;
					$this->Stop->updateAll($fields, $conditions);
				}
				return $this->redirect(array('action' => 'index', 'diary' => $this->request->data[$this->Stop->alias]['diary_id']));
			} else {
				$this->Flash->error(__('The stop could not be saved. Please, try again.'));
				// debug($this->Stop->invalidFields());
				$this->Stop->invalidFields();
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
		$pIds = Hash::extract($diary, 'Stop.{n}.patient_id');
		$options = array(
			'conditions' => array(
				'city_id' => $diary[$this->Stop->Diary->Destination->alias]['city_id'],
				'enabled' => 1,
			),
			'order' => array($this->Stop->Establishment->alias.'.name'),
		);
		$establishments = $this->Stop->Establishment->find('list', $options);
		$options = array(
			'conditions' => array(
				'role' => 'patient',
				'enabled' => 1,
				'NOT' => array(
					'id' => $pIds,
				),
			),
			'order' => array($this->Stop->Patient->alias.'.name'),
		);
		$patients = $this->Stop->Patient->find('list', $options);
		$companions = $patients;
		$hasVacancy = (($diary[$this->Stop->Diary->Car->alias]['capacity'] - count($pIds)) > 1);
		$this->set(compact('establishments', 'patients', 'companions', 'hasVacancy'));
	}

	public function edit($id = null) {
        $this->Stop->id = $id;
		if (!$this->Stop->exists()) {
			$this->Flash->error(__('Invalid stop'));
            return $this->redirect(array('action' => 'index'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$companion = $this->Stop->field('companion_id');
			$diary = $this->Stop->field('diary_id');
			$data = array();
			$data[] = $this->request->data;
			if (isset($this->request->data[$this->Stop->alias]['companion_id']) && !empty($this->request->data[$this->Stop->alias]['companion_id']) && $this->request->data[$this->Stop->alias]['companion_id'] != $companion) {
				// if ($this->request->data[$this->Stop->alias]['companion_id'] == $patient) {
				// 	unset($this->request->data[$this->Stop->alias]['companion_id']);
				// } else {
				// }
				$newCompanion = $this->request->data;
				$newCompanion[$this->Stop->alias]['patient_id'] = $newCompanion[$this->Stop->alias]['companion_id'];
				unset($newCompanion[$this->Stop->alias]['id']);
				unset($newCompanion[$this->Stop->alias]['companion_id']);
				unset($newCompanion[$this->Stop->alias]['bedridden']);
				$newCompanion[$this->Stop->alias]['sequence'] = $this->Stop->field('sequence') + 1;
				$data[] = $newCompanion;
			}
			if (!empty($companion) && $this->request->data[$this->Stop->alias]['companion_id'] != $companion && $this->request->data[$this->Stop->alias]['companion_id'] != $this->request->data[$this->Stop->alias]['patient_id']) {
				$conditions = array(
					$this->Stop->alias.'.diary_id' => $diary,
					$this->Stop->alias.'.patient_id' => $companion,
				);
				$this->Stop->deleteAll($conditions);
			}
			if ($this->Stop->saveMany($data)) {
				$this->Flash->success(__('The stop has been saved.'));
				return $this->redirect(array('controller' => 'stops', 'action' => 'index', 'diary' => $diary));
			} else {
				$this->Flash->error(__('The stop could not be saved. Please, try again.'));
				$this->Stop->invalidFields();
			}
		} else {
			$this->request->data = $this->Stop->read();
		}
		if (!isset($this->request->named['diary']) || $this->request->named['diary'] === null) {
			return $this->redirect(array('controller' => 'diaries', 'action' => 'view'));
		}
		$options = array(
			'conditions' => array(
				$this->Stop->Diary->alias.'.id' => $this->request->named['diary'],
			),
		);
		$diary = $this->Stop->Diary->find('first', $options);
		$pIds = Hash::extract($diary, 'Stop.{n}.patient_id');
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
				'NOT' => array(
					'id' => $pIds,
				),
			),
			'order' => array($this->Stop->Patient->alias.'.name'),
		);
		$companions = $this->Stop->Patient->find('list', $options);
		$this->set(compact('establishments', 'companions'));
	}

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
			$diaryId = $this->Stop->field('diary_id');
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
					$conditions = array(
						'patient_id' => $companion,
						'diary_id' => $diaryId,
					);
					if ($this->Stop->deleteAll($conditions)) {
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

	public function proofOfScheduling($id = null) {
		$this->Stop->id = $id;
		if (!$this->Stop->exists()) {
			$this->Flash->error(__('Invalid stop'));
			return $this->redirect($this->Auth->loginRedirect);
		}
		$this->layout = 'login';
		$this->Stop->recursive = 2;
		$stop = $this->Stop->read();
		$cities = $this->Stop->Patient->City->find('list');
		$this->set(compact('stop', 'cities'));
	}
}
