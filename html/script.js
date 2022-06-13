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