<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Board</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(array(
            'style',
            'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-v4-rtl/4.6.2-1/css/bootstrap.min.css',
            'https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.0/css/font-awesome.min.css',
            'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
        ));

		echo $this->fetch('meta');
		echo $this->fetch('css');	
        
        echo $this->Html->script(array(
            'https://code.jquery.com/jquery-3.7.1.js',
            'https://code.jquery.com/ui/1.13.3/jquery-ui.js',
            'https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-v4-rtl/4.6.2-1/js/bootstrap.min.js',
            'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
        ));
        echo $this->fetch('script');
	?>

</head>
<body>
    <div class="container pt-5">
        <?php echo $this->element('header'); ?>
        <!-- < ?php echo $this->Flash->render(); ?> -->
        <?php echo $this->fetch('content'); ?>
    </div>
</body>
</html>