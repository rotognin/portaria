<?php

namespace Src\Controller;

use Src\Model\Funcoes\Usuarios;
use Lib\Verificacoes;

class UsuarioController extends Controller
{
    /**
     * Carregar a tela com os usuários cadastrados
     */
    public static function usuarios(array $post, array $get, string $mensagem = '')
    {
        $usuarios = new Usuarios();
        if (!$usuarios->listar()){
            $mensagem = $usuarios->mensagem;
        }

        Verificacoes::criarCsrf();
        parent::view('usuario.lista', ['usuarios' => $usuarios->obter(), 'mensagem' => $mensagem]);
    }

    /**
     * Criação de um novo usuário
     */
    public static function novo(array $post, array $get, string $mensagem = '')
    {
        Verificacoes::criarCsrf();
        parent::view('usuario.novo', ['mensagem' => $mensagem]);
    }

    public static function gravar(array $post, array $get)
    {
        self::persistir($post, $get, true);
    }

    public static function atualizar(array $post, array $get)
    {
        self::persistir($post, $get, false);
    }

    private static function persistir(array $post, array $get, bool $novo)
    {
        if (!Verificacoes::token($post)){
            parent::logout();
            exit;
        }

        $view = ($novo) ? 'novo' : 'alterar';

        $usuario = new Usuarios();
        if (!$usuario->dados($post)){
            Verificacoes::criarCsrf();
            parent::view('usuario.' . $view, ['mensagem' => $usuario->mensagem, 'usuario' => $usuario->objeto()]);
            exit;
        }

        if ($usuario->gravar()){
            self::usuarios([], [], 'Usuário gravado com sucesso.');
        } else {
            Verificacoes::criarCsrf();
            parent::view('usuario.' . $view, ['mensagem' => $usuario->mensagem, 'usuario' => $usuario->objeto()]);
        }
    }

    public static function alterar(array $post, array $get, string $mensagem = '')
    {
        Verificacoes::criarCsrf();
        
        $id = filter_var($post['usuario_id'], FILTER_VALIDATE_INT);
        $usuario = new Usuarios();
        $usuario->carregar($id);

        parent::view('usuario.alterar', ['usuario' => $usuario->objeto(), 'mensagem' => $mensagem]);
    }

    public static function ativar(array $post, array $get)
    {
        self::alterarStatus($post, $get, 0);
    }

    public static function inativar(array $post, array $get)
    {
        self::alterarStatus($post, $get, 1);
    }

    private static function alterarStatus(array $post, array $get, int $status)
    {
        if (!Verificacoes::token($post)){
            parent::logout();
            exit;
        }

        $id = filter_var($post['usuario_id'], FILTER_VALIDATE_INT);

        $usuario = new Usuarios();
        $usuario->carregar($id);
        $usuario->alterarStatus($status);

        self::usuarios([], []);
    }
}