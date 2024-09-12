<?php
include "repositorio.php";
include "girComum.php";

$funcao = $_POST["funcao"];

if ($funcao == 'gravar') {
    call_user_func($funcao);
}

if ($funcao == 'recupera') {
    call_user_func($funcao);
}

if ($funcao == 'excluir') {
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

if ($funcao == 'validaCpfDependentes') {
    call_user_func($funcao);
}

return;


function gravar()
{
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
    $cep = $utils->formatarString($_POST['cep']);
    $logradouro = $utils->formatarString($_POST['logradouro']);
    $numero = $utils->formatarString($_POST['numero']);
    $complemento = $utils->formatarString($_POST['complemento']);
    $uf = $utils->formatarString($_POST['uf']);
    $bairro = $utils->formatarString($_POST['bairro']);
    $cidade = $utils->formatarString($_POST['cidade']);
    $emprego = $_POST['emprego'];
    $pis = $utils->formatarString($_POST['pis']);
    $nomeDependentes = $_POST['jsonDependentesArray'] ? $_POST['jsonDependentesArray'] : [];

    //telefone
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

    //-------------------->email<------------------------//
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

    //----------------------------->dependentes<------------------------------//
    $nomeXmlDependentes = "ArrayDependentes";
    $nomeTabelaDependentes = "TabelaDependentes";

    if (sizeof($nomeDependentes) > 0) {
        $xmlJsonDependentes = '<?xml version="1.0"?>';
        $xmlJsonDependentes = $xmlJsonDependentes . '<' . $nomeXmlDependentes . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        foreach ($nomeDependentes as $chave) {
            $xmlJsonDependentes = $xmlJsonDependentes . "<" . $nomeTabelaDependentes . ">";
            foreach ($chave as $campo => $valor) {
                $xmlJsonDependentes = $xmlJsonDependentes . "<" .  $campo . ">" . $valor . "</" . $campo . ">";
            }
            $xmlJsonDependentes = $xmlJsonDependentes . "</" . $nomeTabelaDependentes . ">";
        }
        $xmlJsonDependentes = $xmlJsonDependentes . "</" . $nomeXmlDependentes . ">";
    } else {

        $xmlJsonDependentes = '<?xml version="1.0"?>';
        $xmlJsonDependentes = $xmlJsonDependentes . '<' . $nomeXmlDependentes . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
        $xmlJsonDependentes = $xmlJsonDependentes . "</" . $nomeXmlDependentes . ">";
    }
    $xml = simplexml_load_string($xmlJsonDependentes);
    if ($xml === false) {
        $mensagem = "Erro na criação do XML de Dependentes";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $xmlJsonDependentes = "'" . $xmlJsonDependentes . "'";

    $sql = "dbo.funcionario_atualiza 
        $id,
        $nome,
        1,
        $cpf,
        $rg,
        $dataNascimento,
        $estadoCivil,
        $descricao,
        $xmlJsonTelefone,
        $xmlJsonEmail,
        $cep,
        $logradouro,
        $numero,
        $complemento,
        $uf,
        $bairro,
        $cidade,
        $emprego,
        $pis,
        $xmlJsonDependentes";

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

    $sql = "SELECT codigo,nome,ativo,cpf,rg,dataNascimento,estadoCivil,idGenero,cep,logradouro,numero,complemento,uf,bairro,cidade,emprego,pis
    from dbo.funcionario WHERE (0 = 0) and codigo = $id";

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
        $cep = $row['cep'];
        $logradouro = $row['logradouro'];
        $numero = $row['numero'];
        $complemento = $row['complemento'];
        $uf = $row['uf'];
        $bairro = $row['bairro'];
        $cidade = $row['cidade'];
        $emprego = $row['emprego'];
        $pis = $row['pis'];
    }

    //telefone
    $sql = "SELECT t.codigo, t.idFuncio, t.principal,  t.telefone, t.telefoneId, t.whats
        FROM telefone t
         WHERE idFuncio = $id";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $telefoneNum = 0;
    $arrayTelefone = array();

    foreach ($result as $row) {

        $out = "";
        if ($row = $result[0]) {

            $telefone = $row['telefone'];
            $telefoneId = $row['telefoneId'];
            $principal = $row['principal'];
            $whats = $row['whats'];
            $idFuncio = $row['idFuncio'];
        }

        $sequencialTel = $telefoneNum + 1;
        $arrayTelefone[] = array(
            "sequencialTel"  => $sequencialTel,
            "telefone"  => $telefone,
            "telefoneId"  => $telefoneId,
            "principal"  => $principal,
            "whats"  => $whats,
            "idFuncio"  => $idFuncio
        );
    }

    $strarrayTelefone = json_encode($arrayTelefone);


    //Email
    $sql = "SELECT t.codigo,t.idFunci, t.principalEmail,t.email,t.emailId
        FROM email t
        WHERE idFunci = $id";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $emailNum = 0;
    $arrayEmail = array();

    foreach ($result as $row) {

        $out = "";
        if ($row = $result[0]) {

            $email = $row['email'];
            $emailId = $row['emailId'];
            $principalEmail = $row['principalEmail'];
            $idFunci = $row['idFunci'];
        }

        $sequencialEmail = $emailNum + 1;
        $arrayEmail[] = array(
            "sequencialEmail" =>   $sequencialEmail,
            "email"  => $email,
            "emailId"  => $emailId,
            "principalEmail"  => $principalEmail,
            "idFunci"  => $idFunci
        );
    }

    $strarrayEmail = json_encode($arrayEmail);

    //dependentes
    $sql = "SELECT t.codigo,t.idFuncionario,t.nomeDependentes,t.cpfDependentes,t.dataNascimentoDependentes,t.tipo    
     FROM dependentes t 
    WHERE idFuncionario = $id";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $dependentesNum = 0;
    $arrayDependentes = array();

    foreach ($result as $row) {

        $out = "";


        $idFuncionario = $row['idFuncionario'];
        $nomeDependentes = $row['nomeDependentes'];
        $cpfDependentes = $row['cpfDependentes'];
        $dataNascimentoDependentes = $utils->validaData($row['dataNascimentoDependentes']);
        $tipo = $row['tipo'];


        $sequencialDependentes = $dependentesNum + 1;
        $arrayDependentes[] = array(
            "sequencialDependentes" => $sequencialDependentes,
            "idFuncionario"  => $idFuncionario,
            "nomeDependentes"  => $nomeDependentes,
            "cpfDependentes"  => $cpfDependentes,
            "dataNascimentoDependentes"  => $dataNascimentoDependentes,
            "tipo" => $tipo
        );
    }

    $strarrayNomeDependentes = json_encode($arrayDependentes);

    //---------------------------------------->>-------------------------------------//
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
        $email . "^" .
        $cep . "^" .
        $logradouro . "^" .
        $numero . "^" .
        $complemento . "^" .
        $uf . "^" .
        $bairro . "^" .
        $cidade . "^" .
        $emprego . "^" .
        $pis . "^" .
        $nomeDependentes;

    if ($out == "") {
        echo "failed#";
        return;
    }
    echo "sucess#" . $out . "#" . $strarrayTelefone . "#" . $strarrayEmail . "#" . $strarrayNomeDependentes;

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

//validar cpf(exem: 111.111.111-11)
function validaCpfDependentes()
{

    $utils = new comum();

    $result = $utils->validaCpfDependentes($_POST['cpfDependentes']);

    if ($result) {
        echo 'sucess#';
    } else {
        echo 'failed#';
    }
}

//validar cpf(exem: 111.111.111-11)
function validaRg()
{
    $utils = new comum();

    $result = $utils->validaRg($_POST['rg']);

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

    $id = (int)$_POST["id"];

    if ($id == 0) {
        $sql = "SELECT cpf  from dbo.funcionario where cpf = $cpf";
    } else {
        $sql = "SELECT cpf, codigo  from dbo.funcionario where cpf = $cpf and codigo != $id";
    }

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    if ($result == 0) {
        $ret = 'success# CPF OK';
    } else {
        if (count($result) > 0) {
            $ret = 'failed# CPF já cadastrado';
        }
    }
    echo $ret;

    return;
}

function verificaRg()
{
    $reposit = new reposit();
    $utils = new comum();

    $rg = $utils->formatarString($_POST['rg']);
    $id = (int)$_POST["id"];

    if ($id == 0) {
        $sql = "SELECT rg from dbo.funcionario where rg = $rg";
    } else {
        $sql = "SELECT rg, codigo  from dbo.funcionario where rg = $rg and codigo != $id";
    }

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    if ($result == 0) {
        $ret = 'sucess# RG ok';
    } else {
        if (count($result) > 0) {
            $ret = 'failed# RG já cadastrado';
        }
    }
    echo $ret;
    return;
}
