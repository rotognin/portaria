<?php

namespace Src\Model\Funcoes;

use Src\Model\Entidades\Movimentacao;
use Src\Model\Funcoes\Acompanhantes;

class Movimentacoes
{
    public string $mensagem;
    private array $movimentacoes;
    private Movimentacao $movimentacao;
    private bool $novo;

    public function __construct()
    {
        $this->mensagem = '';
        $this->novo = false;
    }

    public function carregar(int $id)
    {
        $this->movimentacao = (new Movimentacao())->findById($id);
    }

    /**
     * Retorna as movimentações carregadas em forma de array
     */
    public function obter()
    {
        return $this->movimentacoes ?? false;
    }

    /**
     * Retorna a movimentação carregada do banco
     */
    public function objeto()
    {
        return $this->movimentacao ?? false;
    }

    public function obterId()
    {
        return $this->movimentacao->id ?? 0;
    }

    private function validarCampos()
    {
        $retorno = true;
        $this->mensagem = '';

        if ($this->movimentacao->visitante_id == 0){
            $this->mensagem .= 'Necessário selecionar o visitante <br>';
            $retorno = false;
        }

        if ($this->movimentacao->usuario_entrada_id == 0){
            $this->mensagem .= 'Usuário não informado. Favor sair do sistema e entrar novamente <br>';
            $retorno = false;
        }

        if ($this->movimentacao->portaria_entrada_id == 0){
            $this->mensagem .= 'Portaria não informada. Favor sair do sistema e entrar novamente <br>';
            $retorno = false;
        }

        if (!dataValida($this->movimentacao->data_entrada)){
            $this->mensagem .= 'Data incorreta <br>';
            $retorno = false;
        }

        if (!horaValida($this->movimentacao->hora_entrada)){
            $this->mensagem .= 'Hora incorreta <br>';
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
            $this->movimentacao = new Movimentacao();
            $this->novo = true;
        }

        $this->movimentacao->placa = verificarString($dados['placa']);
        $this->movimentacao->visitante_id = filter_var($dados['visitante_id'], FILTER_VALIDATE_INT);
        $this->movimentacao->cracha_id = filter_var($dados['cracha_id'], FILTER_VALIDATE_INT);
        $this->movimentacao->usuario_entrada_id = $_SESSION['usuID'];
        $this->movimentacao->data_entrada = $dados['data_entrada']; // Validar Data
        $this->movimentacao->hora_entrada = $dados['hora_entrada']; // Validar Hora
        $this->movimentacao->portaria_entrada_id = $_SESSION['porID'];
        $this->movimentacao->contato = verificarString($dados['contato']);
        $this->movimentacao->motivo = verificarString($dados['motivo']);
        $this->movimentacao->observacoes = verificarString($dados['observacoes']);

        if (!$this->validarCampos()){
            return false;
        }

        return true;
    }

    public function gravar()
    {
        if (!$this->movimentacao->save()){
            $this->mensagem = $this->movimentacao->fail()->getMessage();
            return false;
        }

        return true;
    }

    public function existemAcompanhantes(array $dados)
    {
        return is_array($dados['nome']);
    }

    public function ajustarAcompanhantes(array $dados)
    {
        $qtd = count($dados['nome']);

        while ($qtd > 0){
            $qtd--;

            $dados['nome'][$qtd] = verificarString($dados['nome'][$qtd]);
            $dados['documento'][$qtd] = verificarString($dados['documento'][$qtd]);
            $dados['obsacompanhante'][$qtd] = verificarString($dados['obsacompanhante'][$qtd]);

            if ($dados['nome'][$qtd] == ''){
                $this->mensagem = 'Verificar o nome do(s) acompanhante(s), pois não pode estar em branco.';
                return false;
            }
        }

        return true;
    }

    /**
     * Se vieram acompanhantes, gravá-los atrelando-os à movimentação
     */
    public function gravarAcompanhantes(array $dados)
    {
        foreach ($dados['nome'] as $codigo => $nome){
            $acompanhante = new Acompanhantes();
            if (!$acompanhante->dados(array (
                    'id' => 0,
                    'movimentacao_id' => $dados['movimentacao_id'],
                    'nome' => $dados['nome'][$codigo],
                    'documento' => $dados['documento'][$codigo], 
                    'observacoes' => $dados['obsacompanhante'][$codigo]))){
                $this->mensagem = $acompanhante->mensagem;
                return false;
            }

            if (!$acompanhante->gravar()){
                return false;
            }

            unset($acompanhante);
        }

        return true;
    }
}