<?php

include "repositorio.php";
include "js/girComum.php";
//initilize the page
require_once("inc/init.php");
//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

require('./fpdf/mc_table.php');
// $codigoLogin = $_SESSION['codigo'];

// if ((empty($_GET["id"])) || (!isset($_GET["id"])) || (is_null($_GET[""]))) {
//     $mensagem = "Nenhum parâmetro de pesquisa foi informado.";
//     echo "failed#" . $mensagem . ' ';
//     return;
// }

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

require_once('fpdf/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        $this->SetLineWidth(1);
        global $codigo;

        $img = "./img/imageNTL.png";

        $this->Image($img, 75, 8, 65, 25); #logo da empresa
        $this->SetXY(100, 6);

        $this->SetFont('Arial', 'B', 15); #Seta a Fonte
        $this->SetXY(100, 40);
        $this->Cell(15, -1, iconv('UTF-8', 'windows-1252', 'Dados do Funcionário'), 0, 0, "C", false, '');
        $this->Ln(24); #Quebra de Linhas

        $this->SetTextColor(255, 192, 203);
        // $this->Image('C:\inetpub\wwwroot\Cadastro\img\marcaDagua.png', 35, 45, 135, 145, 'PNG');
    }
    function Footer()
    {
        $this->SetY(-15);
        $this->Cell(0, 0, iconv('UTF-8', 'windows-1252', 'Página ' . $this->PageNo()), 0, 0, "C", 0, 0);
    }
}
$pdf = new PDF('P', 'mm', 'A4'); #Crio o PDF padrão RETRATO, Medida em Milímetro e papel A$
$pdf->SetFillColor(238, 238, 238);
$pdf->SetMargins(0, 0, 0); #Seta a Margin Esquerda com 20 milímetro, superrior com 20 milímetro e esquerda com 20 milímetros
$pdf->SetDisplayMode('default', 'continuous'); #Digo que o PDF abrirá em tamanho PADRÃO e as páginas na exibição serão contínuas
$pdf->SetFont('Arial', 'B', 16);
$pdf->AddPage();

$tamanhoFonte = 10;
$tamanhoFonteMenor = 8;
$fontWeight = 'B';

$id = $_GET["id"];

$sql = "SELECT codigo,nome,ativo,cpf,rg,dataNascimento,cep,logradouro,numero,complemento,uf,bairro,cidade
    from dbo.funcionario 
    WHERE (0 = 0) and codigo = $id";

$reposit = new reposit();
$utils = new comum();
$sql = $sql .  $where;
$resultQuery = $reposit->RunQuery($sql);

$y = 45;
//dados do funcionario
$pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);

$pdf->setY($y);
$pdf->setX(5);
$pdf->Cell(50, 8, iconv('UTF-8', 'windows-1252', "Nome"), 1, 20, 'C', true, "");

$pdf->setY($y);
$pdf->setX(55);
$pdf->Cell(50, 8, "CPF", 1, 20, 'C', true, "");


$pdf->setY($y);
$pdf->setX(105);
$pdf->Cell(50, 8, 'RG', 1, 20, 'C', true, "");



$pdf->setY($y);
$pdf->setX(155);
$pdf->Cell(50, 8, "Data de nascimento", 1, 20, 'C', true, "");



