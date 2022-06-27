<?php

namespace Src\Model\Funcoes;

use Src\Model\Entidades\Empresa;
use Lib\Verificacoes;

class Empresas
{
    public string $mensagem;
    private array $empresas;
    private Empresa $empresa;
    private bool $novo;

    public function __construct()
    {
        $this->mensagem = '';
        $this->novo = false;
    }

    // Carregar todas as Empresas cadastrados com os dados das unidades também
    public function listar(bool $todas = true)
    {
        $params = '';
        $find = '';

        if (!$todas){
            $params = http_build_query(['status' => 0]);
            $find = 'status = :status';
        }

        $empresas = (new Empresa())->find($find, $params)->fetch(true);

        if (!$empresas){
            $this->mensagem = 'Nenhuma empresa cadastrada.';
            return false;
        }

        $this->empresas = $empresas;
        return true;
    }

    /**
     * Traz um registro de Empresa do banco e o carrega internamente
     */
    public function carregar(int $id)
    {
        $this->empresa = (new Empresa())->findById($id);
    }

    public function obter()
    {
        return $this->empresas ?? false;
    }

    /**
     * Retorna a empresa carregada do banco
     */
    public function objeto()
    {
        return $this->empresa ?? false;
    }

    /**
     * Validação dos campos da Empresa
     */
    private function validarCampos()
    {
        $retorno = true;
        $this->mensagem = '';

        if ($this->empresa->nome == ''){
            $this->mensagem .= 'Informe o Nome da Empresa <br>';
            $retorno = false;
        }

        if ($this->empresa->municipio == ''){
            $this->mensagem .= 'Informe o Município da Empresa <br>';
            $retorno = false;
        }

        if ($this->empresa->uf == ''){
            $this->mensagem .= 'Informe a UF da Empresa <br>';
            $retorno = false;
        }

        if (!Verificacoes::emailValido($this->empresa->email)){
            $this->mensagem .= 'E-mail inválido <br>';
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
            $this->empresa = new Empresa();
            $this->novo = true;
        }

        $this->empresa->nome = Verificacoes::verificarString($dados['nome']);
        $this->empresa->documento = $dados['documento'];
        $this->empresa->tipo = $dados['tipo'];
        $this->empresa->endereco = $dados['endereco'];
        $this->empresa->complemento = $dados['complemento'];
        $this->empresa->cep = $dados['cep'];
        $this->empresa->municipio = $dados['municipio'];
        $this->empresa->uf = strtoupper($dados['uf']);
        $this->empresa->responsavel = Verificacoes::verificarString($dados['responsavel']);
        $this->empresa->email = Verificacoes::verificarString($dados['email']);
        $this->empresa->enviar_email = (isset($dados['enviar_email'])) ? 1 : 0;

        if ($this->novo){
            $this->empresa->status = 0;
        }

        if (!$this->validarCampos()){
            return false;
        }

        return true;
    }

    public function gravar()
    {
        if (!$this->empresa->save()){
            $this->mensagem = $this->empresa->fail()->getMessage();
            return false;
        }

        return true;
    }

    public function alterarStatus(int $status)
    {
        $this->empresa->status = $status;
        $this->gravar();
    }
}