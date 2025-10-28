<form class="col-12" method="post" action="index.php?control=parametro&action=gravar">
    <input type="hidden" name="_token" value="<?php echo $_SESSION['csrf']; ?>">
    <input type="hidden" name="unidade_id" value="<?php echo $unidade->id; ?>">

    <div class="form-group">
        <label for="id" style="margin:0px"><b>ID: &nbsp;</b></label><br>
        <input type="number" id="id" name="id" readonly value="<?php echo ($parametro->id ?? '0'); ?>">
    </div>

    <div class="form-group">
        <label for="limite_acompanhantes" style="margin:0px"><b>Limite de acompanhantes: &nbsp;</b></label><br>
        <input type="number" id="limite_acompanhantes" 
               name="limite_acompanhantes" 
               value="<?php echo ($parametro->limite_acompanhantes ?? '0'); ?>" autofocus>
    </div>

    <div class="form-group">
        <label for="limite_horario_entrada" style="margin:0px"><b>Horário mínimo de entrada: &nbsp;</b></label><br>
        <input type="time" id="limite_horario_entrada" 
               name="limite_horario_entrada" value="<?php echo ($parametro->limite_horario_entrada ?? '00:00'); ?>">
        <input type="checkbox" id="limitar_hora_entrada" name="limitar_hora_entrada" 
               value="1" style="margin-left:10px"
            <?php
                $checked = (($parametro->limitar_hora_entrada ?? 0) != 0) ? ' checked ' : '';
                echo $checked;
            ?>>
        <label for="limitar_hora_entrada">Limitar o horário de entrada</label>
    </div>

    <div class="form-group">
        <label for="limite_horario_saida" style="margin:0px"><b>Horário máximo de saída: &nbsp;</b></label><br>
        <input type="time" id="limite_horario_saida" 
               name="limite_horario_saida" value="<?php echo ($parametro->limite_horario_saida ?? '00:00'); ?>">
        <input type="checkbox" id="limitar_hora_saida" name="limitar_hora_saida" 
               value="1" style="margin-left:10px"
            <?php
                $checked = (($parametro->limitar_hora_saida ?? 0) != 0) ? ' checked ' : '';
                echo $checked;
            ?>>
        <label for="limitar_hora_saida">Limitar o horário de saída</label>
    </div>

    <div class="form-group">
        <input type="checkbox" id="motivo_obrigatorio" name="motivo_obrigatorio" 
               value="1" style="margin-left:10px"
            <?php
                $checked = (($parametro->motivo_obrigatorio ?? 0) != 0) ? ' checked ' : '';
                echo $checked;
            ?>>
        <label for="motivo_obrigatorio">Obrigatório informar o motivo na entrada</label>
    </div>

    <button type="submit" value="Gravar" class="btn botao">Gravar</button>
</form>