<?php

namespace Src\Controller;

use Src\Model\Funcoes\Empresas;
use Src\Model\Funcoes\Crachas;
use Src\Model\Funcoes\Movimentacoes;
use Src\Model\Entidades\Visitante;
use Src\Model\Entidades\Empresa;
use Src\Model\Entidades\Cracha;

class MovimentacaoController extends Controller
{
    public static function inicio(array $post, array $get, string $mensagem = '')
    {
        // Carregar as movimentações em aberto no momento
        $movimentacoes = new Movimentacoes();

        $filtros = array(
            'status' => 0
        );

        $movimentacoes->listar($filtros);

        criarCsrf();
        parent::view('movimentacao.index', ['mensagem' => $mensagem, 'movimentacoes' => $movimentacoes->obter()]);
    }

    public static function novo(array $post, array $get, string $mensagem = '')
    {
        criarCsrf();

        $empresas = new Empresas();

        if (!$empresas->listar(false)){
            self::inicio($post, $get, $empresas->mensagem);
            exit;
        }

        $crachas = new Crachas();

        if (!$crachas->listar(false, $_SESSION['uniID'], true)){
            self::inicio($post, $get, $crachas->mensagem);
            exit;
        }

        parent::view('movimentacao.novo', [
            'mensagem' => $mensagem, 
            'empresas' => $empresas->obter(),
            'crachas' => $crachas->obter()
        ]);
    }

    public static function gravar(array $post, array $get)
    {
        self::persistir($post, $get, true);
    }

    public static function atualizar(array $post, array $get)
    {
        self::persistir($post, $get, false);
    }

    public static function persistir(array $post, array $get, bool $novo)
    {
        if (!isset($post['_token']) || $post['_token'] != $_SESSION['csrf']){
            parent::logout();
            exit;
        }

        $view = ($novo) ? 'novo' : 'alterar';

        $movimentacao = new Movimentacoes();
        if (!$movimentacao->dados($post)){
            criarCsrf();
            parent::view('movimentacao.' . $view, ['mensagem' => $movimentacao->mensagem, 'movimentacao' => $movimentacao->objeto()]);
            exit;
        }

        if ($movimentacao->existemAcompanhantes($post)){
            if (!$movimentacao->ajustarAcompanhantes($post)){
                criarCsrf();
                parent::view('movimentacao.' . $view, ['mensagem' => $movimentacao->mensagem, 'movimentacao' => $movimentacao->objeto()]);
                exit;
            }
        }

        if ($movimentacao->gravar()){
            $mensagem = ($novo) ? 'Movimentação cadastrada com sucesso' : 'Movimentação atualizada com sucesso';

            if ($novo){
                $cracha = new Crachas();
                if (!$cracha->atribuir($post['cracha_id'], $movimentacao->obterId())){
                    $mensagem .= '<br>' . $cracha->mensagem;
                }
            }

            if ($novo && $movimentacao->existemAcompanhantes($post)){
                $post['movimentacao_id'] = $movimentacao->obterId();

                if (!$movimentacao->gravarAcompanhantes($post)){
                    $mensagem .= '<br>Acompanhantes não gravados corretamente.';
                }
            }

            self::inicio([], [], $mensagem);
        } else {
            criarCsrf();
            parent::view('movimentacao.' . $view, ['mensagem' => $movimentacao->mensagem, 'movimentacao' => $movimentacao->objeto()]);
        }
    }

    public static function saida(array $post, array $get)
    {
        if (!isset($post['_token']) || $post['_token'] != $_SESSION['csrf']){
            parent::logout();
            exit;
        }

        if (!isset($post['movimentacao_id']) || $post['movimentacao_id'] == 0){
            $mensagem = 'Movimentação não informada.';
            self::inicio([], [], $mensagem);
            exit;
        }

        $movimentacao_id = filter_var($post['movimentacao_id'], FILTER_VALIDATE_INT);

        $movimentacao = new Movimentacoes();
        $movimentacao->carregar($movimentacao_id);

        $movimentacao->visitante = (new Visitante())->findById($movimentacao->visitante_id);
        $movimentacao->visitante->empresa = (new Empresa())->findById($movimentacao->visitante->empresa_id);
        $movimentacao->cracha = (new Cracha())->findById($movimentacao->cracha_id);

        $acompanhantes = new Acompanhantes();
        $acompanhantes->listar($movimentacao->id);
        $movimentacao->acompanhantes = $acompanhantes->obter();

        criarCsrf();
        parent::view('movimentacao.saida', ['movimentacao' => $movimentacao->objeto()]);
    }

    public static function finalizar(array $post, array $get)
    {

    }

}