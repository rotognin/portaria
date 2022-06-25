<?php

/**
 * Suíte de testes das funções do sistema
 */

declare(strict_types = 1);

use PHPUnit\Framework\TestCase;
use Lib\Verificacoes;

final class VerificacoesTest extends TestCase
{

    public function testDataHora()
    {
        $this->assertEquals(
            Verificacoes::ajustarData('2022-06-23'), '23/06/2022'
        );

        $this->assertEquals(
            Verificacoes::ajustarHora('08:38'), '08:38'
        );
    }

    /**
     * @dataProvider verificarStringProvider
     */
    public function testVerificarString(string $dados)
    {
        $this->assertEquals(
            Verificacoes::verificarString($dados), ''
        );
    }

    public function verificarStringProvider(): array
    {
        $dados = array(array('SELECT * FROM', 'DELETE FROM', '<p>'));
        return $dados;
    }

    public function testCsrf()
    {
        $csrf = Verificacoes::criarCsrf();

        $this->assertEquals(
            $csrf, $_SESSION['csrf']
        );

        $this->assertTrue(Verificacoes::token(array('_token' => $csrf)));
    }

    public function testCnpj()
    {
        $cnpj = '08731682000114';

        $this->assertEquals(
            Verificacoes::montarCnpj($cnpj), '08.731.682/0001-14'
        );
    }

    /**
     * @dataProvider datasInvalidasProvider
     */
    public function testDataInvalida(array $datasInvalidas)
    {
        foreach($datasInvalidas as $dataInvalida)
        {
            $this->assertFalse(
                Verificacoes::dataValida($dataInvalida)
            );
        }
    }

    public function datasInvalidasProvider(): array
    {
        $datasInvalidas = array('2022-01-01', '2022-13-01', '123465789', 'abcdefg', '2022-01-01');

        return array(array($datasInvalidas));
    }
}