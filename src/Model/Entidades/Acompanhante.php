<?php

namespace Src\Model\Entidades;

use CoffeeCode\DataLayer\DataLayer;

class Acompanhante extends DataLayer
{
    public function __construct()
    {
        parent::__construct('acompanhantes', ['nome'], 'id', false);
    }
}