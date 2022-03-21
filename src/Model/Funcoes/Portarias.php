<?php

namespace Src\Model\Funcoes;

use Src\Model\Entidades\Portaria;
use Src\Model\Entidades\Unidade;

class Portarias
{
    public string $mensagem;
    private array $portarias;

    // Carregar todas as portarias cadastradas com os dados das unidades também
    public function carregar(bool $todas = true)
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

    public function obter()
    {
        return $this->portarias ?? false;
    }
}