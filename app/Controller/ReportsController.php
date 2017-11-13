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

    public function patients(){
        if ($this->request->is(array('put', 'post'))) {
            if (!isset($this->request->data[$this->Report->alias]['start_date']) || empty($this->request->data[$this->Report->alias]['start_date']) || !isset($this->request->data[$this->Report->alias]['end_date']) || empty($this->request->data[$this->Report->alias]['end_date'])) {
                $this->Flash->error(__('Invalid period'));
            } else {
                $options = array(
                    'conditions' => array(
                        $this->Diary->alias.'.date BETWEEN ? AND ?' => array(
                            $this->request->data[$this->Report->alias]['start_date'],
                            $this->request->data[$this->Report->alias]['end_date'],
                        ),
                    ),
                    'joins' => array(
                        array(
                            'table' => $this->Destination->table,
                            'alias' => $this->Destination->alias,
                            'type' => 'INNER',
                            'conditions' => array(
                                $this->Destination->alias.'.id = '.$this->Diary->alias.'.destination_id',
                            ),
                        ),
                    ),
                    'recursive' => 2,
                );
                if (isset($this->request->data[$this->Report->alias]['absent']) && !empty($this->request->data[$this->Report->alias]['absent'])) {
                    $options['conditions'][$this->Stop->alias.'.absent'] = $this->request->data[$this->Report->alias]['absent'];
                }
                if (isset($this->request->data[$this->Report->alias]['bedridden']) && !empty($this->request->data[$this->Report->alias]['bedridden'])) {
                    $options['conditions'][$this->Stop->alias.'.bedridden'] = $this->request->data[$this->Report->alias]['bedridden'];
                }
                if (isset($this->request->data[$this->Report->alias]['city_id']) && !empty($this->request->data[$this->Report->alias]['city_id'])) {
                    $options['conditions'][$this->Destination->alias.'.city_id'] = $this->request->data[$this->Report->alias]['city_id'];
                }
                if (isset($this->request->data[$this->Report->alias]['destination_id']) && !empty($this->request->data[$this->Report->alias]['destination_id'])) {
                    $options['conditions'][$this->Destination->alias.'.id'] = $this->request->data[$this->Report->alias]['destination_id'];
                }
                if (isset($this->request->data[$this->Report->alias]['establishment_id']) && !empty($this->request->data[$this->Report->alias]['establishment_id'])) {
                    $options['conditions'][$this->Establishment->alias.'.id'] = $this->request->data[$this->Report->alias]['establishment_id'];
                }
                if (isset($this->request->data[$this->Report->alias]['car_id']) && !empty($this->request->data[$this->Report->alias]['car_id'])) {
                    $options['conditions'][$this->Car->alias.'.id'] = $this->request->data[$this->Report->alias]['car_id'];
                }
                $stops = $this->Stop->find('all', $options);
                $total = count($stops);
                $totalAbsent = 0;
                $totalBedridden = 0;
                $countCity = array();
                $countDestination = array();
                $countEstablishment = array();
                $countCar = array();
                $countDay = array();
                $countMonth = array();
                $patients = array();
                foreach ($stops as $stop) {
                    if ($stop[$this->Stop->alias]['absent']) {
                        $totalAbsent++;
                    }
                    if ($stop[$this->Stop->alias]['bedridden']) {
                        $totalBedridden++;
                    }
                    $countCity[$stop[$this->Establishment->alias][$this->City->alias]['name']][] = 1;
                    $countDestination[$stop[$this->Establishment->alias][$this->City->alias]['name'].' - '.$stop[$this->Diary->alias][$this->Destination->alias]['time']][] = 1;
                    $countEstablishment[$stop[$this->Establishment->alias]['name']][] = 1;
                    $countCar[$stop[$this->Diary->alias][$this->Car->alias]['model'].' - '.$stop[$this->Diary->alias][$this->Car->alias]['car_plate']][] = 1;
                    $countDay[$stop[$this->Diary->alias]['date']][] = 1;
                    $countMonth[date('Y-m', strtotime($stop[$this->Diary->alias]['date']))][] = 1;
                    $patients[] = array(
                        'patient_name' => $stop[$this->Stop->Patient->alias]['name'],
                        'patient_document' => $stop[$this->Stop->Patient->alias]['document'],
                        'diary_date' => $stop[$this->Diary->alias]['date'],
                        'patient_absent' => $stop[$this->Stop->alias]['absent'],
                        'patient_bedridden' => $stop[$this->Stop->alias]['bedridden'],
                        'city_name' => $stop[$this->Establishment->alias][$this->City->alias]['name'],
                        'destination_name' => $stop[$this->Establishment->alias][$this->City->alias]['name'].' - '.$stop[$this->Diary->alias][$this->Destination->alias]['time'],
                        'establishment_name' => $stop[$this->Establishment->alias]['name'],
                        'car_name' => $stop[$this->Diary->alias][$this->Car->alias]['model'].' - '.$stop[$this->Diary->alias][$this->Car->alias]['car_plate'],
                    );
                }
                $byCities = array();
                foreach ($countCity as $name => $num) {
                    $byCities[] = array(
                        'name' => $name,
                        'quantity' => count($num),
                    );
                }
                $byCars = array();
                foreach ($countCar as $name => $num) {
                    $byCars[] = array(
                        'name' => $name,
                        'quantity' => count($num),
                    );
                }
                $byDestinations = array();
                foreach ($countDestination as $name => $num) {
                    $byDestinations[] = array(
                        'name' => $name,
                        'quantity' => count($num),
                    );
                }
                $byEstablishments = array();
                foreach ($countEstablishment as $name => $num) {
                    $byEstablishments[] = array(
                        'name' => $name,
                        'quantity' => count($num),
                    );
                }
                $byDay = array();
                foreach ($countDay as $name => $num) {
                    $byDay[] = array(
                        'name' => $name,
                        'quantity' => count($num),
                    );
                }
                $byMonth = array();
                foreach ($countMonth as $name => $num) {
                    $byMonth[] = array(
                        'name' => $name,
                        'quantity' => count($num),
                    );
                }
                $this->set(compact('patients', 'total', 'totalAbsent', 'totalBedridden', 'byCities', 'byDestinations', 'byEstablishments', 'byCars', 'byDay', 'byMonth'));
            }
        }
        if (!isset($this->request->data[$this->Report->alias]['start_date']) || empty($this->request->data[$this->Report->alias]['start_date'])) {
            $this->request->data[$this->Report->alias]['start_date'] = date('Y-m-d');
        }
        if (!isset($this->request->data[$this->Report->alias]['end_date']) || empty($this->request->data[$this->Report->alias]['end_date'])) {
            $this->request->data[$this->Report->alias]['end_date'] = date('Y-m-d');
        }
		$destinations = $this->Destination->find('all');
		$destinations = Hash::combine($destinations, '{n}.Destination.id', array('%s - %s', '{n}.City.name', '{n}.Destination.time'));
		asort($destinations);
        $this->Car->recursive = -1;
        $cars = $this->Car->find('all');
		$cars = Hash::combine($cars, '{n}.Car.id', array('%s - %s', '{n}.Car.model', '{n}.Car.car_plate'));
        asort($cars);
        $options = array(
            'order' => array('name'),
        );
        $cities = $this->City->find('list', $options);
        $establishments = $this->Establishment->find('all');
        $establishments = Hash::combine($establishments, '{n}.Establishment.id', array('%s - %s', '{n}.City.name', '{n}.Establishment.name'));
		asort($establishments);
        $bedriddens = array(
            '0' => __('No'),
            '1' => __('Yes'),
        );
        $absents = array(
            '0' => __('No'),
            '1' => __('Yes'),
        );
        $this->set(compact('cities', 'destinations', 'establishments', 'cars', 'bedriddens', 'absents'));
    }

    public function kms(){
        if ($this->request->is(array('put', 'post'))) {
            if (!isset($this->request->data[$this->Report->alias]['start_date']) || empty($this->request->data[$this->Report->alias]['start_date']) || !isset($this->request->data[$this->Report->alias]['end_date']) || empty($this->request->data[$this->Report->alias]['end_date'])) {
                $this->Flash->error(__('Invalid period'));
            } else {
                $options = array(
                    'conditions' => array(
                        $this->Diary->alias.'.date BETWEEN ? AND ?' => array(
                            $this->request->data[$this->Report->alias]['start_date'],
                            $this->request->data[$this->Report->alias]['end_date'],
                        ),
                        $this->Diary->alias.'.status' => 'closed',
                    ),
                    'recursive' => 2,
                );
                if (isset($this->request->data[$this->Report->alias]['city_id']) && !empty($this->request->data[$this->Report->alias]['city_id'])) {
                    $options['conditions'][$this->Destination->alias.'.city_id'] = $this->request->data[$this->Report->alias]['city_id'];
                }
                if (isset($this->request->data[$this->Report->alias]['destination_id']) && !empty($this->request->data[$this->Report->alias]['destination_id'])) {
                    $options['conditions'][$this->Destination->alias.'.id'] = $this->request->data[$this->Report->alias]['destination_id'];
                }
                if (isset($this->request->data[$this->Report->alias]['car_id']) && !empty($this->request->data[$this->Report->alias]['car_id'])) {
                    $options['conditions'][$this->Car->alias.'.id'] = $this->request->data[$this->Report->alias]['car_id'];
                }
                $diaries = $this->Diary->find('all', $options);
                $countCity = array();
                $countDestination = array();
                $countCar = array();
                $countDay = array();
                $countMonth = array();
                $kms = array();
                foreach ($diaries as $diary) {
                    $countCity[$diary[$this->Destination->alias][$this->City->alias]['name']][] = $diary[$this->Diary->alias]['final_km'] - $diary[$this->Diary->alias]['initial_km'];
                    $countDestination[$diary[$this->Destination->alias][$this->City->alias]['name'].' - '.$diary[$this->Destination->alias]['time']][] = $diary[$this->Diary->alias]['final_km'] - $diary[$this->Diary->alias]['initial_km'];
                    $countCar[$diary[$this->Car->alias]['model'].' - '.$diary[$this->Car->alias]['car_plate']][] = $diary[$this->Diary->alias]['final_km'] - $diary[$this->Diary->alias]['initial_km'];
                    $countDay[$diary[$this->Diary->alias]['date']][] = $diary[$this->Diary->alias]['final_km'] - $diary[$this->Diary->alias]['initial_km'];
                    $countMonth[date('Y-m', strtotime($diary[$this->Diary->alias]['date']))][] = $diary[$this->Diary->alias]['final_km'] - $diary[$this->Diary->alias]['initial_km'];
                    $kms[] = array(
                        'diary_date' => $diary[$this->Diary->alias]['date'],
                        'car_name' => $diary[$this->Car->alias]['model'].' - '.$diary[$this->Car->alias]['car_plate'],
                        'car_initial_km' => $diary[$this->Diary->alias]['initial_km'],
                        'car_final_km' => $diary[$this->Diary->alias]['final_km'],
                        'car_total_km' => $diary[$this->Diary->alias]['final_km'] - $diary[$this->Diary->alias]['initial_km'],
                        'city_name' => $diary[$this->Destination->alias][$this->City->alias]['name'],
                        'destination_name' => $diary[$this->Destination->alias][$this->City->alias]['name'].' - '.$diary[$this->Destination->alias]['time'],
                    );
                }
                $byCities = array();
                foreach ($countCity as $name => $num) {
                    $byCities[] = array(
                        'name' => $name,
                        'total_km' => round(array_sum($num), 2),
                    );
                }
                $byCars = array();
                foreach ($countCar as $name => $num) {
                    $byCars[] = array(
                        'name' => $name,
                        'total_km' => round(array_sum($num), 2),
                    );
                }
                $byDestinations = array();
                foreach ($countDestination as $name => $num) {
                    $byDestinations[] = array(
                        'name' => $name,
                        'total_km' => round(array_sum($num), 2),
                    );
                }
                $byDay = array();
                foreach ($countDay as $name => $num) {
                    $byDay[] = array(
                        'name' => $name,
                        'total_km' => round(array_sum($num), 2),
                    );
                }
                $byMonth = array();
                foreach ($countMonth as $name => $num) {
                    $byMonth[] = array(
                        'name' => $name,
                        'total_km' => round(array_sum($num), 2),
                    );
                }
                $this->set(compact('kms', 'byCities', 'byDestinations', 'byCars', 'byDay', 'byMonth'));
            }
        }
        if (!isset($this->request->data[$this->Report->alias]['start_date']) || empty($this->request->data[$this->Report->alias]['start_date'])) {
            $this->request->data[$this->Report->alias]['start_date'] = date('Y-m-d');
        }
        if (!isset($this->request->data[$this->Report->alias]['end_date']) || empty($this->request->data[$this->Report->alias]['end_date'])) {
            $this->request->data[$this->Report->alias]['end_date'] = date('Y-m-d');
        }
		$destinations = $this->Destination->find('all');
		$destinations = Hash::combine($destinations, '{n}.Destination.id', array('%s - %s', '{n}.City.name', '{n}.Destination.time'));
		asort($destinations);
        $this->Car->recursive = -1;
        $cars = $this->Car->find('all');
		$cars = Hash::combine($cars, '{n}.Car.id', array('%s - %s', '{n}.Car.model', '{n}.Car.car_plate'));
        asort($cars);
        $options = array(
            'order' => array('name'),
        );
        $cities = $this->City->find('list', $options);
        $this->set(compact('cities', 'destinations', 'cars'));
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
