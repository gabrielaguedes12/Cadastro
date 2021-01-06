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

if ($funcao == 'contaFeriado') {
    call_user_func($funcao);
}

if ($funcao == 'populaComboFuncionario') {
    call_user_func($funcao);
}

return;

function grava()
{

    // Checa permissões
    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("FERIAS_ACESSAR|FERIAS_GRAVAR");

    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para gravar!";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();

    //Dados
    $id = validaNumero($_POST['id']);
    $ativo = 1;
    $abono = validaNumero($_POST['abono']);
    $funcionario = validaNumero($_POST['funcionario']);
    $mesAno = $_POST['mesAno'];
    $dataInicio = validaData($_POST['dataInicio']);
    $dataFim = validaData($_POST['dataFim']);
    $quantidadeDias = validaNumero($_POST['quantidadeDias']);
    $adiantaDecimoTerceiro = validaNumero($_POST['adiantaDecimoTerceiro']);
    $mesAnoInicio = $_POST['mesAnoInicio'];
    $mesAnoFim = $_POST['mesAnoFim'];
    $diaUtil = +$_POST['diaUtil'];
    $projeto = +$_POST['projeto'];
    $diaFeriado = +$_POST['diaFeriado'];
    session_start();
    $usuario = "'" . $_SESSION['login'] . "'";  //Pegando o nome do usuário mantido pela sessão.


    ///////////////////////////////////////////////////////////
    $temMaisRegistro = 0;
    $mesAnoAux = explode("/", $mesAno);
    $mesAno = "'" . $mesAnoAux[1] . "/" . $mesAnoAux[0] . "/" . "01'";


    // if($id > 0 ){
    if ($mesAnoInicio != $mesAnoFim) {
        echo "failed#" . "Atualizações não podem ser feitas com Meses diferentes!";
        return;
    }
    if (temFeriasMesmoPeriodo($funcionario, $mesAno) && $id == 0) {
        echo "failed#" . "Funcionário Já Possui Férias nesse Mês/Ano!";
        return;
    }
    // }

    if ($mesAnoInicio != $mesAnoFim) {
        $temMaisRegistro = 1;
        $quantidadeDias = 0;

        $dataInicioAux =  explode("/", $_POST['dataInicio']);
        $dataInicioAuxUltimoDia = cal_days_in_month(CAL_GREGORIAN, $dataInicioAux[1], $dataInicioAux[2]); // 31
        $dataInicioFinalAux = $dataInicioAux[2] . "/" . $dataInicioAux[1] . "/" . $dataInicioAuxUltimoDia;
        $dataInicioFinal = "'" . $dataInicioAux[2] . "/" . $dataInicioAux[1] . "/" . $dataInicioAuxUltimoDia . "'";

        $dataInicioAux1 =  explode("'", $dataInicio);
        // Usa a função strtotime() e pega o timestamp das duas datas:
        $time_inicial = strtotime($dataInicioAux1[1]);
        $time_final = strtotime($dataInicioFinalAux);
        // Calcula a diferença de segundos entre as duas datas:
        $diferenca = $time_final - $time_inicial;
        // Calcula a diferença de dias
        $quantidadeDiasInicial = (int) floor($diferenca / (60 * 60 * 24));


        $dataFimAux =  explode("/", $_POST['dataFim']);
        $dataFimInicialAux = $dataFimAux[2] . "/" . $dataFimAux[1];
        $dataFimInicial = "'" . $dataFimAux[2] . "/" . $dataFimAux[1] . "/01'";
        $dataFimInicialAux = $dataFimAux[2] . "/" . $dataFimAux[1] . "/01";

        $dataFimAux1 = explode("'", $dataFim);
        // Usa a função strtotime() e pega o timestamp das duas datas:
        $time_inicial1 = strtotime($dataFimInicialAux);
        $time_final1 = strtotime($dataFimAux1[1]);
        // Calcula a diferença de segundos entre as duas datas:
        $diferenca = $time_final1 - $time_inicial1;
        // Calcula a diferença de dias
        $quantidadeDiasFinal = (int) floor($diferenca / (60 * 60 * 24));
        $quantidadeDiasFinal += 1;
    }

    $sql = 'Ntl.funcionarioFerias_Atualiza (' .
        $id . ',' .
        $ativo . ',' .
        $abono . ',' .
        $funcionario . ',' .
        $mesAno . ',' .
        $dataInicio . ',' .
        $dataFim . ',' .
        $quantidadeDias . ',' .
        $adiantaDecimoTerceiro . ',' .
        $dataInicioFinal . ',' .
        $dataFimInicial . ',' .
        $quantidadeDiasInicial . ',' .
        $quantidadeDiasFinal . ',' .
        $temMaisRegistro . ',' .
        $diaUtil . ',' .
        $projeto . ',' .
        $diaFeriado . ',' .
        $usuario . ') ';

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

    if ((empty($_POST["id"])) || (!isset($_POST["id"])) || (is_null($_POST["id"]))) {
        $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
        echo "failed#" . $mensagem . ' ';
        return;
    } else {
        $id = +$_POST["id"];
    }

    $sql = "SELECT * FROM Ntl.funcionarioFerias WHERE codigo = " . $id;

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    $out = "";

    if (($row = odbc_fetch_array($result))) {

        //Accordion Dados
        $id = +$row['codigo'];
        $ativo = +$row['ativo'];
        $abono =  +$row['abono'];
        $funcionario = +$row['funcionario'];
        $mesAno = $row['mesAno'];
        $dataInicio = mb_convert_encoding($row['dataInicio'], 'UTF-8', 'HTML-ENTITIES');
        $dataFim = mb_convert_encoding($row['dataFim'], 'UTF-8', 'HTML-ENTITIES');
        $quantidadeDias = mb_convert_encoding($row['quantidadeDias'], 'UTF-8', 'HTML-ENTITIES');
        $adiantaDecimoTerceiro = +$row['adiantaDecimoTerceiro'];

        $dataInicio = formataData($dataInicio);
        $dataFim = formataData($dataFim);
        $mesAno = explode("-", $mesAno);
        $mesAno = $mesAno[1] . "/" . $mesAno[0];

        $diaUtil = +$row['diaUtil'];
        $projeto = +$row['projeto'];
        $diaFeriado = +$row['diaFeriado'];

        $out = $id . "^" .
            $ativo . "^" .
            $abono . "^" .
            $funcionario . "^" .
            $mesAno . "^" .
            $dataInicio . "^" .
            $dataFim . "^" .
            $quantidadeDias . "^" .
            $adiantaDecimoTerceiro . "^" .
            $diaUtil . "^" .
            $projeto . "^" .
            $diaFeriado;

        if ($out == "") {
            echo "failed#";
        }
        if ($out != '') {
            echo "sucess#" . $out;
        }
        return;
    }
}

