<?php

namespace Src\Controller;

use Src\Model\Funcoes\Movimentacoes;
use Lib\Verificacoes;

class RelatorioController extends Controller
{
    public static function novo(array $post, array $get, string $mensagem = '')
    {
        Verificacoes::criarCsrf();
        parent::view('relatorio.novo', ['mensagem' => $mensagem]);
    }

    public static function filtrar(array $post, array $get)
    {
        if (!Verificacoes::token($post)){
            parent::logout();
            exit;
        }

        if (!Verificacoes::dataValida($post['data_inicial'])){
            $mensagem = 'Data inicial inválida: ' . $post['data_inicial'];
            self::novo($post, $get, $mensagem);
            exit;
        }

        if (!Verificacoes::dataValida($post['data_final'])){
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

        $filtros = self::montarFiltros($post);

        $campos = 'data_inicial=' . $post['data_inicial'] . '&data_final=' . $post['data_final'];
        $movimentacoes->relatorio($filtros, $campos);

        parent::view('relatorio.movimentacoes', ['movimentacoes' => $movimentacoes->obter()]);
    }

    private static function montarFiltros(array $array)
    {
        $filtros = '(data_entrada BETWEEN :data_inicial AND :data_final) AND (';

        $filtros .= (array_key_exists('emaberto', $array)) ? '(status = 0) OR ' : '';
        $filtros .= (array_key_exists('finalizado', $array)) ? '(status = 1) OR ' : '';
        $filtros .= (array_key_exists('cancelado', $array)) ? '(status = 2) OR ' : '';

        return substr($filtros, 0, -4) . ')';
    }
}