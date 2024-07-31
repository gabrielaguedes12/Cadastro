<?php
include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];
if ($funcao == 'verificaDependentes') {
    call_user_func($funcao);
}

if ($funcao == 'gravarDependentes') {
    call_user_func($funcao);
}

if ($funcao == 'recuperaDependentes') {
    call_user_func($funcao);
}

if ($funcao == 'excluirDependentes') {
    call_user_func($funcao);
}

return;

function verificaDependentes()
{$reposit = new reposit();

    if (!((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"])))) {
        $id = 0;
    } else {
        $id = (int) $_POST["id"];
    }

    if (!((empty($_POST["ativo"])) || (!isset($_POST["ativo"])) || (is_null($_POST["ativo"])))) {
        $id = 0;
    } else {
        $id = (int) $_POST["ativo"];
    }

    $reposit = new reposit();
    $utils = new comum();

    $tipo = $utils->formatarString($_POST['tipo']);

    $sql = "SELECT tipo from dbo.tipoDependentes where tipo = $tipo";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if (!$result) {
        echo  "success";
        return true;
    } else {
        $mensagem = "Informe o estado civil";
        echo "failed#" . $mensagem . ' ';
    }
    return;
}


function gravarDependentes()
{
    $reposit = new reposit();

    if (!((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"])))) {
        $id = 0;
    } else {
        $id = (int) $_POST["id"];
    }

    $codigo = (int) $_POST["codigo"];
    $tipo = (string) $_POST["tipo"];
    $ativo = 1;

    session_start();

    $sql = "dbo.tipoDependentes_atualiza 
        $codigo,
        $tipo,
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

function recuperaDependentes()
{
    $utils = new comum();

    $condicaoId = !((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"])));
    $condicaoLogin = !((empty($_POST["loginPesquisa"])) || (!isset($_POST["loginPesquisa"])) || (is_null($_POST["loginPesquisa"])));


    $codigo = $_POST["codigo"];


    $sql = " SELECT codigo,tipo,ativo from dbo.tipoDependentes WHERE (0 = 0) and codigo = $codigo ";


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $codigo = $row['codigo'];
        $tipo = $row['tipo'];
        $ativo = $row['ativo'];
    }

    $out =
        $codigo . "^" .
        $tipo . "^" .
        $ativo;

    if ($out == "") {
        echo "failed#";
        return;
    }
    echo "sucess#" . $out;
    return;
}


function excluirDependentes()
{
    $reposit = new reposit();

    $codigo = (int) $_POST["codigo"];

    $result = $reposit->update('dbo.tipoDependentes' . '|' . 'ativo = 0' .  '|' . 'codigo = ' . $codigo);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}
