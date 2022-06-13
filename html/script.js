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

    return true;
}

function inserirAcompanhanteHTML(numero){
    return '<div class="card" id="nro_' + numero + '">' +
            '<div class="card-body">' +
                '<p><b>Acompanhante ' + numero + '</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + 
                '<button type="button" class="btn btn-danger btn-sm" onclick="removerAcompanhante(' + numero + ')">Remover</button></p>' +
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
}

function adicionarAcompanhante(){
    var nroAcompanhante = parseInt($("#acompanhantes").data("acompanhantes"));
    var qtdAcompanhantes = nroAcompanhante;
    nroAcompanhante += 1;
    $("#acompanhantes").data("acompanhantes", nroAcompanhante);

    if (nroAcompanhante == 1){
        $("#acompanhantes").html(inserirAcompanhanteHTML(nroAcompanhante));
        $("#acompanhantes").show();
        return;
    }

    $("#nro_" + qtdAcompanhantes).after(inserirAcompanhanteHTML(nroAcompanhante));
    return;
}