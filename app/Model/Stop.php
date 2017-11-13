<?php
App::uses('AppModel', 'Model');
/**
 * Stop Model
 *
 * @property Diary $Diary
 * @property Establishment $Establishment
 * @property User $Patient
 * @property User $Companion
 */
class Stop extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'patient_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'patientIsUnique' => array(
				'rule' => array('patientIsUnique'),
				'message' => 'This patient is already in use',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'companion_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'companionIsUnique' => array(
				'rule' => array('companionIsUnique'),
				'message' => 'This companion is already in use',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'diary_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'establishment_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'absent' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'bedridden' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isAmbulance' => array(
				'rule' => array('isAmbulance'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'sequence' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'start_time' => array(
			'time' => array(
				'rule' => array('time'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'end_time' => array(
			'time' => array(
				'rule' => array('time'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Diary' => array(
			'className' => 'Diary',
			'foreignKey' => 'diary_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Establishment' => array(
			'className' => 'Establishment',
			'foreignKey' => 'establishment_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Patient' => array(
			'className' => 'User',
			'foreignKey' => 'patient_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Companion' => array(
			'className' => 'User',
			'foreignKey' => 'companion_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function patientIsUnique($check) {
		$options = array(
			'conditions' => array(
				'OR' => array(
					'patient_id' => $this->data[$this->alias]['patient_id'],
					'companion_id' => $this->data[$this->alias]['patient_id'],
				),
				'diary_id' => $this->data[$this->alias]['diary_id'],
			),
			'recursive' => -1,
		);
		if (isset($this->data[$this->alias]['id'])) {
			$options['conditions']['id <>'] = $this->data[$this->alias]['id'];
		}
		$count = $this->find('count', $options);
		if ($count == 0) {
			return true;
		} else {
			return false;
		}
	}

	public function companionIsUnique($check) {
		$options = array(
			'conditions' => array(
				'OR' => array(
					'patient_id' => $this->data[$this->alias]['companion_id'],
					'AND' => array(
						'companion_id' => $this->data[$this->alias]['companion_id'],
						'patient_id <>' => $this->data[$this->alias]['patient_id'],
					),
				),
				'diary_id' => $this->data[$this->alias]['diary_id'],
			),
			'recursive' => -1,
		);
		$count = $this->find('count', $options);
		if ($count == 0) {
			return true;
		} else {
			return false;
		}
	}

	public function isAmbulance($check) {
		if (!$this->data[$this->alias]['bedridden']) {
			return true;
		}
		if (!isset($this->data[$this->alias]['diary_id']) || empty($this->data[$this->alias]['diary_id'])) {
			return false;
		}
		$options = array(
			'conditions' => array(
				$this->Diary->alias.'.id' => $this->data[$this->alias]['diary_id'],
			),
		);
		$diary = $this->Diary->find('first', $options);
		if (!isset($diary[$this->Diary->Car->alias]['ambulance'])) {
			return false;
		}
		return $diary[$this->Diary->Car->alias]['ambulance'];
	}
}
