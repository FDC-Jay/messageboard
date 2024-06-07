<div class="text-center mt-5">
    <h2 class="mb-3">Login</h2>    
    <?php echo $this->Flash->render(); ?>

    <?php
        echo $this->Form->create('User', array(
            'url' => array('controller' => 'login', 'action' => 'index'),
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
        
        <?php echo $this->Flash->render(); ?>
        
        <input class="btn btn-primary" type="submit" value="Login">
    <?php $this->Form->end(); ?>

    <p class="mt-5">Don't have an account? <a href="<?php echo $this->webroot ?>signup">Sign Up</a></p>
</div>

<?php echo $this->Form->end(); ?>