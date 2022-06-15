<?php

namespace Src\Model\Funcoes;

use Src\Model\Entidades\Cracha;
use Src\Model\Entidades\Unidade;

class Crachas
{
    public string $mensagem;
    private array $crachas;
    private Cracha $cracha;
    private bool $novo;

    public function __construct()
    {
        $this->mensagem = '';
        $this->novo = false;
    }

    // Carregar todos os crachas cadastrados com os dados das unidades também
    public function listar(bool $todas = true, int $unidade_id = 0, bool $livres = true)
    {
        $params = '';
        $find = '';

        $param_array = array();

        if ($livres){
            $param_array['movimentacao_id'] = 0;
            $find = 'movimentacao_id = :movimentacao_id';
        } else {
            $find = 'movimentacao_id > 0';
        }

        if (!$todas){
            $param_array['status'] = 0;
            $find .= ' AND status = :status';
        }

        if ($unidade_id > 0){
            $param_array['unidade_id'] = $unidade_id;
            $find .= ' AND unidade_id = :unidade_id';
        }

        if (count($param_array) > 0){
            $params = http_build_query($param_array);
        }
        
        $crachas = (new Cracha())->find($find, $params)->fetch(true);

        if (!$crachas){
            $this->mensagem = 'Não existem crachás disponíveis.';
            return false;
        }

        foreach ($crachas as $cracha){
            $cracha->unidade = (new Unidade())->findById($cracha->unidade_id);
        }

        $this->crachas = $crachas;
        return true;
    }

    /**
     * Traz um registro de Crachá do banco e o carrega internamente
     */
    public function carregar(int $id)
    {
        $this->cracha = (new Cracha())->findById($id);
    }

    public function obter()
    {
        return $this->crachas ?? false;
    }

    /**
     * Retorna a cracha carregada do banco
     */
    public function objeto()
    {
        return $this->cracha ?? false;
    }

    /**
     * Validação dos campos do Crachá
     */
    private function validarCampos()
    {
        $retorno = true;
        $this->mensagem = '';

        if ($this->cracha->identificacao == ''){
            $this->mensagem .= 'Informe a Identificação do crachá <br>';
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
            $this->cracha = new Cracha();
            $this->novo = true;
        }

        $this->cracha->identificacao = verificarString($dados['identificacao']);
        $this->cracha->unidade_id = filter_var($dados['unidade_id'], FILTER_VALIDATE_INT);

        if ($this->novo){
            $this->cracha->status = 0;
            $this->cracha->movimentacao_id = 0;
        }

        if (!$this->validarCampos()){
            return false;
        }

        return true;
    }

    public function gravar()
    {
        if (!$this->cracha->save()){
            $this->mensagem = $this->cracha->fail()->getMessage();
            return false;
        }

        return true;
    }

    public function alterarStatus(int $status)
    {
        $this->cracha->status = $status;
        $this->gravar();
    }

    public function carregarUnidades()
    {
        if (!$this->crachas){
            return false;
        }

        foreach ($this->crachas as $cracha){
            $cracha->unidade = (new Unidade())->findById($cracha->unidade_id);
        }
    }

    /**
     * Assim que gravada a movimentação, atribuir o crachá para ela
     */
    public function atribuir(int $cracha_id, int $movimentacao_id)
    {
        $this->cracha = (new Cracha())->findById($cracha_id);
        
        if ($this->cracha->status == 1){
            $this->mensagem = 'Crachá inativo. Não foi possível atribuir.';
            return false;
        }

        if ($this->cracha->movimentacao_id != 0){
            $this->mensagem = 'Crachá já atribuído a outra movimentação.';
            return false;
        }

        $this->cracha->movimentacao_id = filter_var($movimentacao_id, FILTER_VALIDATE_INT);
        if (!$this->gravar()){
            $this->mensagem = 'Não foi possível atribuir o crachá na movimentação.';
            return false;
        }

        return true;
    }
}