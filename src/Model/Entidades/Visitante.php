<?php

namespace Src\Model\Entidades;

use CoffeeCode\DataLayer\DataLayer;

class Visitante extends DataLayer
{
    public function __construct()
    {
        parent::__construct('visitantes', ['nome', 'documento'], 'id', false);
    }
}