<?php

declare(strict_types = 1);

use PHPUnit\Framework\TestCase;
use Src\Model\Funcoes\Acompanhantes;

final class AcompanhantesTest extends TestCase
{
    public function testValidarDados()
    {
        $acompanhantes = new Acompanhantes();

        $dados = array(
            'id' => 0,
            'nome' => '',
            'documento' => '123456789',
            'observacoes' => 'Testando a classe de Acompanhantes',
            'movimentacao_id' => 1
        );

        $this->assertFalse(
            $acompanhantes->dados($dados)
        );

    }
}