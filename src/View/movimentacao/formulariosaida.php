<form class="col-12" method="post" 
      action="index.php?control=movimentacao&action=finalizar">
    <input type="hidden" id="_token" name="_token" value="<?php echo $_SESSION['csrf']; ?>">
    <input type="hidden" id="movimentacao_id" name="movimentacao_id" value="<?php echo $movimentacao->id; ?>">

    <div class="form-group margem-baixo">
        <label for="id" style="margin:0px"><b>ID: &nbsp;</b></label>
        <input type="number" id="id" name="id" readonly 
               value="<?php echo ($movimentacao->id ?? '0'); ?>" 
               size="5">
    </div>
    <div class="form-group margem-baixo">
        <label for="empresa_id" style="margin:0px"><b>Empresa: &nbsp;</b></label>
        <input type="text" id="empresa_id" name="empresa_id" value="<?php echo $movimentacao->visitante->empresa_id; ?>" size="5" readonly>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" id="empresa_nome" name="empresa_nome" value="<?php echo $movimentacao->visitante->empresa->nome; ?>" size="30" readonly>
    </div>
    <div class="form-group margem-baixo">
        <label for="visitante_id" style="margin:0px"><b>Visitante: &nbsp;</b></label>
        <input type="text" id="visitante_id" name="visitante_id" value="<?php echo $movimentacao->visitante_id; ?>" size="5" readonly>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" id="visitante_nome" name="visitante_nome" value="<?php echo $movimentacao->visitante->nome; ?>" size="30" readonly>
    </div>
    <div class="form-group margem-baixo">
        <label for="cracha" style="margin:0px"><b>Crachá: &nbsp;</b></label>
        <input type="text" id="cracha" name="cracha" value="<?php echo $movimentacao->cracha->identificacao; ?>" size="15" readonly>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <label for="placa" style="margin:0px"><b>Placa veículo: &nbsp;</b></label>
        <input type="text" id="placa" name="placa" value="<?php echo $movimentacao->placa; ?>" size="10" readonly>
    </div>
    <div class="form-group margem-baixo">
        <label for="data_entrada" style="margin:0px"><b>Data da Entrada: &nbsp;</b></label>
        <input type="text" id="data_entrada" name="data_entrada" value="<?php echo $movimentacao->data_entrada; ?>" readonly>
        <label for="hora_entrada" style="margin:0px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Hora da Entrada: &nbsp;</b></label>
        <input type="text" id="hora_entrada" name="hora_entrada" value="<?php echo $movimentacao->hora_entrada; ?>" readonly>
    </div>
    <div class="form-group margem-baixo">
        <label for="contato"><b>Contato interno: &nbsp;</b></label>
        <input type="text" id="contato" name="contato" value="<?php echo $movimentacao->contato; ?>" size="80" readonly>
    </div>
    <div class="form-group margem-baixo">
        <label for="motivo"><b>Motivo: &nbsp;</b></label>
        <input type="text" id="motivo" name="motivo" value="<?php echo $movimentacao->motivo; ?>" size="80" readonly>
    </div>
    <div class="form-group margem-baixo">
        <label for="observacoes"><b>Observações: &nbsp;</b></label>
        <input type="text" id="observacoes" name="observacoes" value="<?php echo $movimentacao->observacoes; ?>" size="100" readonly>
    </div>

    <br>
    <button type="submit" value="Finalizar" class="btn botao">Finalizar</button>
</form>