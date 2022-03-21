<?php

namespace Src\Model\Funcoes;

use Src\Model\Entidades\Unidade;

class Unidades
{
    public string $mensagem;
    private array $unidades;
    private Unidade $unidade;
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

        $unidades = (new Unidade())->find($find, $params)->fetch(true);

        if (!$unidades){
            $this->mensagem = 'Nenhuma unidade cadastrada.';
            return false;
        }

        $this->unidades = $unidades;
        return true;
    }

    public function obter()
    {
        return $this->unidades ?? false;
    }

    /**
     * Traz um registro de Unidade do banco e o carrega internamente
     */
    public function carregar(int $id)
    {
        $this->unidade = (new Unidade())->findById($id);
    }

    /**
     * Retorna a unidade carregada do banco
     */
    public function objeto()
    {
        return $this->unidade ?? false;
    }

    /**
     * Validação dos campos da Unidade
     */
    private function validarCampos()
    {
        $retorno = true;
        $this->mensagem = '';

        if ($this->unidade->nome == ''){
            $this->mensagem .= 'Informe o Nome da Unidade <br>';
            $retorno = false;
        }

        if ($this->unidade->cnpj == ''){
            $this->mensagem .= 'Informe o CNPJ da Unidade <br>';
            $retorno = false;
        }

        if ($this->unidade->municipio == ''){
            $this->mensagem .= 'Informe o Município da Unidade <br>';
            $retorno = false;
        }

        if ($this->unidade->uf == ''){
            $this->mensagem .= 'Informe a UF da Unidade <br>';
            $retorno = false;
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
            $this->unidade = new Unidade();
            $this->novo = true;
        }

        $this->unidade->nome = verificarString($dados['nome']);
        $this->unidade->cnpj = verificarString($dados['cnpj']);
        $this->unidade->endereco = verificarString($dados['endereco']);
        $this->unidade->complemento = verificarString($dados['complemento']);
        $this->unidade->municipio = verificarString($dados['municipio']);
        $this->unidade->uf = verificarString($dados['uf']);
        $this->unidade->tipo = filter_var($dados['tipo'], FILTER_VALIDATE_INT);

        if ($this->novo){
            $this->unidade->status = 0;
        }

        if (!$this->validarCampos()){
            return false;
        }

        return true;
    }

    public function gravar()
    {
        if (!$this->unidade->save()){
            $this->mensagem = $this->unidade->fail()->getMessage();
            return false;
        }

        return true;
    }

    public function alterarStatus(int $status)
    {
        $this->unidade->status = $status;
        $this->gravar();
    }
}