<?php

namespace Src\Model\Funcoes;

use Src\Model\Entidades\Unidade;
use Src\Model\Funcoes\Parametros;
use Lib\Verificacoes;

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

    /**
     * Traz um registro de Unidade do banco e o carrega internamente
     */
    public function carregar(int $id)
    {
        $this->unidade = (new Unidade())->findById($id);
    }

    public function obter()
    {
        return $this->unidades ?? false;
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

        $this->unidade->nome = Verificacoes::verificarString($dados['nome']);
        $this->unidade->cnpj = Verificacoes::verificarString($dados['cnpj']);
        $this->unidade->endereco = Verificacoes::verificarString($dados['endereco']);
        $this->unidade->complemento = Verificacoes::verificarString($dados['complemento']);
        $this->unidade->municipio = Verificacoes::verificarString($dados['municipio']);
        $this->unidade->uf = Verificacoes::verificarString($dados['uf']);
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

    public function contar()
    {
        return (new Unidade())->find()->count();
    }

    public function criarParametros()
    {
        $parametros = new Parametros();
        $parametros->verificarParametrosUnidade($this->unidade->id);
    }
}