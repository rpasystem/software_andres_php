  
<?php
//session_start();
header("Content-Type: text/html;charset=utf-8");


//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);
require(dirname(__FILE__)."/Classes/PHPExcel.php");
if (ob_get_contents()) ob_end_clean();
if (!isset($_GET)) {
  die('Error, no exite el objeto POST.');
}
$get = $_GET;

if (!isset($get["tipo"])) {
  die('Error, no existe el dato "TIPO" el objeto POST.');
}

require_once(dirname(__FILE__) . "/../model/Generate_Model.php");
require_once(dirname(__FILE__) . "/../model/LogsModel.php");

$staff = $get['staff'];


$end = $get['end'];
$inicio =$get['initial'];
$invoice = $get['invoice'];
$datos_Empleado=Generate_Model::Datos_empleado_1055($staff,$inicio,$end);

$anioarray = explode('-',$end);

$porcentaje =$get['porcent_ganancia'];

//$empleados=Generate_Model::data_Empleado($name,$id);
// Instantiate a new PHPExcel object 
$objPHPExcel = new PHPExcel();  
// Set the active Excel worksheet to sheet 0 
$objPHPExcel->setActiveSheetIndex(0) 
      ->setCellValue('A1', 'Invoice 1055')
      ->setCellValue('B1', $invoice)
      ->setCellValue('A2', $staff)
      ->setCellValue('A3', $inicio.' - '.$end )
      ->setCellValue('A4', 'Warehouse')
      ->setCellValue('B4', 'Employee Name')
      ->setCellValue('C4', 'Regular Hours' )
      ->setCellValue('D4', 'Regular Rate')
      ->setCellValue('E4', 'Regular Total')
      ->setCellValue('F4','OT Hours' )
      ->setCellValue('G4','OT Rate' )
      ->setCellValue('H4','OT Total' )
      ->setCellValue('I4', 'PTO')
      ->setCellValue('J4', 'Bonus')
      ->setCellValue('K4', 'Subtotal');


      $i=5;
      $total_sub=0;
      foreach($datos_Empleado['datos'] as $val){

        $porcentaje_hourvalue = (($porcentaje*$val['hourvalue'])/100)+$val['hourvalue'];
        $porcentaje_ot =(($porcentaje*$val['overtime'])/100)+$val['overtime'];
        
        $total_sub=$total_sub+$subtotal;
        $bonus = 0;
        if($val['bonus'] != "" && $val['bonus'] != "null"){
          $bonus=$val['bonus'];
        }
        $subtotal =($porcentaje_hourvalue*$val['total_reg'])+($porcentaje_ot*$val['total_ot'])+($porcentaje_ot*$val['total_pto'])+intval($bonus);
        $objPHPExcel->setActiveSheetIndex(0) 
      ->setCellValue('A'.$i, $val['work']) 
      ->setCellValue('B'.$i, $val['fullname'])
      ->setCellValue('C'.$i, $val['total_reg'])
      ->setCellValue('D'.$i,'$'.number_format($porcentaje_hourvalue, 2, '.', '') )
      ->setCellValue('E'.$i,'$'.number_format($porcentaje_hourvalue*$val['total_reg'], 2, '.', '') )
      ->setCellValue('F'.$i, $val['total_ot'])
      ->setCellValue('G'.$i,'$'.number_format($porcentaje_ot, 2, '.', '') )
      ->setCellValue('H'.$i,'$'.number_format($porcentaje_ot*$val['total_ot'], 2, '.', '') )
      ->setCellValue('I'.$i,'0'.number_format($porcentaje_ot*$val['total_pto'], 2, '.', ''))
      ->setCellValue('J'.$i,'$'.number_format($bonus, 2, '.', '')) 
      ->setCellValue('K'.$i,'$'.number_format($subtotal, 2, '.', '') );

        $i++;
      }


      
      $styleArray = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        ),
        'font'  => array(
            'bold'  => true,
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'size'  => 20,
            'name'  => 'Calibri'
        ));

        $objPHPExcel->getActiveSheet()->mergeCells("A".("2").":K".("2"));  
        $objPHPExcel->getActiveSheet()->mergeCells("A".("3").":K".("3"));             

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($styleArray);
        
        $styleArray = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '305496')
            ),
            'font'  => array(
               
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'size'  => 12,
                'name'  => 'Times New Roman'
            ));

        
      
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);;

        $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('E4')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('F4')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('G4')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('H4')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('I4')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('J4')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('K4')->applyFromArray($styleArray);


        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15); 

        




          $cant = count($datos_Empleado['datos']);
       


        $BStyle2 = array(
            'borders' => array(
              'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              )
            )
          );
          $cant3 =  $i-1;
        $objPHPExcel->getActiveSheet()->getStyle('A2:K'.$cant3)->applyFromArray($BStyle2);
        $cant3 =  $i;
        $objPHPExcel->getActiveSheet()->getStyle('K'.$cant3)->applyFromArray($BStyle2);
        $objPHPExcel->setActiveSheetIndex(0) 
      ->setCellValue('K'.$cant3, '$'.number_format($total_sub, 2, '.', ''));

// Redirect output to a client’s web browser (Excel5) 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="Format1055.xls"'); 
header('Cache-Control: max-age=0');

//LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'Generate1099',$datos_Empleado['query']);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');