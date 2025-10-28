<form class="col-12" method="post" 
      onsubmit="return validarSituacao()"
      action="index.php?control=relatorio&action=filtrar">
    <input type="hidden" id="_token" name="_token" value="<?php echo $_SESSION['csrf']; ?>">

    <div class="form-group margem-baixo">
        <label style="margin:0px"><b>Período: &nbsp;</b></label>
        <input type="date" id="data_inicial" name="data_inicial" value="<?php echo date('Y-m-d'); ?>">
        <input type="date" id="data_final" name="data_final" value="<?php echo date('Y-m-d'); ?>">
    </div>

    <div class="form-group">
        <label style="margin:0px"><b>Situação: &nbsp;</b></label>
        <input type="checkbox" id="emaberto" name="emaberto" value="Em Aberto" checked>
        <label for="emaberto">Em aberto</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="checkbox" id="finalizado" name="finalizado" value="Finalizado">
        <label for="finalizado">Finalizado</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="checkbox" id="cancelado" name="cancelado" value="Cancelado">
        <label for="cancelado">Cancelado</label>
    </div>

    <div class="alert alert-danger" role="alert" id="mensagem" style="display:none">
    </div>

    <br>
    <button type="submit" value="Filtrar" class="btn botao">Filtrar</button>
</form>