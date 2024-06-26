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
    $email = $_POST['jsonEmailArray'];

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

    //email
    $nomeXmlEmail = "ArrayEmail";
    $nomeTabelaEmail = "TabelaEmail";
    if (sizeof($email) > 0) {
        $xmlJsonEmail = '<?xml version="1.0"?>';
        $xmlJsonEmail = $xmlJsonEmail . '<' . $nomeXmlEmail . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        foreach ($email as $chave) {
            $xmlJsonEmail = $xmlJsonEmail . "<" . $nomeTabelaEmail . ">";
            foreach ($chave as $campo => $valor) {

                $xmlJsonEmail = $xmlJsonEmail . "<" . $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlJsonEmail = $xmlJsonEmail . "</" . $nomeTabelaEmail . ">";
        }

        $xmlJsonEmail = $xmlJsonEmail . "</" . $nomeXmlEmail . ">";
    } else {

        $xmlJsonEmail = '<?xml version="1.0"?>';
        $xmlJsonEmail = $xmlJsonEmail . '<' . $nomeXmlEmail . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlJsonEmail = $xmlJsonEmail . "</" . $nomeXmlEmail . ">";
    }
    $xml = simplexml_load_string($xmlJsonEmail);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de Email";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlJsonEmail = "'" . $xmlJsonEmail . "'";

    $sql = "dbo.funcionario_atualiza 
        $id,
        $nome,
        $ativo,
        $cpf,
        $rg,
        $dataNascimento,
        $estadoCivil,
        $descricao,
        $xmlJsonTelefone,
        $xmlJsonEmail";

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


    $sql = " SELECT codigo,nome,ativo,cpf,rg,dataNascimento,estadoCivil,idGenero 
    from dbo.funcionario WHERE (0 = 0) and codigo = $id ";

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
        $idGenero = $row['idGenero'];
    }


    //telefone
    $sql = "SELECT t.codigo, t.idFuncio, t.principal, t.sequencialTel, t.telefone, t.telefoneId, t.whats
        FROM telefone t
         WHERE idFuncio = $id";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $telefoneNum = 0;
    $arrayTelefone = array();

    foreach ($result as $row) {

         $out = "";
        if ($row = $result[0]) {
            $sequencialTel = $row['sequencialTel'];
            $telefone = $row['telefone'];
            $telefoneId = $row['telefoneId'];
            $principal = $row['principal'];
            $whats = $row['whats'];
            $idFuncio = $row['idFuncio'];
        }

        $telefoneNum = $telefoneNum + 1;
        $arrayTelefone[] = array(
            "sequencialTel" =>   $sequencialTel,
            "telefone"  => $telefone,
            "telefoneId"  => $telefoneId,
            "principal"  => $principal,
            "whats"  => $whats,
            "idFuncio"  => $idFuncio
        );
    }
  
    $strarrayTelefone = json_encode($arrayTelefone);


    //Email
    $sql = "SELECT t.codigo,t.idFunci, t.principalEmail,t.sequencialEmail, t.email,t.emailId
        FROM email t
        WHERE idFunci = $id";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $emailNum = 0;
    $arrayEmail = array();

    foreach ($result as $row) {

        $out = "";
        if ($row = $result[0]) {
            $sequencialEmail = $row['sequencialEmail'];
            $email = $row['email'];
            $emailId = $row['emailId'];
            $principal = $row['principal'];
            $idFunci = $row['idFunci'];
        }

        $emailNum = $emailNum + 1;
        $arrayEmail[] = array(
            "sequencialEmail" =>   $sequencialEmail,
            "email"  => $email,
            "emailId"  => $emailId,
            "principal"  => $principal,
            "idFunci"  => $idFunci
        );
    }

    $strarrayEmail = json_encode($arrayEmail);

    $out =
        $id . "^" .
        $nome . "^" .
        $ativo . "^" .
        $cpf . "^" .
        $rg . "^" .
        $dataNascimento . "^" .
        $estadoCivil . "^" .
        $idGenero . "^" .
        $telefone . "^" .
        $email;

    if ($out == "") {
        echo "failed#";
        return;
    }
        echo "sucess#" . $out . "#" . $strarrayTelefone . "#" . $strarrayEmail;
       
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