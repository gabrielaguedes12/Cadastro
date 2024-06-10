// function gravaFuncionario(id, descricao) {
//     $.ajax({
//         url: 'js/sqlscopeFuncionarioGenero.php',
//         dataType: 'html', //tipo do retorno
//         type: 'post', //metodo de envio
//         data: { funcao: "grava", id: id, descricao : descricao},
//         success: function (data, textStatus) {
//             if (data.indexOf('sucess') < 0) {
//                 var piece = data.split("#");
//                 var mensagem = piece[1];
//                 smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
//                 return '';
//             } else {
//                 smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
//                 setInterval(novo(), 1500)
//             }
//             //retorno dos dados
//         },
//         error: function (xhr, er) {
//             //tratamento de erro
//         }
//     });


//     return '';
// }

function gravaFuncionario(id, descricao, ativo) {
    $.ajax({
        url: 'js/sqlscopeFuncionarioGenero.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: "grava", id: id, descricao: descricao, ativo: ativo}, //valores enviados ao script
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
                //gravar();
            }
            //retorno dos dados
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });
    return '';

}

// function verificarCpf(cpf) {
//     $.ajax({
//         url: 'js/sqlscopeFuncionarioCadastro.php',
//         dataType: ' html',
//         type: 'post',
//         data: { funcao: 'verificaCpf', cpf: cpf },
//         success: function (data, textStatus) {
//             if (data.indexOf('failed') > -1) {
//                 var piece = data.split("#");
//                 var mensagem = piece[1];

//                 if (mensagem !== "") {
//                     smartAlert("Atenção", mensagem, "error");
//                     validaCpf()
//                 } else {
//                     smartAlert("Atenção", "CPF já cadastrado", "error");
//                 }
//             }
//         },
//         error: function (xhr, er) {
//             //tratamento de erro
//         }
//     });
// }

// function validarCpf(cpf) {
//     $.ajax({
//         url: 'js/sqlscopeFuncionarioCadastro.php',
//         dataType: ' html',
//         type: 'post',
//         data: { funcao: 'validaCpf', cpf: cpf },
//         success: function (data, textStatus) {
//             if (data.indexOf('failed') > -1) {
//                 var piece = data.split("#");
//                 var mensagem = piece[1];

//                 if (mensagem !== "") {
//                     smartAlert("Atenção", mensagem, "error");
//                 } else {
//                     smartAlert("Atenção", "CPF inválido", "error");
//                 }
//             }
//         },
//         error: function (xhr, er) {
//             //tratamento de erro
//         }
//     });
// }

// function verificarRg(rg) {
//     $.ajax({
//         url: 'js/sqlscopeFuncionarioCadastro.php',
//         dataType: ' html',
//         type: 'post',
//         data: { funcao: 'verificaRg', rg: rg },
//         success: function (data, textStatus) {
//             if (data.indexOf('failed') > -1) {
//                 var piece = data.split("#");
//                 var mensagem = piece[1];

//                 if (mensagem !== "") {
//                     smartAlert("Atenção", mensagem, "error");
//                 } else {
//                     smartAlert("Atenção", "RG já cadastrado", "error");
//                 }
//             }
//         },
//         error: function (xhr, er) {
//             //tratamento de erro
//         }
//     });
// }

function recuperaFuncionario(descricao) {
    $.ajax({
        url: 'js/sqlscopeFuncionarioGenero.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recupera', id: id}, //valores enviados ao script     
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
                var id = +piece[0];
                var descricao = piece[1];
                var ativo = +piece[2];
                // var cpf = piece[3];
                // var dataNascimento = piece[4];

                // $("#codigo").val(codigo);
                $("#id").val(id);
                $("#descricao").val(descricao);
                $("#ativo").val(ativo);
                // $("#dataNascimento").val(dataNascimento);
                //
                //atribuindo valor 
                return;
            }
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });

    return;
}

function excluirFuncionario(id) {
    $.ajax({
        url: 'js/sqlscopeFuncionarioGenero.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'excluir', id: id}, //valores enviados ao script     
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

function recuperaDadosUsuario(callback) {
    $.ajax({
        url: 'js/sqlscopeFuncionarioGenero.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recuperarDadosUsuario' }, //valores enviados ao script

        success: function (data) {
            callback(data)
        },
    })

    return
}

// function gravaNovaSenha(senha, senhaConfirma, callback) {
//     $.ajax({
//         url: 'js/sqlscopeUsuario.php',
//         dataType: 'html', //tipo do retorno
//         type: 'post', //metodo de envio
//         data: {
//             funcao: 'gravarNovaSenha',
//             senha: senha,
//             senhaConfirma: senhaConfirma,
//         }, //valores enviados ao script
//         success: function (data) {
//             callback(data)
//         },
//     })
// }