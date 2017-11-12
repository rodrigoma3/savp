<div class="form-box" id="login-box">
    <div class="header"><?php echo __('Update Password'); ?></div>
    <?php echo $this->Form->create(
        'User',
        array(
            'role' => 'form',
            'inputDefaults' => array(
                'div' => 'form-group',
                'class' => 'form-control',
            )
        )
    ); ?>
    <div class="body bg-gray">
        <?php echo $this->Form->input('id'); ?>
        <?php echo $this->Form->input('email', array('disabled' => true)); ?>
        <?php echo $this->Form->input('name', array('disabled' => true)); ?>
        <?php echo $this->Form->input('document', array('disabled' => true)); ?>
        <?php echo $this->Form->input('password'); ?>
        <?php echo $this->Form->input('confirm_password', array('type' => 'password', 'required' => true, 'div' => array('class' => ' form-group required'))); ?>
    </div>
    <div class="footer">
        <?php echo $this->Form->end(array('class' => 'btn bg-olive btn-block', 'div' => false, 'type' => 'submit', 'label' => __('Submit'))); ?>

        <?php echo $this->Html->link(__('Sign in'), array('action' => 'login'), array('class' => 'text-center')); ?>
    </div>
</div>
