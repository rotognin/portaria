<?php

namespace Src\Model\Funcoes;

use Src\Model\Entidades\Usuario;
use Src\Model\Entidades\Portaria;
use Src\Model\Entidades\Login;

class Login
{
    private string $login;
    private string $senha;
    public string $mensagem;
    public int $nivel;
    private int $portaria_id;

    public function __construct(string $login = '', string $senha = '')
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

    public function atribuirPortaria(int $portaria_id)
    {
        $id = filter_var($portaria_id, FILTER_VALIDATE_INT);

        if (!$id){
            $this->mensagem = 'Identificação da portaria incorreto.';
            return false;
        }

        $portaria = (new Portaria())->findById($id);
        if (!$portaria){
            $this->mensagem = 'Portaria não cadastrada no sistema.';
            return false;
        }

        if (STATUS[$portaria->status] == 'Inativo'){
            $this->mensagem = 'Portaria inativa no sistema.';
            return false;
        }

        $this->portaria = $portaria->id;
        return true;
    }

    public function registrarEntrada()
    {
        // Continuar...
        // Gravar o login do usuário na tabela

        
    }

}