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

return;


function grava()
{
     $reposit = new reposit();

    if (!((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"])))) {
      $id = 0;
    } else{ 
        $id = (int) $_POST["id"];
    }
       

   
    $id = (int) $_POST["id"];
    $estadoCivil = (string) $_POST["estadoCivil"];
    $ativo = 1;
   
    session_start();

    $sql = "dbo.estadoCivil_atualiza 
        $id,
        '$estadoCivil',
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

function recuperaEstadoCivil()
{
    $utils = new comum();

    $condicaoId = !((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"])));
    $condicaoLogin = !((empty($_POST["loginPesquisa"])) || (!isset($_POST["loginPesquisa"])) || (is_null($_POST["loginPesquisa"])));

    
    $id = $_POST["codigo"];


    $sql = " SELECT codigo,estadoCivil,ativo from dbo.estadoCivil WHERE (0 = 0) and codigo = $id ";


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $id = $row['codigo'];
        $estadoCivil = $row['estadoCivil'];
        $ativo = $row['ativo'];
        }

    $out =
        $id . "^" .
        $estadoCivil. "^" .
        $ativo;

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

    $result = $reposit->update('dbo.estadoCivil' . '|' . 'ativo = 0' .  '|' . 'codigo = ' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }

    echo 'sucess#' . $result;
    return;
}