foreach ($resultQuery as $row) {
    $id = $row['codigo'];
    $nome = $row['nome'];
    $cpf = $row['cpf'];
    $rg = $row['rg'];
    $dataNascimento = $utils->validaData($row['dataNascimento']);
    $cep = $row['cep'];
    $logradouro = $row['logradouro'];
    $numero = $row['numero'];
    $complemento = $row['complemento'];
    $uf = $row['uf'];
    $bairro = $row['bairro'];
    $cidade = $row['cidade'];

    $abreviarNome = explode(" ", $nome);
    $nomeAux =  "";
    if (count($abreviarNome) >= 3) {
        for ($i = 0; (count($abreviarNome)) > $i; $i++) {

            if ($i == 0) {
                $nomeAux = ucfirst($abreviarNome[$i]) . " ";
            }
            if ($i > 0 && strlen($abreviarNome[$i]) > 3 && ($i<count($abreviarNome) - 1)) {

                $abreviarNome[$i] = substr($abreviarNome[$i], 0, 1) . ".";

                if ($nomeAux != "") {
                    $nomeAux = $nomeAux . ucfirst($abreviarNome[$i]) . " ";
                } else {
                    $nomeAux =  ucfirst($abreviarNome[$i]) . " ";
                }
            }
            if($i == count($abreviarNome) - 1 ){
                $nomeAux = $nomeAux . ucfirst($abreviarNome[$i]);
            }
        }
    } else{
        $nomeAux = $nome;
    }

    $pdf->setY($y + 8);
    $pdf->setX(5);
    $pdf->Cell(50, 10, iconv('UTF-8', 'windows-1252', $nomeAux), 1, 20, 'C', 0, "");

    $pdf->setY($y + 8);
    $pdf->setX(55);
    $pdf->Cell(50, 10, $cpf, 1, 20, 'C', 0, "");

    $pdf->setY($y + 8);
    $pdf->setX(105);
    $pdf->Cell(50, 10, $rg, 1, 20, 'C', 0, "");

    $pdf->setY($y + 8);
    $pdf->setX(155);
    $pdf->Cell(50, 10, iconv('UTF-8', 'windows-1252', $dataNascimento), 1, 20, 'C', 0, "");

    // //endereço

    $y = 125;

    $pdf->setY($y);
    $pdf->setX(5);
    $pdf->Cell(25, 8, "CEP", 1, 20, 'C', true, "");

    $pdf->setY($y + 8);
    $pdf->setX(5);
    $pdf->Cell(25, 10, $cep, 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(30);
    $pdf->Cell(60, 8, iconv('UTF-8', 'windows-1252', "Logradouro"), 1, 20, 'C', true, "");

    $pdf->setY($y + 8);
    $pdf->setX(30);
    $pdf->Cell(60, 10, iconv('UTF-8', 'windows-1252', $logradouro), 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(90);
    $pdf->Cell(20, 8, iconv('UTF-8', 'windows-1252', 'Número'), 1, 20, 'C', true, "");

    $pdf->setY($y + 8);
    $pdf->setX(90);
    $pdf->Cell(20, 10, $numero, 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(110);
    $pdf->Cell(30, 8, iconv('UTF-8', 'windows-1252', "Complemento"), 1, 20, 'C', true, "");

    $pdf->setY($y + 8);
    $pdf->setX(110);
    $pdf->Cell(30, 10, iconv('UTF-8', 'windows-1252', $complemento), 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(140);
    $pdf->Cell(10, 8, 'UF', 1, 20, 'C', true, "");

    $pdf->setY($y + 8);
    $pdf->setX(140);
    $pdf->Cell(10, 10, $uf, 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(150);
    $pdf->Cell(30, 8, 'Bairro', 1, 20, 'C', true, "");

    $pdf->setY($y + 8);
    $pdf->setX(150);
    $pdf->Cell(30, 10, iconv('UTF-8', 'windows-1252', $bairro), 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(180);
    $pdf->Cell(25, 8, 'Cidade', 1, 20, 'C', true, "");

    $pdf->setY($y + 8);
    $pdf->setX(180);
    $pdf->Cell(25, 10, iconv('UTF-8', 'windows-1252', $cidade), 1, 20, 'C', 0, "");

    $y = $pdf->getY();
}
$id = $_GET["id"];

$sql = "SELECT t.codigo, t.idFuncio, t.principal, CASE WHEN t.principal = 1 THEN 'Sim' ELSE 'Não' END descricaoPrincipal , t.telefone, t.telefoneId, t.whats,
CASE WHEN t.whats = 1 THEN 'Sim' ELSE 'Não' END descricaoWhats	
        FROM telefone t
          WHERE (0 = 0) and idFuncio = $id ";

$reposit = new reposit();
$utils = new comum();
$sql = $sql .  $where;
$resultQuery = $reposit->RunQuery($sql);

//contato
$pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
$pdf->setY(85);
$pdf->setX(15);
$pdf->Cell(50, 8, "Telefone", 1, 20, 'C', true, "");

$pdf->setY(85);
$pdf->setX(65);
$pdf->Cell(20, 8, "Principal", 1, 20, 'C', true, "");

$pdf->setY(85);
$pdf->setX(85);
$pdf->Cell(20, 8, "Whatsapp", 1, 20, 'C', true, "");

$y = $pdf->getY();

foreach ($resultQuery as $row) {
    
    $telefone = $row['telefone'];
    $descricaoPrincipal = $row['descricaoPrincipal'];
    $telefoneId = $row['telefoneId'];
    $descricaoWhats = $row['descricaoWhats'];
    $idFuncio = $row['idFuncio'];

    // telefone 
    $pdf->setY($y);
    $pdf->setX(15);
    $pdf->Cell(50, 10, $telefone, 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(65);
    $pdf->Cell(20, 10, iconv('UTF-8', 'windows-1252', $descricaoPrincipal), 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(85);
    $pdf->Cell(20, 10, iconv('UTF-8', 'windows-1252', $descricaoWhats), 1, 20, 'C', 0, "");

    $y = $pdf->getY();
}

$sql = "SELECT t.codigo,t.idFunci, t.principalEmail,
		CASE WHEN t.principalEmail = 1 THEN 'Sim' ELSE 'Não' END descricaoPrincipalEmail, t.email,t.emailId
        FROM email t
        WHERE (0 = 0) and idFunci = $id";

$reposit = new reposit();
$utils = new comum();
$sql = $sql .  $where;
$resultQuery = $reposit->RunQuery($sql);

$pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
$pdf->setY(85);
$pdf->setX(115);
$pdf->Cell(60, 8, "Email", 1, 20, 'C', true, "");

$pdf->setY(85);
$pdf->setX(175);
$pdf->Cell(20, 8, "Principal", 1, 20, 'C', true, "");
$y = $pdf->getY();

foreach ($resultQuery as $row) {    
    $email = $row['email'];
    $emailId = $row['emailId'];
    $descricaoPrincipalEmail = $row['descricaoPrincipalEmail'];
    $idFunci = $row['idFunci'];

    $pdf->setY($y);
    $pdf->setX(115);
    $pdf->Cell(60, 10, iconv('UTF-8', 'windows-1252', $email), 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(175);
    $pdf->Cell(20, 10, iconv('UTF-8', 'windows-1252', $descricaoPrincipalEmail), 1, 20, 'C', 0, "");

    $y = $pdf->getY();
}

$id = $_GET["id"];
$sql = "SELECT D.codigo,D.idFuncionario,D.nomeDependentes,D.cpfDependentes,D.dataNascimentoDependentes,TD.tipo 
FROM dbo.dependentes D 

LEFT JOIN dbo.tipoDependentes TD ON D.tipo = TD.codigo WHERE (0 = 0) and idFuncionario = $id";

$reposit = new reposit();
$utils = new comum();
$sql = $sql .  $where;
$resultQuery = $reposit->RunQuery($sql);

$pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
$pdf->setY(165);
$pdf->setX(10);
$pdf->Cell(60, 8, iconv('UTF-8', 'windows-1252', "Nome Dependente"), 1, 20, 'C', true, "");

$pdf->setY(165);
$pdf->setX(70);
$pdf->Cell(50, 8, "CPF", 1, 20, 'C', true, "");

$pdf->setY(165);
$pdf->setX(120);
$pdf->Cell(40, 8, 'Data Nascimento', 1, 20, 'C', true, "");

$pdf->setY(165);
$pdf->setX(160);
$pdf->Cell(40, 8, iconv('UTF-8', 'windows-1252', "Tipo"), 1, 20, 'C', true, "");
$y = $pdf->getY();

foreach ($resultQuery as $row) {
    
    $idFuncionario = $row['idFuncionario'];
    $nomeDependentes = $row['nomeDependentes'];
    $cpfDependentes = $row['cpfDependentes'];
    $dataNascimentoDependentes = $utils->validaData($row['dataNascimentoDependentes']);
    $tipo = $row['tipo'];

    $abreviarNome = explode(" ", $nomeDependentes);
    $nomeAuxDependentes =  "";
    if (count($abreviarNome) >= 3) {
        for ($i = 0; (count($abreviarNome)) > $i; $i++) {

            if ($i == 0) {
                $nomeAuxDependentes = ucfirst($abreviarNome[$i]) . " ";
            }
            if ($i > 0 && strlen($abreviarNome[$i]) > 3 && ($i<count($abreviarNome) - 1)) {

                $abreviarNome[$i] = substr($abreviarNome[$i], 0, 1) . ".";

                if ($nomeAuxDependentes != "") {
                    $nomeAuxDependentes = $nomeAuxDependentes . ucfirst($abreviarNome[$i]) . " ";
                } else {
                    $nomeAuxDependentes =  ucfirst($abreviarNome[$i]) . " ";
                }
            }
            if($i == count($abreviarNome) - 1 ){
                $nomeAuxDependentes = $nomeAuxDependentes . ucfirst($abreviarNome[$i]);
            }
        }
    } else{
        $nomeAuxDependentes = $nomeDependentes;
    }

    $pdf->setY($y);
    $pdf->setX(10);
    $pdf->Cell(60, 10, iconv('UTF-8', 'windows-1252', $nomeAuxDependentes), 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(70);
    $pdf->Cell(50, 10, $cpfDependentes, 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(120);
    $pdf->Cell(40, 10, iconv('UTF-8', 'windows-1252', $dataNascimentoDependentes), 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(160);
    $pdf->Cell(40, 10, iconv('UTF-8', 'windows-1252', $tipo), 1, 20, 'C', 0, "");

    $y = $pdf->getY();
}

$pdf->Ln(8);
$pdf->Output();
