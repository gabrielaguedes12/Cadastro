function gravaFuncionario(id, ativo, nome, cpf, rg, dataNascimento, estadoCivil, descricao, jsonTelefoneArray, jsonEmailArray) {
    $.ajax({
        url: 'js/sqlscopeFuncionarioCadastro.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: "grava", id: id, ativo: ativo, nome: nome, cpf: cpf, rg: rg, dataNascimento: dataNascimento, estadoCivil: estadoCivil, descricao: descricao, jsonTelefoneArray: jsonTelefoneArray, jsonEmailArray: jsonEmailArray },
        success: function (data, textStatus) {
            if (data.indexOf('sucess') < 0) {
                var piece = data.split("#");
                var mensagem = piece[1];
                smartAlert("Atenção", "Operação não realizada - entre em contato com a GIR!", "error");
                return '';
            } else {
                smartAlert("Sucesso", "Operação realizada com sucesso!", "success");
                setInterval(novo(), 1500)
            }
            //retorno dos dados
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });

       return '';
}

function verificarCpf(cpf) {
    $.ajax({
        url: 'js/sqlscopeFuncionarioCadastro.php',
        dataType: ' html',
        type: 'post',
        data: { funcao: 'verificaCpf', cpf: cpf },
        success: function (data, textStatus) {
            if (data.indexOf('failed') > -1) {
                var piece = data.split("#");
                var mensagem = piece[1];

                if (mensagem !== "") {
                    smartAlert("Atenção", mensagem, "error");
                    validaCpf()
                } else {
                    smartAlert("Atenção", "CPF já cadastrado", "error");
                }
            }
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });
}

function validarCpf(cpf) {
    $.ajax({
        url: 'js/sqlscopeFuncionarioCadastro.php',
        dataType: ' html',
        type: 'post',
        data: { funcao: 'validaCpf', cpf: cpf },
        success: function (data, textStatus) {
            if (data.indexOf('failed') > -1) {
                var piece = data.split("#");
                var mensagem = piece[1];

                if (mensagem !== "") {
                    smartAlert("Atenção", mensagem, "error");
                } else {
                    smartAlert("Atenção", "CPF inválido", "error");
                }
            }
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });
}

function verificarRg(rg) {
    $.ajax({
        url: 'js/sqlscopeFuncionarioCadastro.php',
        dataType: ' html',
        type: 'post',
        data: { funcao: 'verificaRg', rg: rg },
        success: function (data, textStatus) {
            if (data.indexOf('failed') > -1) {
                var piece = data.split("#");
                var mensagem = piece[1];

                if (mensagem !== "") {
                    smartAlert("Atenção", mensagem, "error");
                } else {
                    smartAlert("Atenção", "RG já cadastrado", "error");
                }
            }
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });
}

function recuperaFuncionario(id) {
    $.ajax({
        url: 'js/sqlscopeFuncionarioCadastro.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'recupera', id: id }, //valores enviados ao script     
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
                var strarrayTelefone = piece[2];
                var strarrayEmail = piece[3];

                piece = out.split("^");

                var codigo = +piece[0];
                var nome = piece[1];
                var ativo = +piece[2];
                var cpf = piece[3];
                var rg = piece[4];
                var dataNascimento = piece[5];
                var estadoCivil = piece[6];
                var descricao = piece[7];


                $("#codigo").val(codigo);
                $("#nome").val(nome);
                $("#ativo").val(ativo);
                $("#cpf").val(cpf);
                $("#rg").val(rg);
                $("#dataNascimento").val(dataNascimento);
                $("#estadoCivil").val(estadoCivil);
                $("#descricao").val(descricao);

                //atribuindo valor 
                if (ativo === 1) {
                    $('#ativo').prop('checked', true);
                } else {
                    $('#ativo').prop('checked', false);
                }

                idade($("#dataNascimento").val());

                $("#jsonTelefone").val(strarrayTelefone)
                jsonTelefoneArray = JSON.parse($("#jsonTelefone").val());
                fillTableTelefone();

                $("#jsonEmail").val(strarrayEmail)
                jsonEmailArray = JSON.parse($("#jsonEmail").val());
                fillTableEmail();
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
        url: 'js/sqlscopeFuncionarioCadastro.php', //caminho do arquivo a ser executado
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: { funcao: 'excluir', id: id }, //valores enviados ao script     
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
