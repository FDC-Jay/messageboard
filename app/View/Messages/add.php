<style>
    optgroup {
        display: none;
    }
</style>

<h2>New Message</h2>

<div class="row">
    <div class="col-md-5">
        <?php echo $this->Flash->render(); ?>
        <?php
            echo $this->Form->create('Messages', [
                'url' => array('controller' => 'messages', 'action' => 'add'),
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
                <?php echo $this->Form->input('user_to', array(
                    'class' => 'select2 form-control',
                    'options' => array('Search for recipient'),
                    'label' => false
                )); ?>
            </div>

            <div class="form-group">
                <?php echo $this->Form->textarea('content', array(
                    'placeholder' => 'Message',
                    'class' => 'form-control'
                )); ?>
            </div>

            <input class="btn btn-primary" type="submit" value="Send">

        <?php $this->Form->end(); ?>
    </div>
</div>

<script>
    $(function(){
        $('.select2').select2({
            ajax: {
                url: '<?php echo $this->webroot; ?>user/getUsers',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        term: params.term || '', // Search term
                        page: params.page || 1, // Page number
                        limit: 10 // Number of items per page
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                }
            },
            // minimumInputLength: 1
        });

        
    });
</script>