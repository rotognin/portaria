<?php

namespace Src\Model\Entidades;

use CoffeeCode\DataLayer\DataLayer;

class Cracha extends DataLayer
{
    public function __construct()
    {
        parent::__construct('crachas', ['identificacao'], 'id', false);
    }
}