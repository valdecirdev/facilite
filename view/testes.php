<?php
    session_start();
    require_once('config.php');

    $fexperiencia = new Experiencia();
    $experiencias = $fexperiencia->loadById($_GET['id']);
    if(isset($_POST['id_usuario'])){
        $fexperiencia->update($_POST);
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>
        INSERIR
        <form action="" method="POST">
            <br><br>
            <label for="id_experiencia">ID EXPERIENCIA</label>
            <input type="text" id="id_experiencia" name="id_experiencia" value="<?php echo $experiencias->getIdExperiencia(); ?>" style=""><!--display:none-->
            <br><br>
            <label for="id_usuario">ID USUARIO</label>
            <input type="text" id="id_usuario" name="id_usuario" value="<?php echo $experiencias->getIdUsuarioExperiencia(); ?>" style=""><!--display:none-->
            <br><br>
            <label for="des_descricao">DESCRICAO</label>
            <textarea name="des_descricao" id="des_descricao" cols="30" rows="10"><?php echo $experiencias->getDescricaoExperiencia(); ?></textarea>
            <br><br>
            <label for="des_titulo">TITULO</label>
            <input type="text" id="des_titulo" name="des_titulo" value="<?php echo $experiencias->getTituloExperiencia(); ?>">
            <br><br>
            <input type="submit">
        </form>
    </body>
    </html>
    