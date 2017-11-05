<?php
App::uses('AppController', 'Controller');
/**
 * Stops Controller
 *
 * @property Stop $Stop
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class StopsController extends AppController {

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
		$this->Stop->recursive = 0;
        $stops = $this->Stop->find('all');
		$absents = array(
			0 => __('No'),
			1 => __('Yes'),
		);
		$this->set(compact('stops', 'absents'));
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
			$this->Stop->create();
			if ($this->Stop->save($this->request->data)) {
				$this->Flash->success(__('The stop has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The stop could not be saved. Please, try again.'));
			}
		}
		$diaries = $this->Stop->Diary->find('list');
		$establishments = $this->Stop->Establishment->find('list');
		$patients = $this->Stop->Patient->find('list');
		$companions = $this->Stop->Companion->find('list');
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
        $this->Stop->id = $id;
		if (!$this->Stop->exists()) {
			$this->Flash->error(__('Invalid stop'));
            return $this->redirect(array('action' => 'index'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Stop->delete()) {
			$this->Flash->success(__('The stop has been deleted.'));
		} else {
			$this->Flash->error(__('The stop could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
