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
return;

function verificaGenero()
{
    $reposit = new reposit();
    $utils = new comum();

    if (!((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"])))) {
        $id = 0;
    } else {
        $id = (int) $_POST["id"];
    }

    $reposit = new reposit();
    $utils = new comum();

    $descricao = $utils->formatarString($_POST['descricao']);

    $sql = "SELECT descricao from dbo.genero where descricao = $descricao AND codigo != $id";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if (!$result) {
        echo  "success#";
        return ;
    } else {
        $mensagem = "Informe o Gênero";
        echo "failed#" . $mensagem . ' ';
        return;
    }
}

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

    $sql = "SELECT descricao from dbo.genero where descricao = '$descricao' AND codigo = $id";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if (!$result) {
        session_start();

        $sql = "dbo.genero_atualiza 
        $codigo,
        '$descricao',
        $ativo
       ";

        if ($descricao == "''") {
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
        $mensagem = "Informe o Gênero";
        echo "failed#" . $mensagem . ' ';
        return;
    }
}

function recuperaGenero()
{
    $utils = new comum();

    $condicaoId = !((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"])));
    $condicaoLogin = !((empty($_POST["loginPesquisa"])) || (!isset($_POST["loginPesquisa"])) || (is_null($_POST["loginPesquisa"])));

    $codigo = $_POST["codigo"];


    $sql = "SELECT codigo,descricao,ativo from dbo.genero WHERE (0 = 0) and codigo = $codigo ";


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


    $codigo = (int) $_POST["codigo"];

    $result = $reposit->update('dbo.genero' . '|' . 'ativo = 0' .  '|' . 'codigo = ' . $codigo);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}
