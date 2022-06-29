<?php

/**
 * Testes das funções relacionadas ao envio de e-mail
 */

declare(strict_types = 1);

use PHPUnit\Framework\TestCase;
use Src\Model\Funcoes\Emails;

final class EmailsTest extends TestCase
{
    public function montarObjetoEmail()
    {
        $email = new Emails();
        $email->adicionarRemetente();
        $email->adicionarDestinatario('teste@email.com');
        $email->adicionarAssunto('Testando o e-mail');
        $email->adicionarCorpo('Corpo do e-mail');

        return $email;
    }

    public function testInformacoesValidas()
    {
        $email = $this->montarObjetoEmail();

        $this->assertTrue($email->checarCampos());
    }

    /**
     * @dataProvider informacoesIncorretasProvider
     */
    public function testInformacoesInvalidas(array $dados)
    {
        $email = new Emails();
        $email->adicionarRemetente();
        $email->adicionarDestinatario($dados['destinatario']);
        $email->adicionarAssunto($dados['assunto']);
        $email->adicionarCorpo($dados['corpo']);

        $this->assertFalse($email->checarCampos());
    }

    public function informacoesIncorretasProvider() : array
    {
        $destinatario = 'destino@email.com';
        $assunto = 'Assunto do e-mail';
        $corpo = 'Esse é o corpo do e-mail.';

        $dados = array(
            'Destino Incorreto' => array(
                'destinatario' => '123456', 'assunto' => $assunto, 'corpo' => $corpo
            ),
            'Assunto incorreto' => array(
                'destinatario' => $destinatario, 'assunto' => '', 'corpo' => $corpo
            ),
            'Corpo incorreto' => array(
                'destinatario' => $destinatario, 'assunto' => $assunto, 'corpo' => ''
            )
        );

        return array($dados);
    }

    public function testAdicionarDestinatarioInvalido()
    {
        $email = $this->montarObjetoEmail();

        $email->adicionarDestinatario('destino@@email.com');
        $this->assertFalse($email->okEnvio());
    }

    public function testAdicionarAssuntoInvalido()
    {
        $email = $this->montarObjetoEmail();

        $email->adicionarAssunto('SELECT * FROM <input type="text">');
        $this->assertFalse($email->okEnvio());
    }
}