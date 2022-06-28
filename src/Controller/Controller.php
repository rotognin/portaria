<?php

namespace Src\Controller;

use Src\Model\Funcoes\Logins;

class Controller
{
    public static function login(array $post, array $get)
    {
        $login = new Logins($post['login'], $post['senha']);
        if (!$login->realizar()){
            self::view('index', ['mensagem' => $login->mensagem]);
            exit;
        }

        if (NIVEL[$login->nivel] == 'Administrador'){
            AdministracaoController::inicio($post, $get);
        } else {
            PortariaController::selecionar();
        }
    }

    public static function logout()
    {
        session_unset();
        self::view('index');
    }

    public static function principal()
    {
        self::logout();
    }

    public static function view(string $view, array $array = [])
    {
        $view = str_replace('.', DS, $view);
        $arquivo = '.' . DS . 'src' . DS . 'View' . DS . $view . '.php';

        if (!file_exists($arquivo)){
            echo '.... Arquivo não existe ... ' . $arquivo;
            die();
        }

        if (!empty($array)){
            foreach($array as $var => $valor){
                $$var = $var;
                $$var = $valor;
            }
        }

        ob_start();
        require_once $arquivo;
        $pagina = ob_get_contents();
        ob_end_clean();
        echo $pagina;
    }
}