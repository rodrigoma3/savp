<?php
App::uses('AppController', 'Controller');
/**
 * Reports Controller
 *
 * @property Report $Report
 */
class ReportsController extends AppController{

    public $uses = array(
        'Report',
        'Car',
        'City',
        'Destination',
        'Diary',
        'Establishment',
        'Stop',
        'User',
    );

    public function isAuthorized($user = null) {
        if (parent::isAuthorized($user)) {
			return true;
		}

		if (isset($this->Report->perms[$this->request->params['controller']][$this->action]) && in_array($user['role'], $this->Report->perms[$this->request->params['controller']][$this->action])) {
			return true;
		}

		return false;
	}

    public function index(){

    }

    public function historic() {
        $options = array(
			'conditions' => array(
				$this->Stop->alias.'.companion_id' => $this->Auth->user('id'),
			),
		);
		$companions = $this->Stop->find('all', $options);

        $companionPatient = Hash::combine($companions, '{n}.Stop.diary_id', '{n}.Stop.patient_id');
        $options = array(
            'conditions' => array(

            ),
            'fields' => array(
                'diary_id',
                'absent',
            ),
        );
        foreach ($companionPatient as $diaryId => $companionId) {
            $options['conditions'][]['AND'] = array(
                $this->Stop->alias.'.diary_id' => $diaryId,
                $this->Stop->alias.'.patient_id' => $companionId,
            );
        }
        $companionPatients = $this->Stop->find('list', $options);

		$options = array(
			'conditions' => array(
				$this->Stop->alias.'.patient_id' => $this->Auth->user('id'),
                'NOT' => array(
                    $this->Stop->alias.'.diary_id' => Hash::extract($companions, '{n}.Stop.diary_id'),
                ),
			),
		);
		$patients = $this->Stop->find('all', $options);

        $patientCompanion = Hash::combine($patients, '{n}.Stop.diary_id', '{n}.Stop.companion_id');
        $patientCompanion = array_filter($patientCompanion);
        $options = array(
            'conditions' => array(

            ),
            'fields' => array(
                'diary_id',
                'absent',
            ),
        );
        foreach ($patientCompanion as $diaryId => $companionId) {
            $options['conditions'][]['AND'] = array(
                $this->Stop->alias.'.diary_id' => $diaryId,
                $this->Stop->alias.'.companion_id' => $companionId,
            );
        }
        $patientCompanions = $this->Stop->find('list', $options);

        $options = array(
            'order' => array(
                $this->City->alias.'.name',
            ),
        );
        $cities = $this->City->find('list', $options);

        $bedriddens = array(
            0 => __('No'),
            1 => __('Yes'),
        );

        $absents = array(
            0 => __('No'),
            1 => __('Yes'),
        );

        $this->set(compact('patients', 'companions', 'cities', 'bedriddens', 'absents', 'patientCompanions', 'companionPatients'));
	}

}
