<!DOCTYPE html>
<html>
<?php include 'html/head.php'; ?>
<body>
    <div class="container-fluid">
        <?php 
            $titulo = 'Usuários cadastrados no sistema';
            require_once 'html/admin/topo.php';
        ?>
    </div>
    
    <div class="container-fluid">
        <a class="btn fundo-azul text-white" href="index.php?action=novo&control=usuario">Novo Usuário</a>

        <table class="table table-hover table-sm">
            <thead class="fundo-azul branco">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Login</th>
                    <th>Nível</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php
                if ($usuarios){
                    foreach($usuarios as $usuario){
                        $acao = (STATUS[$usuario->status] == 'Ativo') ? 'inativar' : 'ativar';

                        echo '<tr>';
                            echo '<td>' . $usuario->id . '</td>';
                            echo '<td>' . $usuario->nome . '</td>';
                            echo '<td>' . $usuario->login . '</td>';
                            echo '<td>' . NIVEL[$usuario->nivel] . '</td>';

                            if (NIVEL[$usuario->nivel] != 'Administrador'){
                                echo '<td>';
                                    echo '<form method="post" action="index.php?control=usuario&action=' . $acao . '">';
                                        echo '<input type="hidden" name="_token" value="' . $_SESSION['csrf'] . '">';
                                        echo '<input type="hidden" name="usuario_id" value="' . $usuario->id . '">';
                                        echo STATUS[$usuario->status] . '&nbsp;&nbsp;&nbsp;';
                                        echo '<input type="submit" style="margin-left: 10px" value="' . ucfirst($acao) . '" class="btn botao btn-sm">';
                                    echo '</form>';
                                echo '</td>';
                            } else {
                                echo '<td>Ativo</td>';
                            }

                            echo '<td>';
                                echo '<form method="post" action="index.php?control=usuario&action=alterar">';
                                    echo '<input type="hidden" name="_token" value="' . $_SESSION['csrf'] . '">';
                                    echo '<input type="hidden" name="usuario_id" value="' . $usuario->id . '">';
                                    echo '<input type="submit" style="margin-left: 10px" value="Alterar" class="btn botao btn-sm float-left">';
                                echo '</form>';
                            echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr>';
                        echo '<td colspan="5"><i>Nenhum usuario cadastrado...</i></td>';
                    echo '</tr>';
                }
            ?>
            </tbody>
        </table>
    </div>

    <?php include 'html/scriptsjs.php'; ?>
</body>
</html>