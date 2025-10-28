<!DOCTYPE html>
<html>
<?php include 'html/head.php'; ?>
<body>
    <div class="container-fluid">
        <br>
        <h3>Selecione a portaria de trabalho:</h3>
        <?php
            if ($portarias){
                echo '<form class="col-12" method="post" action="index.php?control=login&action=entrar">';
                    echo '<input type="hidden" name="_token" value="' . $_SESSION['csrf'] . '">';
                    echo '<div class="form-group">';
                        echo '<select name="portaria_id" id="portaria_id">';

                        foreach($portarias as $portaria){
                            echo '<option value="' . $portaria->id . '">';
                                echo $portaria->unidade->nome . ' - ' . $portaria->descricao . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                            echo '</option>';
                        }

                        echo '</select>';
                    echo '</div>';

                    echo '<button type="submit" value="Entrar" class="btn botao">Entrar</button>';
                    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    echo '<a class="btn botao" href="index.php">Voltar</a>';
                echo '</form>';
            } else {
                echo '<h4>Atenção:</h4>';
                echo '<p>Não existem portarias cadastradas. <br>';
                echo 'Favor informar à administração do sistema</p>';
            }
        ?>

        <br>
        <?php include_once 'html/mensagem.php'; ?>
    </div>

    <?php include 'html/scriptsjs.php'; ?>
</body>
</html>