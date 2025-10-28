<!DOCTYPE html>
<html>
<?php include 'html/head.php'; ?>
<body>
    <div class="container-fluid">
        <?php 
            $titulo = 'Criação de nova Empresa';
            $exibirTopo = false;
            require_once 'html/' . $_SESSION['ambiente'] . '/topo.php';
        ?>

        <br>
        <?php include_once 'html/mensagem.php'; ?>
        <?php 
            $acao = 'gravar';
            require('formulario.php'); 
        ?>
    </div>

    <?php include 'html/scriptsjs.php'; ?>
</body>
</html>