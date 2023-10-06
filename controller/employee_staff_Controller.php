 <?php
session_start();
header("Content-Type: text/html;charset=utf-8");

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
require(dirname(__FILE__)."/Classes/PHPExcel.php");
ob_clean();
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
//$datosStack=Generate_Model::Detalle_Staff($staff);

$datos_Empleado=Generate_Model::Datos_empleado_Staff($staff);


//$empleados=Generate_Model::data_Empleado($name,$id);
// Instantiate a new PHPExcel object 
$objPHPExcel = new PHPExcel();  
// Set the active Excel worksheet to sheet 0 
$objPHPExcel->setActiveSheetIndex(0) 
      ->setCellValue('A1', 'Id') 
      ->setCellValue('B1', 'First Name ')
      ->setCellValue('C1', 'Second Name ')
      ->setCellValue('D1', 'Last Name')
      ->setCellValue('E1', 'Second Last Name')
      ->setCellValue('F1', 'ID number')
      ->setCellValue('G1', 'Address')
      ->setCellValue('H1', 'Phone')
      ->setCellValue('I1', 'Contact Emergency')
      ->setCellValue('J1', 'Hired Date')
      ->setCellValue('K1', 'Nationality')
      ->setCellValue('L1', 'E-mail')
      ->setCellValue('M1', 'Date end work')
      ->setCellValue('N1', 'Host Company')
      ->setCellValue('O1', 'Work Place')
      ->setCellValue('P1', 'Staff Company')
      ->setCellValue('Q1', 'Position')
      ->setCellValue('R1', 'Regular rate')
      ->setCellValue('S1', 'Over time Rate')
      ->setCellValue('T1', 'Shift')
      ->setCellValue('U1', 'State')
      ->setCellValue('V1', 'gender')
      ->setCellValue('W1', 'Date of birth'); 

      $i=2;
      foreach($datos_Empleado['datos'] as $val){
        $objPHPExcel->setActiveSheetIndex(0) 
      ->setCellValue('A'.$i, $val['id_employee']) 
      ->setCellValue('B'.$i, $val['first_name'])
      ->setCellValue('C'.$i, $val['second_name'])
      ->setCellValue('D'.$i, $val['surname'])
      ->setCellValue('E'.$i, $val['second_surname'])
      ->setCellValue('F'.$i, $val['identification'])
      ->setCellValue('G'.$i, $val['address'])
      ->setCellValue('H'.$i,strval($val['phone']))
      ->setCellValue('I'.$i,  strval ($val['emergency']))
      ->setCellValue('J'.$i, $val['birth'])
      ->setCellValue('K'.$i, $val['nationality'])
      ->setCellValue('L'.$i, $val['email'])
      ->setCellValue('M'.$i, $val['fecha_retiro'])
      ->setCellValue('N'.$i, $val['host_name'])
      ->setCellValue('O'.$i, $val['work_place'])
      ->setCellValue('P'.$i, $val['staff'])
      ->setCellValue('Q'.$i, $val['position'])
      ->setCellValue('R'.$i, $val['hourvalue'])
      ->setCellValue('S'.$i, $val['overtime'])
      ->setCellValue('T'.$i, $val['shift'])
      ->setCellValue('U'.$i, $val['estado'])
      ->setCellValue('V'.$i, $val['genero'])
      ->setCellValue('W'.$i, $val['nacimiento']);
        $i++;
      }





        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(34); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30); 

        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(30); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(30); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(30); 





// Redirect output to a client’s web browser (Excel5) 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="employee_staff.xls"'); 
header('Cache-Control: max-age=0');

//LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'Generate1099',$datos_Empleado['query']);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');