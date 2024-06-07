<style>
    h2 {
        font-size: 4rem;
    }
</style>

<?php 
    $gender = array(
        'F' => 'Female',
        'M' => 'Male'
    );
?>

<h2 class="mb-3">User Profile</h2>
<a class="mb-3 btn btn-secondary" href="<?php echo $this->webroot;?>messages">Messages</a>
<div class="profile-container d-flex mt-4">
    <img class="profile" src="<?php echo $userdata['profile_pic'] ?>" alt="<?php echo $userdata['name']; ?>">
    <div class="info ml-3">
        <h3><?php echo !empty($userdata['name']) ? $userdata['name'] : ''; ?> <?php echo $age; ?></h3>
        <p><strong>Gender:</strong> <?php echo !empty($userdata['gender']) ? $gender[$userdata['gender']] : '-'; ?></p>
        <p><strong>Birthdate:</strong> <?php echo !empty($userdata['birthday']) ? $userdata['birthday'] : '-'; ?></p>
        <p><strong>Joined:</strong> <?php echo !empty($userdata['created']) ? date('F d, Y ga', strtotime($userdata['created'])) : '-'; ?></p>
        <p><strong>Last Login:</strong> <?php echo !empty($userdata['last_login']) ? date('F d, Y ga', strtotime($userdata['last_login'])) : '-'; ?></p>
    </div>
    <a href="<?php echo $this->webroot; ?>user/edit/<?php echo $this->params['id']; ?>" class="edit_icon ml-3"><i class="fa fa-pencil" aria-hidden="true"></i></a>
</div>
<p class="mt-3 mb-0"><strong>hobby</strong></p>
<?php echo !empty($userdata['hobby']) ? $userdata['hobby'] : '-'; ?>

<div class="message-btn mt-5">
    <a href="<?php echo $this->webroot; ?>messages/add" class="btn btn-info">New Message</a>
</div>