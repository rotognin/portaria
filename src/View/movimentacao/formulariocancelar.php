<form class="col-12" method="post" 
      action="index.php?control=movimentacao&action=finalizar">
    <input type="hidden" id="_token" name="_token" value="<?php echo $_SESSION['csrf']; ?>">
    <input type="hidden" id="movimentacao_id" name="movimentacao_id" value="<?php echo $movimentacao->id; ?>">
    <input type="hidden" id="status" name="status" value="2">

    <div class="form-group margem-baixo">
        <label for="id" style="margin:0px"><b>ID: &nbsp;</b></label>
        <input type="number" id="id" name="id" readonly 
               value="<?php echo ($movimentacao->id ?? '0'); ?>" 
               size="5" class="sem-borda">
    </div>
    <div class="form-group margem-baixo">
        <label for="empresa_id" style="margin:0px"><b>Empresa: &nbsp;</b></label>
        <input type="text" id="empresa_id" name="empresa_id" class="sem-borda"
               value="<?php echo $movimentacao->visitante->empresa_id; ?>" size="5" readonly>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" id="empresa_nome" name="empresa_nome" class="sem-borda"
               value="<?php echo $movimentacao->visitante->empresa->nome; ?>" size="30" readonly>
    </div>
    <div class="form-group margem-baixo">
        <label for="visitante_id" style="margin:0px"><b>Visitante: &nbsp;</b></label>
        <input type="text" id="visitante_id" name="visitante_id" class="sem-borda"
               value="<?php echo $movimentacao->visitante_id; ?>" size="5" readonly>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" id="visitante_nome" name="visitante_nome" class="sem-borda"
               value="<?php echo $movimentacao->visitante->nome; ?>" size="30" readonly>
    </div>
    <div class="form-group margem-baixo">
        <label for="cracha_id" style="margin:0px"><b>Crachá: &nbsp;</b></label>
        <input type="text" id="cracha_id" name="cracha_id" class="sem-borda"
               value="<?php echo $movimentacao->cracha_id; ?>" size="5" readonly>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" id="cracha" name="cracha" class="sem-borda"
               value="<?php echo $movimentacao->cracha->identificacao; ?>" size="15" readonly>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <label for="placa" style="margin:0px"><b>Placa veículo: &nbsp;</b></label>
        <input type="text" id="placa" name="placa" class="sem-borda"
               value="<?php echo $movimentacao->placa; ?>" size="10" readonly>
    </div>
    <div class="form-group margem-baixo">
        <label for="data_entrada" style="margin:0px"><b>Data da Entrada: &nbsp;</b></label>
        <input type="date" id="data_entrada" name="data_entrada" class="sem-borda"
               value="<?php echo $movimentacao->data_entrada; ?>" readonly>
        <label for="hora_entrada" style="margin:0px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Hora da Entrada: &nbsp;</b></label>
        <input type="time" id="hora_entrada" name="hora_entrada" class="sem-borda"
               value="<?php echo $movimentacao->hora_entrada; ?>" readonly>
    </div>
    <div class="form-group margem-baixo">
        <label for="contato"><b>Contato interno: &nbsp;</b></label>
        <input type="text" id="contato" name="contato" class="sem-borda"
               value="<?php echo $movimentacao->contato; ?>" size="80" readonly>
    </div>
    <div class="form-group margem-baixo">
        <label for="motivo"><b>Motivo: &nbsp;</b></label>
        <input type="text" id="motivo" name="motivo" class="sem-borda"
               value="<?php echo $movimentacao->motivo; ?>" size="80" readonly>
    </div>
    <div class="form-group margem-baixo">
        <label for="observacoes"><b>Observações: &nbsp;</b></label>
        <input type="text" id="observacoes" name="observacoes" class="sem-borda"
               value="<?php echo $movimentacao->observacoes; ?>" size="80" readonly>
    </div>
    <div class="form-group margem-baixo">
        <label for="acompanhantes"><b>Acompanhantes: &nbsp;</b></label>
        <?php
            if ($movimentacao->acompanhantes){
                $lista = '';
                foreach($movimentacao->acompanhantes as $acompanhante){
                    $lista .= $acompanhante->nome . ', ';
                }

                echo substr($lista, 0, -2);
            } else {
                echo '<i>Sem acompanhantes...</i>';
            }
        ?>
    </div>
    <div class="form-group margem-baixo">
        <label for="cancelamento"><b>Motivo do cancelamento: &nbsp;</b></label>
        <input type="text" id="cancelamento" name="cancelamento" 
               value="<?php echo $movimentacao->cancelamento; ?>" size="100"
               autofocus>
    </div>
    <div class="form-group margem-baixo">
        <label for="data_saida" style="margin:0px"><b>Data do Cancelamento: &nbsp;</b></label>
        <input type="date" id="data_saida" name="data_saida" value="<?php echo date('Y-m-d'); ?>">
        <label for="hora_saida" style="margin:0px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Hora do Cancelamento: &nbsp;</b></label>
        <input type="time" id="hora_saida" name="hora_saida" value="<?php echo date('H:i'); ?>">
    </div>

    <br>
    <button type="submit" value="Cancelar" class="btn botao">Cancelar Movimentação</button>
</form>