<?php

namespace Src\Model\Entidades;

use CoffeeCode\DataLayer\DataLayer;

class Login extends DataLayer
{
    public function __construct()
    {
        parent::__construct('logins', ['data_entrada', 'hora_entrada'], 'id', false);
    }
}