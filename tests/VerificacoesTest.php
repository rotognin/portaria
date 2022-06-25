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
            Verificacoes::ajustarData('123'), ''
        );

        $this->assertEquals(
            Verificacoes::ajustarData('123-321-000'), '000/321/123'
        );

        $this->assertEquals(
            Verificacoes::ajustarData('1-2-3-4-5'), ''
        );

        $this->assertEquals(
            Verificacoes::ajustarHora('08:38'), '08:38'
        );

        $this->assertEquals(
            Verificacoes::ajustarHora('123'), ''
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
     * @dataProvider datasValidasProvider
     */
    public function testDataValida(string $data)
    {
        $this->assertTrue(Verificacoes::dataValida($data));
    }

    public function datasValidasProvider() : array
    {
        $datasValidas = array('2022-01-01', '2022-12-31', '2022-02-28');
        return array($datasValidas);
    }

    /**
     * @dataProvider datasInvalidasProvider
     */
    public function testDataInvalida(string $data)
    {
        $this->assertFalse(Verificacoes::dataValida($data));
    }

    public function datasInvalidasProvider() : array
    {
        $datasValidas = array('2022-01-00', '2022-31-12', '2022-02-29');
        return array($datasValidas);
    }

    /**
     * @dataProvider horasValidasProvider
     */
    public function testHoraValida(string $hora)
    {
        $this->assertTrue(Verificacoes::horaValida($hora));
    }

    public function horasValidasProvider() : array
    {
        $horasValidas = array('00:00', '00:00:00', '23:59');
        return array($horasValidas);
    }

    /**
     * @dataProvider horasInvalidasProvider
     */
    public function testHoraInvalida(string $hora)
    {
        $this->assertFalse(Verificacoes::horaValida($hora));
    }

    public function horasInvalidasProvider() : array
    {
        $horasInvalidas = array('123', '12-12', '24:00', 'abcde');
        return array($horasInvalidas);
    }
}