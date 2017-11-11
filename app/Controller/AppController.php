<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    public $components = array(
            'Session',
            'Flash',
            'Cookie',
    		'Auth' => array(
    			'loginRedirect' => array(
    				'controller' => 'diaries',
    				'action' => 'view',
    			),
                'loginAction' => array(
                    'controller' => 'users',
                    'action' => 'login',
                ),
    			'logoutRedirect' => array(
    				'controller' => 'users',
                    'action' => 'login',
    			),
                // 'authError' => 'Você não está autorizado a acessar esse local.',
                'flash' => array(
                    'params' => array(
                        'class' => 'alert alert-danger',
                    ),
                    'element' => 'error',
                    'key' => 'auth',
                ),
    			'authenticate' => array(
    				'Form' => array(
                        'fields' => array('username' => 'email'),
    					'passwordHasher' => 'Blowfish'
    				),
    			),
                'authorize' => array('Controller'),
    		),
    	);

    public $helpers = array('Html', 'Form', 'Session');

    public function beforeFilter() {
        parent::beforeFilter();
		// $this->Auth->allow();

	}

    public function isAuthorized($user = null) {
        if(isset($user['role']) && $user['role'] === 'admin'){
            return true;
        }
        return false;
    }

}
