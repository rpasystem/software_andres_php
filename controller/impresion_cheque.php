<?php
session_start();
header("Content-Type: text/html;charset=utf-8");
ob_start();
require('fpdf.php');

require_once(dirname(__FILE__) . "/../model/Print_payrollModel.php");
require_once(dirname(__FILE__) . "/../model/LogsModel.php");

    $id_payroll = $_GET['id'];
    if (!isset($_GET)) {
        die('Error.');
    }

    $id_payrolls =  array();
    if($pos = strpos($id_payroll, '-')){
        $id_payrolls = explode("-", $id_payroll);

    }else{
        $id_payrolls[0]=$id_payroll;
    }

    
    $pdf = new FPDF();
foreach($id_payrolls as $item){
    $data = Print_payrollModel::Data_Cheque($item);


    $valor =$data['datos'][0]['net_pay'];
    $float =explode(".", $valor);

   
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(170);
    $pdf->Cell(5,26,''.date('m-d-Y'),'C');
    $pdf->Ln(2);
    $pdf->Cell(16);
    $pdf->Cell(10,47,$data['datos'][0]['name']);
    $pdf->Cell(144);
    $pdf->Cell(10,48,"**".$data['datos'][0]['net_pay']);
    $pdf->Ln(9);
    $pdf->Cell(3);
    $pdf->Cell(10,49,convertNumber($data['datos'][0]['net_pay']) .' and '.$float[1]."/100"." *****************************************");
    $pdf->Cell(60);
    //$pdf->Cell(10,54,"*************");
    $pdf->Ln(7);
    $pdf->Cell(13);
    $pdf->Cell(10,54,$data['datos'][0]['name']);
    $pdf->Ln(5);
    $pdf->Cell(13);
    $pdf->Cell(10,54,$data['datos'][0]['direccion'].",");
    $pdf->Ln(5);
    $pdf->Cell(13);
    $pdf->Cell(10,54,$data['datos'][0]['ciudad']." ".$data['datos'][0]['postcode']);
    
    $pdf->Ln(12);
    $pdf->Cell(13);
    $pdf->Cell(10,50,"Pay period ". $data['datos'][0]['rango'] );

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
    $pdf->Cell(10,54,$data['datos'][0]['name'].",".$data['datos'][0]['direccion'].",".$data['datos'][0]['ciudad']." ".$data['datos'][0]['postcode']);
    $pdf->Cell(90);
    $pdf->Cell(10,54,substr($data['datos'][0]['identification'], 0, 3) . str_repeat('*', strlen($data['datos'][0]['identification']) - 3)  );
    $pdf->Ln(5);
    $pdf->Cell(100);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(10,54,"Pay period: ".$data['datos'][0]['rango']." Pay Date: ".date('m-d-Y'));

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
    $pdf->Cell(10,6,$data['datos'][0]['hour_reg']);
    $pdf->Cell(10,6,$data['datos'][0]['hourvalue']);
    $pdf->Cell(15,6,"$".number_format($data['datos'][0]['total_ger_val'], 2, '.', ''));
    //pendiente
    $pdf->Cell(20,6,"$".number_format($data['datos'][0]['all_subtotal'], 2, '.', ''));

    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Over time");
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(10,6,$data['datos'][0]['hour_ot']);
    $pdf->Cell(10,6,$data['datos'][0]['overtime']);
    $pdf->Cell(15,6,"$".number_format($data['datos'][0]['total_ot_val'], 2, '.', ''));
    //pendiente
    $pdf->Cell(20,6,"$"."0");
    

    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Missing H");
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(10,6,$data['datos'][0]['missing_hours']);
    $pdf->Cell(10,6,$data['datos'][0]['hourvalue']);
    if($data['datos'][0]['missing_hours'] != null){
        $pdf->Cell(15,6,"$".($data['datos'][0]['hourvalue']*$data['datos'][0]['missing_hours']));
    }else{
        $pdf->Cell(15,6,"$0");
    }
   
    //pendiente
    $pdf->Cell(20,6,"$"."0");



    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Missing Over time");
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(10,6,$data['datos'][0]['missing_over_time']);
    $pdf->Cell(10,6,$data['datos'][0]['overtime']);
    if($data['datos'][0]['missing_over_time'] != null){
        $pdf->Cell(15,6,"$".($data['datos'][0]['missing_over_time']*$data['datos'][0]['overtime']));
    }else{
        $pdf->Cell(15,6,"$0");
    }
   
    //pendiente
    $pdf->Cell(20,6,"$"."0");


    
    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"PTO");
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(10,6,$data['datos'][0]['hour_pto']);
    $pdf->Cell(10,6,$data['datos'][0]['hourvalue']);
    $pdf->Cell(15,6,"$".$data['datos'][0]['total_pto_val']);
    //pendiente
    $pdf->Cell(20,6,"$"."0");


    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Bonus");
    $pdf->SetFont('Arial','',8);
    
    $pdf->Cell(20,6,$data['datos'][0]['description_bonus']);
    if($data['datos'][0]['bonus']!= ""){
        $pdf->Cell(15,6,"$".number_format($data['datos'][0]['bonus'], 2, '.', ''));
    }else{
        $pdf->Cell(15,6,"$0");
    }
    
    //pendiente
    $pdf->Cell(20,6,"$"."0");


    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Deduction");
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(20,6,$data['datos'][0]['description_deduction']);
    if($data['datos'][0]['deductions']!= ""){
        $pdf->Cell(15,6,"-$".number_format($data['datos'][0]['deductions'], 2, '.', ''));
    }else{
        $pdf->Cell(15,6,"$0");
    }
    
    //pendiente
    $pdf->Cell(20,6,"$"."0");


    
    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Subtotal");
    $pdf->SetFont('Arial','',8);
    
    $pdf->Cell(20,6,"");
    $pdf->Cell(15,6,"$".number_format($data['datos'][0]['subtotal'], 2, '.', '') );
    //pendiente
    $pdf->Cell(20,6,"$".number_format($data['datos'][0]['all_subtotal'], 2, '.', ''));


    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Federal tax");
    $pdf->SetFont('Arial','',8);
    
    $pdf->Cell(20,6,"-".$data['datos'][0]['tax']."%");
    $pdf->Cell(15,6,"-$".number_format($data['datos'][0]['val_tax'], 2, '.', ''));
    //pendiente
    $pdf->Cell(20,6,"-$".number_format($data['datos'][0]['all_tax'], 2, '.', ''));


    
    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Pay Net");
    $pdf->SetFont('Arial','',8);
    
    $pdf->Cell(20,6,"");
    $pdf->Cell(15,6,"$".number_format($data['datos'][0]['net_pay'], 2, '.', ''));
    //pendiente
    $pdf->Cell(20,6,"$".number_format($data['datos'][0]['all_pay'], 2, '.', ''));



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
    $pdf->Cell(5,46,$data['datos'][0]['name'].",".$data['datos'][0]['direccion'].",".$data['datos'][0]['ciudad']." ".$data['datos'][0]['postcode']);
    $pdf->Cell(95);
    $pdf->Cell(10,46, substr($data['datos'][0]['identification'], 0, 3) . str_repeat('*', strlen($data['datos'][0]['identification']) - 3) );
    $pdf->Ln(5);
    $pdf->Cell(100);
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(10,46,"Pay period: ".$data['datos'][0]['rango']." Pay Date: ".date('m-d-Y'));

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
    $pdf->Cell(10,6,$data['datos'][0]['hour_reg']);
    $pdf->Cell(10,6,$data['datos'][0]['hourvalue']);
    $pdf->Cell(15,6,"$".number_format($data['datos'][0]['total_ger_val'], 2, '.', ''));
    //pendiente
    $pdf->Cell(20,6,"$".number_format($data['datos'][0]['all_subtotal'], 2, '.', ''));

    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Over time");
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(10,6,$data['datos'][0]['hour_ot']);
    $pdf->Cell(10,6,$data['datos'][0]['overtime']);
    $pdf->Cell(15,6,"$".$data['datos'][0]['total_ot_val']);
    //pendiente
    $pdf->Cell(20,6,"$"."0");
    

    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Missing H");
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(10,6,$data['datos'][0]['missing_hours']);
    $pdf->Cell(10,6,$data['datos'][0]['hourvalue']);
    if($data['datos'][0]['missing_hours'] != null){
        $pdf->Cell(15,6,"$".($data['datos'][0]['hourvalue']*$data['datos'][0]['missing_hours']));
    }else{
        $pdf->Cell(15,6,"$0");
    }
    //pendiente
    $pdf->Cell(20,6,"$"."0");

    
    
    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Missing Over time");
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(10,6,$data['datos'][0]['missing_over_time']);
    $pdf->Cell(10,6,$data['datos'][0]['overtime']);
    if($data['datos'][0]['missing_over_time'] != null){
        $pdf->Cell(15,6,"$".($data['datos'][0]['missing_over_time']*$data['datos'][0]['overtime']));
    }else{
        $pdf->Cell(15,6,"$0");
    }
   
    //pendiente
    $pdf->Cell(20,6,"$"."0");


    
    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"PTO");
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(10,6,$data['datos'][0]['hour_pto']);
    $pdf->Cell(10,6,$data['datos'][0]['hourvalue']);
    $pdf->Cell(15,6,"$".$data['datos'][0]['total_pto_val']);
    //pendiente
    $pdf->Cell(20,6,"$"."0");


    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Bonus");
    $pdf->SetFont('Arial','',8);
    
    $pdf->Cell(20,6,$data['datos'][0]['description_bonus']);
    $pdf->Cell(15,6,"$".$data['datos'][0]['bonus']);
    //pendiente
    $pdf->Cell(20,6,"$"."0");


    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Deduction");
    $pdf->SetFont('Arial','',8);
    
    $pdf->Cell(20,6,$data['datos'][0]['description_deduction']);
    $pdf->Cell(15,6,"-$".$data['datos'][0]['deductions']);
    //pendiente
    $pdf->Cell(20,6,"$"."0");


    
    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Subtotal");
    $pdf->SetFont('Arial','',8);
    
    $pdf->Cell(20,6,"");
    $pdf->Cell(15,6,"$".number_format($data['datos'][0]['subtotal'], 2, '.', ''));
    //pendiente
    $pdf->Cell(20,6,"$".number_format($data['datos'][0]['all_subtotal'], 2, '.', ''));


    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Federal tax");
    $pdf->SetFont('Arial','',8);
    
    $pdf->Cell(20,6,"-".$data['datos'][0]['tax']."%");
    $pdf->Cell(15,6,"-$".$data['datos'][0]['val_tax']);
    //pendiente
    $pdf->Cell(20,6,"-$".number_format($data['datos'][0]['all_tax'], 2, '.', ''));


    
    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Pay Net");
    $pdf->SetFont('Arial','',8);
    
    $pdf->Cell(20,6,"");
    $pdf->Cell(15,6,"$".number_format($data['datos'][0]['net_pay'], 2, '.', ''));
    //pendiente
    $pdf->Cell(20,6,"$".number_format($data['datos'][0]['all_pay'], 2, '.', ''));

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