<?php
include_once '../../classes/Banco.php';
$banco = new Banco();
$banco->localConfig = '../../config/database.php';
$dados = $banco->buscarDadosTabela($_GET['nome_tabela']);
echo json_encode($dados);