<?php

namespace Src\Controller;

use Src\Model\Funcoes\Visitantes;

class VisitanteController extends Controller
{
    public static function visitantes()
    {
        $visitantes = new Visitantes();
        $visitantes->listar();
        parent::view('visitante.lista', ['visitantes' => $visitantes->obter()]);
    }
}