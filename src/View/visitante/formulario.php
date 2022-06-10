<form class="col-12" method="post" action="index.php?control=visitante&action=<?php echo $acao; ?>">
    <input type="hidden" name="_token" value="<?php echo $_SESSION['csrf']; ?>">

    <div class="form-group">
        <label for="id" style="margin:0px"><b>ID: &nbsp;</b></label><br>
        <input type="number" id="id" name="id" readonly value="<?php echo ($visitante->id ?? '0'); ?>">
    </div>
    <div class="form-group">
        <label for="nome" style="margin:0px"><b>Nome: &nbsp;</b></label><br>
        <input type="text" id="nome" name="nome" value="<?php echo ($visitante->nome ?? ''); ?>" size="100" autofocus>
    </div>
    <div class="form-group">
        <label for="documento" style="margin:0px"><b>Documento: &nbsp;</b></label><br>
        <input type="text" id="documento" name="documento" value="<?php echo ($visitante->documento ?? ''); ?>" size="30">
    </div>
    <div class="form-group">
        <label for="telefone" style="margin:0px"><b>Telefone: &nbsp;</b></label><br>
        <input type="text" id="telefone" name="telefone" value="<?php echo ($visitante->telefone ?? ''); ?>" size="30">
    </div>
    
    <input type="hidden" id="status" name="status" value="<?php echo ($visitante->status ?? '0'); ?>">
    <input type="hidden" id="empresa_id" name="empresa_id" value="<?php echo ($visitante->empresa_id ?? $empresa_id); ?>">
    <button type="submit" value="<?php echo ucfirst($acao); ?>" class="btn botao"><?php echo ucfirst($acao); ?></button>
</form>