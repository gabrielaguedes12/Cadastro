function gravaFuncionario(id, ativo, nome, cpf, rg, dataNascimento, estadoCivil, descricao, jsonTelefoneArray, jsonEmailArray, cep, logradouro, numero,
     complemento, uf, bairro, cidade, emprego, pis, jsonDependentesArray,callback) {
    $.ajax({
        url: 'js/sqlscopeFuncionarioCadastro.php',
        dataType: 'html', //tipo do retorno
        type: 'post', //metodo de envio
        data: {
            funcao: "gravar", id: id, ativo: ativo, nome: nome, cpf: cpf, rg: rg, dataNascimento: dataNascimento, estadoCivil: estadoCivil, descricao: descricao, jsonTelefoneArray: jsonTelefoneArray, jsonEmailArray: jsonEmailArray,
            cep: cep, logradouro: logradouro, numero: numero, complemento: complemento, uf: uf, bairro: bairro, cidade: cidade, emprego: emprego, pis: pis, jsonDependentesArray: jsonDependentesArray
        },
        success: results => callback(results),
        error: function (xhr, er) {
            //tratamento de erro
        }
    });

    return '';
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
                    $('#cpf').val("");
                }
            }
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });
}


function validarCpfDependentes(cpfDependentes) {
    $.ajax({
        url: 'js/sqlscopeFuncionarioCadastro.php',
        dataType: ' html',
        type: 'post',
        data: {
            funcao: 'validaCpfDependentes',
            cpfDependentes: cpfDependentes
        },
        success: function (data, textStatus) {
            if (data.indexOf('failed') > -1) {
                var piece = data.split("#");
                var mensagem = piece[1];

                if (mensagem !== "") {
                    smartAlert("Atenção", mensagem, "error");
                } else {
                    smartAlert("Atenção", "CPF dependente inválido", "error");
                    $('#cpfDependentes').val("");
                }
            }
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });
}

function validarRg(rg) {
    $.ajax({
        url: 'js/sqlscopeFuncionarioCadastro.php',
        dataType: ' html',
        type: 'post',
        data: {
            funcao: 'validaRg',
            rg: rg
        },
        success: function (data, textStatus) {
            if (data.indexOf('failed') > -1) {
                var piece = data.split("#");
                var mensagem = piece[1];

                if (mensagem !== "") {
                    smartAlert("Atenção", mensagem, "error");
                } else {
                    smartAlert("Atenção", "RG dependente inválido", "error");
                    $('#rg').val("");
                }
            }
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });
}

function verificarCpf(id, cpf) {
    $.ajax({
        url: 'js/sqlscopeFuncionarioCadastro.php',
        dataType: ' html',
        type: 'post',
        data: { funcao: 'verificaCpf', id: id, cpf: cpf },
        success: function (data, textStatus) {
            if (data.indexOf('failed') > -1) {
                var piece = data.split("#");
                var mensagem = piece[1];

                if (mensagem !== "") {
                    smartAlert("Atenção", "CPF já cadastrado", "error");
                    $('#cpf').val("");
                }
            }
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });
}

function verificarRg(id, rg) {
    $.ajax({
        url: 'js/sqlscopeFuncionarioCadastro.php',
        dataType: ' html',
        type: 'post',
        data: { funcao: 'verificaRg', id: id, rg: rg },
        success: function (data, textStatus) {
            if (data.indexOf('failed') > -1) {
                var piece = data.split("#");
                var mensagem = piece[1];

                if (mensagem !== "") {
                    smartAlert("Atenção", "RG já cadastrado", "error");
                    $('#rg').val("");
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
                var strarrayNomeDependentes = piece[4];

                piece = out.split("^");

                var codigo = +piece[0];
                var nome = piece[1];
                var ativo = +piece[2];
                var cpf = piece[3];
                var rg = piece[4];
                var dataNascimento = piece[5];
                var estadoCivil = piece[6];
                var descricao = piece[7];
                var cep = piece[10];
                var logradouro = piece[11];
                var numero = piece[12];
                var complemento = piece[13];
                var uf = piece[14];
                var bairro = piece[15];
                var cidade = piece[16];
                var emprego = piece[17];
                var pis = piece[18];

                $("#codigo").val(codigo);
                $("#nome").val(nome);
                $("#ativo").val(ativo);
                $("#cpf").val(cpf);
                $("#rg").val(rg);
                $("#dataNascimento").val(dataNascimento);
                $("#estadoCivil").val(estadoCivil);
                $("#descricao").val(descricao);
                $("#cep").val(cep);
                $("#logradouro").val(logradouro);
                $("#numero").val(numero);
                $("#complemento").val(complemento);
                $("#uf").val(uf);
                $("#bairro").val(bairro);
                $("#cidade").val(cidade);
                $("#emprego").val(emprego);
                $("#pis").val(pis);

                //voltar o botão
                $("#btnPdf").removeClass("hidden")
                //atribuindo valor 
                if (ativo === 1) {
                    $('#btnExcluir').removeClass('hidden');
                }

                validaData();

                if (emprego == 0) {
                    $('#pis').removeClass("readonly").attr("disabled", false)
                } else {
                    $('#pis').addClass("readonly").attr("disabled", true).val("")
                }


                $("#jsonTelefone").val(strarrayTelefone)
                jsonTelefoneArray = JSON.parse($("#jsonTelefone").val());
                fillTableTelefone();

                $("#jsonEmail").val(strarrayEmail)
                jsonEmailArray = JSON.parse($("#jsonEmail").val());
                fillTableEmail();

                $("#jsonDependentes").val(strarrayNomeDependentes)
                jsonDependentesArray = JSON.parse($("#jsonDependentes").val());
                fillTableDependentes();
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
                voltar();
            }
        },
        error: function (xhr, er) {
            //tratamento de erro
        }
    });
}
