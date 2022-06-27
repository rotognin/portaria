<?php

//declare(strict_types = 1);

use PHPUnit\Framework\TestCase;
use Src\Model\Funcoes\Movimentacoes;

final class MovimentacoesTest extends TestCase
{
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        
        $_SESSION['usuID'] = 1;
        $_SESSION['porID'] = 1;
        $_SESSION['uniID'] = 1;

        if (!defined("STATUS_MOVIMENTACAO")){
            define ("STATUS_MOVIMENTACAO", array(
                0 => 'Em aberto',
                1 => 'Finalizado',
                2 => 'Cancelado'
            ));
        }
    }

    /**
     * @dataProvider dadosMovimentacoesProvider
     * @testdox Verificando os dados de $dados
     */
    public function testValidarDados(array $dados)
    {
        $movimentacoes = new Movimentacoes();

        $this->assertFalse(
            $movimentacoes->dados($dados)
        );
    }

    public function dadosMovimentacoesProvider() : array
    {
        $dados = array(
            'Visitante zerado' => array(array(
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
            )),
            'Crachá zerado' => array(array(
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
            )),
            'Visitante com string' => array(array(
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
            )),
            'Finalizado' => array(array(
                'id' => 1,
                'status' => 1, // Finalizado
                'placa' => 'ABC1234',
                'visitante_id' => 1,
                'cracha_id' => 1,
                'data_entrada' => '2022-06-27',
                'hora_entrada' => '07:11',
                'contato' => 'Setor financeiro',
                'motivo' => 'Visita técnica',
                'observacoes' => 'Observações diversas',
                'data_saida' => 'abc', // falhar
                'hora_saida' => '09:13'
            )),
            'ID inexistente' => array(array(
                'id' => 2,
                'status' => 1,
                'placa' => 'ABC1234',
                'visitante_id' => 1,
                'cracha_id' => 1,
                'data_entrada' => '2022-06-27',
                'hora_entrada' => '07:11',
                'contato' => 'Setor financeiro',
                'motivo' => 'Visita técnica',
                'observacoes' => 'Observações diversas',
                'data_saida' => '2022-06-27',
                'hora_saida' => 'abc' // falhar
            ))
        );

        return $dados;
    }

    public function testExistemAcompanhantes()
    {
        $movimentacoes = new Movimentacoes();

        $dados = array();
        $this->assertFalse($movimentacoes->existemAcompanhantes($dados));
    }

    public function testAjustarAcompanhantes()
    {
        $movimentacoes = new Movimentacoes();

        $dados = array(
            'nome' => array('Rodrigo Tognin', ''),
            'documento' => array('123456789', '987987987'),
            'obsacompanhante' => array('Observações gerais', '')
        );

        $this->assertFalse($movimentacoes->ajustarAcompanhantes($dados));
    }
}