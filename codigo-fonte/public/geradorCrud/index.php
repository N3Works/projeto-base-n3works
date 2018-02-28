<?php

if(session_id() == '') {
    session_start();
}

date_default_timezone_set("Brazil/East");

include 'config/dados.php';
include 'classes/Gerador.php';

$gerador = new Gerador();

if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
    $response = $gerador->gerarModelos($_POST);
}

$request = array_merge([
        'Gerador' => [
            'nomeDesenv' => '',
            'emailDesenv' => '',
            'nomeTabela' => '',
            'generoEntidade' => '',
            'entidadePlural' => '',
            'entidadeSingular' => ''
        ]
    ], 
    $_POST, 
    $_GET
);

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php include_once('view/head.php'); ?>
    </head>

    <body>
        <div class="container">
           <?php include_once('view/container.php'); ?>
        </div>
        <?php include_once('view/footer.php'); ?>
    </body>
</html>
