<form class="col-12" method="post" action="#">
    <input type="hidden" id="movimentacao_id" name="movimentacao_id" value="<?php echo $movimentacao->id; ?>">
    <input type="hidden" id="status" name="status" value="1">

    <div class="form-group margem-baixo">
        <label for="id" style="margin:0px"><b>ID: &nbsp;</b></label>
        <input type="number" id="id" name="id" readonly 
               value="<?php echo ($movimentacao->id ?? '0'); ?>" 
               size="5" class="sem-borda">
        <label for="descricao_status" style="margin:0px"><b>Situação: &nbsp;</b></label>
        <input type="text" id="descricao_status" name="descricao_status" readonly
               value="<?php echo STATUS_MOVIMENTACAO[$movimentacao->status]; ?>" 
               size="15" class="sem-borda">
    </div>
    <div class="form-group margem-baixo">
        <label for="unidade_id" style="margin:0px"><b>Unidade: &nbsp;</b></label>
        <input type="text" id="unidade_id" name="unidade_id" class="sem-borda"
               value="<?php echo $movimentacao->unidade->id; ?>" size="5" readonly>
        <input type="text" id="unidade_nome" name="unidade_nome" class="sem-borda"
               value="<?php echo $movimentacao->unidade->nome; ?>" size="30" readonly>
    </div>
    <div class="form-group margem-baixo">
        <label for="empresa_id" style="margin:0px"><b>Empresa: &nbsp;</b></label>
        <input type="text" id="empresa_id" name="empresa_id" class="sem-borda"
               value="<?php echo $movimentacao->visitante->empresa_id; ?>" size="5" readonly>
        <input type="text" id="empresa_nome" name="empresa_nome" class="sem-borda"
               value="<?php echo $movimentacao->visitante->empresa->nome; ?>" size="30" readonly>
    </div>
    <div class="form-group margem-baixo">
        <label for="visitante_id" style="margin:0px"><b>Visitante: &nbsp;</b></label>
        <input type="text" id="visitante_id" name="visitante_id" class="sem-borda"
               value="<?php echo $movimentacao->visitante_id; ?>" size="5" readonly>
        <input type="text" id="visitante_nome" name="visitante_nome" class="sem-borda"
               value="<?php echo $movimentacao->visitante->nome; ?>" size="30" readonly>
    </div>
    <div class="form-group margem-baixo">
        <label for="cracha_id" style="margin:0px"><b>Crachá: &nbsp;</b></label>
        <input type="text" id="cracha_id" name="cracha_id" class="sem-borda"
               value="<?php echo $movimentacao->cracha_id; ?>" size="5" readonly>
        <input type="text" id="cracha" name="cracha" class="sem-borda"
               value="<?php echo $movimentacao->cracha->identificacao; ?>" size="15" readonly>
        <label for="placa" style="margin:0px"><b>Placa veículo: &nbsp;</b></label>
        <input type="text" id="placa" name="placa" class="sem-borda"
               value="<?php echo $movimentacao->placa; ?>" size="10" readonly>
    </div>

    <div class="form-group margem-baixo">
        <label for="contato" style="margin:0px"><b>Contato interno: &nbsp;</b></label>
        <input type="text" id="contato" name="contato" class="sem-borda"
               value="<?php echo $movimentacao->contato; ?>" size="80" readonly>
    </div>
    <div class="form-group margem-baixo">
        <label for="motivo" style="margin:0px"><b>Motivo: &nbsp;</b></label>
        <input type="text" id="motivo" name="motivo" class="sem-borda"
               value="<?php echo $movimentacao->motivo; ?>" size="80" readonly>
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
        <label for="observacoes" style="margin:0px"><b>Observações: &nbsp;</b></label>
        <input type="text" id="observacoes" name="observacoes" class="sem-borda"
               value="<?php echo $movimentacao->observacoes; ?>" size="100"
               readonly>
    </div>

    <?php
        if ($movimentacao->status == 2){
        ?>
            <div class="form-group margem-baixo">
                <label for="cancelamento" style="margin:0px"><b>Motivo do cancelamento: &nbsp;</b></label>
                <input type="text" id="cancelamento" name="cancelamento" class="sem-borda"
                    value="<?php echo $movimentacao->cancelamento; ?>" size="100" readonly>
            </div>
        <?php
        }
    ?>

    <p style="margin:0px"><b>------------------------------ Dados de Entrada ------------------------------ </b></p>
    <div class="form-group margem-baixo">
        <label for="data_entrada" style="margin:0px"><b>Data: &nbsp;</b></label>
        <input type="date" id="data_entrada" name="data_entrada" class="sem-borda"
               value="<?php echo $movimentacao->data_entrada; ?>" readonly>
        <label for="hora_entrada" style="margin:0px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Hora: &nbsp;</b></label>
        <input type="time" id="hora_entrada" name="hora_entrada" class="sem-borda"
               value="<?php echo $movimentacao->hora_entrada; ?>" readonly>
    </div>
    <div class="form-group margem-baixo">
        <label for="portaria_entrada_id" style="margin:0px"><b>Portaria: &nbsp;</b></label>
        <input type="text" id="portaria_entrada_id" name="portaria_entrada_id" class="sem-borda"
               value="<?php echo $movimentacao->portaria_entrada->id; ?>" size="5" readonly>
        <input type="text" id="portaria_entrada_descricao" name="portaria_entrada_descricao" class="sem-borda"
               value="<?php echo $movimentacao->portaria_entrada->descricao; ?>" size="40" readonly>
    </div>
    <div class="form-group margem-baixo">
        <label for="usuario_entrada_id" style="margin:0px"><b>Usuário: &nbsp;</b></label>
        <input type="text" id="usuario_entrada_id" name="usuario_entrada_id" class="sem-borda"
               value="<?php echo $movimentacao->usuario_entrada->id; ?>" size="5" readonly>
        <input type="text" id="usuario_entrada_nome" name="usuario_entrada_nome" class="sem-borda"
               value="<?php echo $movimentacao->usuario_entrada->nome; ?>" size="40" readonly>
    </div>

    <?php 
        if ($movimentacao->status == 1){
        ?>
            <p style="margin:0px"><b>------------------------------ Dados de Saída ------------------------------ </b></p>
            <div class="form-group margem-baixo">
                <label for="data_saida" style="margin:0px"><b>Data: &nbsp;</b></label>
                <input type="date" id="data_saida" name="data_saida" class="sem-borda"
                    value="<?php echo $movimentacao->data_saida; ?>" readonly>
                <label for="hora_saida" style="margin:0px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Hora: &nbsp;</b></label>
                <input type="time" id="hora_saida" name="hora_saida" class="sem-borda"
                    value="<?php echo $movimentacao->hora_saida; ?>" readonly>
            </div>
            <div class="form-group margem-baixo">
                <label for="portaria_saida_id" style="margin:0px"><b>Portaria: &nbsp;</b></label>
                <input type="text" id="portaria_saida_id" name="portaria_saida_id" class="sem-borda"
                    value="<?php echo $movimentacao->portaria_saida->id; ?>" size="5" readonly>
                <input type="text" id="portaria_saida_descricao" name="portaria_saida_descricao" class="sem-borda"
                    value="<?php echo $movimentacao->portaria_saida->descricao; ?>" size="40" readonly>
            </div>
            <div class="form-group margem-baixo">
                <label for="usuario_saida_id" style="margin:0px"><b>Usuário: &nbsp;</b></label>
                <input type="text" id="usuario_saida_id" name="usuario_saida_id" class="sem-borda"
                    value="<?php echo $movimentacao->usuario_saida->id; ?>" size="5" readonly>
                <input type="text" id="usuario_saida_nome" name="usuario_saida_nome" class="sem-borda"
                    value="<?php echo $movimentacao->usuario_saida->nome; ?>" size="40" readonly>
            </div>
        <?php
        }
    ?>

    
</form>