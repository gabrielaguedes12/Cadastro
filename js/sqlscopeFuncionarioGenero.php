<?php
include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];
if ($funcao == 'verificaGenero') {
    call_user_func($funcao);
}

if ($funcao == 'gravaGenero') {
    call_user_func($funcao);
}

if ($funcao == 'recuperaGenero') {
    call_user_func($funcao);
}

if ($funcao == 'excluirGenero') {
    call_user_func($funcao);
}

if ($funcao == 'recuperarDadosUsuario') {
    call_user_func($funcao);
}

return;

function verificaGenero()
{
    $sql = " SELECT codigo,descricao,ativo from dbo.genero WHERE ";


};

function gravaGenero()
{
    $reposit = new reposit();

    if (!((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"])))) {
        $id = 0;
    } else {
        $id = (int) $_POST["id"];
    }

    $codigo = (int) $_POST["codigo"];
    $descricao = (string) $_POST["descricao"];
    $ativo = 1;

    session_start();

    $sql = "dbo.genero_atualiza 
        $codigo,
        '$descricao',
        $ativo
       ";

    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);

    $ret = 'sucess#';
    if ($result < 1) {
        $ret = 'failed#';
    }
    echo $ret;
    return;
}

function recuperaGenero()
{
    $utils = new comum();

    $condicaoId = !((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"])));
    $condicaoLogin = !((empty($_POST["loginPesquisa"])) || (!isset($_POST["loginPesquisa"])) || (is_null($_POST["loginPesquisa"])));

    $codigo = $_POST["codigo"];


    $sql = " SELECT codigo,descricao,ativo from dbo.genero WHERE (0 = 0) and codigo = $codigo ";


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $codigo = $row['codigo'];
        $descricao = $row['descricao'];
        $ativo = $row['ativo'];
    }

    $out =
        $codigo . "^" .
        $descricao . "^" .
        $ativo;

    if ($out == "") {
        echo "failed#";
        return;
    }
    echo "sucess#" . $out;
    return;
}


function excluirGenero()
{

    $reposit = new reposit();


    $codigo =(int) $_POST["codigo"];

    $result = $reposit->update('dbo.genero' . '|' . 'ativo = 0' .  '|' . 'codigo = ' . $codigo);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}
