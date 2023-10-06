<?php
session_start();
header("Content-Type: text/html;charset=utf-8");
ob_start();
require('fpdf.php');

require_once(dirname(__FILE__) . "/../model/Print_payrollModel.php");
require_once(dirname(__FILE__) . "/../model/LogsModel.php");

$data = Print_payrollModel::Data_Membrete($_SESSION['user_login_status']['id']);

$pdf = new FPDF();
$pdf->AddPage();
//$pdf->Image('../img/Hoja-membrete.png',-10,0,-370);


   
   
    if (strpos(strtoupper($data['datos'][0]['staff']), strtoupper('aramount')) !== false) {
     
        $pdf->Image('../img/paramount.png',0,0,210,300);
    }

    if (strpos(strtoupper($data['datos'][0]['staff']), strtoupper('llegiance')) !== false) {
     
        $pdf->Image('../img/allegiance.png',0,0,210,300);
    }

    if (strpos(strtoupper($data['datos'][0]['staff']), strtoupper('lpine')) !== false) {
     
        $pdf->Image('../img/alpine.png',0,0,210,300);
    }
    
    if (strpos(strtoupper($data['datos'][0]['staff']), strtoupper('almetto')) !== false) {
     
        $pdf->Image('../img/palmetto.png',0,0,210,300);
    }
    
    if (strpos(strtoupper($data['datos'][0]['staff']), strtoupper('rgos')) !== false) {
     
        $pdf->Image('../img/argos.png',0,0,210,300);
    }
	
	if (strpos(strtoupper($data['datos'][0]['staff']), strtoupper('luna')) !== false) {
     
        $pdf->Image('../img/luna.png',0,0,210,300);
    }

    if (strpos(strtoupper($data['datos'][0]['staff']), strtoupper('lliance')) !== false) {
     
        $pdf->Image('../img/alliance.png',0,0,210,300);
    }
    
   

  
    $pdf->Ln(35);
    $pdf->Cell(16);
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell(10,47,''.date('m-d-Y'),'C');
    $pdf->Ln(10);
    $pdf->Cell(16);
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell(10,47,'Employer Name:','C');
    $pdf->Cell(21);
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(10,47,$data['datos'][0]['staff'],'C');
    $pdf->Ln(10);
    $pdf->Cell(16);
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell(10,47,'Address:','C');
    $pdf->Cell(8);
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(10,47,$data['datos'][0]['addres_staff'],'C');
    $pdf->Ln(10);
    $pdf->Cell(16);
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell(10,47,'RE:','C');
    $pdf->Cell(-4);
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(4,47,' Verification of Employment '.$data['datos'][0]['name_emp'],'C');
    $pdf->Ln(10);
    $pdf->Cell(16);
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(10,47,'To whom this may concern,','C');
    $pdf->Ln(30);
    $pdf->Cell(16);
    $pdf->SetFont('Arial','',11);
    $pdf-> SetRightMargin(25);
    $pdf->MultiCell(0,5,'Please accept this letter as confirmation that '.$data['datos'][0]['name_emp'].' has been employed with '.$data['datos'][0]['staff'].'. since '.$data['datos'][0]['fecha_contratacion'].'.');

    $pdf->Ln(6);
    $pdf->Cell(16);
    $pdf->SetFont('Arial','',11);
   
    $pdf->MultiCell(0,5,'Currently '.$data['datos'][0]['name_emp'].' holds the title of '. $data['datos'][0]['position'].' and works on a full-time basis of 40 hours per week while earning $'.$data['datos'][0]['rate'].' payable hourly and does not receive any type of bonus.');

    $pdf->Ln(6);
    $pdf->Cell(16);
    $pdf->SetFont('Arial','',11);
    $pdf->MultiCell(0,5,'If you have any question or require further information, please do not hesitate to contact me at (704) 606-7871 or marioluna@staffinggroup.com');
    $pdf->Ln(15);
    $pdf->Cell(16);
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(10,47,'Sincerely yours,','C');

    $pdf->Ln(10);
    $pdf->Cell(16);
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(10,47,'Signature:','C');

    $pdf->Image('../img/firma.jpeg',30,213,40,20);
    $pdf->SetLineWidth(0.5);
    $pdf->Line(27,230,78,230);
    
    $pdf->Ln(30);
    $pdf->Cell(16);
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(10,47,'By Mario A. Luna Garcia','C');

    $pdf->Ln(10);
    $pdf->Cell(16);
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(10,47,'Employer Title: President','C');
// Insert a dynamic image from a URL
//$pdf->Image('http://chart.googleapis.com/chart?cht=p3&chd=t:60,40&chs=250x100&chl=Hello|World',60,30,90,0,'PNG');

$pdf->Output('my_file.pdf','I');