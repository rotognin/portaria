<?php

namespace Src\Controller;

use Src\Model\Funcoes\Parametros;
use Lib\Verificacoes;

class ParametroController extends Controller
{
    /**
     * Verifica se a unidade tem parametrização. Se não tiver, cria
     */
    public static function verificarParametrosUnidade(int $unidade_id)
    {
        $id = filter_var($unidade_id, FILTER_VALIDATE_INT);

        if (!$id){
            return false;
        }

        $parametros = new Parametros();
        $parametros->verificarParametrosUnidade($id);
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
        self::verificarParametrosUnidade($unidade_id);
        $parametros = new Parametros();
        $parametros->carregar($unidade_id);

        parent::view('parametro.cadastro', ['parametros' => $parametros->objeto()]);
    }
}