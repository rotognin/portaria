<!DOCTYPE html>
<html>
<?php include 'html/head.php'; ?>
<body>
    <div class="container-fluid">
        <?php 
            $titulo = 'Detalhes da movimentação';
            $exibirTopo = false;

            if ($ambiente == 'admin'){
                require_once 'html/admin/topo.php';
            } else {
                require_once 'html/movimentacao/topo.php';
            }
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