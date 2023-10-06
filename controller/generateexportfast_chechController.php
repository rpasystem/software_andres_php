<?php
session_start();
header("Content-Type: text/html;charset=utf-8");


//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);
require(dirname(__FILE__)."/Classes/PHPExcel.php");
if (ob_get_contents()) ob_end_clean();


require_once(dirname(__FILE__) . "/../model/Generate_Model.php");
require_once(dirname(__FILE__) . "/../model/LogsModel.php");


//$datosStack=Generate_Model::Detalle_Staff($staff);

$datos_Empleado=Generate_Model::getFastCheck();


//$empleados=Generate_Model::data_Empleado($name,$id);
// Instantiate a new PHPExcel object 
$objPHPExcel = new PHPExcel();  
// Set the active Excel worksheet to sheet 0 
$objPHPExcel->setActiveSheetIndex(0) 
      ->setCellValue('A1', 'Number check') 
      ->setCellValue('B1', 'Name')
      ->setCellValue('C1', 'Total value')
      ->setCellValue('D1', 'Reason')
      ->setCellValue('E1', 'Tax')
      ->setCellValue('F1', 'Admin')
      ->setCellValue('G1', 'Date'); 

      $i=2;
      foreach($datos_Empleado['datos'] as $val){
        $objPHPExcel->setActiveSheetIndex(0) 
      ->setCellValue('A'.$i, $val['id_check']) 
      ->setCellValue('B'.$i, $val['nombre'])
      ->setCellValue('C'.$i, $val['val_total'])
      ->setCellValue('D'.$i, $val['description'])
      ->setCellValue('E'.$i, $val['tax'])
      ->setCellValue('F'.$i, $val['admin'])
      ->setCellValue('G'.$i, $val['fecha_creacion']);
        $i++;
      }





        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(34); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30); 

        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30); 
 




// Redirect output to a client’s web browser (Excel5) 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="fast_check.xls"'); 
header('Cache-Control: max-age=0');

//LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'Generate1099',$datos_Empleado['query']);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');