<!DOCTYPE html>
<html>
<?php 
    include ('./html/head.php'); 
?>
<body>
    <div class="container">
        <br>
        <div class="card text-center" style="border:0px solid white">
            <h3><span style="color:#003366">Acesso ao sistema de portarias.</span></h3>
            <span><i>Versão: 2022-06-23-003</i></span>
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
                <input type="submit" style="background-color:#003366;color:white;" value="Entrar" class="btn">
            </form>
            <?php 
                $regra = 'danger';
                include_once ('./lib/mensagem.php');
            ?>
            <br>
        </div>
    </div>
    <?php include ('./html/scriptsjs.php'); ?>
</body>
</html>