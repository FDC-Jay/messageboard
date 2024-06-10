<style>
    .card {
        width: 100%;
    }
</style>

<section id="messages">
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
</section>

<div class="pagination mt-0">
    <?php
        echo $this->Paginator->next('See more', null, null, ['class' => 'disabled']);
    ?>
</div>

<a href="<?php echo $this->webroot; ?>messages/add" class="btn btn-info mt-4">New Message</a>

<script>
    $(function(){
        var isDeleting = false;
        var isLoadingMessages = false;
        var hasNextPage = '<?php echo $this->request->params['paging']['MessageConnects']['nextPage']; ?>';
        var pageNum = '<?php echo $this->request->params['paging']['MessageConnects']['page']; ?>';

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

        $(document).on('click', '.pagination .next a', function(e){
            e.preventDefault();
            var that = this;

            if(hasNextPage) pageNum++;

            var url = '<?php echo $this->webroot . 'messages/index/page:' ?>' + pageNum;
            $.ajax({
                url,
                type: 'post',
                success: function(res){
                    if(res.message != '') {
                        $('#messages').append(res.message);
                    }

                    if(res.paginator.nextPage === true) {
                        pageNum++;
                    } else {
                        $(that).addClass('disabled');
                    }
                }
            });
        });
    });
</script>