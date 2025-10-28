<?php

namespace Src\Model\Entidades;

use CoffeeCode\DataLayer\DataLayer;
use Lib\Verificacoes;

class Movimentacao extends DataLayer
{
    public function __construct()
    {
        parent::__construct('movimentacoes', ['data_entrada', 'hora_entrada'], 'id', false);
    }

    public function ajustarDataEntrada()
    {
        return Verificacoes::ajustarData($this->data_entrada);
    }

    public function  ajustarHoraEntrada()
    {
        return Verificacoes::ajustarHora($this->hora_entrada);
    }

    public function ajustarDataSaida()
    {
        return Verificacoes::ajustarData($this->data_saida);
    }

    public function  ajustarHoraSaida()
    {
        return Verificacoes::ajustarHora($this->hora_saida);
    }
}