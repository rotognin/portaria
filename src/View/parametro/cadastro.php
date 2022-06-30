<!DOCTYPE html>
<html>
<?php include 'html/head.php'; ?>
<body>
    <div class="container-fluid">
        <?php 
            $titulo = 'Parâmetros da Unidade: ' . $unidade->nome;
            require_once 'html/admin/topo.php';
        ?>

        <?php include_once 'html/mensagem.php'; ?>
        <?php require('formulario.php'); ?>
    </div>

    <?php include 'html/scriptsjs.php'; ?>
</body>
</html>