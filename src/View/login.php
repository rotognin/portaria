<!DOCTYPE html>
<html>
<?php 
    include ('./html/head.php'); 
?>
<body>
    <div class="container">
        <br>
        <div class="card text-center" style="border:0px solid white">
            <h3><span class="azul">Acesso ao sistema de portarias.</span></h3>
            <span><i><?php echo APP_VERSION; ?></i></span>
            <br>
            <form method="post" action="index.php?action=login">
                <div class="form-group">
                    <label for="login">&nbsp;<b>Login:</b> &nbsp;</label>
                    <input type="text" id="login" name="login" size="30px" required autofocus>
                </div>
                <div class="form-group">
                    <label for="senha"><b>Senha:</b> &nbsp;</label>
                    <input type="password" id="senha" name="senha" size="30px" required>
                </div>
                <input type="submit" value="Entrar" class="btn botao">
            </form>
            <?php 
                $regra = 'danger';
                include_once ('./html/mensagem.php');
            ?>
            <br>
        </div>
    </div>
    <?php include ('./html/scriptsjs.php'); ?>
</body>
</html>