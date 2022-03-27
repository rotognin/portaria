<?php

namespace Src\Controller;

class MovimentacaoController extends Controller
{
    public static function inicio()
    {
        parent::view('movimentacao.index');
    }
}