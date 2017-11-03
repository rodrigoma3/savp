<?php
App::uses('Destination', 'Model');

/**
 * Destination Test Case
 */
class DestinationTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.destination',
		'app.city',
		'app.establishment',
		'app.user',
		'app.diary'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Destination = ClassRegistry::init('Destination');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Destination);

		parent::tearDown();
	}

}
