<?php

namespace Src\Controller;

use Src\Model\Funcoes\Login;

class LoginController extends Controller
{
    public static function entrar(array $post, array $get)
    {
        if (!isset($post['_token']) || $post['_token'] != $_SESSION['csrf']){
            parent::logout();
            exit;
        }

        $login = new Login();
        if (!$login->atribuirPortaria($post['portaria_id'])){
            PortariaController::selecionar($login->mensagem);
            exit;
        }

        if (!$login->registrarEntrada()){
            PortariaController::selecionar($login->mensagem);
            exit;
        }

        parent::view('movimentacao.index');
    }
}