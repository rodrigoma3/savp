<?php
App::uses('Establishment', 'Model');

/**
 * Establishment Test Case
 */
class EstablishmentTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.establishment',
		'app.city',
		'app.destination',
		'app.diary',
		'app.car',
		'app.driver',
		'app.stop',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Establishment = ClassRegistry::init('Establishment');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Establishment);

		parent::tearDown();
	}

}
