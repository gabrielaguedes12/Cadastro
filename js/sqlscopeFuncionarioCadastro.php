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

if($funcao == 'validaCpf'){
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
    $dataNascimento = $utils->formataDataSql($_POST['dataNascimento']);

    $sql = "dbo.funcionario_atualiza 
        $id,
        $nome,
        $ativo,
        $cpf,
        $dataNascimento";

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


    $sql = " SELECT codigo,nome,ativo,cpf, dataNascimento from dbo.funcionario WHERE (0 = 0) and codigo = $id ";


    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $id = $row['codigo'];
        $nome = $row['nome'];
        $ativo = $row['ativo'];
        $cpf = $row['cpf'];
        $dataNascimento = $utils->validaData($row['dataNascimento']);
    }

    $out =
        $id . "^" .
        $nome . "^" .
        $ativo . "^" .
        $cpf . "^" .
        $dataNascimento; 
        
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

function valida($login)
{
    $sql = "SELECT codigo,[login],ativo FROM Ntl.usuario
    WHERE [login] LIKE $login and ativo = 1";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if ($result[0]) {
        return true;
    } else {
        return false;
    }
}

function recuperarDadosUsuario()
{

    session_start();
    $codigoLogin = $_SESSION['codigo'];

    $sql = "SELECT codigo, login, ativo, restaurarSenha
    FROM Ntl.usuario
    WHERE (0=0) AND
    codigo = " . $codigoLogin;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";
    if ($row = $result[0]) {
        $codigo = (int)$row['codigo'];
        $restaurarSenha = $row['restaurarSenha'];
    }

    $out = $codigo . "^" .
        $restaurarSenha;

    if ($out == "") {
        echo "failed#";
        return;
    }

    echo "sucess#" . $out;
    return;
}


function gravarNovaSenha()
{
    $reposit = new reposit();
    $senhaConfirma = $_POST["senhaConfirma"];
    $senha = $_POST["senha"];

    if ((empty($_POST['senhaConfirma'])) || (!isset($_POST['senhaConfirma'])) || (is_null($_POST['senhaConfirma']))) {
        $senhaConfirma = null;
    }
    if ((empty($_POST['senha'])) || (!isset($_POST['senha'])) || (is_null($_POST['senha']))) {
        $senha = null;
    }

    if ((!is_null($senhaConfirma)) or (!is_null($senha))) {
        $comum = new comum();
        $validouSenha = 1;
        if (!is_null($senha)) {
            $validouSenha = $comum->validaSenha($senha);
        }
        if ($validouSenha === 0) {
            if ($senhaConfirma !== $senha) {
                $mensagem = "A confirmação da senha deve ser igual a senha.";
                echo "failed#" . $mensagem . ' ';
                return;
            } else {
                $comum = new comum();
                $senhaCript = $comum->criptografia($senha);
                $senha = "'" . $senhaCript . "'";
            }
        } else {
            switch ($validouSenha) {
                case 1:
                    $mensagem = "Senha não pode conter espaços.";
                    break;
                case 2:
                    $mensagem = "Senha deve possuir no mínimo 7 caracter.";
                    break;
                case 3:
                    $mensagem = "Senha ultrapassou de 15 caracteres.";
                    break;
                case 4:
                    $mensagem = "Senha deve possuir no mínimo um caractér númerico.";
                    break;
                case 5:
                    $mensagem = "Senha deve possuir no mínimo um caractér alfabético.";
                    break;
                case 6:
                    $mensagem = "Senha deve possuir no mínimo um caracter especial.\nSão válidos : ! # $ & * - + ? . ; , : ] [ ( )";
                    break;
                case 7:
                    $mensagem = "Senha não pode ter caracteres acentuados.";
                    break;
            }
            echo "failed#" . $mensagem . ' ';
            return;
        }
    }

    session_start();
    $login = "'" .  $_SESSION['login'] . "'";
    $usuario =  $login;

    $id = $_SESSION['codigo'];
    $funcionario = $_SESSION['funcionario'];
    if (!$funcionario) {
        $funcionario = 'NULL';
    }
    $ativo = 1;
    $tipoUsuario = 'C';
    $restaurarSenha = 0;

    $sql = "Ntl.usuario_Atualiza " . $id . "," . $ativo . "," . $login . "," . $senha . "," . $tipoUsuario . "," . $usuario . "," . $funcionario . "," . $restaurarSenha . " ";

    $reposit = new reposit();
    $result = $reposit->Execprocedure($sql);

    $ret = 'sucess#';

    if ($result < 1) {
        $ret = 'failed#';
    }

    echo $ret;

    return;
}

function verificaCpf()
{
    $utils = new comum();

    $result = $utils->validaCpf($_POST['cpf']);

    if( $result ){
        echo 'sucess#';
    }else{
        echo 'failed#';
    }
}

function validaCpf(){
    $reposit = new reposit();
    $utils = new comum();

    $cpf = $utils->formatarString($_POST['cpf']);

    $sql = "SELECT cpf from dbo.funcionario where cpf = $cpf";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $ret = 'sucess# CPF cadastrado';
    if (count($result)>0) {
        $ret = 'failed# CPF já existente';
    }
    echo $ret;
    return;
}