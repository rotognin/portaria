<?php

namespace Src\Model\Entidades;

use CoffeeCode\DataLayer\DataLayer;

class Portaria extends DataLayer
{
    public function __construct()
    {
        parent::__construct('portarias', ['descricao'], 'id', false);
    }
}