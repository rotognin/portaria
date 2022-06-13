<?php

/**
 * Recebe o campo Data do banco e o formata para DD/MM/AAAA
 */
function ajustarData(string $dataOrigem)
{
    if ($dataOrigem == ''){
        return '';
    }
    
    $data = explode('-', $dataOrigem);
    $dataAjustada = $data[2] . '/' . $data[1] . '/' . $data[0];
    return ($dataAjustada == '00/00/0000') ? '' : $dataAjustada;
}

/**
 * Recebe o campo Hora do banco e o formata para HH:MM
 */
function ajustarHora(string $dataHoraOrigem)
{
    $dataHora = explode(' ', $dataHoraOrigem);
    $hora     = explode(':', $dataHora[1]);
    return $hora[0] . ':' . $hora[1];
}

/**
 * Proteção contra textos maliciosos
 */
function verificarString(string $texto) {
    $texto = preg_replace("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/i", "", $texto);
    $texto = trim($texto);
    $texto = strip_tags($texto);
    $texto = addslashes($texto);
    return $texto;
}

/**
 * Criação do token CSRF guardando na seção
 */
function criarCsrf()
{
    $_SESSION['csrf'] = sha1(date('d-m-Y H-i-s'));
}

/**
 * Formatar o CNPJ
 */
function Cnpj(string $cnpj)
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
function dataValida(string $data)
{
    $data_array = explode('-', $data);
    $ano = $data_array[0];
    $mes = $data_array[1];
    $dia = $data_array[2];

    return checkdate($mes, $dia, $ano);
}

/**
 * Verificar se um horário é válido.
 * Receber o horário dessa forma: hh:mm
 */
function horaValida(string $horario)
{
    $hora_array = explode(':', $horario);
    $hora = $hora_array[0];
    $minuto = $hora_array[1];

    $retorno = true;

    if ($hora > 23 || $minuto > 59){
        $retorno = false;
    }

    return $retorno;
}