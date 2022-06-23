<?php

namespace Src\Model\Funcoes;

use Src\Model\Entidades\Usuario;
use Lib\Verificacoes;

class Usuarios
{
    public string $mensagem;
    private array $usuarios;
    private Usuario $usuario;
    private bool $novo;

    public function __construct()
    {
        $this->mensagem = '';
        $this->novo = false;
    }

    public function listar(bool $todos = true)
    {
        $params = '';
        $find = '';

        if (!$todos){
            $params = http_build_query(['status' => 0]);
            $find = 'status = :status';
        }

        $usuarios = (new Usuario())->find($find, $params)->fetch(true);

        if (!$usuarios){
            $this->mensagem = 'Nenhum usuário cadastrado.';
            return false;
        }

        $this->usuarios = $usuarios;
        return true;
    }

    /**
     * Traz um registro de Usuário do banco e o carrega internamente
     */
    public function carregar(int $id)
    {
        $this->usuario = (new Usuario())->findById($id);
    }

    /**
     * Retorna o array com os objetos
     */
    public function obter()
    {
        return $this->usuarios ?? false;
    }

    /**
     * Retorna o usuário carregado do banco
     */
    public function objeto()
    {
        return $this->usuario ?? false;
    }

    /**
     * Validação dos campos do usuário
     */
    private function validarCampos()
    {
        $retorno = true;
        $this->mensagem = '';

        if ($this->usuario->nome == ''){
            $this->mensagem .= 'Informe o Nome do usuário <br>';
            $retorno = false;
        }

        if ($this->usuario->login == ''){
            $this->mensagem .= 'Informe o Login do usuário <br>';
            $retorno = false;
        }

        if ($this->novo){
            if ($this->usuario->senha == ''){
                $this->mensagem .= 'Informe a senha do usuário <br>';
                $retorno = false;
            }
        }

        if (!$retorno){
            $this->mensagem = substr($this->mensagem, 0, -4);
        }

        return $retorno;
    }

    /**
     * Verificar os dados que vieram do formulário
     */
    public function dados(array $dados)
    {
        if ($dados['id'] > 0){
            $this->carregar($dados['id']);
        } else {
            $this->usuario = new Usuario();
            $this->novo = true;
        }

        $this->usuario->nome = Verificacoes::verificarString($dados['nome']);
        $this->usuario->login = Verificacoes::verificarString($dados['login']);

        if ($dados['senha'] != ''){
            $this->usuario->senha = sha1($dados['senha']);
        } else {
            if ($this->novo){
                $this->usuario->senha = '';
            }
        }

        $this->usuario->nivel = filter_var($dados['nivel'], FILTER_VALIDATE_INT);

        if ($this->novo){
            $this->usuario->status = 0;
        }

        if (!$this->validarCampos()){
            return false;
        }

        return true;
    }

    public function gravar()
    {
        if (!$this->usuario->save()){
            $this->mensagem = $this->usuario->fail()->getMessage();
            return false;
        }

        return true;
    }

    public function alterarStatus(int $status)
    {
        $this->usuario->status = $status;
        $this->gravar();
    }
}