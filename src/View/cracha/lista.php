<!DOCTYPE html>
<html>
<?php include 'html/head.php'; ?>
<body>
    <div class="container-fluid">
        <?php 
            $titulo = 'Crachás cadastrados no sistema';
            require_once 'html/admin/topo.php';
        ?>
    </div>

    <div class="container-fluid">
    <?php
        if ($botaoNovo){
            echo '<a class="btn fundo-azul text-white" href="index.php?action=novo&control=cracha">Novo Crachá</a>';
        } else {
            echo '<i>' . $mensagem . '</i>';
        }
    ?>

        <table class="table table-hover table-sm">
            <thead class="fundo-azul branco">
                <tr>
                    <th>ID</th>
                    <th>Identificação</th>
                    <th>Unidade</th>
                    <th>ID Movimentação</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php
                if ($crachas){
                    foreach($crachas as $cracha){
                        $acao = (STATUS[$cracha->status] == 'Ativo') ? 'inativar' : 'ativar';

                        echo '<tr>';
                            echo '<td>' . $cracha->id . '</td>';
                            echo '<td>' . $cracha->identificacao . '</td>';
                            echo '<td>' . $cracha->unidade->nome . '</td>';
                            echo '<td>' . $cracha->movimentacao_id . '</td>';

                            echo '<td>';
                                echo '<form method="post" action="index.php?control=cracha&action=' . $acao . '">';
                                    echo '<input type="hidden" name="_token" value="' . $_SESSION['csrf'] . '">';
                                    echo '<input type="hidden" name="cracha_id" value="' . $cracha->id . '">';
                                    echo STATUS[$cracha->status] . '&nbsp;&nbsp;&nbsp;';

                                    if ($cracha->movimentacao_id == 0){
                                        echo '<input type="submit" style="margin-left: 10px" value="' . ucfirst($acao) . '" class="btn botao btn-sm">';
                                    }
                                    
                                echo '</form>';
                            echo '</td>';

                            echo '<td>';
                                if ($cracha->movimentacao_id == 0){
                                    echo '<form method="post" action="index.php?control=cracha&action=alterar">';
                                        echo '<input type="hidden" name="_token" value="' . $_SESSION['csrf'] . '">';
                                        echo '<input type="hidden" name="cracha_id" value="' . $cracha->id . '">';
                                        echo '<input type="submit" style="margin-left: 10px" value="Alterar" class="btn botao btn-sm float-left">';
                                    echo '</form>';
                                }
                                
                            echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr>';
                        echo '<td colspan="5"><i>Nenhum crachá cadastrado...</i></td>';
                    echo '</tr>';
                }
            ?>
            </tbody>
        </table>
    </div>

    <?php include 'html/scriptsjs.php'; ?>
</body>
</html>