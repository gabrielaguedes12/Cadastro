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

$sql = "SELECT F.codigo, nome, cpf,rg, dataNascimento,T.telefone, M.email,cep,logradouro,numero,complemento,uf,bairro,cidade,emprego,pis,E.estadoCivil, G.descricao, F.ativo FROM dbo.funcionario F
				LEFT JOIN dbo.telefone T ON T.idFuncio= F.codigo 
				LEFT JOIN dbo.email M ON M.idFunci= F.codigo                 	
				LEFT JOIN dbo.estadoCivil E ON E.codigo= F.estadoCivil 
                LEFT JOIN dbo.genero G ON G.codigo = F.idGenero ";

$reposit = new reposit();
$utils = new comum();
$sql = $sql .  $where;
$resultQuery = $reposit->RunQuery($sql);

$pdf->SetFont($tipoDeFonte, $fontWeightRegular, $tamanhoFonte);


$pdf->setY(100);
$pdf->setX(15);
$pdf->Cell(40, 8, "Telefone", 1, 20, 'C', true, "");

$pdf->setY(100);
$pdf->setX(55);
$pdf->Cell(20, 8, "Principal", 1, 20, 'C', true, "");

$pdf->setY(100);
$pdf->setX(75);
$pdf->Cell(20, 8, 'Whatsapp', 1, 20, 'C', true, "");

$pdf->setY(100);
$pdf->setX(125);
$pdf->Cell(50, 8, "Email", 1, 20, 'C', true, "");

$pdf->setY(100);
$pdf->setX(175);
$pdf->Cell(20, 8, 'Principal', 1, 20, 'C', true, "");

$y = $pdf->getY();

//linhas
$pdf->setY(130);
$pdf->setX(5);
$pdf->Cell(25, 8, "CEP", 1, 20, 'C', true, "");

$pdf->setY(130);
$pdf->setX(30);
$pdf->Cell(60, 8, iconv('UTF-8', 'windows-1252',"Logradouro"), 1, 20, 'C', true, "");

$pdf->setY(130);
$pdf->setX(90);
$pdf->Cell(20, 8, iconv('UTF-8', 'windows-1252','Número'), 1, 20, 'C', true, "");

$pdf->setY(130);
$pdf->setX(110);
$pdf->Cell(30, 8,iconv('UTF-8', 'windows-1252', "Complemento"), 1, 20, 'C', true, "");

$pdf->setY(130);
$pdf->setX(140);
$pdf->Cell(10, 8, 'UF', 1, 20, 'C', true, "");

$pdf->setY(130);
$pdf->setX(150);
$pdf->Cell(30, 8, 'Bairro', 1, 20, 'C', true, "");

$pdf->setY(130);
$pdf->setX(180);
$pdf->Cell(25, 8, 'Cidade', 1, 20, 'C', true, "");

$y = $pdf->getY();

$pdf->setY(230);
$pdf->setX(15);
$pdf->Cell(60, 8, iconv('UTF-8', 'windows-1252',"Nome Dependente"), 1, 20, 'C', true, "");

$pdf->setY(230);
$pdf->setX(75);
$pdf->Cell(40, 8, "CPF", 1, 20, 'C', true, "");

$pdf->setY(230);
$pdf->setX(115);
$pdf->Cell(30, 8, 'Data Nascimento', 1, 20, 'C', true, "");

$pdf->setY(230);
$pdf->setX(145);
$pdf->Cell(30, 8,iconv('UTF-8', 'windows-1252', "Tipo"), 1, 20, 'C', true, "");


foreach ($resultQuery as $row) {
    $id = $row['codigo'];
    $nome = $row['nome'];
    $cpf = $row['cpf'];
    $rg = $row['rg'];
    $dataNascimento = $utils->validaData($row['dataNascimento']);
    $estadoCivil = $row['estadoCivil'];
    $idGenero = $row['idGenero'];
    $telefone = $row['telefone'];
    $principal = $row['principal'];
    $whats = $row['whats'];
    $email = $row['email'];
    $principal = $row['principal'];
    $cep = $row['cep'];
    $logradouro = $row['logradouro'];
    $numero = $row['numero'];
    $complemento = $row['complemento'];
    $uf = $row['uf'];
    $bairro = $row['bairro'];
    $cidade = $row['cidade'];
    $nomeDependentes = $row['nomeDependentes'];
    $cpfDependentes = $row['cpfDependentes'];
    $dataNascimentoDependentes = $row['dataNascimentoDependentes'];
    $tipo = $row['tipo'];
    
    //telefone e email
    $pdf->setY($y);
    $pdf->setX(5);
    $pdf->Cell(25, 10, $cep, 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(30);
    $pdf->Cell(60, 10,iconv('UTF-8', 'windows-1252', $logradouro), 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(90);
    $pdf->Cell(20, 10, $numero, 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(110);
    $pdf->Cell(30, 10,iconv('UTF-8', 'windows-1252', $complemento), 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(140);
    $pdf->Cell(10, 10, $uf, 1, 20, 'C', 0, "");

    //endereço
    $pdf->setY($y);
    $pdf->setX(5);
    $pdf->Cell(25, 10, $cep, 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(30);
    $pdf->Cell(60, 10,iconv('UTF-8', 'windows-1252', $logradouro), 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(90);
    $pdf->Cell(20, 10, $numero, 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(110);
    $pdf->Cell(30, 10,iconv('UTF-8', 'windows-1252', $complemento), 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(140);
    $pdf->Cell(10, 10, $uf, 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(150);
    $pdf->Cell(30, 10, iconv('UTF-8', 'windows-1252',$bairro), 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(180);
    $pdf->Cell(25, 10,iconv('UTF-8', 'windows-1252', $cidade), 1, 20, 'C', 0, "");

    $y = $pdf->getY();

    //dependente
    $pdf->setY($y);
    $pdf->setX(110);
    $pdf->Cell(30, 10,iconv('UTF-8', 'windows-1252', $complemento), 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(140);
    $pdf->Cell(10, 10, $uf, 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(150);
    $pdf->Cell(30, 10, iconv('UTF-8', 'windows-1252',$bairro), 1, 20, 'C', 0, "");

    $pdf->setY($y);
    $pdf->setX(180);
    $pdf->Cell(25, 10,iconv('UTF-8', 'windows-1252', $cidade), 1, 20, 'C', 0, "");

    $y = $pdf->getY();
}

$pdf->Ln(8);
$pdf->Output();
