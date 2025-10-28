<?php

declare(strict_types = 1);

use PHPUnit\Framework\TestCase;
use Src\Model\Funcoes\Crachas;

final class CrachasTest extends TestCase
{
    public function testValidarDados()
    {
        $crachas = new Crachas();

        $dados = array(
            'id' => 0,
            'identificacao' => '',
            'unidade_id' => 1,
            'status' => 0,
            'movimentacao_id' => 0
        );

        $this->assertFalse(
            $crachas->dados($dados)
        );

    }
}