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



}