<?php

namespace Src\Controller;

class AdministracaoController extends Controller
{
    public static function inicio()
    {
        parent::view('admin.index');
    }
}