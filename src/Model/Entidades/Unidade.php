<?php

namespace Src\Model\Entidades;

use CoffeeCode\DataLayer\DataLayer;

class Unidade extends DataLayer
{
    public function __construct()
    {
        parent::__construct('unidades', ['nome'], 'id', false);
    }
}