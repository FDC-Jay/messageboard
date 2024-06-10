<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Board | <?php echo $this->name; ?></title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-v4-rtl/4.6.2-1/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(array(
            'style'
        ));

		echo $this->fetch('meta');
		echo $this->fetch('css');		
	?>

    <style>
        .media {
            height: 100vh;
        }
    </style>

</head>
<body>
    <div class="container">
        
        <?php echo $this->fetch('content'); ?>
    </div>

    <?php 
        echo $this->Html->script(array(
            'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js',
            'https://code.jquery.com/jquery-3.2.1.slim.min.js',
            'https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-v4-rtl/4.6.2-1/js/bootstrap.min.js'
        ));
        echo $this->fetch('script'); 
    ?>
</body>
</html>