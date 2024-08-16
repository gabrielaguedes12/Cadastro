<?php

include "repositorio.php";

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
        $sqlLogo = "SELECT nome  FROM dbo.funcionario";
        $reposit = new reposit();
        $result = $reposit->RunQuery($sqlLogo);


        // $rowLogo = $result[0];
        // $logo = $rowLogo['parametroLogoRelatorio'];
        // if ($logo != "") {
        //     $img = explode('/', $logo);
        //     $img = $img[1] . "/" . $img[2] . "/" . $img[3];
        //     $img = str_replace('"', "'", $img);


        //     list($x1, $y1) = getimagesize($img);
        //     $x2 = 15;
        //     $y2 = 10;
        //     if (($x1 / $x2) < ($y1 / $y2)) {
        //         $y2 = 5;
        //     } else {
        //         $x2 = 5;
        //     }
        //     $this->Cell(116, 1, "", 0, 1, 'C', $this->Image($img, $x2, $y2, 0, 15));
        // }
        // $sqlMarca = "SELECT parametroMarca 
        // FROM Ntl.parametro ";
        // $reposit = new reposit();
        // $result = $reposit->RunQuery($sqlMarca);
        // $rowMarca = $result[0];
        // $logoMarca = $rowMarca['parametroMarca'];
        // if ($logoMarca != "") {
        //     $img1 = explode('/', $logoMarca);
        //     $img1 = $img1[1] . "/" . $img1[2] . "/" . $img1[3];
        //     $img1 = str_replace('"', "'", $img1);
        //     list($x3, $y3) = getimagesize($img1);
        //     $x4 = 1;
        //     $y4 = 100;
        //     if (($x3 / $x4) < ($y3 / $y4)) {
        //         $y4 = 5;
        //     } else {
        //         $x4 = 50;
        //     }
        //     $this->Image($img1, $x4, $y4, 105, 105);
        // }
        //        if ($nomeLogoRelatorio != "")
        //        $this->SetFont('Arial', '', 8); #Seta a Fonte
        //        $dataAux = new DateTime();
        //        $dataAux->setTimezone(new DateTimeZone("GMT-3"));
        //        $dataAtualizada = $dataAux->format('d/m/Y H:i:s');
        //        $this->Cell(288, 0, $dataAtualizada, 0, 0, 'R', 0); #Título do Relatório
        // $this->Cell(116, 1, "", 0, 1, 'C', 0); #Título do Relatório
        // $this->Image($img, 7, 5, 13, 13); #logo da empresa
        // $this->SetXY(190, 5);
        // $this->SetFont('Arial', 'B', 8); #Seta a Fonte

        // $this->Cell(20, 7.5, 'Pagina ' . $this->pageno()); #Imprime o Número das Páginas

        // $this->Ln(24); #Quebra de Linhas

        // $this->SetTextColor(255, 192, 203);
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

$sql = "SELECT codigo,nome,ativo,cpf,rg,dataNascimento,estadoCivil,idGenero,cep,logradouro,numero,complemento,uf,bairro,cidade,emprego,pis
 from dbo.funcionario";

$reposit = new reposit();
$resultQuery = $reposit->RunQuery($sql);

if ($resultQuery[0]) {
    $id = $resultQuery['codigo'];
    $nome = $resultQuery[0]['nome'];
    $cpf = $resultQuery[2]['cpf'];
    $rg = $resultQuery[0]['rg'];
    $dataNascimento = $resultQuery[0]['dataNascimento'];
    $estadoCivil = $resultQuery[0]['estadoCivil'];
    $idGenero = $resultQuery[0]['idGenero'];
    // $cep = $resultQuery[0]['cep'];
    // $logradouro = $resultQuery[0]['logradouro'];
    // $numero = $resultQuery[0]['numero'];
    // $complemento = $resultQuery[0]['complemento'];
    // $uf = $resultQuery[0]['uf'];
    // $bairro = $resultQuery[0]['bairro'];
    // $cidade = $resultQuery[0]['cidade'];
    $emprego = $resultQuery[0]['emprego'];
    $pis = $resultQuery[0]['pis'];
}

$pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);

$pdf->setY(28);
$pdf->setX(25);
$pdf->Cell(180, 15, "", 1, 10, 'C', 0, "");
$pdf->Cell(25, -1, iconv('UTF-8', 'windows-1252', $nome), 0, 0, "L", 0,"");
$pdf->Cell(30, -1, iconv('UTF-8', 'windows-1252', $cpf), 0, 0, "L", 0,"");
$pdf->Cell(40, -1, iconv('UTF-8', 'windows-1252', $rg), 0, 0, "L", 0,"");
$pdf->Cell(40, -1, iconv('UTF-8', 'windows-1252', $dataNascimento), 0, 0, "L", 0,"");
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $estadoCivil), 0, 0, "L", 0);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $idGenero), 0, 0, "L", 0);
// $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $cep), 0, 0, "L", 0);
// $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $logradouro), 0, 0, "L", 0);
// $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $numero), 0, 0, "L", 0);
// $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $complemento), 0, 0, "L", 0);
// $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $uf), 0, 0, "L", 0);
// $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $bairro), 0, 0, "L", 0);
// $pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $cidade), 0, 0, "L", 0);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $emprego), 0, 0, "L", 0);
$pdf->Cell(20, -1, iconv('UTF-8', 'windows-1252', $pis), 0, 0, "L", 0);
// Dependentes nome, cpf  data e tipo

$pdf->Ln(8);
$pdf->Output();