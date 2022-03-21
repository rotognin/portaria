<?php

namespace Src\Controller;

class PortariaController extends Controller
{
    /**
     * Selecionar a portaria que o usuário está logando
     */
    public static function selecionar()
    {
        // Carregar todas as portarias cadastradas, anexando os nomes das unidades
        $portarias = new Portarias();
        if (!$portarias->carregar()){
            parent::view('index', ['mensagem' => $portarias->mensagem]);
            exit;
        }

        parent::view('portaria.selecionar', ['portarias' => $portarias->obter()]);
    }
}