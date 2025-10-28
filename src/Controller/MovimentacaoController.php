<?php

namespace Src\Controller;

use Src\Model\Funcoes\Empresas;
use Src\Model\Funcoes\Crachas;
use Src\Model\Funcoes\Movimentacoes;
use Src\Model\Funcoes\Parametros;
use Src\Model\Funcoes\Portarias;
use Src\Model\Entidades\Visitante;
use Src\Model\Entidades\Empresa;
use Src\Model\Entidades\Cracha;
use Src\Model\Entidades\Movimentacao;
use Lib\Verificacoes;

class MovimentacaoController extends Controller
{
    public static function inicio(array $post, array $get, string $mensagem = '')
    {
        // Carregar as movimentações em aberto no momento
        $movimentacoes = new Movimentacoes();

        $filtros = array(
            'status' => 0,
            'unidade_id' => $_SESSION['uniID']
        );

        $movimentacoes->listar($filtros);

        Verificacoes::criarCsrf();
        parent::view('movimentacao.index', ['mensagem' => $mensagem, 'movimentacoes' => $movimentacoes->obter()]);
    }

    public static function novo(array $post, array $get, string $mensagem = '', Movimentacao $movimentacao = NULL)
    {
        Verificacoes::criarCsrf();

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

        $parametros = new Parametros();
        $param_id = $parametros->verificarParametrosUnidade($_SESSION['uniID']);
        $parametros->carregar($param_id);

        $portaria = new Portarias();
        $portaria->carregar($_SESSION['porID']);

        parent::view('movimentacao.novo', [
            'mensagem' => $mensagem, 
            'empresas' => $empresas->obter(),
            'crachas' => $crachas->obter(),
            'parametros' => $parametros->objeto(),
            'movimentacao' => $movimentacao,
            'portaria' => $portaria->objeto()
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
        if (!Verificacoes::token($post)){
            parent::logout();
            exit;
        }

        $movimentacao = new Movimentacoes();
        if (!$movimentacao->dados($post)){
            self::novo([], [], $movimentacao->mensagem, $movimentacao->objeto());
            exit;
        }

        // Verificar se o visitante selecionado está em outra movimentação Em Aberto
        if ($movimentacao->visitanteEmAberto()){
            $mensagem = 'Esse visitante já está em uma movimentação em aberto.';
            self::novo([], [], $mensagem, $movimentacao->objeto());
            exit;
        }

        // Verificar se tem outra movimentação Em Aberto com a mesma placa de veículo
        if ($movimentacao->veiculoEmAberto()){
            $mensagem = 'Esse veículo já está em uma movimentação em aberto.';
            self::novo([], [], $mensagem, $movimentacao->objeto());
            exit;
        }

        if ($movimentacao->existemAcompanhantes($post)){
            if (!$movimentacao->ajustarAcompanhantes($post)){
                self::novo([], [], $movimentacao->mensagem, $movimentacao->objeto());
                exit;
            }
        }

        if ($movimentacao->gravar()){
            $mensagem = 'Movimentação cadastrada com sucesso';

            $cracha = new Crachas();
            if (!$cracha->atribuir($post['cracha_id'], $movimentacao->obterId())){
                $mensagem .= '<br>' . $cracha->mensagem;
            }

            if ($movimentacao->existemAcompanhantes($post)){
                $post['movimentacao_id'] = $movimentacao->obterId();

                if (!$movimentacao->gravarAcompanhantes($post)){
                    $mensagem .= '<br>Acompanhantes não gravados corretamente.';
                }
            }

            if (!$movimentacao->checarEnviarEmail('Abertura de movimentação - visita')){
                $mensagem .= '<br>O e-mail de abertura não foi enviado: [ ' . $movimentacao->mensagem . ' ]';
            }

            self::inicio([], [], $mensagem);
        } else {
            Verificacoes::criarCsrf();
            parent::view('movimentacao.novo', ['mensagem' => $movimentacao->mensagem, 'movimentacao' => $movimentacao->objeto()]);
        }
    }

    private static function carregarMovimentacao(array $dados)
    {
        $movimentacao_id = filter_var($dados['movimentacao_id'], FILTER_VALIDATE_INT);

        if (!$movimentacao_id){
            return false;
        }

        $movimentacao = new Movimentacoes();
        $movimentacao->carregar($movimentacao_id);

        return $movimentacao;
    }

    public static function detalhes(array $post, array $get)
    {
        if (!Verificacoes::token($post)){
            parent::logout();
            exit;
        }

        $movimentacao = self::carregarMovimentacao($post);

        if (!$movimentacao){
            $mensagem = 'Movimentação não informada.';
            self::inicio([], [], $mensagem);
            exit;
        }

        parent::view('movimentacao.detalhes', ['movimentacao' => $movimentacao->objeto()]);
    }

    public static function saida(array $post, array $get, string $mensagem = '')
    {
        if (!Verificacoes::token($post)){
            parent::logout();
            exit;
        }

        $movimentacao = self::carregarMovimentacao($post);

        if (!$movimentacao){
            $mensagem = 'Movimentação não informada.';
            self::inicio([], [], $mensagem);
            exit;
        }

        $parametros = new Parametros();
        $param_id = $parametros->verificarParametrosUnidade($_SESSION['uniID']);
        $parametros->carregar($param_id);

        Verificacoes::criarCsrf();
        parent::view('movimentacao.saida', [
            'movimentacao' => $movimentacao->objeto(), 
            'mensagem' => $mensagem,
            'parametros' => $parametros->objeto()
        ]);
    }

    public static function cancelar(array $post, array $get, string $mensagem = '')
    {
        if (!Verificacoes::token($post)){
            parent::logout();
            exit;
        }

        $movimentacao = self::carregarMovimentacao($post);

        if (!$movimentacao){
            $mensagem = 'Movimentação não informada.';
            self::inicio([], [], $mensagem);
            exit;
        }

        Verificacoes::criarCsrf();
        parent::view('movimentacao.cancelar', ['movimentacao' => $movimentacao->objeto(), 'mensagem' => $mensagem]);
    }

    public static function finalizar(array $post, array $get, string $mensagem = '')
    {
        if (!Verificacoes::token($post)){
            parent::logout();
            exit;
        }

        $status = filter_var($post['status'], FILTER_VALIDATE_INT);
        $acao = ($status == 1) ? 'saida' : 'cancelar';

        $movimentacao = new Movimentacoes();
        if (!$movimentacao->dados($post)){
            Verificacoes::criarCsrf();
            parent::view('movimentacao.' . $acao, ['mensagem' => $movimentacao->mensagem, $movimentacao->objeto()]);
            exit;
        }

        if (!$movimentacao->verificarDatas()){
            $mensagem = 'Data e hora de encerramento menor que a data e hora de abertura';

            self::$acao(array('movimentacao_id' => $post['id'], '_token' => $post['_token']), [], $mensagem);
            exit;
        }

        if ($movimentacao->gravar()){
            $mensagem = ($acao == 'saida') ? 'Movimentação finalizada!' : 'Movimentação cancelada';

            $cracha = new Crachas();
            if (!$cracha->liberar($post['cracha_id'])){
                $mensagem .= ' ' . $cracha->mensagem;
            }

            self::inicio([], [], $mensagem);
        } else {
            Verificacoes::criarCsrf();
            parent::view('movimentacao.' . $acao, ['mensagem' => $movimentacao->mensagem, 'movimentacao' => $movimentacao->objeto()]);
        }
    }
}