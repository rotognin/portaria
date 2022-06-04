<?php

namespace Src\Controller;

use Src\Model\Funcoes\Empresas;

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
        criarCsrf();

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
        if (!isset($post['_token']) || $post['_token'] != $_SESSION['csrf']){
            parent::logout();
            exit;
        }

        // Continuar...
    }

}