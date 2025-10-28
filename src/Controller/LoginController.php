<?php

namespace Src\Controller;

use Src\Model\Funcoes\Logins;
use Lib\Verificacoes;

class LoginController extends Controller
{
    public static function entrar(array $post, array $get)
    {
        if (!Verificacoes::token($post)){
            parent::logout();
            exit;
        }

        $login = new Logins();
        if (!$login->atribuirPortaria($post['portaria_id'])){
            PortariaController::selecionar($login->mensagem);
            exit;
        }

        if (!$login->registrarEntrada()){
            PortariaController::selecionar($login->mensagem);
            exit;
        }

        MovimentacaoController::inicio([], []);
    }
}