<?php

namespace Src\Model\Funcoes;

use Src\Model\Entidades\Movimentacao;
use Src\Model\Entidades\Visitante;
use Src\Model\Entidades\Cracha;
use Src\Model\Entidades\Empresa;
use Src\Model\Entidades\Unidade;
use Src\Model\Entidades\Usuario;
use Src\Model\Entidades\Portaria;
use Src\Model\Funcoes\Acompanhantes;
use Src\Model\Funcoes\Emails;
use Lib\Verificacoes;
use Lib\Email;

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

        $movimentacoes = $this->buscarRegistros($movimentacoes);

        $this->movimentacoes = $movimentacoes;
        return true;
    }

    public function relatorio(string $filtros, string $campos)
    {
        $movimentacoes = (new Movimentacao())->find($filtros, $campos)->fetch(true);

        if (!$movimentacoes){
            return false;
        }
        
        $this->movimentacoes = $this->buscarRegistros($movimentacoes);
        return true;
    }

    private function buscarRegistros(array $movimentacoes)
    {
        foreach($movimentacoes as $movimentacao){
            $movimentacao = $this->carregarDados($movimentacao);
        }

        return $movimentacoes;
    }

    public function carregar(int $id)
    {
        $movimentacao = (new Movimentacao())->findById($id);
        $this->movimentacao = $this->carregarDados($movimentacao);
    }

    private function carregarDados(Movimentacao $movimentacao)
    {
        $movimentacao->visitante = (new Visitante())->findById($movimentacao->visitante_id);
        $movimentacao->visitante->empresa = (new Empresa())->findById($movimentacao->visitante->empresa_id);
        $movimentacao->cracha = (new Cracha())->findById($movimentacao->cracha_id);
        $movimentacao->unidade = (new Unidade())->findById($movimentacao->unidade_id);
        $movimentacao->usuario_entrada = (new Usuario())->findById($movimentacao->usuario_entrada_id);
        $movimentacao->portaria_entrada = (new Portaria())->findById($movimentacao->portaria_entrada_id);

        if (STATUS_MOVIMENTACAO[$movimentacao->status] == 'Finalizado'){
            $movimentacao->usuario_saida = (new Usuario())->findById($movimentacao->usuario_saida_id);
            $movimentacao->portaria_saida = (new Portaria())->findById($movimentacao->portaria_saida_id);
        }

        $acompanhantes = new Acompanhantes();
        $acompanhantes->listar($movimentacao->id);
        $movimentacao->acompanhantes = $acompanhantes->obter();
        unset($acompanhantes);

        return $movimentacao;
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

        if ($this->movimentacao->cracha_id == 0){
            $this->mensagem .= 'Necessário selecionar um crachá <br>';
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

        if (!Verificacoes::dataValida($this->movimentacao->data_entrada)){
            $this->mensagem .= 'Data incorreta <br>';
            $retorno = false;
        }

        if (!Verificacoes::horaValida($this->movimentacao->hora_entrada)){
            $this->mensagem .= 'Hora incorreta <br>';
            $retorno = false;
        }

        if (STATUS_MOVIMENTACAO[$this->movimentacao->status] == 'Finalizado'){
            if (!Verificacoes::dataValida($this->movimentacao->data_saida)){
                $this->mensagem .= 'Data incorreta <br>';
                $retorno = false;
            }
    
            if (!Verificacoes::horaValida($this->movimentacao->hora_saida)){
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
        $id = filter_var($dados['id'], FILTER_VALIDATE_INT);

        if ($dados['id'] > 0){
            $this->movimentacao = (new Movimentacao())->findById($id);
            $this->movimentacao->id = $id;
        } else {
            $this->movimentacao = new Movimentacao();
        }

        $this->movimentacao->status = filter_var($dados['status'], FILTER_VALIDATE_INT);

        if (STATUS_MOVIMENTACAO[$this->movimentacao->status] == 'Em aberto'){
            $this->movimentacao->placa = Verificacoes::verificarString($dados['placa']);
            $this->movimentacao->visitante_id = filter_var($dados['visitante_id'], FILTER_VALIDATE_INT);
            $this->movimentacao->cracha_id = filter_var($dados['cracha_id'], FILTER_VALIDATE_INT);
            $this->movimentacao->usuario_entrada_id = filter_var($_SESSION['usuID'], FILTER_VALIDATE_INT);
            $this->movimentacao->data_entrada = $dados['data_entrada'];
            $this->movimentacao->hora_entrada = $dados['hora_entrada'];
            $this->movimentacao->portaria_entrada_id = filter_var($_SESSION['porID'], FILTER_VALIDATE_INT);
            $this->movimentacao->contato = Verificacoes::verificarString($dados['contato']);
            $this->movimentacao->motivo = Verificacoes::verificarString($dados['motivo']);
            $this->movimentacao->unidade_id = $_SESSION['uniID'];
            $this->movimentacao->data_saida = '0000-00-00';
            $this->movimentacao->hora_saida = '00:00';
        }

        $this->movimentacao->observacoes = Verificacoes::verificarString($dados['observacoes']);

        if (STATUS_MOVIMENTACAO[$this->movimentacao->status] == 'Finalizado'){
            // Está finalizando a movimentação
            $this->movimentacao->usuario_saida_id = filter_var($_SESSION['usuID'], FILTER_VALIDATE_INT);
            $this->movimentacao->portaria_saida_id = filter_var($_SESSION['porID'], FILTER_VALIDATE_INT);
            $this->movimentacao->data_saida = $dados['data_saida'];
            $this->movimentacao->hora_saida = $dados['hora_saida'];
        }

        if (STATUS_MOVIMENTACAO[$this->movimentacao->status] == 'Cancelado'){
            // Está cancelando a movimentação
            $this->movimentacao->cancelamento = Verificacoes::verificarString($dados['cancelamento']);
            $this->movimentacao->data_saida = $dados['data_saida'];
            $this->movimentacao->hora_saida = $dados['hora_saida'];
        }

        //var_dump($this->movimentacao);

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

            $dados['nome'][$qtd] = Verificacoes::verificarString($dados['nome'][$qtd]);
            $dados['documento'][$qtd] = Verificacoes::verificarString($dados['documento'][$qtd]);
            $dados['obsacompanhante'][$qtd] = Verificacoes::verificarString($dados['obsacompanhante'][$qtd]);

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
            
            if (!$acompanhante->dados(array(
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

    public function visitanteEmAberto()
    {
        $filtros = array(
            'visitante_id' => $this->movimentacao->visitante_id,
            'status' => 0
        );

        return $this->listar($filtros);
    }

    public function veiculoEmAberto()
    {
        if (empty($this->movimentacao->placa)){
            return false;
        }

        $filtros = array(
            'placa' => $this->movimentacao->placa,
            'status' => 0
        );

        return $this->listar($filtros);
    }

    public function verificarDatas()
    {
        if ($this->movimentacao->data_entrada == $this->movimentacao->data_saida){
            if ($this->movimentacao->hora_entrada > $this->movimentacao->hora_saida){
                return false;
            }
        }

        if ($this->movimentacao->data_entrada > $this->movimentacao->data_saida){
            return false;
        }

        return true;
    }

    public function checarEnviarEmail(string $assunto = '')
    {
        if (empty($assunto)){
            $this->mensagem = 'Assunto do e-mail em branco.';
            return false;
        }

        $this->movimentacao = $this->carregarDados($this->movimentacao);

        if ($this->movimentacao->visitante->empresa->enviar_email == 1){
            if (empty($this->movimentacao->visitante->empresa->email)){
                $this->mensagem = 'E-mail da empresa em branco.';
                return false;
            }

            $email = new Emails();
            $email->adicionarRemetente();
            $email->adicionarDestinatario(Verificacoes::verificarString($this->movimentacao->visitante->empresa->email));
            $email->adicionarAssunto($assunto);
            $email->adicionarCorpo(
                Email::aberturaDeVisita(
                    $this->movimentacao->visitante->nome, 
                    $this->movimentacao->data_entrada, 
                    $this->movimentacao->hora_entrada)
            );

            if (!$email->checarCampos()){
                $this->mensagem = $email->obterMensagemErro();
                return false;
            }

            $email->enviar();

            if (!$email->okEnvio()){
                $this->mensagem = $email->obterMensagemErro();
                return false;
            }
        }

        return true;
    }
}