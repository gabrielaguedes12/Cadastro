<?php
include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'grava') {
    call_user_func($funcao);
}

if ($funcao == 'recupera') {
    call_user_func($funcao);
}

if ($funcao == 'excluir') {
    call_user_func($funcao);
}

if ($funcao == 'recuperarDadosUsuario') {
    call_user_func($funcao);
}

if ($funcao == 'gravarNovaSenha') {
    call_user_func($funcao);
}

if ($funcao == 'verificaCpf') {
    call_user_func($funcao);
}

if ($funcao == 'validaCpf') {
    call_user_func($funcao);
}

if ($funcao == 'verificaRg') {
    call_user_func($funcao);
}

return;


function grava()
{
    if (!((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"])))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();
    $utils = new comum();

    $id = (int) $_POST["id"];
    $ativo = (int) $_POST["ativo"];
    $nome = $utils->formatarString($_POST['nome']);
    $cpf = $utils->formatarString($_POST['cpf']);
    $rg = $utils->formatarString($_POST['rg']);
    $dataNascimento = $utils->formataDataSql($_POST['dataNascimento']);
    $estadoCivil = $utils->formatarString($_POST['estadoCivil']);
    $descricao = $utils->formatarString($_POST['descricao']);
    $telefone = $_POST['jsonTelefoneArray'];
    $email = $_POST['email'];


    $nomeXml = "ArrayTelefone";
    $nomeTabela = "TabelaTelefone";
    if (sizeof($telefone) > 0) {
        $xmlJsonTelefone = '<?xml version="1.0"?>';
        $xmlJsonTelefone = $xmlJsonTelefone . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        foreach ($telefone as $chave) {
            $xmlJsonTelefone = $xmlJsonTelefone . "<" . $nomeTabela . ">";
            foreach ($chave as $campo => $valor) {
                
                $xmlJsonTelefone = $xmlJsonTelefone . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlJsonTelefone = $xmlJsonTelefone . "</" . $nomeTabela . ">";
        }

        $xmlJsonTelefone = $xmlJsonTelefone . "</" . $nomeXml . ">";
    } else {
       
        $xmlJsonTelefone = '<?xml version="1.0"?>';
        $xmlJsonTelefone = $xmlJsonTelefone . '<' . $nomeXml . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlJsonTelefone = $xmlJsonTelefone . "</" . $nomeXml . ">";
    }
    $xml = simplexml_load_string($xmlJsonTelefone);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de Telefone";
        echo "failed#" . $mensagem . ' ';
        return;
    }
   
    $xmlJsonTelefone = "'" . $xmlJsonTelefone . "'";

 
    $sql = "dbo.funcionario_atualiza 
        $id,
        $nome,
        $ativo,
        $cpf,
        $rg,
        $dataNascimento,
        $estadoCivil,
        $descricao,
        $telefone,
        $email";

    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);

    $ret = 'sucess#';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret;
    return;
}

function recupera()
{
    $utils = new comum();

    $condicaoId = !((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"])));
    $condicaoLogin = !((empty($_POST["loginPesquisa"])) || (!isset($_POST["loginPesquisa"])) || (is_null($_POST["loginPesquisa"])));

    if (($condicaoId === false) && ($condicaoLogin === false)) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    if (($condicaoId === true) && ($condicaoLogin === true)) {
        $mensagem = "Somente 1 parâmetro de pesquisa deve ser informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    }


    $id = $_POST["id"];


    $sql = " SELECT codigo,nome,ativo,cpf,rg,dataNascimento,estadoCivil,descricao,telefone,email from dbo.funcionario WHERE (0 = 0) and codigo = $id ";


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $id = $row['codigo'];
        $nome = $row['nome'];
        $ativo = $row['ativo'];
        $cpf = $row['cpf'];
        $rg = $row['rg'];
        $dataNascimento = $utils->validaData($row['dataNascimento']);
        $estadoCivil = $row['estadoCivil'];
        $descricao = $row['descricao'];
        $telefone = $row['telefone'];
        $email = $row['email'];
    }

    $out =
        $id . "^" .
        $nome . "^" .
        $ativo . "^" .
        $cpf . "^" .
        $rg . "^" .
        $dataNascimento . "^" .
        $estadoCivil . "^" .
        $descricao . "^" .
        $telefone . "^" .
        $email;



    if ($out == "") {
        echo "failed#";
        return;
    }
    echo "sucess#" . $out;
    return;
}


function excluir()
{

    $reposit = new reposit();


    $id = $_POST["id"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um usuário.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();

    $result = $reposit->update('dbo.funcionario' . '|' . 'ativo = 0' .  '|' . 'codigo = ' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}
//validar cpf(exem: 111.111.111-11)
function validaCpf()
{
    $utils = new comum();

    $result = $utils->validaCpf($_POST['cpf']);

    if ($result) {
        echo 'sucess#';
    } else {
        echo 'failed#';
    }
}

//verificar se já foi cadastrado
function verificaCpf()
{
    $reposit = new reposit();
    $utils = new comum();

    $cpf = $utils->formatarString($_POST['cpf']);

    $sql = "SELECT cpf from dbo.funcionario where cpf = $cpf";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $ret = 'sucess# CPF ok';
    if (count($result) > 0) {
        $ret = 'failed# CPF já cadastrado';
    }
    echo $ret;
    return;
}

function verificaRg()
{
    $reposit = new reposit();
    $utils = new comum();

    $rg = $utils->formatarString($_POST['rg']);

    $sql = "SELECT rg from dbo.funcionario where rg = $rg";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $ret = 'sucess# RG ok';
    if (count($result) > 0) {
        $ret = 'failed# RG já cadastrado';
    }
    echo $ret;
    return;
}