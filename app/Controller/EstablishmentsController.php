<?php
App::uses('AppController', 'Controller');
/**
 * Establishments Controller
 *
 * @property Establishment $Establishment
 */
class EstablishmentsController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Establishment->recursive = 0;
        $establishments = $this->Establishment->find('all');
		$enableds = array(
			0 => __('No'),
			1 => __('Yes'),
		);
		$this->set(compact('establishments', 'enableds'));
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
        $this->Establishment->id = $id;
		if (!$this->Establishment->exists()) {
			$this->Flash->error(__('Invalid establishment'));
            return $this->redirect(array('action' => 'index'));
		}
        $establishment = $this->Establishment->read();
		$enableds = array(
			0 => __('No'),
			1 => __('Yes'),
		);
		$this->set(compact('establishment', 'enableds'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Establishment->create();
			if ($this->Establishment->save($this->request->data)) {
				$this->Flash->success(__('The establishment has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The establishment could not be saved. Please, try again.'));
			}
		}
		$options = array(
			'conditions' => array(
				$this->Establishment->City->alias.'.enabled' => 1,
			),
		);
		$cities = $this->Establishment->City->find('list', $options);
		$this->set(compact('cities'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
        $this->Establishment->id = $id;
		if (!$this->Establishment->exists()) {
			$this->Flash->error(__('Invalid establishment'));
            return $this->redirect(array('action' => 'index'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Establishment->save($this->request->data)) {
				$this->Flash->success(__('The establishment has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The establishment could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Establishment->read();
		}
		$options = array(
			'conditions' => array(
				$this->Establishment->City->alias.'.enabled' => 1,
			),
		);
		$cities = $this->Establishment->City->find('list', $options);
		$this->set(compact('cities'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
        $this->Establishment->id = $id;
		if (!$this->Establishment->exists()) {
			$this->Flash->error(__('Invalid establishment'));
            return $this->redirect(array('action' => 'index'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Establishment->delete()) {
			$this->Flash->success(__('The establishment has been deleted.'));
		} else {
			$this->Flash->error(__('The establishment could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function sequence() {
		if ($this->request->is('ajax')) {
			$this->autoRender = false;
			$res = array(
				'error' => 1,
				'data' => array(),
			);
			// CakeLog::info(print_r($this->request, true));
			if ($this->request->query('city_id') !== null) {
				$options = array(
					'conditions' => array(
						$this->Establishment->alias.'.city_id' => $this->request->query('city_id'),
						$this->Establishment->alias.'.enabled' => 1,
					),
					'order' => array($this->Establishment->alias.'.sequence'),
				);
				$establishments = $this->Establishment->find('all', $options);
				// CakeLog::info(print_r($establishments, true));
				foreach ($establishments as $establishment) {
					$res['data'][] = array(
						'text' => $establishment[$this->Establishment->alias]['name'],
						'id' => $establishment[$this->Establishment->alias]['id'],
					);
				}
				$res['error'] = 0;
			}

			return json_encode($res);
		} elseif ($this->request->is('post')) {
			$sequences = array();
			if (isset($this->request->data[$this->Establishment->alias]['sequence']) && !empty($this->request->data[$this->Establishment->alias]['sequence'])) {
				$sequences = explode(',', $this->request->data[$this->Establishment->alias]['sequence']);
			}
			if (!empty($sequences)) {
				$data = array();
				$count = 1;
				foreach ($sequences as $sequence) {
					$data[] = array(
						$this->Establishment->alias => array(
							'id' => $sequence,
							'sequence' => $count,
						),
					);
					$count++;
				}
				if (!empty($data)) {
					if ($this->Establishment->saveMany($data)) {
						$this->Flash->success(__('The sequence of the establishments has been saved.'));
					} else {
						$this->Flash->error(__('The sequence of the establishments could not be saved.'));
					}
				}
			}
		}
		$options = array(
			'conditions' => array(
				'enabled' => 1,
			),
		);
		$cities = $this->Establishment->City->find('list', $options);
		$this->set(compact('cities'));
	}
}
