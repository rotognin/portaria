<?php

session_start();

use Src\Controller;

require ('./lib/definicoes.php');

$action = (isset($_GET['action'])) ? $_GET['action'] : 'principal';
$control = (isset($_GET['control'])) ? ucfirst($_GET['control']) : '';
$funcao = 'Src\\Controller\\' . $control . 'Controller::' . $action;

$controlVerif = 'Src\\Controller\\' . $control . 'Controller';

if (!method_exists($controlVerif, $action)){
    echo '<h1>Página inexistente...</h1>';
    echo '<a href=index.php>Clique aqui</a> para retornar ao sistema.';
    exit;
}

call_user_func($funcao, $_POST, $_GET);