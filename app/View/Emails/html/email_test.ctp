<fieldset>
    <legend><?php echo __('Test email successfully sent!'); ?></legend>

    <p><?php echo h(Configure::read('AppSetting.system_name')); ?></p>
    <p><?php echo __('This is a test email. Do not answer it.') ?></p>
    <p><?php echo $this->Html->link(__('Click here'),array('controller' => 'users', 'action' => 'login', 'full_base' => true)).'&nbsp;'.__('to access the system.'); ?></p>
</fieldset>
