<?php

declare(strict_types = 1);

use PHPUnit\Framework\TestCase;
use Src\Model\Funcoes\Empresas;

final class EmpresaTest extends TestCase
{
    /**
     * @dataProvider informacoesProvider
     */
    public function testValidarDados(array $dados) : void
    {
        $empresa = new Empresas();

        $this->assertEquals(
            $empresa->dados($dados), false
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