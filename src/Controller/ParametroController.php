<?php

namespace Src\Controller;

use Src\Model\Funcoes\Parametros;
use Lib\Verificacoes;

class ParametroController extends Controller
{
    /**
     * Na criação de uma Unidade, os parâmetros para ela serão criados automaticamente
     */
    public static function criarParametrosUnidade(int $unidade_id)
    {
        $id = filter_var($unidade_id, FILTER_VALIDATE_INT);

        if (!$id){
            return false;
        }

        $parametros = new Parametros();
        $parametros->criarParametrosUnidade($id);
        return true;
    }

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

        // Checar se existem parametrizações para a unidade passada



    }
}