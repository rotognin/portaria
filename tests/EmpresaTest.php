<?php

declare(strict_types = 1);

use PHPUnit\Framework\TestCase;
use Src\Model\Funcoes\Empresas;
use Lib\Verificacoes;

final class EmpresaTest extends TestCase
{
    /**
     * @dataProvider informacoesProvider
     */
    public function testValidarDados(array $dados) : void
    {
        $empresa = new Empresas();

        /*
        $this->assertTrue(
            $empresa->dados($dados)
        );
        */

        $this->assertEquals(
            $empresa->dados($dados), false
        );
    }

    public function testFuncoes()
    {
        $this->assertEquals(
            Verificacoes::ajustarData('2022-06-23'), '23/06/2022'
        );

        $this->assertEquals(
            Verificacoes::ajustarHora('2022-06-23 08:38'), '08:38'
        );

        $this->assertEquals(
            Verificacoes::verificarString('SELECT * FROM tabela'), 'tabela'
        );
    }

    public function informacoesProvider(): array
    {
        return [[array(
            'id' => 0,
            'nome' => '',
            'documento' => '2091289012',
            'tipo' => '1',
            'endereco' => 'Rua das ruas',
            'complemento' => '',
            'cep' => '',
            'municipio' => 'Piracicaba',
            'uf' => 'SP'
        )]];
    }
}