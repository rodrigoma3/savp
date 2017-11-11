<fieldset>
    <legend><?php echo __('New User'); ?></legend>
    <h1><?php echo __('Hello %s!', $user['User']['name']); ?></h1>
    <br>
    <p><?php echo __('Your user has been registered'); ?></p>
    <br>
    <h3><?php echo __('Click the button below to create your password to access the %s.', Configure::read('AppSetting.system_name')); ?>
    <br>
    <p><a href="<?php echo $link; ?>" style="text-decoration: none;"><button type="button" name="button" style="background-color: #428BCA !important; border-color: #428BCA; color: #FFF!important; text-shadow: 0 -1px 0 rgba(0,0,0,.25); background-image: none!important; border: 5px solid #FFF; border-radius: 0; box-shadow: none!important; -webkit-transition: background-color .15s,border-color .15s,opacity .15s; -o-transition: background-color .15s,border-color .15s,opacity .15s; transition: background-color .15s,border-color .15s,opacity .15s; vertical-align: middle; margin: 0; position: relative; display: inline-block; cursor: pointer; white-space: nowrap; padding: 6px 12px; font-size: 14px; line-height: 1.42857143; touch-action: manipulation; font-weight: 400; text-align: center; user-select: none;"><?php echo __('Create Password'); ?></button></a></p>
    <br>
    <p><?php echo __('This link will expire on: %s', $user['User']['token_expiration_datetime']); ?></p>
    <br>
    <p><?php echo __('In case of doubts, please contact the system administrator at %s.', Configure::read('AppSetting.system_administrator_email')); ?></p>

</fieldset>
<p><?php echo __('This is an automated e-mail. Do not answer it.') ?></p>
