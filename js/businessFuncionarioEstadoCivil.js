function gravaEstadoCivil(codigo, estadoCivil, ativo) {
    $.ajax({
        url: 'js/sqlscopeFuncionarioEstadoCivil.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'gravaEstadoCivil', codigo: codigo, estadoCivil: estadoCivil, ativo: ativo }, //valores enviados ao script
        beforeSend: function () {
            //função chamada antes de realizar o ajax
        },
        complete: function () {
            //função executada depois de terminar o ajax
        },
        success: function (data, textStatus) {
            if (data.indexOf('success') < 0) {
                var piece = data.split("#");
                var mensagem = piece[1];
                if (mensagem !== "") {
                    smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
                    return '';
                } else {
                    smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                    setInterval(voltar(), 1500)
                }
            }
            //retorno dos dados
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });
    return '';
}


function recuperaEstadoCivil(codigo) {
    $.ajax({
        url: 'js/sqlscopeFuncionarioEstadoCivil.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperaEstadoCivil', codigo: codigo }, //valores enviados ao script     
        beforeSend: function () {
            //função chamada antes de realizar o ajax
        },
        complete: function () {
            //função executada depois de terminar o ajax
        },
        success: function (data, textStatus) {
            if (data.indexOf('failed') > -1) {
                return;
            } else {
                data = data.replace(/failed/g, '');
                var piece = data.split("#");

                var mensagem = piece[0];
                var out = piece[1];
                piece = out.split("^");
                var codigo = +piece[0];
                var estadoCivil = piece[1];
                var ativo = +piece[2];

                $("#codigo").val(codigo);
                $("#estadoCivil").val(estadoCivil);
                $("#ativo").val(ativo);

                if (ativo === 1) {
                    $('#btnExcluir').removeClass('hidden');
                }
                return;
            }
        },
        error: function (xhr, er) {

        }
    });

    return;
}

function excluirEstadoCivil(codigo) {
    $.ajax({
        url: 'js/sqlscopeFuncionarioEstadoCivil.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'excluirEstadoCivil', codigo: codigo }, //valores enviados ao script     
        beforeSend: function () {
            //função chamada antes de realizar o ajax
        },
        complete: function () {
            //função executada depois de terminar o ajax
        },
        success: function (data, textStatus) {
            if (data.indexOf('failed') > -1) {
                var piece = data.split("#");
                var mensagem = piece[1];

                if (mensagem !== "=") {
                    smartAlert("Atenção", mensagem, "error");
                } else {
                    smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
                }
                novo();
            } else {
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                novo();
            }
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });
}

