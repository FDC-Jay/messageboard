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
                'name' => $message['User']['name'],
                'content' => $message['Messages']['content'],
                'is_current_user' => $user_id == $message['Messages']['user_id'] ? true : false,
                'page' => 'index'
            ));
        endforeach;
    }  ?>

<a href="<?php echo $this->webroot; ?>messages/add" class="btn btn-info mt-4">New Message</a>