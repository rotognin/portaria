<?php

/**
 * Funções auxiliares (helpers) para chamada de outras
 */

/**
 * Helper para ajudar na gravação do Log
 */
function gravarLog($mensagem)
{
    $log = new Src\Model\Log();
    $log->texto = $mensagem;
    $log->save();
}