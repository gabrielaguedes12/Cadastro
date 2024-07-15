<?php
include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'gravaDependentes') {
    call_user_func($funcao);
}

if ($funcao == 'recuperaDependentes') {
    call_user_func($funcao);
}

if ($funcao == 'excluirDependentes') {
    call_user_func($funcao);
}

return;


function gravaDependentes()
{
     $reposit = new reposit();

    if (!((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"])))) {
      $id = 0;
    } else{ 
        $id = (int) $_POST["id"];
    }
       

   
    $id = (int) $_POST["id"];
    $dependentes = (string) $_POST["dependentes"];
    $ativo = 1;
   
    session_start();

    $sql = "dbo.dependentes_atualiza 
        $id,
        '$dependentes',
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


    $sql = " SELECT codigo,dependentes,ativo from dbo.dependentes WHERE (0 = 0) and codigo = $codigo ";


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $codigo = $row['codigo'];
        $dependentes = $row['dependentes'];
        $ativo = $row['ativo'];
        }

    $out =
        $codigo . "^" .
        $dependentes . "^" .
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


    $codigo = $_POST["codigo"];

    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um usuário.";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();

    $result = $reposit->update('dbo.dependentes' . '|' . 'ativo = 0' .  '|' . 'codigo = ' . $codigo);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}