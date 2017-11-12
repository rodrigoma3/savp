<?php
App::uses('AppController', 'Controller');
/**
 * AppSettings Controller
 *
 * @property AppSetting $AppSetting
 */
class AppSettingsController extends AppController{

    public function isAuthorized($user = null) {
        if (parent::isAuthorized($user)) {
			return true;
		}

		if (isset($this->AppSetting->perms[$this->request->params['controller']][$this->action]) && in_array($user['role'], $this->AppSetting->perms[$this->request->params['controller']][$this->action])) {
			return true;
		}

		return false;
	}

    public function index(){
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data[$this->AppSetting->alias]['to'])) {
                if (!empty($this->request->data[$this->AppSetting->alias]['to'])) {
                    $options = array();
                    $options['to'] = $this->request->data[$this->AppSetting->alias]['to'];
                    $options['template'] = 'emailTest';
                    $options['subject'] = __('Email test - %s', Configure::read('AppSetting.system_name'));
                    $res = $this->AppSetting->sendMail($options);
                    if (isset($res['error']) && $res['error'] == 0) {
                        $this->Flash->success(__('Test email successfully sent.'));
                    } else {
                        $this->Flash->error(__('Could not send test email.'));
                    }
                } else {
                    $this->Flash->warning(__('Informed email is invalid or absent.'));
                }
                return $this->redirect(array('action' => 'index'));
            } elseif ($this->AppSetting->save($this->request->data)) {
                $this->Flash->success(__('The app settings has been saved.'));
            } else {
                $this->Flash->error(__('The app settings could not be saved. Please try again.'));
            }
        } else {
            $this->request->data[$this->AppSetting->alias] = Configure::read('AppSetting');
            if (isset($this->request->data[$this->AppSetting->alias]['email_ssl']) && $this->request->data[$this->AppSetting->alias]['email_ssl'] != '') {
                $this->request->data[$this->AppSetting->alias]['email_ssl'] = true;
            }
        }
        if (isset($this->request->data[$this->AppSetting->alias]['email_password'])) {
            unset($this->request->data[$this->AppSetting->alias]['email_password']);
        }
    }

/**
 * set_language method
 *
 * @param string $option
 * @return void
 */
	public function setLanguage($option = null){
		$this->Session->write('Config.language', $option);
		return $this->redirect($this->referer());
	}

}
