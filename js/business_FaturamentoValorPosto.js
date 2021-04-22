function gravaValorPosto(valorPosto, callback) {
    $.ajax({
        url: 'js/sqlscope_faturamentoValorPosto.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'gravaValorPosto', valorPosto: valorPosto },

        success: function (data) {
            callback(data);
        }
    });
}

function recuperaValorPosto(id, callback) {
    $.ajax({
        url: 'js/sqlscope_faturamentoValorPosto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperaValorPosto', id: id }, //valores enviados ao script      
        success: function (data) {
            callback(data);
        }
    });
}


function excluirValorPosto(id, callback) {
    $.ajax({
        url: 'js/sqlscope_faturamentoValorPosto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'excluirValorPosto', id: id },
        success: function (data) {
            callback(data);
        }
    });
}

function recuperaDadosBdi(bdi, callback) {
    $.ajax({
        url: 'js/sqlscope_faturamentoValorPosto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperarDadosBdi', bdi: bdi }, //valores enviados ao script     
        async: false,
        success: function (data) {
            callback(data);
        }

    });

    return;
}

function recuperaTipoRemuneracao(remuneracao, callback) {
    $.ajax({
        url: 'js/sqlscope_faturamentoValorPosto.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperarTipoRemuneracao', remuneracao: remuneracao }, //valores enviados ao script     
        async: false,
        success: function (data) {
            callback(data);
        }

    });

    return;
}
