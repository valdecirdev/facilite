<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="theme-color" content="#29344d">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?php echo $description ?? 'Encontre prestadores de serviços e conecte-se a novos clientes em poucos cliques.'; ?>">

        <title><?php echo $pg_title; ?> Facilite Serviços</title>
        <link rel="icon" href="view/_img/icon.png">

        <link rel="manifest" href="manifest.json">
        <!-- <link rel="stylesheet" href="view/_css/bootstrap.min.css"> -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="view/_css/fontawesome-all.min.css">
        <link rel="stylesheet" href="view/_css/style.css">
    </head>
    <body>
    <?php 
        session_start();
        include_once 'menu.php'; 
    ?>
