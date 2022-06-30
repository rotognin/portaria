<!DOCTYPE html>
<html>
<?php include 'html/head.php'; ?>
<body>
    <div class="container-fluid">
        <?php 
            $titulo = 'Unidades cadastradas no sistema';
            require_once 'html/admin/topo.php';
        ?>
    </div>
    <?php include_once 'html/mensagem.php'; ?>
    <div class="container-fluid">
        <a class="btn fundo-azul text-white" href="index.php?action=novo&control=unidade">Nova Unidade</a>

        <table class="table table-hover table-sm">
            <thead class="fundo-azul branco">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CNPJ</th>
                    <th>Tipo</th>
                    <th>Município/UF</th>
                    <th>Status</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php
                if ($unidades){
                    foreach($unidades as $unidade){
                        $acao = (STATUS[$unidade->status] == 'Ativo') ? 'inativar' : 'ativar';

                        echo '<tr>';
                            echo '<td>' . $unidade->id . '</td>';
                            echo '<td>' . $unidade->nome . '</td>';
                            echo '<td>' . $unidade->ajustarCnpj() . '</td>';
                            echo '<td>' . TIPO_UNIDADE[$unidade->tipo] . '</td>';
                            echo '<td>' . $unidade->municipio . '/' . $unidade->uf . '</td>';

                            if (TIPO_UNIDADE[$unidade->tipo] != 'Matriz'){
                                echo '<td>';
                                    echo '<form method="post" action="index.php?control=unidade&action=' . $acao . '">';
                                        echo '<input type="hidden" name="_token" value="' . $_SESSION['csrf'] . '">';
                                        echo '<input type="hidden" name="unidade_id" value="' . $unidade->id . '">';
                                        echo STATUS[$unidade->status] . '&nbsp;&nbsp;&nbsp;';
                                        echo '<input type="submit" style="margin-left: 10px" value="' . ucfirst($acao) . '" class="btn botao btn-sm">';
                                    echo '</form>';
                                echo '</td>';
                            } else {
                                echo '<td>Ativo</td>';
                            }

                            echo '<td>';
                                echo '<form method="post" action="index.php?control=unidade&action=alterar">';
                                    echo '<input type="hidden" name="_token" value="' . $_SESSION['csrf'] . '">';
                                    echo '<input type="hidden" name="unidade_id" value="' . $unidade->id . '">';
                                    echo '<input type="submit" style="margin-left: 10px" value="Alterar" class="btn botao btn-sm float-left">';
                                echo '</form>';
                            echo '</td>';

                            echo '<td>';
                                echo '<form method="post" action="index.php?control=parametro&action=parametros">';
                                    echo '<input type="hidden" name="_token" value="' . $_SESSION['csrf'] . '">';
                                    echo '<input type="hidden" name="unidade_id" value="' . $unidade->id . '">';
                                    echo '<input type="submit" style="margin-left: 10px" value="Parâmetros" class="btn botao btn-sm float-left">';
                                echo '</form>';
                            echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr>';
                        echo '<td colspan="8"><i>Nenhuma unidade cadastrada...</i></td>';
                    echo '</tr>';
                }
            ?>
            </tbody>
        </table>
    </div>

    <?php include 'html/scriptsjs.php'; ?>
</body>
</html>