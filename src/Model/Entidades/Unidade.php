<?php

namespace Src\Model\Entidades;

use CoffeeCode\DataLayer\DataLayer;
use Lib\Verificacoes;

class Unidade extends DataLayer
{
    public function __construct()
    {
        parent::__construct('unidades', ['nome'], 'id', false);
    }

    public function ajustarCnpj()
    {
        return Verificacoes::montarCnpj($this->cnpj);
    }
}