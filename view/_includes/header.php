<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo $pg_title; ?> Facilite Serviços</title>
        <link rel="icon" href="view/_img/favicon.ico">
        
        <link rel="stylesheet" href="view/_css/bootstrap.min.css">
        <link rel="stylesheet" href="view/_css/font-awesome.min.css">
        <link rel="stylesheet" href="view/_css/style.css">
    </head>
    <body>
    <?php 
        require_once('config.php');
        session_start();
        include_once 'menu.php'; 
    ?>
