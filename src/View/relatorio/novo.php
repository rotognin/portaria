<!DOCTYPE html>
<html>
<?php include 'html/head.php'; ?>
<body>
    <div class="container-fluid">
        <?php 
            $titulo = 'Relatório de movimentações';
            $exibirTopo = false;
            require_once 'html/admin/topo.php';
        ?>

        <?php include_once ('html/mensagem.php'); ?>
        <?php require('formulario.php'); ?>
    </div>

    <script src="html/script.js"></script>
    <?php include 'html/scriptsjs.php'; ?>
</body>
</html>