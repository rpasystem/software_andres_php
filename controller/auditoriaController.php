  
<?php
//session_start();
header("Content-Type: text/html;charset=utf-8");

//error_reporting(E_ALL);
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

require_once(dirname(__FILE__) . "/../model/AuditoriaModel.php");
require_once(dirname(__FILE__) . "/../model/LogsModel.php");


$admin = $get['admin'];
$id_admin = $get['id_admin'];
$datos_admin=AuditoriaModel::Datos_admin($admin);

$end = $get['end'];
$inicio =$get['initial'];
$staff=1;
$datos_logs=AuditoriaModel::Datos_Logs($admin,$inicio,$end);


//$empleados=Generate_Model::data_Empleado($name,$id);
// Instantiate a new PHPExcel object 
$objPHPExcel = new PHPExcel();  
// Set the active Excel worksheet to sheet 0 
$objPHPExcel->setActiveSheetIndex(0) 
      ->setCellValue('A1', 'Logs Audit ') 
      ->setCellValue('A3', 'Name:')
      ->setCellValue('A4', 'Email:')
      ->setCellValue('A5', 'Id number:')
      


      ->setCellValue('B3', $datos_admin['datos'][0]['firstname']." ".$datos_admin['datos'][0]['second_name']." ".$datos_admin['datos'][0]['surename']." ".$datos_admin['datos'][0]['second_surname'])
      ->setCellValue('B4', $datos_admin['datos'][0]['email'])
      ->setCellValue('B5',strval($datos_admin['datos'][0]['identification'])); 

      $i=10;
      foreach($datos_logs['datos'] as $val){
        $objPHPExcel->setActiveSheetIndex(0) 
      ->setCellValue('A'.$i, $val['date']) 
      ->setCellValue('B'.$i, $val['action'])
      ->setCellValue('C'.$i, str_replace(":", "=", $val['data']) );
        $i++;
      }

     

// Redirect output to a client’s web browser (Excel5) 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="audit.xls"'); 
header('Cache-Control: max-age=0');


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');