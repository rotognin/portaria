<?php

declare(strict_types = 1);

use PHPUnit\Framework\TestCase;
use Src\Model\Funcoes\Movimentacoes;

final class MovimentacoesTest extends TestCase
{
    /**
     * @dataProvider dadosMovimentacoesProvider
     */
    public function testValidarDados(array $dados)
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

        $this->assertFalse(
            $movimentacoes->dados($dados)
        );
    }

    public function dadosMovimentacoesProvider() : array
    {
        $dados = array(
            array(
                'id' => 0,
                'status' => 0,
                'placa' => 'ABC1234',
                'visitante_id' => 0, // falhar
                'cracha_id' => 1,
                'data_entrada' => '2022-06-27',
                'hora_entrada' => '07:11',
                'contato' => 'Setor financeiro',
                'motivo' => 'Visita técnica',
                'observacoes' => 'Observações diversas'
            ),
            array(
                'id' => 0,
                'status' => 0,
                'placa' => 'ABC1234',
                'visitante_id' => 1,
                'cracha_id' => 0, // falhar
                'data_entrada' => '2022-06-27',
                'hora_entrada' => '07:11',
                'contato' => 'Setor financeiro',
                'motivo' => 'Visita técnica',
                'observacoes' => 'Observações diversas'
            ),
            array(
                'id' => 0,
                'status' => 0,
                'placa' => 'ABC1234',
                'visitante_id' => 'abc', // falhar
                'cracha_id' => 1,
                'data_entrada' => '2022-06-27',
                'hora_entrada' => '07:11',
                'contato' => 'Setor financeiro',
                'motivo' => 'Visita técnica',
                'observacoes' => 'Observações diversas'
            ),
            array(
                'id' => 0,
                'status' => 1, // Finalizado
                'placa' => 'ABC1234',
                'visitante_id' => 1,
                'cracha_id' => 1,
                'data_entrada' => '2022-06-27',
                'hora_entrada' => '07:11',
                'contato' => 'Setor financeiro',
                'motivo' => 'Visita técnica',
                'observacoes' => 'Observações diversas',
                'data_saida' => '2022-06-27',
                'hora_saida' => '09:13'
            )
        );

        return array($dados);
    }
}