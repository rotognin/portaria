<?php

namespace Src\Controller;

use Src\Model\Funcoes\Portarias;
use Src\Model\Funcoes\Unidades;

class PortariaController extends Controller
{
    /**
     * Selecionar a portaria que o usuário está logando
     */
    public static function selecionar()
    {
        // Carregar todas as portarias cadastradas, anexando os nomes das unidades
        $portarias = new Portarias();
        if (!$portarias->listar()){
            parent::view('index', ['mensagem' => $portarias->mensagem]);
            exit;
        }

        parent::view('portaria.selecionar', ['portarias' => $portarias->objeto()]);
    }

    public static function portarias(array $post, array $get, string $mensagem = '')
    {
        // Só poderá cadastrar novas portarias se pelo menos uma unidade
        // estiver cadastrada no sistema
        $unidades = new Unidades();
        if ($unidades->contar() > 0){
            $botaoNovo = true;

            $portarias = new Portarias();
            if ($portarias->listar()){
                if (!$portarias->carregarUnidades()){
                    $mensagem = 'Não há Unidades de Negócio cadastradas.';
                    $botaoNovo = false;
                }
            }
        }

        criarCsrf();

        parent::view('portaria.lista', 
            ['portarias' => $portarias->objeto() ?? false, 
             'mensagem'  => $mensagem,
             'botaoNovo' => $botaoNovo]);
    }
}