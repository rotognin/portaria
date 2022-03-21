<?php

namespace Src\Model\Entidades;

use CoffeeCode\DataLayer\DataLayer;

class Movimentacao extends DataLayer
{
    public function __construct()
    {
        parent::__construct('movimentacoes', ['data_entrada', 'hora_entrada'], 'id', false);
    }
}