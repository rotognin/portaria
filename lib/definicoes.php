<?php

header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('America/Sao_Paulo');

require('./vendor/autoload.php');

define("DS", DIRECTORY_SEPARATOR);
define("APP_VERSION", '2024.06.26-001');

define("NIVEL", array(
    '1' => 'Administrador',
    '2' => 'Usuário Comum'
));

define("STATUS", array(
    '0' => 'Ativo',
    '1' => 'Inativo',
    '2' => 'Sob Consulta',
    '3' => 'Bloqueado'
));

define("STATUS_MOVIMENTACAO", array(
    '0' => 'Em aberto',
    '1' => 'Finalizado',
    '2' => 'Cancelado'
));

define("TIPO_PASSAGEM", array(
    '1' => 'Pessoas e Veículos',
    '2' => 'Pessoas apenas',
    '3' => 'Veículos apenas'
));

define("STATUS_ATIVO", 0);
define("STATUS_INATIVO", 1);
define("STATUS_CONSULTA", 2);
define("STATUS_BLOQUEADO", 3);

define("TIPO_UNIDADE", array(
    '1' => 'Matriz',
    '2' => 'Filial',
    '3' => 'Cooperado'
));
