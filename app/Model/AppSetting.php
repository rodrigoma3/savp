<?php

App::uses('AppModel', 'Model');

class AppSetting extends AppModel {
    public $useTable = false;

    public $validate = array(
        'system_name' => array(
            'notBlank' => array(
                'rule'    => array('notBlank'),
                'message' => 'this field could not be empty',
            ),
        ),
        'starting_address' => array(
            'notBlank' => array(
                'rule'    => array('notBlank'),
                'message' => 'this field could not be empty',
            ),
        ),
        'token_expiration_time' => array(
            'numeric' => array(
                'rule'    => array('numeric'),
                'message' => 'only numbers',
            ),
        ),
        'email_host' => array(
            'notBlank' => array(
                'rule'    => array('notBlank'),
                'message' => 'this field could not be empty',
            ),
        ),
        'email_port' => array(
            'numeric' => array(
                'rule'    => array('numeric'),
                'message' => 'only numbers',
            ),
        ),
        'email_from_name' => array(
            'notBlank' => array(
                'rule'    => array('notBlank'),
                'message' => 'this field could not be empty',
            ),
        ),
        'email_from_email' => array(
            'notBlank' => array(
                'rule'    => array('notBlank'),
                'message' => 'this field could not be empty',
            ),
        ),
        'email_tls' => array(
            'boolean' => array(
                'rule'    => array('boolean'),
                'message' => 'invalid option',
            ),
        ),
        'email_ssl' => array(
            'boolean' => array(
                'rule'    => array('boolean'),
                'message' => 'invalid option',
            ),
        ),
        'email_timeout' => array(
            'numeric' => array(
                'rule'    => array('numeric'),
                'message' => 'only numbers',
            ),
        ),
    );

    public function save($data = null, $validate = true, $fieldList = array()){
        try {
            if ($data === null || empty($data) || !isset($data['AppSetting']) || empty($data['AppSetting'])) {
                return false;
            }
            $this->set($data);
            if (!$validate || $this->validates()) {
                foreach ($data['AppSetting'] as $parameter => $value) {
                    if (!empty($fieldList) && is_array($fieldList)) {
                        if (!in_array($parameter, $fieldList)) {
                            continue;
                        }
                    }
                    switch ($parameter) {
                        case 'email_ssl':
                            if ($value) {
                                $value = 'ssl://';
                            } else {
                                $value = '';
                            }
                            break;
                        case 'email_password':
                            if (empty($value)) {
                                $value = Configure::read('AppSetting.email_password');
                            } else {
                                $value = Security::encrypt($value, Configure::read('Security.cipherSeed'));
                            }
                            break;
                        default:
                            break;
                    }
                    if (!in_array($parameter, array('confirm_password'))) {
                        Configure::write('AppSetting.'.$parameter, $value);
                    }
                }
                Configure::dump('appsettings', 'default', array('AppSetting'));
            } else {
                // $this->invalidFields();
                return false;
            }

            return true;
        } catch (Exception $e) {
            CakeLog::write('error', $e->getMessage());
            CakeLog::write('error', $e->getTraceAsString());
            return false;
        }
    }

}
