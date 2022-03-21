<?php

namespace Src\Model\Entidades;

use CoffeeCode\DataLayer\DataLayer;

class Usuario extends DataLayer
{
    public function __construct()
    {
        parent::__construct('usuarios', ['nome', 'login', 'senha'], 'id', false);
    }
}