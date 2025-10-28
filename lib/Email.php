<?php

namespace Lib;

class Email
{
    public static function aberturaDeVisita(string $visitante, string $data_entrada, string $hora_entrada)
    {
        $mensagem = '';
        $mensagem = 'Foi realizada a abertura da visita pelo ' . $visitante .
                    ' na data ' . Verificacoes::ajustarData($data_entrada) . 
                    ' e hora ' . Verificacoes::ajustarHora($hora_entrada);

        return $mensagem;
    }
}