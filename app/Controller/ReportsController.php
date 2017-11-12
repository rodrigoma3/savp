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
        $f = array();
        $fieldsCar = $this->Car->schema();
        $f[$this->Car->alias] = array_keys($fieldsCar);
        $fieldsCity = $this->City->schema();
        $f[$this->City->alias] = array_keys($fieldsCity);
        $fieldsDestination = $this->Destination->schema();
        $f[$this->Destination->alias] = array_keys($fieldsDestination);
        $fieldsDiary = $this->Diary->schema();
        $f[$this->Diary->alias] = array_keys($fieldsDiary);
        $fieldsEstablishment = $this->Establishment->schema();
        $f[$this->Establishment->alias] = array_keys($fieldsEstablishment);
        $fieldsStop = $this->Stop->schema();
        $f[$this->Stop->alias] = array_keys($fieldsStop);
        $fieldsUser = $this->User->schema();
        $fieldsUser = array_keys($fieldsUser);

        $fields = array();
        $flattenFields = array();
        foreach ($f as $model => $modelFields) {
            foreach ($modelFields as $field) {
                $fields[$model][$model.'.'.$field] = $field;
                $flattenFields[$model.'.'.$field] = $model.'.'.$field;
            }
        }
        foreach ($fieldsUser as $field) {
            if ($field != 'role') {
                $fields['Driver']['Driver.'.$field] = $field;
                $fields['Patient']['Patient.'.$field] = $field;
                $fields['Companion']['Companion.'.$field] = $field;
            }
        }

        $conditionOperators = array(
            '=' => __('egual to'),
            '<>' => __('diferent than'),
            '<' => __('less than'),
            '<=' => __('less than or equal to'),
            '>' => __('greater than'),
            '>=' => __('greater than or equal to'),
            'LIKE_IN' => __('contains the expression (sensitive)'),
            'ILIKE IN' => __('contains the expression (insensitive)'),
            'NOT LIKE_IN' => __('does not contain (sensitive)'),
            'NOT ILIKE_IN' => __('does not contain (insensitive)'),
            'LIKE_INI' => __('begins with (sensitive)'),
            'ILIKE_INI' => __('begins with (insensitive)'),
            'NOT LIKE_INI' => __('does not start with (sensitive)'),
            'NOT ILIKE_INI' => __('does not start with (insensitive)'),
            'LIKE_END' => __('ends with (sensitive)'),
            'ILIKE_END' => __('ends with (insensitive)'),
            'NOT LIKE_END' => __('does not end with (sensitive)'),
            'NOT ILIKE_END' => __('does not end with (insensitive)'),
        );

        $this->set(compact('fields', 'flattenFields', 'conditionOperators'));
    }

    public function report() {
        if ($this->request->is(array('put', 'post'))) {
            $fields = $this->request->data[$this->Report->alias]['fields'];
            $options = array(
                'conditions' => implode(' ', $this->request->data[$this->Report->alias]['conditions']),
                'fields' => implode(', ', $fields),
                'order' => $this->request->data[$this->Report->alias]['order'],
                'joins' => array(
                    array(
                        'table' => $this->Diary->table,
                        'alias' => $this->Diary->alias,
                        'type' => 'INNER',
                        'conditions' => array(
                            $this->Car->alias.'.id = '.$this->Diary->alias.'.car_id',
                            $this->Destination->alias.'.id = '.$this->Diary->alias.'.destination_id',
                            'Driver.id = '.$this->Diary->alias.'.driver_id',
                            $this->Diary->alias.'.id = '.$this->Stop->alias.'.diary_id',
                        ),
                    ),
                    array(
                        'table' => $this->Car->table,
                        'alias' => $this->Car->alias,
                        'type' => 'INNER',
                        'conditions' => array(
                            $this->Car->alias.'.id = '.$this->Diary->alias.'.car_id',
                        ),
                    ),
                    array(
                        'table' => $this->City->table,
                        'alias' => $this->City->alias,
                        'type' => 'INNER',
                        'conditions' => array(
                            $this->City->alias.'.id = '.$this->Destination->alias.'.city_id',
                            $this->City->alias.'.id = '.$this->Establishment->alias.'.city_id',
                            $this->City->alias.'.id = '.$this->User->alias.'.city_id',
                            $this->City->alias.'.id = Driver.city_id',
                            $this->City->alias.'.id = Patient.city_id',
                        ),
                    ),
                    array(
                        'table' => $this->Destination->table,
                        'alias' => $this->Destination->alias,
                        'type' => 'INNER',
                        'conditions' => array(
                            $this->Destination->alias.'.id = '.$this->Diary->alias.'.city_id',
                        ),
                    ),
                    array(
                        'table' => $this->Establishment->table,
                        'alias' => $this->Establishment->alias,
                        'type' => 'INNER',
                        'conditions' => array(
                            $this->Establishment->alias.'.city_id = '.$this->City->alias.'.id',
                            $this->Establishment->alias.'.id = '.$this->Stop->alias.'.establishment_id',
                        ),
                    ),
                    array(
                        'table' => $this->Stop->table,
                        'alias' => $this->Stop->alias,
                        'type' => 'INNER',
                        'conditions' => array(
                            $this->Stop->alias.'.establishment_id = '.$this->Establishment->alias.'.id',
                            $this->Stop->alias.'.diary_id = '.$this->Diary->alias.'.id',
                            $this->Stop->alias.'.patient_id = Patient.id',
                            $this->Stop->alias.'.companion_id = Companion.id',
                        ),
                    ),
                    array(
                        'table' => $this->User->table,
                        'alias' => 'Driver',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Driver.city_id = '.$this->City->alias.'.id',
                            'Driver.id = '.$this->Diary->alias.'.driver_id',
                            'Driver.role = "driver"',
                        ),
                    ),
                    array(
                        'table' => $this->User->table,
                        'alias' => 'Companion',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Companion.city_id = '.$this->City->alias.'.id',
                            'Companion.id = '.$this->Stop->alias.'.companion_id',
                            'Companion.role = "patient"',
                        ),
                    ),
                    array(
                        'table' => $this->User->table,
                        'alias' => 'Patient',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Patient.city_id = '.$this->City->alias.'.id',
                            'Patient.id = '.$this->Stop->alias.'.patient_id',
                            'Patient.role = "patient"'
                        ),
                    ),
                ),
            );
            $this->User->recursive = -1;
            $result = $this->User->find('all', $options);

            $this->set(compact('result', 'fields'));
        } else {
            return $this->redirect(array('action' => 'index'));
        }
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
