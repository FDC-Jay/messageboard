<style>
    .card {
        width: 100%;
    }
</style>

<?php
    if($messages) {
        foreach ( $messages as $key => $message) :
            echo $this->element('message-card', array(
                'profile_pic' => $message['User']['profile_pic'],
                'message_id' => $message['Messages']['msg_connect_id'],
                'msg_id' => $message['Messages']['msg_connect_id'],
                'name' => $message['User']['name'],
                'content' => $message['Messages']['content'],
                'is_current_user' => $user_id == $message['Messages']['user_id'] ? true : false,
                'page' => 'index'
            ));
        endforeach;
    }  ?>

<a href="<?php echo $this->webroot; ?>messages/add" class="btn btn-info mt-4">New Message</a>

<script>
    $(function(){
        var isDeleting = false;
        $(document).on('click', '.deleteConvo', function(){
            var that = this;
            if(!isDeleting && confirm('Are you sure you want to delete?')) {
                $.ajax({
                    url: '<?php echo $this->webroot; ?>api/convoDelete',
                    type: 'post',
                    data: {
                        id: $(that).data('msgid'),                        
                    },
                    success: function(res){
                        if(res.status) {
                            alert('Deleted');
                        }
                    }
                })
            }
        });
    });
</script>