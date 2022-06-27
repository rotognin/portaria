<?php

//declare(strict_types = 1);

use PHPUnit\Framework\TestCase;
use Src\Model\Funcoes\Movimentacoes;

final class MovimentacoesTest extends TestCase
{
    public function testValidarDados()
    {
        $movimentacoes = new Movimentacoes();
        $_SESSION['usuID'] = 1;
        $_SESSION['porID'] = 1;
        $_SESSION['uniID'] = 1;

        define ("STATUS_MOVIMENTACAO", array(
            0 => 'Em aberto',
            1 => 'Finalizado',
            2 => 'Cancelado'
        ));

        $dados = array(
            'id' => 0,
            'status' => 0,
            'placa' => 'ABC1234',
            'visitante_id' => 0,
            'cracha_id' => 0,
            'data_entrada' => '2022-06-27',
            'hora_entrada' => '07:11',
            'contato' => 'Setor financeiro',
            'motivo' => 'Visita técnica',
            'observacoes' => 'Observações diversas'
        );

        $this->expectOutputString('');

        $this->assertTrue(
            $movimentacoes->dados($dados)
        );
    }
}