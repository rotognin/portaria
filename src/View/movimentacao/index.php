<!DOCTYPE html>
<html>
<?php include 'html/head.php'; ?>
<body>
    <div class="container-fluid">
        <?php 
            $titulo = 'Registro de visitas';
            $exibirTopo = true;
            require_once 'html/movimentacao/topo.php';
        ?>
        <?php include_once 'html/mensagem.php'; ?>

        <table class="table table-hover table-sm">
            <thead class="fundo-azul branco">
                <tr>
                    <th>ID</th>
                    <th>Visitante</th>
                    <th>Empresa</th>
                    <th>Crachá</th>
                    <th>Data / Hora</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php
                if ($movimentacoes){
                    foreach($movimentacoes as $movimentacao){
                        // Montar a tabela com as informações
                        echo '<tr>';
                            echo '<td>' . $movimentacao->id . '</td>';
                            echo '<td>' . $movimentacao->visitante->nome . '</td>';
                            echo '<td>' . $movimentacao->visitante->empresa->nome . '</td>';
                            echo '<td>' . $movimentacao->cracha->identificacao . '</td>';
                            echo '<td>' . $movimentacao->ajustarDataEntrada() . ' ' . $movimentacao->ajustarHoraEntrada() . '</td>';
                            echo '<td>';
                                echo '<form method="post" action="index.php?control=movimentacao&action=saida">';
                                    echo '<input type="hidden" name="_token" value="' . $_SESSION['csrf'] . '">';
                                    echo '<input type="hidden" name="movimentacao_id" value="' . $movimentacao->id . '">';
                                    echo '<input type="submit" style="margin-left: 10px" value="Saída" class="btn botao btn-sm float-left">';
                                echo '</form>';
                            echo '</td>';
                            echo '<td>';
                                echo '<form method="post" target="_blank" action="index.php?control=movimentacao&action=detalhes">';
                                    echo '<input type="hidden" name="_token" value="' . $_SESSION['csrf'] . '">';
                                    echo '<input type="hidden" name="movimentacao_id" value="' . $movimentacao->id . '">';
                                    echo '<input type="submit" style="margin-left: 10px" value="Detalhes" class="btn botao btn-sm float-left">';
                                echo '</form>';
                            echo '</td>';
                            echo '<td>';
                                echo '<form method="post" action="index.php?control=movimentacao&action=cancelar">';
                                    echo '<input type="hidden" name="_token" value="' . $_SESSION['csrf'] . '">';
                                    echo '<input type="hidden" name="movimentacao_id" value="' . $movimentacao->id . '">';
                                    echo '<input type="submit" style="margin-left: 10px" value="Cancelar" class="btn botao btn-sm float-left">';
                                echo '</form>';
                            echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr>';
                        echo '<td colspan="7"><i>Nenhuma movimentação em aberto...</i></td>';
                    echo '</tr>';
                }
            ?>
            </tbody>
        </table>
    </div>

    <?php include 'html/scriptsjs.php'; ?>
</body>
</html>