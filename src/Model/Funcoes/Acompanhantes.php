<?php

namespace Src\Model\Funcoes;

use Src\Model\Entidades\Acompanhante;
use Lib\Verificacoes;

class Acompanhantes
{
    public string $mensagem;
    private array $acompanhantes;
    private Acompanhante $acompanhante;
    private bool $novo;

    public function __construct()
    {
        $this->mensagem = '';
        $this->novo = false;
    }

    // Carregar todos os acompanhantes de uma visita (movimentação)
    public function listar(int $movimentacao_id)
    {
        $params = '';
        $find = '';

        $array_params = array('movimentacao_id' => $movimentacao_id);
        $find = 'movimentacao_id = :movimentacao_id';

        $params = http_build_query($array_params);

        $acompanhantes = (new Acompanhante())->find($find, $params)->fetch(true);

        if (!$acompanhantes){
            $this->mensagem = 'Nenhum acompanhante cadastrado para essa movimentação';
            return false;
        }

        $this->acompanhantes = $acompanhantes;
        return true;
    }

    public function carregar(int $id)
    {
        $this->acompanhante = (new Acompanhante())->findById($id);
    }

    // Retorna a lista de acompanhantes
    public function obter()
    {
        return $this->acompanhantes ?? false;
    }

    // Retorna um objeto Acompanhante com o mesmo carregado
    public function objeto()
    {
        return $this->acompanhante ?? false;
    }

    private function validarCampos()
    {
        $retorno = true;
        $this->mensagem = '';

        if ($this->acompanhante->nome == ''){
            $this->mensagem .= 'Informe o Nome do Acompanhante <br>';
            $retorno = false;
        }

        if (!$retorno){
            $this->mensagem = substr($this->mensagem, 0, -4);
        }

        return $retorno;
    }

    public function dados(array $dados)
    {
        if ($dados['id'] > 0){
            $this->carregar($dados['id']);
        } else {
            $this->acompanhante = new Acompanhante();
            $this->novo = true;
        }

        $this->acompanhante->nome = Verificacoes::verificarString($dados['nome']);
        $this->acompanhante->documento = Verificacoes::verificarString($dados['documento']);
        $this->acompanhante->observacoes = Verificacoes::verificarString($dados['observacoes']);
        $this->acompanhante->movimentacao_id = filter_var($dados['movimentacao_id'], FILTER_VALIDATE_INT);

        if (!$this->validarCampos()){
            return false;
        }

        return true;
    }

    public function gravar()
    {
        if (!$this->acompanhante->save()){
            $this->mensagem = $this->acompanhante->fail()->getMessage();
            return false;
        }

        return true;
    }
}