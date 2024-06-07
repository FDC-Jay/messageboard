<h2>Sign up</h2>

<?php
    echo $this->Form->create('User', array(
        'url' => array('controller' => 'user', 'action' => 'signup'),
        'type' => 'post',
        'class' => 'mt-3'
    ));
?>
    <div class="form-group">
        <?php echo $this->Form->input('email'); ?>
    </div>
    <div class="form-group">
        <?php echo $this->Form->input('password'); ?>
    </div>
    <div class="form-group">
        <?php echo $this->Form->input('password_confirm', ['type' => 'password']); ?>
    </div>
    
    <div class="d-flex">
        <input class="btn btn-primary mr-1" type="submit" value="Sign up">
        <a href="<?php echo $this->webroot; ?>user/login" class="btn btn-primary">Login</a>
    </div>
<?php echo $this->Form->end(); ?>