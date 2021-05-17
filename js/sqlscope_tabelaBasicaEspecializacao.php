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

return;

function grava()
{
    $reposit = new reposit(); //Abre a conexão.
    $possuiPermissao = $reposit->PossuiPermissao("ESPECIALIZACAO_ACESSAR|ESPECIALIZACAO_GRAVAR"); //Verifica permissões

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    session_start(); // PEGAR O LOGIN
    $usuario = "'" . $_SESSION['login'] . "'";  //Pegando o nome do usuário mantido pela sessão.
    $codigo = (int) $_POST['id'];
    $descricao = "'" . $_POST['descricao'] . "'";
    $ativo = (int) $_POST['ativo'];




    $sql="SELECT descricao FROM Ntl.especializacao WHERE descricao = $descricao";
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    if($row = $result[0])
    $verificaDescricao = "'".$row[ 'descricao']."'";
    if ($verificaDescricao == $descricao) {
        $mensagem = "Esta Descrição já existe na Tabela.";
        echo "failed#" . $mensagem . ' ';
        return;
    }




    $sql = "Ntl.especializacao_Atualiza
        $codigo ,
        $descricao ,
        $ativo,
        $usuario 
        ";

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
    if ((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["id"];
    }

    $sql = "SELECT codigo, descricao, ativo FROM Ntl.especializacao
    WHERE (0=0) AND codigo = " . $id;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if($row = $result[0])


    $id = +$row['codigo'];
    $descricao = $row['descricao'];
    $ativo = +$row['ativo'];

    $out =   $id . "^" .
        $descricao . "^" .
        $ativo;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out;
    return;
}

function verificaDescricao(){
    $descricao = "'" . $_POST['descricao'] . "'";
    $sql="SELECT descricao FROM Ntl.especializacao WHERE descricao = $descricao";
    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
}


function excluir()
{
    $reposit = new reposit();  //Abre a conexão.
    $possuiPermissao = $reposit->PossuiPermissao("ESPECIALIZACAO_ACESSAR|ESPECIALIZACAO_EXCLUIR"); //Verifica permissões

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um Código de Servico.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = (int) $_POST["id"];
    }

    $result = $reposit->update('Ntl.especializacao' . '|' . 'ativo = 0' . '|' . 'codigo = ' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}
