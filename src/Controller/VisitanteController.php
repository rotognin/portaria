<?php

namespace Src\Controller;

use Src\Model\Funcoes\Visitantes;
use Src\Model\Entidades\Empresa;

class VisitanteController extends Controller
{
    public static function visitantes(array $post, array $get)
    {
        if (!isset($post['_token']) || $post['_token'] != $_SESSION['csrf']){
            parent::logout();
            exit;
        }

        criarCsrf();
        $empresa_id = filter_var($post['empresa_id'], FILTER_VALIDATE_INT);
        $empresa = (new Empresa())->findById($empresa_id);

        $visitantes = new Visitantes();
        $visitantes->listar($post['empresa_id']);
        parent::view('visitante.lista', ['visitantes' => $visitantes->obter(), 'empresa' => $empresa]);
    }
}