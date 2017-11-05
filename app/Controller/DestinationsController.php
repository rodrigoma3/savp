<?php
App::uses('AppController', 'Controller');
/**
 * Destinations Controller
 *
 * @property Destination $Destination
 */
class DestinationsController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Destination->recursive = 0;
        $destinations = $this->Destination->find('all');
		$enableds = array(
			0 => __('No'),
			1 => __('Yes'),
		);
		$this->set(compact('destinations', 'enableds'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Destination->create();
			if ($this->Destination->save($this->request->data)) {
				$this->Flash->success(__('The destination has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The destination could not be saved. Please, try again.'));
			}
		}
		$cities = $this->Destination->City->find('list');
		$this->set(compact('cities'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
        $this->Destination->id = $id;
		if (!$this->Destination->exists()) {
			$this->Flash->error(__('Invalid destination'));
            return $this->redirect(array('action' => 'index'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Destination->save($this->request->data)) {
				$this->Flash->success(__('The destination has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The destination could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Destination->read();
		}
		$cities = $this->Destination->City->find('list');
		$this->set(compact('cities'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
        $this->Destination->id = $id;
		if (!$this->Destination->exists()) {
			$this->Flash->error(__('Invalid destination'));
            return $this->redirect(array('action' => 'index'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Destination->delete()) {
			$this->Flash->success(__('The destination has been deleted.'));
		} else {
			$this->Flash->error(__('The destination could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
