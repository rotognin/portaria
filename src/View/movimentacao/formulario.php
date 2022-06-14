<form class="col-12" method="post" 
      onsubmit="return validarMovimentacao()" 
      action="index.php?control=movimentacao&action=<?php echo $acao; ?>">
    <input type="hidden" id="_token" name="_token" value="<?php echo $_SESSION['csrf']; ?>">
    <input type="hidden" id="movimentacao_id" name="movimentacao_id" value="0">

    <div class="form-group margem-baixo">
        <label for="id" style="margin:0px"><b>ID: &nbsp;</b></label>
        <input type="number" id="id" name="id" readonly 
               value="<?php echo ($movimentacao->id ?? '0'); ?>" 
               size="5">
    </div>
    <div class="form-group margem-baixo">
        <label for="empresa_id" style="margin:0px"><b>Empresa: &nbsp;</b></label>
        <select id="empresa_id" name="empresa_id" onchange="buscarVisitantes()">
        <?php
            echo '<option value="0">Selecione a empresa...</option>';
            foreach ($empresas as $empresa){
                echo '<option value="' . $empresa->id . '">';
                    echo $empresa->nome . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                echo '</option>';
            }
        ?>
        </select>
        <label for="visitante_id" style="margin:0px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Visitante: &nbsp;</b></label>
        <select id="visitante_id" name="visitante_id">

        </select>
    </div>

    <div class="form-group margem-baixo">
        <label for="cracha_id" style="margin:0px"><b>Crachá: &nbsp;</b></label>
        <select id="cracha_id" name="cracha_id">
        <?php
            echo '<option value="0">Selecione o crachá...</option>';
            foreach ($crachas as $cracha){
                echo '<option value="' . $cracha->id . '">';
                    echo $cracha->identificacao . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                echo '</option>';
            }
        ?>
        </select>
    </div>

    <div class="form-group margem-baixo">
        <label for="placa" style="margin:0px"><b>Placa veículo: &nbsp;</b></label>
        <input type="text" id="placa" name="placa" value="<?php echo ($movimentacao->placa ?? ''); ?>" size="10">
    </div>

    <div class="form-group margem-baixo">
        <label for="data_entrada" style="margin:0px"><b>Data da Entrada: &nbsp;</b></label>
        <input type="date" id="data_entrada" name="data_entrada" value="<?php echo date('Y-m-d'); ?>">
        <label for="hora_entrada" style="margin:0px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Hora da Entrada: &nbsp;</b></label>
        <input type="time" id="hora_entrada" name="hora_entrada" value="<?php echo date('H:i'); ?>">
    </div>
    
    <div class="form-group margem-baixo">
        <label for="contato"><b>Contato interno: &nbsp;</b></label>
        <input type="text" id="contato" name="contato" value="<?php echo ($movimentacao->contato ?? ''); ?>" size="80">
    </div>
    <div class="form-group margem-baixo">
        <label for="motivo"><b>Motivo: &nbsp;</b></label>
        <input type="text" id="motivo" name="motivo" value="<?php echo ($movimentacao->motivo ?? ''); ?>" size="80">
    </div>
    <div class="form-group margem-baixo">
        <label for="observacoes"><b>Observações: &nbsp;</b></label>
        <input type="text" id="observacoes" name="observacoes" value="<?php echo ($movimentacao->observacoes ?? ''); ?>" size="100">
    </div>
    
    
    <button type="button" class="btn btn-primary margem-baixo" onclick="adicionarAcompanhante()">Adicionar Acompanhante</button>
    <div id="acompanhantes" style="display:none" data-acompanhantes="0">
        
    </div>

    <div class="alert alert-danger" role="alert" id="mensagem" style="display:none">
    </div>

    <br>
    <button type="submit" value="<?php echo ucfirst($acao); ?>" class="btn botao"><?php echo ucfirst($acao); ?></button>
</form>