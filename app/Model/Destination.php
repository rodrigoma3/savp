<?php
App::uses('AppModel', 'Model');
/**
 * Destination Model
 *
 * @property City $City
 * @property Diary $Diary
 */
class Destination extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'time';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'city_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'time' => array(
			'time' => array(
				'rule' => array('time'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'enabled' => array(
			'boolean' => array(
				'rule' => array('boolean'),
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
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'city_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Diary' => array(
			'className' => 'Diary',
			'foreignKey' => 'destination_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public function afterFind($results, $primary = false) {
		foreach ($results as $key => $val) {
			if (!is_null($val)) {
				if ($key === 'prev' || $key === 'next') {
					if (isset($val[$this->alias]['time'])) {
						$results[$key][$this->alias]['time'] = date('H:i', strtotime($results[$key][$this->alias]['time']));
					}
				} elseif ($key === $this->alias) {
					if (isset($results[$this->alias]['time'])) {
						$results[$this->alias]['time'] = date('H:i', strtotime($results[$this->alias]['time']));
					}
				} elseif (array_key_exists($this->alias, $val)) {
					if (isset($results[$key][$this->alias]['time'])) {
						$results[$key][$this->alias]['time'] = date('H:i', strtotime($results[$key][$this->alias]['time']));
					}
				}
				if (array_key_exists('children', $val)) {
					foreach ($val['children'] as $c => $child) {
						if (array_key_exists($this->alias, $child)) {
							if (isset($child[$this->alias]['time'])) {
								$results[$key]['children'][$c][$this->alias]['time'] = date('H:i', strtotime($results[$key]['children'][$c][$this->alias]['time']));
							}
						}
					}
				}
			}
	    }

	    return $results;
	}

}
