<form class="col-12" method="post" action="index.php?control=empresa&action=<?php echo $acao; ?>">
    <input type="hidden" name="_token" value="<?php echo $_SESSION['csrf']; ?>">

    <div class="form-group">
        <label for="id" style="margin:0px"><b>ID: &nbsp;</b></label><br>
        <input type="number" id="id" name="id" readonly value="<?php echo ($empresa->id ?? '0'); ?>">
    </div>
    <div class="form-group">
        <label for="nome" style="margin:0px"><b>Nome: &nbsp;</b></label><br>
        <input type="text" id="nome" name="nome" value="<?php echo ($empresa->nome ?? ''); ?>" size="100" autofocus>
    </div>
    <div class="form-group">
        <label for="documento" style="margin:0px"><b>Documento: &nbsp;</b></label><br>
        <input type="text" id="documento" name="documento" value="<?php echo ($empresa->documento ?? ''); ?>" size="30">
    </div>
    <div class="form-group">
        <label for="endereco" style="margin:0px"><b>Endereço: &nbsp;</b></label><br>
        <input type="text" id="endereco" name="endereco" value="<?php echo ($empresa->endereco ?? ''); ?>" size="100">
    </div>
    <div class="form-group">
        <label for="complemento" style="margin:0px"><b>Complemento: &nbsp;</b></label><br>
        <input type="text" id="complemento" name="complemento" value="<?php echo ($empresa->complemento ?? ''); ?>" size="100">
    </div>
    <div class="form-group">
        <label for="cep" style="margin:0px"><b>CEP: &nbsp;</b></label><br>
        <input type="text" id="cep" name="cep" value="<?php echo ($empresa->cep ?? ''); ?>" size="20">
    </div>
    <div class="form-group">
        <label for="municipio" style="margin:0px"><b>Município / UF: &nbsp;</b></label><br>
        <input type="text" id="municipio" name="municipio" value="<?php echo ($empresa->municipio ?? ''); ?>" size="30">
        <input type="text" id="uf" name="uf" 
               value="<?php echo ($empresa->uf ?? ''); ?>" size="3" 
               style="margin-left:10px; text-transform: uppercase;">
    </div>
    <div class="form-group">
        <label for="responsavel" style="margin:0px"><b>Responsável: &nbsp;</b></label><br>
        <input type="text" id="responsavel" name="responsavel" value="<?php echo ($empresa->responsavel ?? ''); ?>" size="100">
    </div>
    <div class="form-group">
        <label for="email" style="margin:0px"><b>E-mail principal: &nbsp;</b></label><br>
        <input type="text" id="email" name="email" value="<?php echo ($empresa->email ?? ''); ?>" size="80">
        <input type="checkbox" id="enviar_email" name="enviar_email" 
               value="1" style="margin-left:10px" 
            <?php
                $checked = (($empresa->enviar_email ?? 0) != 0) ? ' checked ' : '';
                echo $checked;
            ?>>
        <label for="enviar_email">Enviar e-mail ao abrir visita</label>
    </div>
    
    <input type="hidden" id="tipo" name="tipo" value="<?php echo ($empresa->tipo ?? '0'); ?>">
    <input type="hidden" id="status" name="status" value="<?php echo ($empresa->status ?? '0'); ?>">
    <button type="submit" value="<?php echo ucfirst($acao); ?>" class="btn botao"><?php echo ucfirst($acao); ?></button>
</form>