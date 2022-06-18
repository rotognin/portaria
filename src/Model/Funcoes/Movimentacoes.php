<?php

namespace Src\Model\Funcoes;

use Src\Model\Entidades\Movimentacao;
use Src\Model\Entidades\Visitante;
use Src\Model\Entidades\Cracha;
use Src\Model\Entidades\Empresa;
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

    /**
     * Listar as movimentações.
     * Passar um array com filtros a serem considerados
     */
    public function listar(array $filtros)
    {
        $params = '';
        $find = '';
        $and = '';

        foreach ($filtros as $campo => $valor){
            $find .= $and . $campo . ' = :' . $campo;
            $and = ' AND ';
        }

        if (count($filtros) > 0){
            $params = http_build_query($filtros);
        }

        $movimentacoes = (new Movimentacao())->find($find, $params)->fetch(true);

        if (!$movimentacoes){
            return false;
        }

        // Trazer os registros do Visitante e do crachá da movimentação
        foreach($movimentacoes as $movimentacao){
            $movimentacao->visitante = (new Visitante())->findById($movimentacao->visitante_id);
            $movimentacao->visitante->empresa = (new Empresa())->findById($movimentacao->visitante->empresa_id);
            $movimentacao->cracha = (new Cracha())->findById($movimentacao->cracha_id);

            $acompanhantes = new Acompanhantes();
            $acompanhantes->listar($movimentacao->id);
            $movimentacao->acompanhantes = $acompanhantes->obter();
            unset($acompanhantes);
        }

        $this->movimentacoes = $movimentacoes;
        return true;
    }

    public function carregar(int $id)
    {
        $this->movimentacao = (new Movimentacao())->findById($id);
        $this->carregarDados();
    }

    private function carregarDados()
    {
        $this->movimentacao->visitante = (new Visitante())->findById($this->movimentacao->visitante_id);
        $this->movimentacao->visitante->empresa = (new Empresa())->findById($this->movimentacao->visitante->empresa_id);
        $this->movimentacao->cracha = (new Cracha())->findById($this->movimentacao->cracha_id);

        $acompanhantes = new Acompanhantes();
        $acompanhantes->listar($this->movimentacao->id);
        $this->movimentacao->acompanhantes = $acompanhantes->obter();
        unset($acompanhantes);
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

        if ($this->movimentacao->status == 1){
            if (!dataValida($this->movimentacao->data_saida)){
                $this->mensagem .= 'Data incorreta <br>';
                $retorno = false;
            }
    
            if (!horaValida($this->movimentacao->hora_saida)){
                $this->mensagem .= 'Hora incorreta <br>';
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
            $this->movimentacao = new Movimentacao();
            $this->novo = true;
        }

        $this->movimentacao->placa = verificarString($dados['placa']);
        $this->movimentacao->visitante_id = filter_var($dados['visitante_id'], FILTER_VALIDATE_INT);
        $this->movimentacao->cracha_id = filter_var($dados['cracha_id'], FILTER_VALIDATE_INT);
        $this->movimentacao->usuario_entrada_id = filter_var($_SESSION['usuID'], FILTER_VALIDATE_INT);
        $this->movimentacao->data_entrada = $dados['data_entrada'];
        $this->movimentacao->hora_entrada = $dados['hora_entrada'];
        $this->movimentacao->portaria_entrada_id = filter_var($_SESSION['porID'], FILTER_VALIDATE_INT);
        $this->movimentacao->contato = verificarString($dados['contato']);
        $this->movimentacao->motivo = verificarString($dados['motivo']);
        $this->movimentacao->observacoes = verificarString($dados['observacoes']);
        $this->movimentacao->status = filter_var($dados['status'], FILTER_VALIDATE_INT);
        $this->movimentacao->unidade_id = $_SESSION['uniID'];

        if ($this->movimentacao->status == 1){
            // Está finalizando a movimentação
            $this->movimentacao->usuario_saida_id = filter_var($_SESSION['usuID'], FILTER_VALIDATE_INT);
            $this->movimentacao->portaria_saida_id = filter_var($_SESSION['porID'], FILTER_VALIDATE_INT);
            $this->movimentacao->data_saida = $dados['data_saida'];
            $this->movimentacao->hora_saida = $dados['hora_saida'];
        }

        if ($this->movimentacao->status == 2){
            // Está cancelando a movimentação
            $this->movimentacao->cancelamento = verificarString($dados['cancelamento']);
        }

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
        return isset($dados['nome']);
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