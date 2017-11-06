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
			'isUniqueAdvanced' => array(
				'rule' => array('isUniqueAdvanced', 'diary_id'),
				'message' => 'This patient is already in use',
				//'allowEmpty' => false,
				//'required' => false,
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

	public function isUniqueAdvanced($check, $otherfield) {
		$fname = '';
		foreach ($check as $key => $value){
			$fname = $key;
			break;
		}
		$options = array(
			'conditions' => array(
				$otherfield => $this->data[$this->alias][$otherfield],
				$fname => $this->data[$this->alias][$fname],
			),
		);
		$count = $this->find('count', $options);
		if ($count == 0) {
			return true;
		} else {
			return false;
		}
	}
}
