<!DOCTYPE html>
<html>
<?php include 'html/head.php'; ?>
<body>
    <div class="container-fluid">
        <?php 
            $titulo = 'Portarias cadastradas no sistema';
            require_once 'html/admin/topo.php';
        ?>
    </div>

    <div class="container-fluid">
    <?php
        if ($botaoNovo){
            echo '<a class="btn fundo-azul text-white" href="index.php?action=novo&control=portaria">Nova Portaria</a>';
        } else {
            echo '<i>' . $mensagem . '</i>';
        }
    ?>

        <table class="table table-hover table-sm">
            <thead class="fundo-azul branco">
                <tr>
                    <th>ID</th>
                    <th>Unidade</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php
                if ($portarias){
                    foreach($portarias as $portaria){
                        $acao = (STATUS[$portaria->status] == 'Ativo') ? 'inativar' : 'ativar';

                        echo '<tr>';
                            echo '<td>' . $portaria->id . '</td>';
                            echo '<td>' . $portaria->unidade->nome . '</td>';
                            echo '<td>' . $portaria->descricao . '</td>';

                            echo '<td>';
                                echo '<form method="post" action="index.php?control=portaria&action=' . $acao . '">';
                                    echo '<input type="hidden" name="_token" value="' . $_SESSION['csrf'] . '">';
                                    echo '<input type="hidden" name="portaria_id" value="' . $portaria->id . '">';
                                    echo STATUS[$portaria->status] . '&nbsp;&nbsp;&nbsp;';
                                    echo '<input type="submit" style="margin-left: 10px" value="' . ucfirst($acao) . '" class="btn botao btn-sm">';
                                echo '</form>';
                            echo '</td>';

                            echo '<td>';
                                echo '<form method="post" action="index.php?control=portaria&action=alterar">';
                                    echo '<input type="hidden" name="_token" value="' . $_SESSION['csrf'] . '">';
                                    echo '<input type="hidden" name="portaria_id" value="' . $portaria->id . '">';
                                    echo '<input type="submit" style="margin-left: 10px" value="Alterar" class="btn botao btn-sm float-left">';
                                echo '</form>';
                            echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr>';
                        echo '<td colspan="5"><i>Nenhuma portaria cadastrada...</i></td>';
                    echo '</tr>';
                }
            ?>
            </tbody>
        </table>
    </div>

    <?php include 'html/scriptsjs.php'; ?>
</body>
</html>