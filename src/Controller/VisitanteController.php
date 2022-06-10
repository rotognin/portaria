<?php

namespace Src\Controller;

use Src\Model\Funcoes\Visitantes;
use Src\Model\Entidades\Empresa;

class VisitanteController extends Controller
{
    public static function visitantes(array $post, array $get, string $mensagem = '')
    {
        if (!isset($post['_token']) || $post['_token'] != $_SESSION['csrf']){
            parent::logout();
            exit;
        }

        criarCsrf();
        $empresa_id = filter_var($post['empresa_id'], FILTER_VALIDATE_INT);
        $empresa = (new Empresa())->findById($empresa_id);

        $visitantes = new Visitantes();
        $visitantes->listar($post['empresa_id']);
        parent::view('visitante.lista', ['visitantes' => $visitantes->obter(), 'empresa' => $empresa, 'mensagem' => $mensagem]);
    }

    public static function novo(array $post, array $get)
    {
        if (!isset($post['_token']) || $post['_token'] != $_SESSION['csrf']){
            parent::logout();
            exit;
        }

        $empresa_id = filter_var($post['empresa_id'], FILTER_VALIDATE_INT);
        $empresa = (new Empresa())->findById($empresa_id);
        if (is_null($empresa)){
            $mensagem = 'Falha ao carregar o cadastro da Empresa ' . $empresa_id;
            self::visitantes($post, $get, $mensagem);
            exit;
        }

        criarCsrf();
        parent::view('visitante.novo', ['empresa_id' => $empresa_id]);
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
        if (!isset($post['_token']) || $post['_token'] != $_SESSION['csrf']){
            parent::logout();
            exit;
        }

        $view = ($novo) ? 'novo' : 'alterar';

        $visitante = new Visitantes();
        if (!$visitante->dados($post)){
            criarCsrf();
            parent::view('visitante.' . $view, ['mensagem' => $visitante->mensagem, 'visitante' => $visitante->objeto()]);
            exit;
        }

        if ($visitante->gravar()){
            self::visitantes($post, $get, 'Visitante registrado com sucesso.');
        } else {
            criarCsrf();
            parent::view('visitante.' . $view, ['mensagem' => $visitante->mensagem, 'visitante' => $visitante->objeto()]);
        }
    }

    public static function alterar(array $post, array $get, string $mensagem = '')
    {
        criarCsrf();
        $id = filter_var($post['visitante_id'], FILTER_VALIDATE_INT);
        $visitante = new Visitantes();
        $visitante->carregar($id);

        parent::view('visitante.alterar', ['visitante' => $visitante->objeto(), 'mensagem' => $mensagem]);
    }

    public static function ativar(array $post, array $get)
    {
        self::alterarStatus($post, $get, STATUS_ATIVO);
    }

    public static function inativar(array $post, array $get)
    {
        self::alterarStatus($post, $get, STATUS_INATIVO);
    }

    public static function sobConsulta(array $post, array $get)
    {
        self::alterarStatus($post, $get, STATUS_CONSULTA);
    }

    public static function bloquear(array $post, array $get)
    {
        self::alterarStatus($post, $get, STATUS_BLOQUEADO);
    }

    private static function alterarStatus(array $post, array $get, int $status)
    {
        if (!isset($post['_token']) || $post['_token'] != $_SESSION['csrf']){
            parent::logout();
            exit;
        }

        $id = filter_var($post['visitante_id'], FILTER_VALIDATE_INT);

        $visitante = new Visitantes();
        $visitante->carregar($id);
        $visitante->alterarStatus($status);

        self::visitantes($post, $get, 'Status do visitante alterado');
    }
}