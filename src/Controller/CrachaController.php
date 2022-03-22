<?php

namespace Src\Controller;

use Src\Model\Funcoes\Crachas;
use Src\Model\Funcoes\Unidades;

class CrachaController extends Controller
{
    public static function crachas(array $post, array $get, string $mensagem = '')
    {
        // Só poderá cadastrar novos crachá se pelo menos uma unidade
        // estiver cadastrada no sistema
        $unidades = new Unidades();
        if ($unidades->contar() > 0){
            $botaoNovo = true;

            $crachas = new Crachas();
            $crachas->listar();
        }

        criarCsrf();

        parent::view('cracha.lista', 
            ['crachas' => $crachas->obter() ?? false, 
             'mensagem'  => $mensagem,
             'botaoNovo' => $botaoNovo]);
    }

     /**
     * Criação de um novo crachá
     */
    public static function novo(array $post, array $get, string $mensagem = '')
    {
        criarCsrf();

        $unidades = new Unidades();
        $unidades->listar();

        parent::view('cracha.novo', ['mensagem' => $mensagem, 'unidades' => $unidades->obter()]);
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
        if (!isset($post['_token']) || $post['_token'] != $_SESSION['csrf']){
            parent::logout();
            exit;
        }

        $view = ($novo) ? 'novo' : 'alterar';

        $cracha = new Crachas();
        if (!$cracha->dados($post)){
            criarCsrf();
            parent::view('cracha.' . $view, ['mensagem' => $cracha->mensagem, 'cracha' => $cracha->objeto()]);
            exit;
        }

        if ($cracha->gravar()){
            self::crachas([], [], 'Cracha gravada com sucesso.');
        } else {
            criarCsrf();
            parent::view('cracha.' . $view, ['mensagem' => $cracha->mensagem, 'cracha' => $cracha->objeto()]);
        }
    }

    public static function alterar(array $post, array $get, string $mensagem = '')
    {
        criarCsrf();
        $id = filter_var($post['cracha_id'], FILTER_VALIDATE_INT);
        $cracha = new Crachas();
        $cracha->carregar($id);

        $unidades = new Unidades();
        $unidades->listar();

        parent::view('cracha.alterar', ['cracha' => $cracha->objeto(), 'mensagem' => $mensagem, 'unidades' => $unidades->obter()]);
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
        if (!isset($post['_token']) || $post['_token'] != $_SESSION['csrf']){
            parent::logout();
            exit;
        }

        $id = filter_var($post['cracha_id'], FILTER_VALIDATE_INT);

        $cracha = new Crachas();
        $cracha->carregar($id);
        $cracha->alterarStatus($status);

        self::crachas([], []);
    }
}