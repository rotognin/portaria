<?php

namespace Src\Controller;

use Src\Model\Funcoes\Empresas;
use Src\Model\Funcoes\Crachas;

class MovimentacaoController extends Controller
{
    public static function inicio(array $post, array $get, string $mensagem = '')
    {
        parent::view('movimentacao.index', ['mensagem' => $mensagem]);
    }

    public static function novo(array $post, array $get, string $mensagem = '')
    {
        criarCsrf();

        $empresas = new Empresas();

        if (!$empresas->listar(false)){
            self::inicio($post, $get, $empresas->mensagem);
            exit;
        }

        $crachas = new Crachas();

        if (!$crachas->listar(false)){
            self::inicio($post, $get, $crachas->mensagem);
            exit;
        }

        parent::view('movimentacao.novo', [
            'mensagem' => $mensagem, 
            'empresas' => $empresas->obter(),
            'crachas' => $crachas->obter()
        ]);
    }
}