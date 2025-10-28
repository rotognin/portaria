<?php

namespace Src\Model\Funcoes;

use Lib\Verificacoes;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Emails
{
    private string $remetente;
    private string $destinatario;
    private string $assunto;
    private bool $ok;
    private string $mensagem;
    private string $corpo;

    private string $servidor;   
    private string $usuario;
    private string $senha;
    private int $porta;

    public function __construct()
    {
        $this->ok = true;
        $this->mensagem = '';
        $this->remetente = '';
        $this->destinatario = '';
        $this->assunto = '';
        $this->corpo = '';

        $this->servidor = EMAIL_CONFIG['servidor'];
        $this->usuario = EMAIL_CONFIG['usuario'];
        $this->senha = EMAIL_CONFIG['senha'];
        $this->porta = EMAIL_CONFIG['porta'];
    }

    public function adicionarRemetente()
    {
        $this->remetente = EMAIL_CONFIG['remetente'];
    }

    public function adicionarDestinatario(string $destinatario)
    {
        if (filter_var($destinatario, FILTER_VALIDATE_EMAIL)){
            $this->destinatario = $destinatario;
        } else {
            $this->ok = false;
            $this->mensagem .= 'E-mail do destinatário inválido. ';
        }
    }

    public function adicionarAssunto(string $assunto)
    {
        $this->assunto = Verificacoes::verificarString($assunto);

        if (empty($this->assunto)){
            $this->ok = false;
            $this->mensagem .= 'Assunto do e-mail em branco. ';
        }
    }

    public function checarCampos()
    {
        if (empty($this->servidor)){
            $this->mensagem .= 'Endereço do servidor em branco. ';
            $this->ok = false;
        }

        if (empty($this->usuario)){
            $this->mensagem .= 'Usuário do e-mail em branco. ';
            $this->ok = false;
        }

        if (empty($this->senha)){
            $this->mensagem .= 'Senha do e-mail em branco. ';
            $this->ok = false;
        }

        if (!filter_var($this->porta, FILTER_VALIDATE_INT)){
            $this->mensagem .= 'Número da porta de e-mail incorreta. ';
            $this->ok = false;
        }

        if (empty($this->corpo)){
            $this->mensagem .= 'Corpo do e-mail em branco. ';
            $this->ok = false;
        }

        return $this->ok;
    }

    public function adicionarCorpo($texto)
    {
        $this->corpo = $texto;
    }

    public function enviar()
    {
        $email = new PHPMailer(true);

        try{
            //$email->SMTPDebug = SMTP::DEBUG_LOWLEVEL;
            $email->isSMTP();
            $email->Host = $this->servidor;
            $email->SMTPAuth = true;
            $email->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $email->Username = $this->usuario;
            $email->Password = $this->senha;
            $email->Port = $this->porta;
            $email->Charset = PHPMailer::CHARSET_UTF8;
            $email->Encoding = PHPMailer::ENCODING_BASE64;

            $email->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $email->setFrom($this->usuario, INFORMACOES['empresa']);
            $email->addReplyTo($this->remetente);
            $email->addAddress($this->destinatario);
            $email->isHTML(true);
            $email->Subject = utf8_decode($this->assunto);
            $email->Body = utf8_decode(nl2br($this->corpo));
            $email->AltBody = strip_tags($this->corpo);

            if (!$email->send()){
                $this->mensagem = 'Erro ao enviar e-mail: ' . $email->ErrorInfo;
                $this->ok = false;
            }
        } catch (Exception $exc) {
            $this->mensagem = 'Exceção ao enviar e-mail: ' . $email->ErrorInfo;
            $this->ok = false;
        }
    }

    public function okEnvio()
    {
        return $this->ok;
    }

    public function obterMensagemErro()
    {
        return $this->mensagem;
    }
}