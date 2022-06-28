<!DOCTYPE html>
<html>
<?php include 'html/head.php'; ?>
<body>
    <div class="container-fluid">
        <?php 
            $titulo = 'Visitantes da Empresa';
            $exibirTopo = false;
            require_once 'html/' . $_SESSION['ambiente'] . '/topo.php';
        ?>
        <p><i>
            <?php echo $empresa->nome; ?>
        </i></p>
    </div>

    <div class="container-fluid">
        <form method="post" action="index.php?action=novo&control=visitante">
            <input type="hidden" name="empresa_id" value="<?php echo $empresa->id; ?>">
            <input type="hidden" name="_token" value="<?php echo $_SESSION['csrf']; ?>">
            <button type="submit" class="btn botao">Novo Visitante</button>
        </form>

        <table class="table table-hover table-sm">
            <thead class="fundo-azul branco">
                <tr>
                    <th>ID</th>
                    <th>Visitante</th>
                    <th>Documento</th>
                    <th>Telefone</th>
                    <th>Situação</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php
                if ($visitantes){
                    foreach($visitantes as $visitante){
                        $acao = (STATUS[$visitante->status] == 'Ativo') ? 'inativar' : 'ativar';

                        echo '<tr>';
                            echo '<td>' . $visitante->id . '</td>';
                            echo '<td>' . $visitante->nome . '</td>';
                            echo '<td>' . $visitante->documento . '</td>';
                            echo '<td>' . $visitante->telefone . '</td>';
                            echo '<td>' . STATUS[$visitante->status] . '</td>';

                            echo '<td>';
                                echo '<form method="post" action="index.php?control=visitante&action=alterar">';
                                    echo '<input type="hidden" name="_token" value="' . $_SESSION['csrf'] . '">';
                                    echo '<input type="hidden" name="visitante_id" value="' . $visitante->id . '">';
                                    echo '<input type="submit" style="margin-left: 10px" value="Alterar" class="btn botao btn-sm float-left">';
                                echo '</form>';
                            echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr>';
                        echo '<td colspan="5"><i>Nenhum visitante cadastrado...</i></td>';
                    echo '</tr>';
                }
            ?>
            </tbody>
        </table>
        <?php include 'html/mensagem.php'; ?>
    </div>

    <?php include 'html/scriptsjs.php'; ?>
</body>
</html>