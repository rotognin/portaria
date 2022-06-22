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

        if (!dataValida($post['data_inicial'])){
            $mensagem = 'Data inicial inválida: ' . $post['data_inicial'];
            self::novo($post, $get, $mensagem);
            exit;
        }

        if (!dataValida($post['data_final'])){
            $mensagem = 'Data final inválida: ' . $post['data_final'];
            self::novo($post, $get, $mensagem);
            exit;
        }

        if ($post['data_inicial'] > $post['data_final']){
            $mensagem = 'Data inicial maior que a data final.';
            self::novo($post, $get, $mensagem);
            exit;
        }

        $movimentacoes = new Movimentacoes();

        // Filtrar as opções escolhidas...
        self::novo($post, $get, 'Teste... OK');
    }



}