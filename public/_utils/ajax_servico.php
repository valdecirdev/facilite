<?php

    use controller\{AvaliacaoController};

    header('Access-Control-Allow-Origin: *');
    require_once('../../bootstrap/app.php');

    if (isset($_POST['acao'])) {
        switch ($_POST['acao']) {
            case 'avaliar':
                AvaliacaoController::avaliar($_POST);
                break;
            default:
                # code...
                break;
        }
    }