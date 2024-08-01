function gravarDependentes(codigo, tipo, ativo) {
    $.ajax({
        url: 'js/sqlscopeFuncionarioDependentes.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'gravarDependentes', codigo: codigo, tipo: tipo, ativo: ativo }, //valores enviados ao script
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
                    smartAlert("Atenção", mensagem, "error");
                } else {
                    smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                }
                return '';
            } else {
                smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
                voltar();
            }
            //retorno dos dados
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });
    return '';

}

function recuperaDependentes(codigo) {
    $.ajax({
        url: 'js/sqlscopeFuncionarioDependentes.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperaDependentes', codigo: codigo }, //valores enviados ao script     
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
                var tipo = piece[1];
                var ativo = +piece[2];

                $("#codigo").val(codigo);
                $("#tipo").val(tipo);
                $("#ativo").val(ativo);

                return;
            }
        },
        error: function (xhr, er) {

        }
    });

    return;
}

function excluirDependentes(codigo) {
    $.ajax({
        url: 'js/sqlscopeFuncionarioDependentes.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'excluirDependentes', codigo: codigo }, //valores enviados ao script     
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

                if (mensagem !== "") {
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

function verificarDependentes(tipo) {
    $.ajax({
        url: 'js/sqlscopeFuncionarioDependentes.php',
        dataType: ' html',
        type: 'post',
        async: true,
        data: { funcao: 'verificaDependentes', tipo: tipo },
        success: function (data, textStatus) {
            if (data.indexOf('success') > -1) {
                var piece = data.split("#");
                var status = piece[0];

                if (status == 'success') {
                    $("#tipo").val('');
                }
            }

        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });
}