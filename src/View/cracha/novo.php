<!DOCTYPE html>
<html>
<?php include 'html/head.php'; ?>
<body>
    <div class="container-fluid">
        <?php 
            $titulo = 'Criação de novo Crachá';
            require_once 'html/admin/topo.php';
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