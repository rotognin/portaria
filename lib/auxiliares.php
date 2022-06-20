<?php

function gravarLog($mensagem)
{
    $log = new Src\Model\Log();
    $log->texto = $mensagem;
    $log->save();
}