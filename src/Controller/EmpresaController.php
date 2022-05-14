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
}