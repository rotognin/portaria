<!DOCTYPE html>
<html>
<?php include 'html/head.php'; ?>
<body>
    <div class="container-fluid">
        <?php 
            $titulo = 'Relatório de movimentações';
            $exibirTopo = false;
            require_once 'html/admin/topo.php';
        ?>

        <table class="table table-hover table-sm">
            <thead class="fundo-azul branco">
                <tr>
                    <th>ID</th>
                    <th>Unidade</th>
                    <th>Visitante</th>
                    <th>Empresa</th>
                    <th>Crachá</th>
                    <th>Entrada</th>
                    <th>Saída</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php
                if ($movimentacoes){
                    foreach($movimentacoes as $movimentacao){
                        echo '<tr>';
                            echo '<td>' . $movimentacao->id . '</td>';
                            echo '<td>' . $movimentacao->unidade->nome . '</td>';
                            echo '<td>' . $movimentacao->visitante->nome . '</td>';
                            echo '<td>' . $movimentacao->visitante->empresa->nome . '</td>';
                            echo '<td>' . $movimentacao->cracha->identificacao . '</td>';
                            echo '<td>' . ajustarData($movimentacao->data_entrada) . ' ' . ajustarHora('00/00/0000' . ' ' . $movimentacao->hora_entrada) . '</td>';
                            echo '<td>' . ajustarData($movimentacao->data_saida) . ' ' . ajustarHora('00/00/0000' . ' ' . $movimentacao->hora_saida) . '</td>';
                            echo '<td>' . STATUS_MOVIMENTACAO[$movimentacao->status] . '</td>';
                            echo '<td>';
                                echo '<form method="post" target="_blank" action="index.php?control=movimentacao&action=detalhes&ambiente=admin">';
                                    echo '<input type="hidden" name="_token" value="' . $_SESSION['csrf'] . '">';
                                    echo '<input type="hidden" name="movimentacao_id" value="' . $movimentacao->id . '">';
                                    echo '<input type="submit" style="margin-left: 10px" value="Detalhes" class="btn botao btn-sm float-left">';
                                echo '</form>';
                            echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr>';
                        echo '<td colspan="9"><i>Nenhuma movimentação encontrada...</i></td>';
                    echo '</tr>';
                }
            ?>
            </tbody>
        </table>
    </div>

    <script src="html/script.js"></script>
    <?php include 'html/scriptsjs.php'; ?>
</body>
</html>