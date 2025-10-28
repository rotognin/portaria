<?php

namespace lib;

class Verificacoes
{
    /**
     * Recebe o campo Data do banco e o formata para DD/MM/AAAA
     */
    public static function ajustarData(string $dataOrigem)
    {
        if ($dataOrigem == '' || $dataOrigem == 'NULL'){
            return '';
        }
        
        $data = explode('-', $dataOrigem);

        if (count($data) != 3){
            return '';
        }

        $dataAjustada = $data[2] . '/' . $data[1] . '/' . $data[0];
        return ($dataAjustada == '00/00/0000') ? '' : $dataAjustada;
    }

    /**
     * Recebe o campo Hora do banco e o formata para HH:MM
     */
    public static function ajustarHora(string $horaOrigem)
    {
        if ($horaOrigem == '' || $horaOrigem == 'NULL'){
            return '';
        }

        $hora = explode(':', $horaOrigem);

        if (count($hora) < 2){
            return '';
        }

        $horaAjustada = $hora[0] . ':' . $hora[1];

        return ($horaAjustada == '00:00') ? '' : $horaAjustada;
    }

    /**
     * Proteção contra textos maliciosos
     */
    public static function verificarString(string $texto) {
        $texto = preg_replace("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/i", "", $texto);
        $texto = trim($texto);
        $texto = strip_tags($texto);
        $texto = addslashes($texto);
        return $texto;
    }

    /**
     * Criação do token CSRF guardando na seção
     */
    public static function criarCsrf()
    {
        $csrf = sha1(date('d-m-Y H-i-s'));
        $_SESSION['csrf'] = $csrf;
        return $csrf;
    }

    /**
     * Verificar se o token foi passado e se é válido
     */
    public static function token(array $dados)
    {
        return (isset($dados['_token']) && $dados['_token'] == $_SESSION['csrf']);
    }

    /**
     * Formatar o CNPJ
     */
    public static function montarCnpj(string $cnpj)
    {
        return substr($cnpj, 0, 2) . '.' . 
               substr($cnpj, 2, 3) . '.' .
               substr($cnpj, 5, 3) . '/' .
               substr($cnpj, 8, 4) . '-' .
               substr($cnpj, 12, 2);
    }

    /**
     * Verificar se a data é válida.
     * Receber a data dessa forma: YYYY-mm-dd
     */
    public static function dataValida(string $data)
    {
        $data_array = explode('-', $data);

        if (count($data_array) != 3){
            return false;
        }

        $ano = $data_array[0];
        $mes = $data_array[1];
        $dia = $data_array[2];

        return checkdate($mes, $dia, $ano);
    }

    /**
     * Verificar se um horário é válido.
     * Receber o horário dessa forma: hh:mm
     */
    public static function horaValida(string $horario)
    {
        $hora_array = explode(':', $horario);

        if (count($hora_array) < 2){
            return false;
        }

        $hora = $hora_array[0];
        $minuto = $hora_array[1];

        $retorno = true;

        if ($hora > 23 || $minuto > 59){
            $retorno = false;
        }

        return $retorno;
    }

    /**
     * Fazer a validação de campos e-mail
     */
    public static function emailValido(string $email, bool $okBranco = true)
    {
        if (empty($email)){
            return $okBranco;
        }

        return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}