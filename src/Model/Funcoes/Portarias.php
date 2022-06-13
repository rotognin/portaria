<?php

namespace Src\Model\Funcoes;

use Src\Model\Entidades\Portaria;
use Src\Model\Entidades\Unidade;

class Portarias
{
    public string $mensagem;
    private array $portarias;
    private Portaria $portaria;
    private bool $novo;

    public function __construct()
    {
        $this->mensagem = '';
        $this->novo = false;
    }

    // Carregar todas as portarias cadastradas com os dados das unidades também
    public function listar(bool $todas = true)
    {
        $params = '';
        $find = '';

        if (!$todas){
            $params = http_build_query(['status' => 0]);
            $find = 'status = :status';
        }
        
        $portarias = (new Portaria())->find($find, $params)->fetch(true);

        if (!$portarias){
            $this->mensagem = 'Nenhuma portaria cadastrada.';
            return false;
        }

        foreach ($portarias as $portaria){
            $portaria->unidade = (new Unidade())->findById($portaria->unidade_id);
        }

        $this->portarias = $portarias;
        return true;
    }

    /**
     * Traz um registro de Portaria do banco e o carrega internamente
     */
    public function carregar(int $id)
    {
        $this->portaria = (new Portaria())->findById($id);
    }

    public function obter()
    {
        return $this->portarias ?? false;
    }

    /**
     * Retorna a portaria carregada do banco
     */
    public function objeto()
    {
        return $this->portaria ?? false;
    }

    private function validarCampos()
    {
        $retorno = true;
        $this->mensagem = '';

        if ($this->portaria->descricao == ''){
            $this->mensagem .= 'Informe a Descrição da portaria <br>';
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
            $this->portaria = new Portaria();
            $this->novo = true;
        }

        $this->portaria->descricao = verificarString($dados['descricao']);
        $this->portaria->unidade_id = filter_var($dados['unidade_id'], FILTER_VALIDATE_INT);

        if ($this->novo){
            $this->portaria->status = 0;
        }

        if (!$this->validarCampos()){
            return false;
        }

        return true;
    }

    public function gravar()
    {
        if (!$this->portaria->save()){
            $this->mensagem = $this->portaria->fail()->getMessage();
            return false;
        }

        return true;
    }

    public function alterarStatus(int $status)
    {
        $this->portaria->status = $status;
        $this->gravar();
    }

    public function carregarUnidades()
    {
        if (!$this->portarias){
            return false;
        }

        foreach ($this->portarias as $portaria){
            $portaria->unidade = (new Unidade())->findById($portaria->unidade_id);
        }
    }
}