<?php
include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'verificaEstadoCivil') {
    call_user_func($funcao);
}

if ($funcao == 'gravaEstadoCivil') {
    call_user_func($funcao);
}

if ($funcao == 'recuperaEstadoCivil') {
    call_user_func($funcao);
}

if ($funcao == 'excluirEstadoCivil') {
    call_user_func($funcao);
}

return;



function verificaEstadoCivil()
{
    $reposit = new reposit();
    $utils = new comum();

    if (!((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"])))) {
        $id = 0;
    } else {
        $id = (int) $_POST["id"];
    }

    $estadoCivil = $utils->formatarString($_POST['estadoCivil']);

    $sql = "SELECT estadoCivil from dbo.estadoCivil where estadoCivil = $estadoCivil AND codigo != $id";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if (!$result) {
        echo  "success#";
        return;
    } else {
        $mensagem = "Informe o estado civil";
        echo "failed#" . $mensagem . ' ';
        return;
    }
}


function gravaEstadoCivil()
{
    $reposit = new reposit();

    if (!((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"])))) {
        $id = 0;
    } else {
        $id = (int) $_POST["id"];
    }

    $codigo = (int) $_POST["codigo"];
    $estadoCivil = (string) $_POST["estadoCivil"];
    $ativo = 1;

    $sql = "SELECT estadoCivil from dbo.estadoCivil where estadoCivil = '$estadoCivil' AND codigo = $id";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if (!$result) {
        session_start();

        $sql = "dbo.estadoCivil_atualiza 
            $codigo,
            '$estadoCivil',
            $ativo
           ";

        if ($estadoCivil == "''") {
            $ret = 'failed#';
            echo $ret;
            return;
        }

        $reposit = new reposit();
        $result = $reposit->Execprocedure($sql);
        $ret = 'sucess#';
        if ($result < 1) {
            $ret = 'failed#';
        }
        echo $ret;
        return;
    } else {
        $mensagem = "Informe o estado civil";
        echo "failed#" . $mensagem . ' ';
        return;
    }
}

function recuperaEstadoCivil()
{
    $utils = new comum();
    $condicaoId = !((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"])));
    $condicaoLogin = !((empty($_POST["loginPesquisa"])) || (!isset($_POST["loginPesquisa"])) || (is_null($_POST["loginPesquisa"])));

    $codigo = $_POST["codigo"];
    $sql = "SELECT codigo,estadoCivil,ativo from dbo.estadoCivil WHERE (0 = 0) and codigo = $codigo ";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $codigo = $row['codigo'];
        $estadoCivil = $row['estadoCivil'];
        $ativo = $row['ativo'];
    }

    $out =
        $codigo . "^" .
        $estadoCivil . "^" .
        $ativo;

    if ($out == "") {
        echo "failed#";
        return;
    }
    echo "sucess#" . $out;
    return;
}


function excluirEstadoCivil()
{
    $reposit = new reposit();
    $codigo = (int)$_POST["codigo"];

    $result = $reposit->update('dbo.estadoCivil' . '|' . 'ativo = 0' .  '|' . 'codigo = ' . $codigo);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}
