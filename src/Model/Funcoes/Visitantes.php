<?php

namespace Src\Model\Funcoes;

use Src\Model\Entidades\Visitante;
use Lib\Verificacoes;

class Visitantes
{
    public string $mensagem;
    private array $visitantes;
    private Visitante $visitante;
    private bool $novo;

    public function __construct()
    {
        $this->mensagem = '';
        $this->novo = false;
    }

    // Carregar todos os visitantes de uma empresa
    public function listar(int $empresa_id, bool $todos = true)
    {
        $params = '';
        $find = '';

        $array_params = array('empresa_id' => $empresa_id);
        $find = 'empresa_id = :empresa_id';

        if (!$todos){
            $array_params['status'] = '0';
            $find .= ' AND status = :status';
        }

        $params = http_build_query($array_params);

        $visitantes = (new Visitante())->find($find, $params)->fetch(true);

        if (!$visitantes){
            $this->mensagem = 'Nenhum visitante cadastrado para essa empresa';
            return false;
        }

        $this->visitantes = $visitantes;
        return true;
    }

    public function carregar(int $id)
    {
        $this->visitante = (new Visitante())->findById($id);
    }

    // Retorna a lista de visitantes encontrados
    public function obter()
    {
        return $this->visitantes ?? false;
    }

    // Retorna um objeto Visitante com o mesmo carregado
    public function objeto()
    {
        return $this->visitante ?? false;
    }

    private function validarCampos()
    {
        $retorno = true;
        $this->mensagem = '';

        if ($this->visitante->nome == ''){
            $this->mensagem .= 'Informe o Nome do Visitante <br>';
            $retorno = false;
        }

        if ($this->visitante->documento == ''){
            $this->mensagem .= 'Informe um documento do Visitante <br>';
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
            $this->visitante = new Visitante();
            $this->novo = true;
        }

        $this->visitante->nome = Verificacoes::verificarString($dados['nome']);
        $this->visitante->documento = Verificacoes::verificarString($dados['documento']);
        $this->visitante->empresa_id = filter_var($dados['empresa_id'], FILTER_VALIDATE_INT);
        $this->visitante->telefone = Verificacoes::verificarString($dados['telefone']);
        $this->visitante->status = filter_var($dados['status'], FILTER_VALIDATE_INT);
        $this->visitante->observacoes = Verificacoes::verificarString($dados['observacoes']);

        if ($this->novo){
            $this->visitante->data_cadastro = date('Y-m-d');
        }

        if (!$this->validarCampos()){
            return false;
        }

        return true;
    }

    public function gravar()
    {
        if (!$this->visitante->save()){
            $this->mensagem = $this->visitante->fail()->getMessage();
            return false;
        }

        return true;
    }

    public function alterarStatus(int $status)
    {
        $this->visitante->status = $status;
        $this->gravar();
    }

    public function montarOption()
    {
        $html = '';

        foreach ($this->visitantes as $visitante){
            $html .= '<option value="' . $visitante->id . '">';
            $html .= $visitante->nome . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $html .= '</option>';
        }

        return $html;
    }

}