<form class="col-12" method="post" action="index.php?control=unidade&action=<?php echo $acao; ?>">
    <input type="hidden" name="_token" value="<?php echo $_SESSION['csrf']; ?>">

    <div class="form-group">
        <label for="id" style="margin:0px"><b>ID: &nbsp;</b></label><br>
        <input type="number" id="id" name="id" readonly value="<?php echo ($unidade->id ?? '0'); ?>">
    </div>
    <div class="form-group">
        <label for="nome" style="margin:0px"><b>Nome: &nbsp;</b></label><br>
        <input type="text" id="nome" name="nome" value="<?php echo ($unidade->nome ?? ''); ?>" size="60" autofocus>
    </div>
    <div class="form-group">
        <label for="cnpj" style="margin:0px"><b>CNPJ: &nbsp;</b></label><br>
        <input type="text" id="cnpj" name="cnpj" value="<?php echo ($unidade->cnpj ?? ''); ?>" size="40">
    </div>
    <div class="form-group">
        <?php
            $tipo = ($unidade->tipo ?? 1);
        ?>
        <label for="tipo" style="margin:0px"><b>Tipo: &nbsp;</b></label><br>
        <select name="tipo" id="tipo">
            <option value="1" <?php echo ($tipo == 1) ? 'selected' : ''; ?>>Matriz &nbsp;&nbsp;</option>
            <option value="2" <?php echo ($tipo == 2) ? 'selected' : ''; ?>>Filial &nbsp;&nbsp;</option>
            <option value="3" <?php echo ($tipo == 3) ? 'selected' : ''; ?>>Cooperado &nbsp;&nbsp;</option>
        </select>
    </div>
    <div class="form-group">
        <label for="endereco" style="margin:0px"><b>Endereço: &nbsp;</b></label><br>
        <input type="text" id="endereco" name="endereco" value="<?php echo ($unidade->endereco ?? ''); ?>" size="100">
    </div>
    <div class="form-group">
        <label for="complemento" style="margin:0px"><b>Complemento: &nbsp;</b></label><br>
        <input type="text" id="complemento" name="complemento" value="<?php echo ($unidade->complemento ?? ''); ?>" size="100">
    </div>
    <div class="form-group">
        <label for="municipio" style="margin:0px"><b>Município/UF: &nbsp;</b></label><br>
        <input type="text" id="municipio" name="municipio" value="<?php echo ($unidade->municipio ?? ''); ?>" size="60">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" id="uf" name="uf" value="<?php echo ($unidade->uf ?? ''); ?>" size="10">
    </div>

    <input type="hidden" id="status" name="status" value="<?php echo ($unidade->status ?? '0'); ?>">
    <button type="submit" value="<?php echo ucfirst($acao); ?>" class="btn botao"><?php echo ucfirst($acao); ?></button>
</form>