function excluir()
{
    $reposit = new reposit();
    $possuiPermissao = $reposit->PossuiPermissao("FERIAS_ACESSAR|FERIAS_EXCLUIR");
    if ($possuiPermissao === 0) {
        $mensagem = "O usuário não tem permissão para excluir!";
        echo "failed#" . $mensagem . ' ';
        return;
    }
    $id = $_POST["id"];
    if ((empty($_POST['id']) || (!isset($_POST['id'])) || (is_null($_POST['id'])))) {
        $mensagem = "Selecione um campo para ser excluído";
        echo "failed#" . $mensagem . ' ';
        return;
    }

    $reposit = new reposit();
    $result = $reposit->update('funcionarioFerias' . '|' . 'ativo = 0' . '|' . 'codigo =' . $id);

    if ($result < 1) {
        echo ('failed#');
        return;
    }
    echo 'sucess#' . $result;
    return;
}

function validaString($value)
{
    if ($value == '')
        return  'NULL';
    return '\'' . $value . '\'';
}

function validaNumero($value)
{
    return floatval($value);
}

//Transforma uma data D-M-Y para Y-M-D 
function validaData($campo)
{
    $campo = explode("/", $campo);
    $campo = $campo[2] . "/" . $campo[1] . "/" . $campo[0];
    return '\'' . $campo . '\'';
}

