<?php
App::uses('AppController', 'Controller');
/**
 * Establishments Controller
 *
 * @property Establishment $Establishment
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class EstablishmentsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Flash');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Establishment->recursive = 0;
        $establishments = $this->Establishment->find('all');
		$this->set(compact('establishments'));
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
		$this->set(compact('establishment'));
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
		$cities = $this->Establishment->City->find('list');
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
		$cities = $this->Establishment->City->find('list');
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
}
