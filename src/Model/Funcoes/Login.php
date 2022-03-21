<?php

namespace Src\Model\Funcoes;

use Src\Model\Entidades\Usuario;

class Login
{
    private string $login;
    private string $senha;
    public string $mensagem;
    public int $nivel;

    public function __construct(string $login, string $senha)
    {
        $this->login = verificarString($login);
        $this->senha = sha1($senha);
    }

    public function realizar()
    {
        if ($this->login == ''){
            $this->mensagem = 'Usuário ou senha incorretos.';
            return false;
        }

        $params = http_build_query(['login' => $this->login, 'senha' => $this->senha]);
        $usuario = (new Usuario())->find('login = :login AND senha = :senha', $params)->fetch();

        if (!$usuario){
            $this->mensagem = 'Usuário ou senha incorretos.';
            return false;
        }

        if ($usuario->status == 1){
            $this->mensagem = 'Usuário bloqueado para acesso.';
            return false;
        }

        $_SESSION['usuID'] = $usuario->id;
        $_SESSION['usuNome'] = $usuario->nome;
        $_SESSION['usuNivel'] = $usuario->nivel;

        $this->nivel = $usuario->nivel;

        return true;

    }


}