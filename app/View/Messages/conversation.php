<div class="search-container text-right mb-3">
    <a href="javascript:;" class="searchIcon">Search <i class="fa fa-search" aria-hidden="true"></i></a>
    <input type="text" name="search" hidden>
</div>

<div class="card-container">
    <?php
    if($messages) {
        foreach ( $messages as $key => $message) :
            echo $this->element('message-card', array(
                'profile_pic' => $message['User']['profile_pic'],
                'message_id' => $message['Messages']['id'],
                'msg_id' => $message['Messages']['id'],
                'content' => $message['Messages']['content'],
                'is_current_user' => $user_id != $message['Messages']['user_id'] ? true : false,
                'page' => 'conversation'
            ));
        endforeach;
    }
    ?>
</div>
    <div class="pagination">
        <?php
        echo $this->Paginator->next('See more', null, null, ['class' => 'disabled']);
        ?>
    </div>

<?php
    echo $this->Form->create('Message', [
        'url' => null,
        'type' => 'post',
        'inputDefaults' => [
            'label' => [
                'class' => 'mr-4'
            ]
        ],
        'class' => 'mt-3'
    ]);

    echo $this->Form->textarea('content', array(
        'placeholder' => 'Message',
        'class' => 'form-control'
    ));
?>

<input type="submit" value="Send" class="btn btn-primary mt-2 ml-auto d-flex">

<?php $this->Form->end(); ?>

<script>
    var base_url = '<?php echo $this->webroot; ?>';
    $('#MessageConversationForm').on('submit', function(e){
        e.preventDefault();
        let message = $('#MessageContent').val();
        $(function(){
            $.ajax({
                url: '<?php echo $this->webroot . 'api/messageAdd' ?>',
                type: 'post',
                dataType: 'json',
                data: {
                    Messages: {
                        msg_connect_id: '<?php echo $this->request->params['id']; ?>',
                        user_id: <?php echo $user_id; ?>,
                        content: message
                    }
                },
                success(res){
                    if(res.status) {
                        $('.card-container').append(res.message);
                        $('#MessageContent').val('');
                    }
                }
            });
        });
    });

    $(document).on('click', '.deleteMsg', function(){
        let that = this;
        if(confirm('Are you sure you want to delete?')) {
            $.ajax({
                url: '<?php echo $this->webroot . 'api/messageDelete' ?>',
                type: 'post',
                dataType: 'json',
                data: {
                    Messages: {
                        id: $(that).data('msgid'),
                    }
                },
                success(res){
                    if(res.status) {
                        $(that).parents('.card').remove();
                        alert('Message successfully removed');
                    }
                }
            });

            console.log($(that).data('msgid'))
        }
    });

    $('.searchIcon').click(function(){
        let inputRes =  prompt('Search a message', '');
        if(inputRes != null) {
            $.ajax({
                url: '<?php echo $this->webroot . 'api/messageSearch' ?>',
                type: 'post',
                dataType: 'json',
                data: {
                    search: inputRes
                },
                success(res){
                    if(res.status) {
                        $('.card-container').html(res.messages);
                    } else {
                        alert('Message not found');
                    }
                }
            });
        }
    })

    $('.searchIcon').blur(function(){
        $('input[name=search]').attr('hidden', 'hidden');
    });

    $(document).on('click', '.readmore', function(){
        if(this.firstChild.className == 'readless') {
            $(this).prev().find('span.ellipsisBtn').hide();
            this.innerHTML = '... <a style="display: block;cursor: pointer; color: #7c7c7c">[Read More]</a>';
        } else {
            this.innerHTML = '<a class="readless" style="display: block;cursor: pointer; color: #7c7c7c">[Read Less]</a>';
            this.previousElementSibling.style.display = "inline";
            $(this).prev().find('span.ellipsisBtn').show();
        }

    });

    $('.pagination a').click(function(e){
        e.preventDefault();
        
        var url = $(this).attr('href');
        // url = url.replace('<?php echo $this->webroot; ?>messages/conversation/', '<?php echo $this->webroot; ?>messages/<?php echo $this->request->params['id']; ?>/')
        // console.log(url);
        // $.ajax({
        //     url: url,
        //     dataType: 'json',
        //     data: {
        //         'Messages': {
        //             'msg_connect_id' : '<?php echo $this->request->params['id']; ?>'
        //         }
        //     },
        //     type: 'post',
        //     success: function(res) {
        //         if(res != '') {
        //             $('.card-container').append(res.message);
        //         } else {
        //             alert('Something went wrong');
        //         }
        //         console.log(res);
        //     }
        // });

        var page = url.replace('<?php echo $this->webroot; ?>messages/conversation/page:', '')
    })

    function checkLongText(element){
        if(element) {

        } else {
            $('.card-body-container').each(function(){
                let max = 100;
                let len = $(this).find('.card-text').text().length;

                if(len > max) {
                    $(this).html($(this).html().substr(0,max)+ '<span class="ellipsisBtn" style="display: none">' + $(this).html().substr(max,$(this).html().length) + '</span>' + '<span class="readmore">... <a style="display: block; cursor: pointer; color: #7c7c7c">[Read More]</a></span>');
                }

            });
        }
        
    }

    checkLongText();
    
</script>