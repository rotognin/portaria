<form class="col-12" method="post" action="index.php?control=usuario&action=<?php echo $acao; ?>">
    <input type="hidden" name="_token" value="<?php echo $_SESSION['csrf']; ?>">
    
    <div class="form-group">
        <label for="id" style="margin:0px"><b>ID: &nbsp;</b></label><br>
        <input type="number" id="id" name="id" readonly value="<?php echo ($usuario->id ?? '0'); ?>">
    </div>
    <div class="form-group">
        <label for="nome" style="margin:0px"><b>Nome: &nbsp;</b></label><br>
        <input type="text" id="nome" name="nome" value="<?php echo ($usuario->nome ?? ''); ?>" size="60" autofocus>
    </div>
    <div class="form-group">
        <label for="login" style="margin:0px"><b>Login: &nbsp;</b></label><br>
        <input type="text" id="login" name="login" value="<?php echo ($usuario->login ?? ''); ?>" size="60">
    </div>
    <div class="form-group">
        <label for="senha" style="margin:0px"><b>Senha: &nbsp;</b></label><br>
        <input type="password" id="senha" name="senha" value="">
    </div>

    <div class="form-group">
        <?php
            $nivel = ($usuario->nivel ?? 2);
        ?>
        <label for="nivel" style="margin:0px"><b>Nível: &nbsp;</b></label><br>
        <select name="nivel" id="nivel">
            <option value="1" <?php echo ($nivel == 1) ? 'selected' : ''; ?>>Administrador &nbsp;&nbsp;</option>
            <option value="2" <?php echo ($nivel == 2) ? 'selected' : ''; ?>>Usuário Comum &nbsp;&nbsp;</option>
        </select>
    </div>

    <input type="hidden" id="status" name="status" value="<?php echo ($usuario->status ?? '0'); ?>">
    <button type="submit" value="<?php echo ucfirst($acao); ?>" class="btn botao"><?php echo ucfirst($acao); ?></button>
</form>