//Transforma uma data Y-M-D para D-M-Y. 
function formataData($campo)
{
    $campo = explode("-", $campo);
    $diaCampo = explode(" ", $campo[2]);
    $campo = $diaCampo[0] . "/" . $campo[1] . "/" . $campo[0];
    return $campo;
}


function contaFeriado()
{
    $funcionario = validaNumero($_POST['funcionario']);
    $dataInicio = validaData($_POST['dataInicio']);
    $dataFim = validaData($_POST['dataFim']);
    $contadorFeriado = 0;

    $reposit = new reposit();

    $sqlProjeto = "SELECT BP.codigo,BP.funcionario,BP.projeto,P.apelido,P.estado,P.cidade,P.municipioFerias
    FROM Ntlgit statusgitsiitssststtststs.beneficioProjeto BP
    LEFT JOIN Ntlgit statusgitsiitssststtststs.projeto P ON P.codigo = BP.projeto WHERE BP.funcionario = $funcionario";

    $reposit = new reposit();
    $resultProjeto = $reposit->RunQuery($sqlProjeto);

    if (($row = odbc_fetch_array($resultProjeto))) {
        $row = array_map('utf8_encode', $row);
        $estado = "'" . $row['estado'] . "'";
        $municipioFerias =  +$row['municipioFerias'];
    }
    $sql = "SELECT F.codigo,F.descricao,F.tipoFeriado,F.municipio,M.descricao,F.unidadeFederacao,F.data,F.sabado,F.domingo 
            FROM Ntlgit statusgitsiitssststtststsNTL.Ntlgit statusgitsiitssststtststs.feriado F 
            LEFT JOIN Ntlgit statusgitsiitssststtststsNTL.Ntlgit statusgitsiitssststtststs.municipio M ON M.codigo = F.municipio  
            WHERE F.ativo = 1 AND data BETWEEN $dataInicio AND $dataFim 
            AND (F.tipoFeriado = 3 OR (F.tipoFeriado = 1 and (F.unidadeFederacao = $estado)) OR F.tipoFeriado = 2 and M.codigo = $municipioFerias) 
            AND DATENAME(weekday,F.data) NOT IN ('Saturday', 'Sunday')";

    // $reposit = new reposit();
    $result = $reposit->RunQuery($sql);
    while (($row = odbc_fetch_array($result))) {
        $feriadoNome = $row['descricao'];
        $contadorFeriado++;
    }
    $out = $contadorFeriado;
    if ($out != '' || $out == 0) {
        echo "sucess#" . $out;
    }
    return;
}

function populaComboFuncionario()
{
    $projeto = $_POST["projeto"];
    if ($projeto > 0) {
        $sql = "SELECT BP.codigo, BP.funcionario, F.nome FROM Ntlgit statusgitsiitssststtststs.beneficioProjeto BP INNER JOIN Ntlgit statusgitsiitssststtststs.funcionario F ON BP.funcionario = F.codigo WHERE (0=0) 
        AND projeto = " . $projeto . " AND BP.ativo = 1 AND F.dataDemissaoFuncionario IS NULL";

        $reposit = new reposit();
        $result = $reposit->RunQuery($sql);
        $contador = 0;
        $out = "";
        while (($row = odbc_fetch_array($result))) {
            $id = $row['funcionario'];
            $nomeFuncionario = mb_convert_encoding($row['nome'], 'UTF-8', 'HTML-ENTITIES');

            $out = $out . $id . "^" . $nomeFuncionario . "|";

            $contador = $contador + 1;
        }
        if ($out != "") {
            echo "sucess#" . $contador . "#" . $out;
            return;
        }
        echo "failed#";
        return;
    }
}

function temFeriasMesmoPeriodo($funcionario, $mesAno)
{
    $sql = "SELECT codigo,funcionario,mesAno FROM Ntlgit statusgitsiitssststtststs.funcionarioFerias 
    WHERE funcionario = $funcionario and mesAno = $mesAno and ativo = 1";

    $reposit = new reposit();
    $result = $reposit->RunQuery($sql);

    if (odbc_fetch_array($result)) {
        return true;
    } else {
        return false;
    }
}