<?php
App::uses('AppController', 'Controller');
/**
 * Cities Controller
 *
 * @property City $City
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class CitiesController extends AppController {

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
		$this->City->recursive = 0;
        $cities = $this->City->find('all');
		$this->set(compact('cities'));
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
        $this->City->id = $id;
		if (!$this->City->exists()) {
			$this->Flash->error(__('Invalid city'));
            return $this->redirect(array('action' => 'index'));
		}
        $city = $this->City->read();
		$this->set(compact('city'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->City->create();
			if ($this->City->save($this->request->data)) {
				$this->Flash->success(__('The city has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The city could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
        $this->City->id = $id;
		if (!$this->City->exists()) {
			$this->Flash->error(__('Invalid city'));
            return $this->redirect(array('action' => 'index'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->City->save($this->request->data)) {
				$this->Flash->success(__('The city has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The city could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->City->read();
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
        $this->City->id = $id;
		if (!$this->City->exists()) {
			$this->Flash->error(__('Invalid city'));
            return $this->redirect(array('action' => 'index'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->City->delete()) {
			$this->Flash->success(__('The city has been deleted.'));
		} else {
			$this->Flash->error(__('The city could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
