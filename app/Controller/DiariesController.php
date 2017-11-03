<?php
App::uses('AppController', 'Controller');
/**
 * Diaries Controller
 *
 * @property Diary $Diary
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class DiariesController extends AppController {

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
		$this->Diary->recursive = 0;
        $diaries = $this->Diary->find('all');
		$this->set(compact('diaries'));
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
        $this->Diary->id = $id;
		if (!$this->Diary->exists()) {
			$this->Flash->error(__('Invalid diary'));
            return $this->redirect(array('action' => 'index'));
		}
        $diary = $this->Diary->read();
		$this->set(compact('diary'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Diary->create();
			if ($this->Diary->save($this->request->data)) {
				$this->Flash->success(__('The diary has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The diary could not be saved. Please, try again.'));
			}
		}
		$destinations = $this->Diary->Destination->find('list');
		$cars = $this->Diary->Car->find('list');
		$drivers = $this->Diary->Driver->find('list');
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
		$destinations = $this->Diary->Destination->find('list');
		$cars = $this->Diary->Car->find('list');
		$drivers = $this->Diary->Driver->find('list');
		$this->set(compact('destinations', 'cars', 'drivers'));
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
