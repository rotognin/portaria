<!DOCTYPE html>
<html>
<?php include 'html/head.php'; ?>
<body>
    <div class="container-fluid">
        <?php 
            $titulo = 'Cancelamento de movimentação';
            $exibirTopo = false;
            require_once 'html/movimentacao/topo.php';
        ?>

        <?php include_once 'html/mensagem.php'; ?>
        <?php 
            require('formulariocancelar.php'); 
        ?>
    </div>

    <script src="html/script.js"></script>
    <?php include 'html/scriptsjs.php'; ?>
</body>
</html>