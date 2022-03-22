<form class="col-12" method="post" action="index.php?control=portaria&action=<?php echo $acao; ?>">
    <input type="hidden" name="_token" value="<?php echo $_SESSION['csrf']; ?>">

    <div class="form-group">
        <label for="id" style="margin:0px"><b>ID: &nbsp;</b></label><br>
        <input type="number" id="id" name="id" readonly value="<?php echo ($portaria->id ?? '0'); ?>">
    </div>
    <div class="form-group">
        <label for="descricao" style="margin:0px"><b>Descrição: &nbsp;</b></label><br>
        <input type="text" id="descricao" name="descricao" value="<?php echo ($portaria->nome ?? ''); ?>" size="100" autofocus>
    </div>
    <div class="form-group">
        <label for="tipo" style="margin:0px"><b>Tipo: &nbsp;</b></label><br>
        <select name="tipo" id="tipo">
            <option value="1" <?php echo ($tipo == 1) ? 'selected' : ''; ?>>Matriz &nbsp;&nbsp;</option>
            <option value="2" <?php echo ($tipo == 2) ? 'selected' : ''; ?>>Filial &nbsp;&nbsp;</option>
            <option value="3" <?php echo ($tipo == 3) ? 'selected' : ''; ?>>Cooperado &nbsp;&nbsp;</option>
        </select>
    </div>

    <input type="hidden" id="status" name="status" value="<?php echo ($unidade->status ?? '0'); ?>">
    <button type="submit" value="<?php echo ucfirst($acao); ?>" class="btn botao"><?php echo ucfirst($acao); ?></button>
</form>