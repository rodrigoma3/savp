<div class="form-box" id="login-box">
    <div class="header"><?php echo __('Register New Patient'); ?></div>
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
        <?php echo $this->Form->input('email'); ?>
        <?php echo $this->Form->input('password'); ?>
        <?php echo $this->Form->input('name'); ?>
        <?php echo $this->Form->input('document'); ?>
        <?php echo $this->Form->input('phone'); ?>
        <?php echo $this->Form->input('address'); ?>
        <?php echo $this->Form->input('number'); ?>
        <?php echo $this->Form->input('complement'); ?>
        <?php echo $this->Form->input('neighborhood'); ?>
        <?php echo $this->Form->input('telephone_to_message'); ?>
        <?php echo $this->Form->input('name_for_message'); ?>
        <?php echo $this->Form->input('city_id'); ?>
    </div>
    <div class="footer">
        <?php echo $this->Form->end(array('class' => 'btn bg-olive btn-block', 'div' => false, 'type' => 'submit', 'label' => __('Sign me up'))); ?>

        <?php echo $this->Html->link(__('I already have a account'), array('action' => 'login'), array('class' => 'text-center')); ?>
    </div>
</div>
