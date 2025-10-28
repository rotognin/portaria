<?php

namespace Src\Controller;

use Src\Model\Funcoes\Empresas;
use Lib\Verificacoes;

class EmpresaController extends Controller
{
    public static function empresas()
    {
        $empresas = new Empresas();
        $empresas->listar();
        parent::view('empresa.lista', ['empresas' => $empresas->obter()]);
    }

    // Criação de nova Empresa
    public static function novo(array $post, array $get, string $mensagem = '')
    {
        Verificacoes::criarCsrf();
        parent::view('empresa.novo', ['mensagem' => $mensagem]);
    }

    // Gravação da Empresa
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

        $empresa = new Empresas();
        if (!$empresa->dados($post)){
            Verificacoes::criarCsrf();
            parent::view('empresa.' . $view, ['mensagem' => $empresa->mensagem, 'empresa' => $empresa->objeto()]);
            exit;
        }

        if ($empresa->gravar()){
            self::empresas([], [], 'Empresa gravada com sucesso.');
        } else {
            Verificacoes::criarCsrf();
            parent::view('empresa.' . $view, ['mensagem' => $empresa->mensagem, 'empresa' => $empresa->objeto()]);
        }
    }

    public static function alterar(array $post, array $get, string $mensagem = '')
    {
        $id = filter_var($post['empresa_id'], FILTER_VALIDATE_INT);
        $empresa = new Empresas();
        $empresa->carregar($id);

        Verificacoes::criarCsrf();
        parent::view('empresa.alterar', ['empresa' => $empresa->objeto(), 'mensagem' => $mensagem]);
    }

    public static function ativar(array $post, array $get)
    {
        self::alterarStatus($post, $get, STATUS_ATIVO);
    }

    public static function inativar(array $post, array $get)
    {
        self::alterarStatus($post, $get, STATUS_INATIVO);
    }

    private static function alterarStatus(array $post, array $get, int $status)
    {
        if (!Verificacoes::token($post)){
            parent::logout();
            exit;
        }

        $id = filter_var($post['empresa_id'], FILTER_VALIDATE_INT);

        $empresa = new Empresas();
        $empresa->carregar($id);
        $empresa->alterarStatus($status);

        self::empresas([], []);
    }

}