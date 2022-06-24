<?php

namespace Src\Controller;

use Src\Model\Funcoes\Visitantes;
use Src\Model\Entidades\Empresa;
use Lib\Verificacoes;

class VisitanteController extends Controller
{
    public static function visitantes(array $post, array $get, string $mensagem = '')
    {
        if (!Verificacoes::token($post)){
            parent::logout();
            exit;
        }

        Verificacoes::criarCsrf();

        $empresa_id = filter_var($post['empresa_id'], FILTER_VALIDATE_INT);
        $empresa = (new Empresa())->findById($empresa_id);

        $visitantes = new Visitantes();
        $visitantes->listar($post['empresa_id']);
        parent::view('visitante.lista', ['visitantes' => $visitantes->obter(), 'empresa' => $empresa, 'mensagem' => $mensagem]);
    }

    public static function novo(array $post, array $get)
    {
        if (!Verificacoes::token($post)){
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

        Verificacoes::criarCsrf();
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
            Verificacoes::criarCsrf();
            parent::view('visitante.' . $view, ['mensagem' => $visitante->mensagem, 'visitante' => $visitante->objeto()]);
            exit;
        }

        if ($visitante->gravar()){
            $mensagem = ($novo) ? 'Visitante cadastrado com sucesso' : 'Registro atualizado com sucesso';

            self::visitantes($post, $get, $mensagem);
        } else {
            Verificacoes::criarCsrf();
            parent::view('visitante.' . $view, ['mensagem' => $visitante->mensagem, 'visitante' => $visitante->objeto()]);
        }
    }

    public static function alterar(array $post, array $get, string $mensagem = '')
    {
        Verificacoes::criarCsrf();
        
        $id = filter_var($post['visitante_id'], FILTER_VALIDATE_INT);
        $visitante = new Visitantes();
        $visitante->carregar($id);

        parent::view('visitante.alterar', ['visitante' => $visitante->objeto(), 'mensagem' => $mensagem]);
    }

    /**
     * Função chamada usando AJAX, retorna com "echo".
     */
    public static function buscar(array $post, array $get)
    {
        $empresa_id = filter_var($get['empresa_id'], FILTER_VALIDATE_INT);

        if (!$empresa_id || $empresa_id == 0){
            echo 'nada...';
            exit;
        }

        if (!Verificacoes::token($get)){
            echo 'nada..';
            exit;
        }

        $visitantes = new Visitantes();
        if (!$visitantes->listar($empresa_id, false)){
            echo '';
            exit;
        }

        echo $visitantes->montarOption();
    }
}