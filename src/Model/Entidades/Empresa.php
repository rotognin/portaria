<?php

namespace Src\Model\Entidades;

use CoffeeCode\DataLayer\DataLayer;

class Empresa extends DataLayer
{
    public function __construct()
    {
        parent::__construct('empresas', ['nome'], 'id', false);
    }
}