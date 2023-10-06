  
<?php
//session_start();
header("Content-Type: text/html;charset=utf-8");

//error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
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
$datosStack=Generate_Model::Detalle_Staff($staff);

$end = $get['end'];
$inicio =$get['initial'];
$datos_Empleado=Generate_Model::Datos_empleado($staff,$inicio,$end);

$anioarray = explode('/',$end);

//$empleados=Generate_Model::data_Empleado($name,$id);
// Instantiate a new PHPExcel object 
$objPHPExcel = new PHPExcel();  
// Set the active Excel worksheet to sheet 0 
$objPHPExcel->setActiveSheetIndex(0) 
      ->setCellValue('A1', 'Miscellanneous Income for Form 1099 ') 
      ->setCellValue('A3', 'Company Name:')
      ->setCellValue('A4', 'Address:')
      ->setCellValue('A5', 'Phone number:')
      ->setCellValue('A6', 'Payer´s TIN:')
      ->setCellValue('A7', 'Year Report:')
      ->setCellValue('F1', 'Report Date:')


      ->setCellValue('B3', $datosStack['datos'][0]['name'])
      ->setCellValue('B4', $datosStack['datos'][0]['address'])
      ->setCellValue('B5',strval($datosStack['datos'][0]['phone']))
      ->setCellValue('B6', $datosStack['datos'][0]['payer'])
      ->setCellValue('B7', strval($anioarray[2]))
  
    


      

      ->setCellValue('A9', 'Recipient´s TIN:')
      ->setCellValue('B9', 'Name employee')
      ->setCellValue('C9', 'State')
      ->setCellValue('D9', 'Street Address (including Apt. No.)')
      ->setCellValue('E9', 'City or town, state or porvidence, country, and ZIP')
      ->setCellValue('F9', 'Nonemployee compensation')
      ->setCellValue('G9', 'State tax withheld')
      ->setCellValue('G1', date('m-d-Y')); 

      $i=10;
      $subtotal = 0;
      $val_tax = 0;
      foreach($datos_Empleado['datos'] as $val){
        $objPHPExcel->setActiveSheetIndex(0) 
      ->setCellValue('A'.$i, $val['identification']) 
      ->setCellValue('B'.$i, $val['fullname'])
      ->setCellValue('C'.$i, $val['estado'])
      ->setCellValue('D'.$i, $val['address'])
      ->setCellValue('E'.$i, $val['lugar'])
      ->setCellValue('F'.$i, $val['subtotal'])
      ->setCellValue('G'.$i, $val['val_tax']);

      $subtotal = $subtotal+$val['subtotal'];
      $val_tax =$val_tax+ $val['val_tax'];
        $i++;

      }

      

      $objPHPExcel->setActiveSheetIndex(0) 
      ->setCellValue('F'.$i, $subtotal) 
      ->setCellValue('G'.$i, $val_tax);


      $styleArray = array(
        'font'  => array(
            'bold'  => true,
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'size'  => 20,
            'name'  => 'Calibri'
        ));

        $objPHPExcel->getActiveSheet()->mergeCells("A".("1").":C".("1"));             

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);

        $styleArray = array(
            'font'  => array(
                'bold'  => true,
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'size'  => 12,
                'name'  => 'Calibri'
            ));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($styleArray);
        
        $objPHPExcel->getActiveSheet()->getStyle('A9')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('B9')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('C9')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($styleArray)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);;
        $objPHPExcel->getActiveSheet()->getStyle('B4')->applyFromArray($styleArray)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);;
        $objPHPExcel->getActiveSheet()->getStyle('B5')->applyFromArray($styleArray)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);;
        $objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArray)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);;
        $objPHPExcel->getActiveSheet()->getStyle('B7')->applyFromArray($styleArray)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);;
        $objPHPExcel->getActiveSheet()->getStyle('D9')->applyFromArray($styleArray)->getAlignment()->setWrapText(true) ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('E9')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('F9')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('G9')->applyFromArray($styleArray);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(34); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30); 
        $styleArray2 = array(
            'font'  => array(
                
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'size'  => 16,
                'name'  => 'Calibri'
            ));
        $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($styleArray2);


        $styleArray3 = array(
            'borders' => array(
                'bottom' => array(
                 'style' => PHPExcel_Style_Border::BORDER_THIN 
               ) 
              ) ,
            'font'  => array(
              
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'size'  => 16,
                'name'  => 'Calibri'
            ));
        $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($styleArray3);


        $BStyle = array(
            'borders' => array(
              'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              )
            )
          );
          $cant = count($datos_Empleado['datos']);
          $cant2 = $cant+20;
        $objPHPExcel->getActiveSheet()->getStyle('A1:G'.$cant2)->applyFromArray($BStyle);


        $BStyle2 = array(
            'borders' => array(
              'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              )
            )
          );
          $cant3 =  $cant+9;
        $objPHPExcel->getActiveSheet()->getStyle('A9:G'.$cant3)->applyFromArray($BStyle2);

// Redirect output to a client’s web browser (Excel5) 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="Format1099.xls"'); 
header('Cache-Control: max-age=0');

//LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'Generate1099',$datos_Empleado['query']);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
$objWriter->save('php://output');