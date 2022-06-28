<!DOCTYPE html>
<html>
<?php include 'html/head.php'; ?>
<body>
    <div class="container-fluid">
        <?php 
            $titulo = 'Empresas - Clientes';
            $exibirTopo = false;
            require_once 'html/' . $_SESSION['ambiente'] . '/topo.php';
        ?>
    </div>

    <div class="container-fluid">
        <a class="btn fundo-azul text-white" href="index.php?action=novo&control=empresa">Nova Empresa</a>

        <table class="table table-hover table-sm">
            <thead class="fundo-azul branco">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Município / UF</th>
                    <th>Status</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php
                if ($empresas){
                    foreach($empresas as $empresa){
                        $acao = (STATUS[$empresa->status] == 'Ativo') ? 'inativar' : 'ativar';

                        echo '<tr>';
                            echo '<td>' . $empresa->id . '</td>';
                            echo '<td>' . $empresa->nome . '</td>';
                            echo '<td>' . $empresa->municipio . ' / '. $empresa->uf . '</td>';

                            echo '<td>';
                                echo '<form method="post" action="index.php?control=empresa&action=' . $acao . '">';
                                    echo '<input type="hidden" name="_token" value="' . $_SESSION['csrf'] . '">';
                                    echo '<input type="hidden" name="empresa_id" value="' . $empresa->id . '">';
                                    echo STATUS[$empresa->status] . '&nbsp;&nbsp;&nbsp;';
                                    echo '<input type="submit" style="margin-left: 10px" value="' . ucfirst($acao) . '" class="btn botao btn-sm">';
                                echo '</form>';
                            echo '</td>';

                            echo '<td>';
                                echo '<form method="post" action="index.php?control=empresa&action=alterar">';
                                    echo '<input type="hidden" name="_token" value="' . $_SESSION['csrf'] . '">';
                                    echo '<input type="hidden" name="empresa_id" value="' . $empresa->id . '">';
                                    echo '<input type="submit" style="margin-left: 10px" value="Alterar" class="btn botao btn-sm float-left">';
                                echo '</form>';
                            echo '</td>';

                            echo '<td>';
                                echo '<form method="post" action="index.php?control=visitante&action=visitantes">';
                                    echo '<input type="hidden" name="_token" value="' . $_SESSION['csrf'] . '">';
                                    echo '<input type="hidden" name="empresa_id" value="' . $empresa->id . '">';
                                    echo '<input type="submit" style="margin-left: 10px" value="Visitantes" class="btn botao btn-sm float-left">';
                                echo '</form>';
                            echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr>';
                        echo '<td colspan="6"><i>Nenhuma empresa cadastrada...</i></td>';
                    echo '</tr>';
                }
            ?>
            </tbody>
        </table>
    </div>

    <?php include 'html/scriptsjs.php'; ?>
</body>
</html>