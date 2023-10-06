<?php
session_start();
header("Content-Type: text/html;charset=utf-8");
ob_start();
require('fpdf.php');

require_once(dirname(__FILE__) . "/../model/print_fast_checkModel.php");
require_once(dirname(__FILE__) . "/../model/LogsModel.php");

    $id_payroll = $_GET['id'];
    if (!isset($_GET)) {
        die('Error.');
    }

    $id_payrolls =  array();
   
        $id_payrolls[0]=$id_payroll;
    

    
    $pdf = new FPDF();
foreach($id_payrolls as $item){
    $data = Print_fast_checkModel::Data_Cheque($item);


    $valor =$data['datos'][0]['val_total'];
    $float =explode(".", $data['datos'][0]['val_total']-(($data['datos'][0]['tax']*$data['datos'][0]['val_total'])/100));

   
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(170);
    $pdf->Cell(5,26,''.date('m-d-Y'),'C');
    $pdf->Ln(2);
    $pdf->Cell(16);
    $pdf->Cell(10,47,$data['datos'][0]['nombre']);
    $pdf->Cell(144);

     $value = $data['datos'][0]['val_total']-(($data['datos'][0]['tax']*$data['datos'][0]['val_total'])/100);

     if(is_int($value)){
        $pdf->Cell(10,48,$data['datos'][0]['val_total']-(($data['datos'][0]['tax']*$data['datos'][0]['val_total'])/100) .".00*");
     }else{
        $pdf->Cell(10,48,number_format($data['datos'][0]['val_total']-(($data['datos'][0]['tax']*$data['datos'][0]['val_total'])/100), 2, '.', '') ."*");
     }


    $pdf->Ln(9);
    $pdf->Cell(3);
    $pdf->Cell(10,49,convertNumber(number_format($data['datos'][0]['val_total']-(($data['datos'][0]['tax']*$data['datos'][0]['val_total'])/100), 2, '.', '') ) .' and '.$float[1]."/100"." ******************");
    $pdf->Cell(60);
    //$pdf->Cell(10,54,"*************");
    $pdf->Ln(7);
    $pdf->Cell(13);
    $pdf->Cell(10,54,$data['datos'][0]['nombre']);
    $pdf->Ln(5);
    $pdf->Cell(13);
    $pdf->Cell(10,54," "."");
    $pdf->Ln(5);
    $pdf->Cell(13);
    $pdf->Cell(10,54," "." "." ");
    
    $pdf->Ln(12);
    $pdf->Cell(13);
    $pdf->Cell(10,50,"Pay period ". date('m-d-Y') );

    //CUADRO 1
    $pdf->Ln(29);
   
   
    
    $pdf->SetLineWidth(0.5);
    $pdf->Line(10,108,94,108);

    $pdf->Line(110,108,198,108);
    
    
    $pdf->Line(10,124,94,124);
    
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(10,54,"Employee");
    
    $pdf->Cell(90);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(10,54,"SSN");

    $pdf->Ln(6);
    $pdf->Line(60,165,94,165);
    $pdf->Line(60,177,94,177);
    $pdf->SetFont('Arial','',6);
    $pdf->Cell(10,54,$data['datos'][0]['nombre'].""." ".""." "." "." ");
    $pdf->Cell(90);
    $pdf->Cell(10,54," " . " " );
    $pdf->Ln(5);
    $pdf->Cell(100);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(10,54,"Pay period: "." "." Pay Date: ".date('m-d-Y'));

    $pdf->Ln(30);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,4,"Earnings and Hours");
    $pdf->Cell(10,4,"QTY");
    $pdf->Cell(10,4,"Rate");
    $pdf->Cell(15,4,"Current");
    $pdf->Cell(20,4,"YDT Amount");
    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Regular");
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(10,6," ");
    $pdf->Cell(10,6," ");
    $pdf->Cell(15,6,"$0");
    //pendiente
    $pdf->Cell(20,6,"$0");

    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Over time");
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(10,6,"0");
    $pdf->Cell(10,6,"0");
    $pdf->Cell(15,6,"$0");
    //pendiente
    $pdf->Cell(20,6,"$"."0");
    

    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Missing H");
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(10,6,"0");
    $pdf->Cell(10,6,"0");
    
        $pdf->Cell(15,6,"$0");
    
   
    //pendiente
    $pdf->Cell(20,6,"$"."0");



    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Missing Over time");
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(10,6,"0");
    $pdf->Cell(10,6,"0");
    
        $pdf->Cell(15,6,"$0");
    
   
    //pendiente
    $pdf->Cell(20,6,"$"."0");


    
    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"PTO");
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(10,6,"0");
    $pdf->Cell(10,6,"0");
    $pdf->Cell(15,6,"$0");
    //pendiente
    $pdf->Cell(20,6,"$"."0");


    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Bonus");
    $pdf->SetFont('Arial','',8);
    
    $pdf->Cell(20,6,"");
        $pdf->Cell(15,6,"$0");
    
    
    //pendiente
    $pdf->Cell(20,6,"$"."0");


    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Deduction");
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(20,6,"");
    
        $pdf->Cell(15,6,"$0");
    
    
    //pendiente
    $pdf->Cell(20,6,"$"."0");


    
    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Subtotal");
    $pdf->SetFont('Arial','',8);
    
    $pdf->Cell(20,6,"");
    $pdf->Cell(15,6,"$".number_format($data['datos'][0]['val_total'], 2, '.', ''));
    //pendiente
    $pdf->Cell(20,6,"$".number_format($data['datos'][0]['total'], 2, '.', ''));


    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Federal tax");
    $pdf->SetFont('Arial','',8);
    
    $pdf->Cell(20,6,"-".$data['datos'][0]['tax']."%");
    $pdf->Cell(15,6,"-$".number_format((($data['datos'][0]['tax']*$data['datos'][0]['val_total'])/100), 2, '.', ''));
    //pendiente
    $pdf->Cell(20,6,"-$".number_format(($data['datos'][0]['total_tax']), 2, '.', ''));


    
    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Pay Net");
    $pdf->SetFont('Arial','',8);
    
    $pdf->Cell(20,6,"");
    $pdf->Cell(15,6,"$".number_format($data['datos'][0]['val_total']-(($data['datos'][0]['tax']*$data['datos'][0]['val_total'])/100), 2, '.', '') );
    //pendiente
    $pdf->Cell(20,6,"$".number_format(($data['datos'][0]['subtotal']), 2, '.', ''));



    //CUADRO 2
    $pdf->Ln(0.1);
    
    $pdf->SetLineWidth(0.5);
    $pdf->Line(10,200,94,200);
    
    $pdf->Line(110,200,198,200);
    
    $pdf->Line(10,212,94,212);

   

   // $pdf->Rect(10, 203, 188, 80, 'D');
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(10,40,"Employee");
    



    //$pdf->Line(50, 45, 210-50, 45);
    $pdf->Cell(90);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(10,40,"SSN");

    $pdf->Ln(1);
    $pdf->Line(60,255,94,255);
    $pdf->Line(60,265,94,265);

    
    
    $pdf->SetFont('Arial','',6);
    $pdf->Cell(5,46,$data['datos'][0]['nombre']."  ");
    $pdf->Cell(95);
    $pdf->Cell(10,46, " " . " " );
    $pdf->Ln(5);
    $pdf->Cell(100);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(10,46,"Pay period: ".""." Pay Date: ".date('m-d-Y'));

    $pdf->Ln(24);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,4,"Earnings and Hours");
    $pdf->Cell(10,4,"QTY");
    $pdf->Cell(10,4,"Rate");
    $pdf->Cell(15,4,"Current");
    $pdf->Cell(20,4,"YDT Amount");
    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Regular");
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(10,6,"0");
    $pdf->Cell(10,6,"0");
    $pdf->Cell(15,6,"$0");
    //pendiente
    $pdf->Cell(20,6,"$0");

    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Over time");
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(10,6,"0");
    $pdf->Cell(10,6,"0");
    $pdf->Cell(15,6,"$0");
    //pendiente
    $pdf->Cell(20,6,"$"."0");
    

    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Missing H");
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(10,6,"0");
    $pdf->Cell(10,6,"0");
        $pdf->Cell(15,6,"$0");
    
    //pendiente
    $pdf->Cell(20,6,"$"."0");

    
    
    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Missing Over time");
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(10,6,"0");
    $pdf->Cell(10,6,"0");
    
        $pdf->Cell(15,6,"$0");
    
   
    //pendiente
    $pdf->Cell(20,6,"$"."0");


    
    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"PTO");
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(10,6,"0");
    $pdf->Cell(10,6,"0");
    $pdf->Cell(15,6,"$0");
    //pendiente
    $pdf->Cell(20,6,"$"."0");


    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Bonus");
    $pdf->SetFont('Arial','',8);
    
    $pdf->Cell(20,6,"0");
    $pdf->Cell(15,6,"$0");
    //pendiente
    $pdf->Cell(20,6,"$"."0");


    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Deduction");
    $pdf->SetFont('Arial','',8);
    
    $pdf->Cell(20,6,"");
    $pdf->Cell(15,6,"-$0");
    //pendiente
    $pdf->Cell(20,6,"$"."0");


    
    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Subtotal");
    $pdf->SetFont('Arial','',8);
    
    $pdf->Cell(20,6,"");
    $pdf->Cell(15,6,"$".number_format($data['datos'][0]['val_total'], 2, '.', ''));
    //pendiente
    $pdf->Cell(20,6,"$".number_format(($data['datos'][0]['total']), 2, '.', ''));


    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Federal tax");
    $pdf->SetFont('Arial','',8);
    
    $pdf->Cell(20,6,"-".$data['datos'][0]['tax']."%");
    $pdf->Cell(15,6,"-$".number_format((($data['datos'][0]['tax']*$data['datos'][0]['val_total'])/100), 2, '.', ''));
    //pendiente
    $pdf->Cell(20,6,"-$".number_format(($data['datos'][0]['total_tax']), 2, '.', ''));


    
    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Pay Net");
    $pdf->SetFont('Arial','',8);
    
    $pdf->Cell(20,6,"");
    $pdf->Cell(15,6,"$".number_format($data['datos'][0]['val_total']-(($data['datos'][0]['tax']*$data['datos'][0]['val_total'])/100), 2, '.', '') );
    //pendiente
    $pdf->Cell(20,6,"$".number_format($data['datos'][0]['subtotal'], 2, '.', ''));

    $datos = "{id_payroll:'.$id_payroll.'}";
  
    LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'PrintPayroll',$data['query'],$datos);
    
}

    $pdf->Output('my_file.pdf','I');

   


    
