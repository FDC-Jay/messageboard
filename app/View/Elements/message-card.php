<div class="card mb-2 <?php echo isset($is_current_user) && $is_current_user ? 'mr-auto' : 'ml-auto'; ?> page-<?php echo $page; ?>">
    <?php if ($page == 'index') : ?>
        <a href="<?php echo $this->webroot . 'messages/conversation/' . $message_id; ?>">
        <?php endif; ?>

        <div class="card-body d-flex <?php echo isset($is_current_user) && $is_current_user ? 'justify-content-start' : 'justify-content-end'; ?>">
            <img class="profile sm mr-3" src="<?php echo $profile_pic; ?>">
            <div class="card-body-container">
                <?php if (isset($name)) : ?>
                    <div class="card-title">
                        <h5><?php echo $name; ?></h5>
                    </div>
                <?php endif; ?>
                <div class="card-text"><?php echo isset($page) && $page == 'index' && $is_current_user == true ? 'You: ' : ''; ?><?php echo $content; ?></div>
            </div>
            <?php if ($page == 'conversation') : ?>
                <a href="javascript:;" class="deleteMsg" data-msgid="<?php echo isset($msg_id) ? $msg_id : ''; ?>">
                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                </a>
            <?php else : ?>
                <a href="javascript:;" class="deleteConvo" data-msgid="<?php echo isset($msg_id) ? $msg_id : ''; ?>">
                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                </a>
            <?php endif; ?>
            <small><?php echo !empty($datetime) ? $datetime : ''; ?></small>

        </div>
        <?php if ($page == 'index') : ?>
        </a>
    <?php endif; ?>

</div>