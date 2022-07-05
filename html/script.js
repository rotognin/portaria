function buscarVisitantes(){
    var empresa_id = $('#empresa_id').val();

    if (empresa_id > 0){
        var token = $("#_token").val();
        $.get("index.php?control=visitante&action=buscar&empresa_id=" + empresa_id + '&_token=' + token, function(data, status){
            if (status === "success"){
                if (data == ''){
                    alert("Empresa sem visitantes ativos/cadastrados.");
                } else {
                    $("#visitante_id").html(data);
                }
            } else {
                alert("Não foi possível obter a lista dos Visitantes.");
            }
        });
    }
}

function validarMovimentacao(){
    var empresa_id = $("#empresa_id").val();

    if (empresa_id == 0){
        $("#mensagem").html("Necessário informar a empresa").show();
        return false;
    }

    var cracha_id = $("#cracha_id").val();

    if (cracha_id == 0){
        $("#mensagem").html("É necessário selecionar um crachá").show();
        return false;
    }

    var limite_hora_entrada = parseInt($("#param_hora_entrada").data("limitar-hora-entrada"));
    var limite_horario_entrada = $("#param_hora_entrada").data("limite-horario-entrada");

    if (limite_hora_entrada == 1){
        var horario_entrada = $("#hora_entrada").val();

        if (horario_entrada < limite_horario_entrada){
            alert("Hora de abertura abaixo do limite permitido: " + limite_horario_entrada);
            return false;
        }
    }

    return true;
}

function validarMovimentacaoSaida(){
    var limite_hora_saida = parseInt($("#param_hora_saida").data("limitar-hora-saida"));
    var limite_horario_saida = $("#param_hora_saida").data("limite-horario-saida");

    if (limite_hora_saida == 1){
        var horario_saida = $("#hora_saida").val();

        if (horario_saida > limite_horario_saida){
            alert("Hora de saída acima do limite permitido: " + limite_horario_saida);
            return false;
        }
    }

    return true;
}

function inserirAcompanhanteHTML(numero){
    return '<div class="card" id="nro_' + numero + '">' +
            '<div class="card-body">' +
                '<p><b>Acompanhante ' + numero + '</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + 
                '<button id="remove_' + numero + '" type="button" class="btn btn-danger btn-sm" onclick="removerAcompanhante(' + numero + ')">Remover</button></p>' +
                '<div class="form-group margem-baixo">' +
                    '<label for="nome_' + numero + '">Nome: &nbsp;</label>' +
                    '<input type="text" id="nome_' + numero + '" name="nome[]" size="20" required>' +
                    '<label for="documento_' + numero + '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Documento: &nbsp;</label>' +
                    '<input type="text" id="documento_' + numero + '" name="documento[]" size="15">' +
                '</div>' +
                '<div class="form-group margem-baixo">' +
                    '<label for="obsacompanhante_' + numero + '">Observações: &nbsp;</label>' +
                    '<input type="text" id="obsacompanhante_' + numero + '" name="obsacompanhante[]" size="60">' +
                '</div>' +
            '</div>' +
        '</div>';
}

function removerAcompanhante(numero){
    if (numero == 0){
        return;
    }

    $("#nro_" + numero).remove();

    var qtdAcompanhantes = parseInt($("#acompanhantes").data("acompanhantes"));
    qtdAcompanhantes -= 1;
    $("#acompanhantes").data("acompanhantes", qtdAcompanhantes);
    $("#remove_" + qtdAcompanhantes).show();

    $("#btnAddAcompanhantes").show();
}

function adicionarAcompanhante(){
    var nroAcompanhante = parseInt($("#acompanhantes").data("acompanhantes"));
    var maxAcompanhante = parseInt($("#acompanhantes").data("maximo"));

    if (nroAcompanhante == maxAcompanhante){
        alert("Máximo de acompanhantes atingido.");
        return;
    }

    var qtdAcompanhantes = nroAcompanhante;
    nroAcompanhante += 1;
    $("#acompanhantes").data("acompanhantes", nroAcompanhante);

    if (nroAcompanhante == maxAcompanhante){
        $("#btnAddAcompanhantes").hide();
    }

    if (nroAcompanhante == 1){
        $("#acompanhantes").html(inserirAcompanhanteHTML(nroAcompanhante));
        $("#acompanhantes").show();
        return;
    }

    $("#remove_" + qtdAcompanhantes).hide();

    $("#nro_" + qtdAcompanhantes).after(inserirAcompanhanteHTML(nroAcompanhante));
    return;
}

function validarSituacao(){
    if (!$("#emaberto").prop("checked") && !$("#finalizado").prop("checked") && !$("#cancelado").prop("checked")){
        $("#mensagem").html("Favor selecionar pelo menos uma situação.");
        $("#mensagem").show();
        return false;
    }

    return true;
}