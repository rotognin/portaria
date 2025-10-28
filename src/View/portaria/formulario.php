<form class="col-12" method="post" action="index.php?control=portaria&action=<?php echo $acao; ?>">
    <input type="hidden" name="_token" value="<?php echo $_SESSION['csrf']; ?>">

    <div class="form-group">
        <label for="id" style="margin:0px"><b>ID: &nbsp;</b></label><br>
        <input type="number" id="id" name="id" readonly value="<?php echo ($portaria->id ?? '0'); ?>">
    </div>
    <div class="form-group">
        <label for="descricao" style="margin:0px"><b>Descrição: &nbsp;</b></label><br>
        <input type="text" id="descricao" name="descricao" value="<?php echo ($portaria->descricao ?? ''); ?>" size="100" autofocus>
    </div>
    <div class="form-group">
        <label for="unidade_id" style="margin:0px"><b>Unidade: &nbsp;</b></label><br>
        <select name="unidade_id" id="unidade_id">
        <?php
            $unidade_id = $portaria->unidade_id ?? 0;

            foreach($unidades as $unidade){
                echo '<option value="' . $unidade->id . '" ';

                if ($unidade_id == $unidade->id){
                    echo 'selected';
                }

                echo '>' . $unidade->id . ' - ' . $unidade->nome . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>';
            }
        ?>
        </select>
    </div>

    <div class="form-group">
        <label for="tipo_passagem" style="margin:0px"><b>Tipo de passagem: &nbsp;</b></label><br>
        <select name="tipo_passagem" id="tipo_passagem">
        <?php
            $tipo_passagem = $portaria->tipo_passagem ?? 1;
        ?>
            <option value="1"
            <?php
                echo ($tipo_passagem == 1) ? ' selected' : '';
            ?>
            >Pessoas e Veículos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
            <option value="2"
            <?php
                echo ($tipo_passagem == 2) ? ' selected' : '';
            ?>
            >Pessoas apenas</option>
            <option value="3"
            <?php
                echo ($tipo_passagem == 3) ? ' selected' : '';
            ?>
            >Veículos apenas</option>
        </select>
    </div>

    <input type="hidden" id="status" name="status" value="<?php echo ($portaria->status ?? '0'); ?>">
    <button type="submit" value="<?php echo ucfirst($acao); ?>" class="btn botao"><?php echo ucfirst($acao); ?></button>
</form>