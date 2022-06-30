<?php

namespace Src\Controller;

use Src\Model\Funcoes\Parametros;
use Src\Model\Funcoes\Unidades;
use Lib\Verificacoes;

class ParametroController extends Controller
{
    public static function parametros(array $post, array $get, string $mensagem = '')
    {
        if (!Verificacoes::token($post)){
            parent::logout();
            exit;
        }

        $unidade_id = filter_var($post['unidade_id'], FILTER_VALIDATE_INT);

        if (!$unidade_id){
            $mensagem = 'ID da Unidade não informado.';
            UnidadeController::unidades($post, $get, $mensagem);
            exit;
        }

        $parametros = new Parametros();
        $parametro_id = $parametros->verificarParametrosUnidade($unidade_id);
        $parametros->carregar($parametro_id);

        $unidade = new Unidades();
        $unidade->carregar($unidade_id);

        parent::view('parametro.cadastro', ['parametros' => $parametros->objeto(), 'unidade' => $unidade->objeto()]);
    }
}