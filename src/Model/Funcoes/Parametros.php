<?php

namespace Src\Model\Funcoes;

use Src\Model\Entidades\Parametro;
use Lib\Verificacoes;

class Parametros
{
    public string $mensagem;
    private array $parametros;
    private Parametro $parametro;
    private bool $novo;

    public function __construct()
    {
        $this->mensagem = '';
        $this->novo = false;
    }

    public function verificarParametrosUnidade(int $unidade_id)
    {
        // Checar se a Unidade já tem parametrizações cadastradas
        $unidade_id = filter_var($unidade_id, FILTER_VALIDATE_INT);

        if (!$unidade_id){
            return false;
        }

        $params = http_build_query(['unidade_id' => $unidade_id]);
        $find = 'unidade_id = :unidade_id';

        $parametro = (new Parametro())->find($find, $params)->limit(1)->fetch(true);
        
        if (!$parametro){
            $this->criarParametros($unidade_id);
        } else {
            $this->carregar($parametro[0]->id);
        }

        return $this->parametro->id;
    }

    private function criarParametros(int $unidade_id)
    {
        $dados = array(
            'id' => 0,
            'unidade_id' => $unidade_id,
            'limite_acompanhantes' => 10,
            'limitar_hora_entrada' => 0,
            'limite_horario_entrada' => '00:00',
            'limitar_hora_saida' => 0,
            'limite_horario_saida' => '00:00',
            'motivo_obrigatorio' => 0
        );

        if (!$this->dados($dados)){
            return false;
        }

        return $this->gravar();
    }

    public function gravar()
    {
        if (!$this->parametro->save()){
            $this->mensagem = $this->parametro->fail()->getMessage();
            return false;
        }

        return true;
    }

    public function carregar(int $id)
    {
        $this->parametro = (new Parametro())->findById($id);
    }

    public function objeto()
    {
        return $this->parametro ?? false;
    }

    private function validarCampos()
    {
        $retorno = true;
        $this->mensagem = '';

        if (!Verificacoes::horaValida($this->parametro->limite_horario_entrada)){
            $this->mensagem .= 'Horário limite de entrada incorreto';
            $retorno = false;
        }

        if (!Verificacoes::horaValida($this->parametro->limite_horario_saida)){
            $this->mensagem .= 'Horário limite de saída incorreto';
            $retorno = false;
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
            $this->parametro = new Parametro();
            $this->novo = true;
        }

        $this->parametro->unidade_id = filter_var($dados['unidade_id'], FILTER_VALIDATE_INT);
        $this->parametro->limite_acompanhantes = filter_var($dados['limite_acompanhantes'], FILTER_VALIDATE_INT);
        $this->parametro->limite_horario_entrada = Verificacoes::verificarString($dados['limite_horario_entrada']);
        $this->parametro->limite_horario_saida = Verificacoes::verificarString($dados['limite_horario_saida']);

        if ($this->novo){
            $this->parametro->limitar_hora_entrada = 0;
            $this->parametro->limitar_hora_saida = 0;
            $this->parametro->motivo_obrigatorio = 0;
        } else {
            $this->parametro->limitar_hora_entrada = (isset($dados['limitar_hora_entrada'])) ? 1 : 0;
            $this->parametro->limitar_hora_saida = (isset($dados['limitar_hora_saida'])) ? 1 : 0;
            $this->parametro->motivo_obrigatorio = (isset($dados['motivo_obrigatorio'])) ? 1 : 0;
        }

        if (!$this->validarCampos()){
            return false;
        }

        return true;
    }


}