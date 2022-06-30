<?php

namespace Src\Model\Entidades;

use CoffeeCode\DataLayer\DataLayer;

class Parametro extends DataLayer
{
    public function __construct()
    {
        parent::__construct('parametros', ['unidade_id'], 'id', false);
    }
}