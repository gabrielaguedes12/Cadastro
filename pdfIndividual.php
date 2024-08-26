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

        $img = "./img/imageNTL.png";

        $this->Image($img, 75, 8, 65, 25); #logo da empresa
        $this->SetXY(100, 6);

        $this->SetFont('Arial', 'B', 15); #Seta a Fonte
        $this->SetXY(100, 40);
        $this->Cell(15, -1, iconv('UTF-8', 'windows-1252', 'Contato do Funcionário'), 0, 0, "C", false, '');
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

$sql = "SELECT F.codigo, nome, cpf,rg, dataNascimento,cep,logradouro,numero,complemento,uf,bairro,cidade,emprego,pis E.estadoCivil, G.descricao, F.ativo FROM dbo.funcionario F
                LEFT JOIN dbo.estadoCivil E ON E.codigo= F.estadoCivil 
                LEFT JOIN dbo.genero G ON G.codigo = F.idGenero ";

$reposit = new reposit();
$sql = $sql .  $where;
$resultQuery = $reposit->RunQuery($sql);

$pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);
//linhas
$pdf->setY(45);
$pdf->setX(18);
$pdf->Cell(50, 8, "Nome", 1, 20, 'C', true, "");

$pdf->setY(45);
$pdf->setX(68);
$pdf->Cell(40, 8, "CPF", 1, 20, 'C', true, "");

$pdf->setY(45);
$pdf->setX(108);
$pdf->Cell(30, 8, "Data Nascimento", 1, 20, 'C', true, "");

$pdf->setY(45);
$pdf->setX(138);
$pdf->Cell(30, 8, "Estado Civil", 1, 20, 'C', true, "");

$pdf->setY(45);
$pdf->setX(168);
$pdf->Cell(30, 8, iconv('UTF-8', 'windows-1252', 'Gênero'), 1, 20, 'C', true, "");

$y = $pdf->getY();

foreach ($resultQuery as $row) {
    $id =  $row['codigo'];
    $nome =  $row['nome'];
    $cpf =  $row['cpf'];
    $dataNascimento =  $row['dataNascimento'];
    $estadoCivil =  $row['estadoCivil'];
    $descricao =  $row['descricao'];   

    $pdf->setY($y);
    $pdf->setX(18);
    $pdf->Cell(50, 10, iconv('UTF-8', 'windows-1252', $nome), 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(68);
    $pdf->Cell(40, 10, $cpf, 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(108);
    $pdf->Cell(30, 10, $dataNascimento, 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(138);
    $pdf->Cell(30, 10, $estadoCivil, 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(168);
    $pdf->Cell(30, 10, $descricao, 1, 20, 'C', 0, "");

    $y = $pdf->getY();
}

$pdf->Ln(8);
$pdf->Output();
