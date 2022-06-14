<?php

namespace Src\Controller;

use Src\Model\Funcoes\Empresas;
use Src\Model\Funcoes\Crachas;
use Src\Model\Funcoes\Movimentacoes;

class MovimentacaoController extends Controller
{
    public static function inicio(array $post, array $get, string $mensagem = '')
    {
        parent::view('movimentacao.index', ['mensagem' => $mensagem]);
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

        if (!$crachas->listar(false)){
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
}