function convertNumber($num = false)
{
    $num = str_replace(array(',', ''), '' , trim($num));
    if(! $num) {
        return false;
    }
    $num = (int) $num;
    $words = array();
    $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
        'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
    );
    $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
    $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
        'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
        'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
    );
    $num_length = strlen($num);
    $levels = (int) (($num_length + 2) / 3);
    $max_length = $levels * 3;
    $num = substr('00' . $num, -$max_length);
    $num_levels = str_split($num, 3);
    for ($i = 0; $i < count($num_levels); $i++) {
        $levels--;
        $hundreds = (int) ($num_levels[$i] / 100);
        $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ( $hundreds == 1 ? '' : '' ) . ' ' : '');
        $tens = (int) ($num_levels[$i] % 100);
        $singles = '';
        if ( $tens < 20 ) {
            $tens = ($tens ? '  ' . $list1[$tens] . ' ' : '' );
        } elseif ($tens >= 20) {
            $tens = (int)($tens / 10);
            $tens = ' ' . $list2[$tens] . ' ';
            $singles = (int) ($num_levels[$i] % 10);
            $singles = ' ' . $list1[$singles] . ' ';
        }
        $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
    } //end for loop
    $commas = count($words);
    if ($commas > 1) {
        $commas = $commas - 1;
    }
    $words = implode(' ',  $words);
    $words = preg_replace('/^\s\b(and)/', '', $words );
    $words = trim($words);
    $words = ucfirst($words);
    $words = $words ;
    return $words;
}