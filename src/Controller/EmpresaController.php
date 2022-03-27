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
}