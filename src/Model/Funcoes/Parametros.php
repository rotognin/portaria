<?php

namespace Src\Model\Funcoes;

use Src\Model\Entidades\Parametro;

class Parametros
{
    public string $mensagem;
    private array $parametros;
    private Parametro $parametro;

    public function __construct()
    {
        $this->mensagem = '';
    }

    public function criarParametrosUnidade(int $unidade_id)
    {
        // Checar se a Unidade já tem parametrizações cadastradas

        // Se não tiver, criar com valores padrão

        
    }


}