<style>
    label {
        margin-right: 10px;
    }
    textarea {
        width: 500px;
        min-height: 200px;
    }
    .custom-file {
        width: 300px;
        display: block;
    }
    label[for="UserProfilePic"] {
        display: inline
    }
</style>
<?php
    echo $this->Form->create('User', [
        'url' => array('controller' => 'user', 'action' => 'edit/' . $this->request->params['id']),
        'type' => 'file',
        'inputDefaults' => [
            'label' => [
                'class' => 'mr-4'
            ]
        ],
        'class' => 'mt-3'
    ]);
?>
    <div class="form-group">
        <?php 
            $img_path = $this->webroot . '/img/profile.png';
            if(!empty($userdata['profile_pic'])) {
                $img_path = $userdata['profile_pic'];
                $file_name = str_replace($this->webroot . 'uploads/', '',  $img_path);
            }
        ?>
        <img class="mb-3 profile <?php echo empty($userdata['profile_pic']) ? 'dummy' : '' ?>" src="<?php echo $img_path; ?>">
        <?php if (!empty($userdata['profile_pic'])): ?>
            <p><?php echo $file_name; ?></p>
        <?php endif; ?>
        <div class="d-block">
            <?php echo $this->Form->input('profile_pic', ['type' => 'file', 'label' => 'Update picture']); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $this->Form->input('name', array(
            'value' => !empty($userdata['name']) ? $userdata['name'] : null
        )); ?>
    </div>

    <div class="form-group">
        <?php echo $this->Form->input('email', array(
            'value' => !empty($userdata['email']) ? $userdata['email'] : null
        )); ?>
    </div>

    <div class="form-group">
        <?php echo $this->Form->input('password', array(
            'label' => 'Change password',
            'required' => false
        )); ?>
    </div>
    <div class="form-group password_confirm" hidden>
        <?php echo $this->Form->input('password_confirm', array(
            'label' => 'Confirm password',
            'type' => 'password',
            'required' => false
        )); ?>
    </div>

    <div class="form-group">
        <?php echo $this->Form->input('birthday', array(
            'label' => 'Birthdate',
            'type' => 'text',
            'value' => !empty($userdata['birthday']) ? date('m-d-Y', strtotime($userdata['birthday'])) : null
        )); ?>
    </div>
    
    <div class="form-radio">
        <label for="">Gender</label>
        <?php echo $this->Form->radio('gender', ['M' => 'Male', 'F' => 'Female'], [
            'legend' => false,
            'default' => !empty($userdata['gender']) ? $userdata['gender'] : null
        ]); ?>
    </div>
        

    <div class="form-group mt-2">
        <label for="">hobby</label>
        <?php echo $this->Form->textarea('hobby', array(
            'value' => !empty($userdata['hobby']) ? $userdata['hobby'] : null
        )); ?>
    </div>

    <input class="btn btn-primary" type="submit" value="Update">

<?php $this->Form->end(); ?>

<script>
    $( function() {
        $( "#UserBirthday" ).datepicker({
            dateFormat: 'mm-dd-yy'
        });
        $( "#UserBirthday" ).datepicker('setDate', "<?php echo date('m-d-Y', strtotime($userdata['birthday'])); ?>");

        $('#UserPassword').on('input', function(){
            if($(this).val() != '') {
                $('div.password_confirm').removeAttr('hidden');
            } else {
                $('div.password_confirm').attr('hidden', '');
                $('.password_confirm input[type="password"]').val('');
            }
        });

        if(!$('#UserPassword').val('')) {
            $('#UserPasswordConfirm').attr('required', 'required');
        }

        if($('.password_confirm .input').hasClass('error')) {
            $('.password_confirm').removeAttr('hidden');
        }
        
        $('input[type="radio"]').each(function(){
            if($(this).hasClass('form-error')) {
                $(this).parent().addClass('form-error')
            }
        });
    } );
  </script>