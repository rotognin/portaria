<!DOCTYPE html>
<html>
<?php include 'html/head.php'; ?>
<body>
    <div class="container-fluid">
        <?php 
            $titulo = 'Detalhes da movimentação';
            $exibirTopo = false;
            require_once 'html/movimentacao/topo.php';
        ?>

        <?php include_once 'lib/mensagem.php'; ?>
        <?php 
            require('formulariodetalhes.php'); 
        ?>
    </div>

    <script src="html/script.js"></script>
    <?php include 'html/scriptsjs.php'; ?>
</body>
</html>