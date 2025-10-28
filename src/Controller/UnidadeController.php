<?php

namespace Src\Controller;

use Src\Model\Funcoes\Unidades;
use Lib\Verificacoes;

class UnidadeController extends Controller
{
    /**
     * Carregar a tela com os unidades cadastrados
     */
    public static function unidades(array $post, array $get, string $mensagem = '')
    {
        $unidades = new Unidades();
        if (!$unidades->listar()){
            $mensagem = $unidades->mensagem;
        }

        Verificacoes::criarCsrf();
        parent::view('unidade.lista', ['unidades' => $unidades->obter(), 'mensagem' => $mensagem]);
    }

    /**
     * Criação de um nova unidade
     */
    public static function novo(array $post, array $get, string $mensagem = '')
    {
        Verificacoes::criarCsrf();
        parent::view('unidade.novo', ['mensagem' => $mensagem]);
    }

    public static function gravar(array $post, array $get)
    {
        self::persistir($post, $get, true);
    }

    public static function atualizar(array $post, array $get)
    {
        self::persistir($post, $get, false);
    }

    private static function persistir(array $post, array $get, bool $novo)
    {
        if (!Verificacoes::token($post)){
            parent::logout();
            exit;
        }

        $view = ($novo) ? 'novo' : 'alterar';

        $unidade = new Unidades();
        if (!$unidade->dados($post)){
            Verificacoes::criarCsrf();
            parent::view('unidade.' . $view, ['mensagem' => $unidade->mensagem, 'unidade' => $unidade->objeto()]);
            exit;
        }

        if ($unidade->gravar()){
            if ($novo){
                $unidade->criarParametros();
            }

            self::unidades([], [], 'Unidade gravado com sucesso.');
        } else {
            Verificacoes::criarCsrf();
            parent::view('unidade.' . $view, ['mensagem' => $unidade->mensagem, 'unidade' => $unidade->objeto()]);
        }
    }

    public static function alterar(array $post, array $get, string $mensagem = '')
    {
        Verificacoes::criarCsrf();
        
        $id = filter_var($post['unidade_id'], FILTER_VALIDATE_INT);
        $unidade = new Unidades();
        $unidade->carregar($id);

        parent::view('unidade.alterar', ['unidade' => $unidade->objeto(), 'mensagem' => $mensagem]);
    }

    public static function ativar(array $post, array $get)
    {
        self::alterarStatus($post, $get, 0);
    }

    public static function inativar(array $post, array $get)
    {
        self::alterarStatus($post, $get, 1);
    }

    private static function alterarStatus(array $post, array $get, int $status)
    {
        if (!Verificacoes::token($post)){
            parent::logout();
            exit;
        }

        $id = filter_var($post['unidade_id'], FILTER_VALIDATE_INT);

        $unidade = new Unidades();
        $unidade->carregar($id);
        $unidade->alterarStatus($status);

        self::unidades([], []);
    }
}