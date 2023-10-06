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

    $pdf->SetFont('Arial','',10);
    
    $pdf->Cell(5,9,strtoupper($data['datos'][0]['staff']),'C');
    $pdf->Ln(0);
    $pos = strpos($data['datos'][0]['staff_direccion'], ',');
        if($pos=== false){
          $pdf->Cell(0,20,strtoupper($data['datos'][0]['staff_direccion']),'C');
          $pdf->Ln(0);
        }else{   
            $direccionArray= explode(",",$data['datos'][0]['staff_direccion']);
            $pdf->Cell(0,17,strtoupper($direccionArray[0]),'C');
            $pdf->Ln(0);
            $pdf->Cell(0,25,strtoupper($direccionArray[1]),'C');
        }

        $pdf->Ln(22);
        $pdf->Cell(10);
        $pdf->Cell(13,54,$data['datos'][0]['name'],'c');
        $pdf->Ln(4);
        $pdf->Cell(10);
        $pdf->Cell(13,54,$data['datos'][0]['direccion'],'c');
        $pdf->Ln(4);
        $pdf->Cell(10);
        $pdf->Cell(13,54,$data['datos'][0]['ciudad']." ".$data['datos'][0]['postcode'],'c');

    //CUADRO 1
    
   
   
    $pdf->Ln(25);
    $pdf->SetLineWidth(0.5);
    $pdf->Line(10,101,94,101);

    $pdf->Line(110,101,198,101);
    
    
    $pdf->Line(10,116,94,116);
    $pdf->Line(37,152,94,152);
    $pdf->Line(37,169,94,169);
    $pdf->SetLineWidth(0.01);
    $pdf->SetFont('Arial','B',8);
    $pdf->Line(10,90,200,90);
    $pdf->Cell(10,54,"Employee Pay Stub");
    $pdf->Cell(90);
    $pdf->Cell(10,54,str_replace("For", "Pay period", $data['datos'][0]['rango']) );
    $pdf->Cell(50);
    $porciones = explode("-", $data['datos'][0]['rango']);
    $pdf->Cell(20,54,'Pay Date:'.$porciones[1],'C');

    $pdf->Ln(7);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(10,54,"Employee");
    
    $pdf->Cell(90);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(10,54,"SSN");
    $pdf->Ln(5);
    $pdf->SetFont('Arial','',6);
    $pdf->Cell(10,54,$data['datos'][0]['name'].",".$data['datos'][0]['direccion'].",".$data['datos'][0]['ciudad']." ".$data['datos'][0]['postcode']);
    $pdf->Cell(90);
    $pdf->Cell(10,54,   substr($data['datos'][0]['identification'], 0, 3) . str_repeat('*', strlen($data['datos'][0]['identification']) - 3)  );
    $pdf->Ln(5);
    $pdf->Cell(100);
    $pdf->SetFont('Arial','',8);
    //$pdf->Cell(10,54,"Pay period: ".$data['datos'][0]['rango']." Pay Date: ".date('m-d-Y'));

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
    $pdf->Cell(15,6,"$".number_format($data['datos'][0]['total_ger_val'], 2, '.', '') );
    //pendiente
    $pdf->Cell(20,6,"$".number_format($data['datos'][0]['all_subtotal'], 2, '.', ''));

    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Over time");
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(10,6,$data['datos'][0]['hour_ot']);
    $pdf->Cell(10,6,$data['datos'][0]['overtime']);
    $pdf->Cell(15,6,"$".number_format($data['datos'][0]['total_ot_val'], 2, '.', '') );
    //pendiente
    $pdf->Cell(20,6,"$"."0");
    

    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Missing H");
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(10,6,$data['datos'][0]['missing_hours']);
    $pdf->Cell(10,6,$data['datos'][0]['hourvalue']);
    if($data['datos'][0]['missing_hours'] != null){
        $pdf->Cell(15,6,"$". number_format(($data['datos'][0]['hourvalue']*$data['datos'][0]['missing_hours']), 2, '.', ''));
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
        $pdf->Cell(15,6,"$".number_format(($data['datos'][0]['missing_over_time']*$data['datos'][0]['overtime']), 2, '.', '')  );
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
    $pdf->Cell(15,6,"$".number_format($data['datos'][0]['total_pto_val'], 2, '.', '') );
    //pendiente
    $pdf->Cell(20,6,"$"."0");


    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Bonus");
    $pdf->SetFont('Arial','',8);
    
    $pdf->Cell(20,6,$data['datos'][0]['description_bonus']);
	if($data['datos'][0]['bonus'] != null){
	$pdf->Cell(15,6,"$". number_format($data['datos'][0]['bonus'], 2, '.', '') );	
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
	
	if($data['datos'][0]['deductions'] != null){
		$pdf->Cell(15,6,"-$".number_format($data['datos'][0]['deductions'], 2, '.', ''));
	}else{
	$pdf->Cell(15,6,"-$0");	
	}
	
    
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
    $pdf->Cell(20,6,"-$".number_format($data['datos'][0]['all_tax'], 2, '.', '') );


    
    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,6,"Pay Net");
    $pdf->SetFont('Arial','',8);
    
    $pdf->Cell(20,6,"");
    $pdf->Cell(15,6,"$".number_format($data['datos'][0]['net_pay'], 2, '.', '') );
    //pendiente
    $pdf->Cell(20,6,"$".number_format($data['datos'][0]['all_pay'], 2, '.', '') );


    $pdf->SetY(-1);
   
    $pdf->Cell(13,-25,$data['datos'][0]['staff'].', '.$data['datos'][0]['staff_direccion'],'c');

    
    $json= json_encode($_GET);
    $datos_array = str_replace('"', "", $json);
    LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'PrintPayroll',$data['query'],$json);
   
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