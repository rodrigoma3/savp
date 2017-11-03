<div class="form-box" id="login-box">
    <div class="header"><?php echo __('Sign In'); ?></div>
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
        <?php echo $this->Form->input('email', array('placeholder' => __('Email'), 'label' => false)); ?>
        <?php echo $this->Form->input('password', array('placeholder' => __('Password'), 'label' => false)); ?>
        <?php echo $this->Form->input('remember_me', array('type' => 'checkbox', 'class' => false)); ?>
    </div>
    <div class="footer">
        <?php echo $this->Form->end(array('class' => 'btn bg-olive btn-block', 'div' => false, 'type' => 'submit', 'label' => __('Sign me in'))); ?>

        <p><?php echo $this->Html->link(__('I forgot my password'), array('action' => 'forgotPassword')); ?></p>

        <?php echo __('Do not have an account? '); ?>
        <?php echo $this->Html->link(__('Sign up'), array('action' => 'register'), array('class' => 'text-center')) ?>
    </div>
</div>
