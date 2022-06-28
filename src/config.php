<?php

define("DATA_LAYER_CONFIG", [
    "driver" => "mysql",
    "host" => "localhost",
    "port" => "3306",
    "dbname" => "portaria_db",
    "username" => "root",
    "passwd" => "",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);

define("INFORMACOES", array(
    'empresa' => 'Empresa Matriz - portaria'
));

require_once('configemail.php');

define("EMAIL_CONFIG", array(
    'remetente' => $email_remetente,
    'servidor' => $email_servidor,
    'usuario' => $email_usuario,
    'senha' => $email_senha,
    'porta' => 465
));