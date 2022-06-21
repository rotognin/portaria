<?php

namespace Src\Controller;

use Src\Model\Funcoes\Movimentacoes;

class RelatorioController extends Controller
{
    public static function novo(array $post, array $get, string $mensagem = '')
    {
        criarCsrf();
        parent::view('relatorio.novo', ['mensagem' => $mensagem]);
    }

    public static function filtrar(array $post, array $get)
    {
        if (!isset($post['_token']) || $post['_token'] != $_SESSION['csrf']){
            parent::logout();
            exit;
        }

        $movimentacoes = new Movimentacoes();

        // Filtrar as opções escolhidas...


    }



}