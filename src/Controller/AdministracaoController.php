<?php

namespace Src\Controller;

use Src\Model\Funcoes\Movimentacoes;
use Lib\Verificacoes;

class AdministracaoController extends Controller
{
    public static function inicio(array $post, array $get)
    {
        if (isset($post['data_filtrar'])){
            if (!isset($post['_token']) || $post['_token'] != $_SESSION['csrf']){
                parent::logout();
                exit;
            }

            $data = $post['data_filtrar'];
        } else {
            $data = date('Y-m-d');
        }

        $movimentacoes = new Movimentacoes();

        $filtros = array(
            'data_entrada' => $data
        );

        $movimentacoes->listar($filtros);

        Verificacoes::criarCsrf();
        parent::view('admin.index', ['movimentacoes' => $movimentacoes->obter(), 'data_filtrar' => $data]);
    }
}