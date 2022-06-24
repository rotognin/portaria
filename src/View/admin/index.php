<!DOCTYPE html>
<html>
<?php include 'html/head.php'; ?>
<body>
    <div class="container-fluid">
        <?php 
            $titulo = 'Página principal da administração';
            require_once 'html/admin/topo.php';
        ?>

        <form method="post" action="index.php?control=administracao&action=inicio">
            <input type="hidden" id="_token" name="_token" value="<?php echo $_SESSION['csrf']; ?>">
            <div class="form-group margem-baixo">
                <label for="data_filtrar" style="margin:0px"><b>Dia: &nbsp;</b></label>
                <input type="date" id="data_filtrar" name="data_filtrar" value="<?php echo $data_filtrar ?>">
                <button type="submit" value="Filtrar" class="btn botao">Filtrar</button>
            </div>
        </form>

        <?php include('html/mensagem.php'); ?>

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
                            echo '<td>' . $movimentacao->ajustarDataEntrada() . ' ' . $movimentacao->ajustarHoraEntrada() . '</td>';
                            echo '<td>' . $movimentacao->ajustarDataSaida() . ' ' . $movimentacao->ajustarHoraSaida() . '</td>';
                            echo '<td>' . STATUS_MOVIMENTACAO[$movimentacao->status] . '</td>';
                            echo '<td>';
                                echo '<form method="post" target="_blank" action="index.php?control=movimentacao&action=detalhes">';
                                    echo '<input type="hidden" name="_token" value="' . $_SESSION['csrf'] . '">';
                                    echo '<input type="hidden" name="movimentacao_id" value="' . $movimentacao->id . '">';
                                    echo '<input type="submit" style="margin-left: 10px" value="Detalhes" class="btn botao btn-sm float-left">';
                                echo '</form>';
                            echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr>';
                        echo '<td colspan="9"><i>Nenhuma movimentação em aberto...</i></td>';
                    echo '</tr>';
                }
            ?>
            </tbody>
        </table>
    </div>

    <?php include 'html/scriptsjs.php'; ?>
</body>
</html>