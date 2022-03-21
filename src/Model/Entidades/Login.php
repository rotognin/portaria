<?php

namespace Src\Model\Entidades;

use CoffeeCode\DataLayer\DataLayer;

class Login extends DataLayer
{
    public function __construct()
    {
        parent::__construct('logins', ['data', 'hora'], 'id', false);
    }
}