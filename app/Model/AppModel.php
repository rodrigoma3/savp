<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');
App::uses('CakeEmail', 'Network/Email');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

    public function sendMail($options = array()){
        $result = array(
            'error' => 1,
            'message' => '',
        );
        try {
            $parameter = Configure::read('AppSetting');
            $Email = new CakeEmail();
            $configEmail = array(
                    'host' => $parameter['email_ssl'].$parameter['email_host'],
                    'port' => $parameter['email_port'],
                    'timeout' => $parameter['email_timeout'],
                    'username' => $parameter['email_username'],
                    'password' => Security::decrypt($parameter['email_password'], Configure::read('Security.cipherSeed')),
                    'transport' => 'Smtp',
                    'charset' => 'utf-8',
                    'headerCharset' => 'utf-8',
                    'from' => array($parameter['email_from_email'] => $parameter['email_from_name']),
                    'tls' => $parameter['email_tls'],
                    'to' => $options['to'],
                    'emailFormat' => 'html',
                    'template' => $options['template'],
                    'viewVars' => $options,
                    'subject' => $options['subject'],
                );

            if (!isset($options['cc'])) {
                  $options['cc'] = array();
            }
            if (!isset($options['bcc'])) {
                  $options['bcc'] = array();
            }
            if (!isset($options['reply_to'])) {
                  $options['reply_to'] = array();
            }
            if (!is_array($options['cc'])) {
                  $options['cc'] = array($options['cc']);
            }
            if (!is_array($options['bcc'])) {
                  $options['bcc'] = array($options['bcc']);
            }
            if (!is_array($options['reply_to'])) {
                  $options['reply_to'] = array($options['reply_to']);
            }
            if (!empty($parameter['email_cc'])) {
                  $replyTo = explode(';',$parameter['email_cc']);
                  $options['cc'] = array_merge($options['cc'], $replyTo);
            }
            if (!empty($parameter['email_bcc'])) {
                  $replyTo = explode(';',$parameter['email_bcc']);
                  $options['bcc'] = array_merge($options['bcc'], $replyTo);
            }
            if (!empty($options['cc'])) {
                  $Email->cc($options['cc']);
            }
            if (!empty($options['bcc'])) {
                  $Email->bcc($options['bcc']);
            }
            if (isset($options['reply_to']) && !empty($options['reply_to'])) {
                  $Email->replyTo($options['reply_to']);
            } elseif (isset($parameter['email_reply_to']) && !empty($parameter['email_reply_to'])) {
                $Email->replyTo($parameter['email_reply_to']);
            }

            $Email->config($configEmail);
            $Email->send();

            $result['error'] = 0;
            $result['error'] = __('E-mail successfully sent.');
        } catch (Exception $e) {
            CakeLog::write('error', 'Email Exception Message: '.$e->getMessage());
            CakeLog::write('error', 'Email Exception Trace: '.$e->getTraceAsString());
            $result['message'] = $e->getMessage();
        } finally {
            return $result;
        }
    }
}
