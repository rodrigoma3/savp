<?php
/**
 * Stop Fixture
 */
class StopFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'),
		'patient_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true),
		'companion_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'diary_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true),
		'establishment_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true),
		'start_time' => array('type' => 'time', 'null' => true, 'default' => null),
		'end_time' => array('type' => 'time', 'null' => true, 'default' => null),
		'absent' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'sequence' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'patient_id' => 1,
			'companion_id' => 1,
			'diary_id' => 1,
			'establishment_id' => 1,
			'start_time' => '02:21:53',
			'end_time' => '02:21:53',
			'absent' => 1,
			'sequence' => 1
		),
	);

}
