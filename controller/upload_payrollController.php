<?php
session_start();
header("Content-Type: text/html;charset=utf-8");


require(dirname(__FILE__)."/Classes/PHPExcel.php");

ob_start();
if (!isset($_POST)) {
    die('Error, no exite el objeto POST.');
}
$post = $_POST;


if (!isset($post["tipo"])) {
    die('Error, no existe el dato "TIPO" el objeto POST.');
}

//$GLOBALS['path'] ='/application';
$GLOBALS['path'] ='';
require_once(dirname(__FILE__) . "/../model/UploadPayRollModel.php");
require_once(dirname(__FILE__) . "/../model/LogsModel.php");



switch ($post['tipo']) {
    case "UPLOAD":
    Upload($post);
    break;
    case "UPLOAD_EXCEL":
    Upload_excel($post);
    break;
    case "LISTDETAILS":
    ListDetails($post);
    break;
    case "TABLE_DETAILS_FAIL":
    Table_Details_Fails($post);
    break;
    case "LISTSUCCESS":
    List_Success($post);
    break;
    case "LIST_HISTORIC":
    List_historic($post);
    break;
    case "DETAILS_SUCCESS":
    Detalle_exitoso($post);
    break;
    case "DELETE_PAYROLL":
    Delete_Payroll($post);
    break;
    case "CALCULATE_PAYROLL":
    Calculate_Payroll($post);
    break;
    case "IMPIRMIR":
    Imprimir();
    break;
    case "LISTSUCCESS_PRINT":
    List_Success_Print($post);
    break;
    case "LIST_HISTORIC_EMPLOYEE":
    List_historic_employee($post);
    break;
    case "List_historic_employee_admin":
        List_historic_employee_admin($post);
    break;
    case "ACEPT_PAYROLL":
        Aceptar_Payroll($post);
    break;
    default: echo('Error, no existe el dato "TIPO" en el objeto POST');
    break;
}
function Aceptar_Payroll($post){
    $id = $post['id'];
    $data = UploadPayRollModel::Aceptar_Payroll($id);
    echo json_encode($data);
}



function List_historic_employee_admin($dataPost){
    
    $columns = $dataPost['columns'];
    
    $start = $dataPost['start'];
    $length = $dataPost['length'];

    $searchArray = $dataPost['search'];
    $search = $searchArray['value'];
   
    $orderArray = $dataPost['order'];
    $orderNumberField = $orderArray[0]['column'];
    $orderField = $columns[$orderNumberField]['data'];
    $orderDir = $orderArray[0]['dir'];
    
    $respuesta["recordsTotal"] = $respuesta["recordsFiltered"] = 0;
    
 
    $id =$dataPost['id_employee'];;
    $respuesta["data"] = array();
    $data = UploadPayRollModel::List_historic_Employee($start, $length, $search, $orderField, $orderDir,$id);
    LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'Historic pay',"SELECT * FROM payroll","");
    if (empty($data)) {
        echo json_encode($respuesta);
    } else {
        $respuesta["recordsTotal"] = $respuesta["recordsFiltered"] = $data["total"];
        $respuesta["data"] = $data["datos"];
        echo json_encode($respuesta);
    }
}


function List_historic_employee($dataPost){
    
    $columns = $dataPost['columns'];
    
    $start = $dataPost['start'];
    $length = $dataPost['length'];

    $searchArray = $dataPost['search'];
    $search = $searchArray['value'];
   
    $orderArray = $dataPost['order'];
    $orderNumberField = $orderArray[0]['column'];
    $orderField = $columns[$orderNumberField]['data'];
    $orderDir = $orderArray[0]['dir'];
    
    $respuesta["recordsTotal"] = $respuesta["recordsFiltered"] = 0;
    
 
    $id = $_SESSION['user_login_status']['id'];
    $respuesta["data"] = array();
    $data = UploadPayRollModel::List_historic_Employee($start, $length, $search, $orderField, $orderDir,$id);
    LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'Historic pay',"SELECT * FROM payroll","");
    if (empty($data)) {
        echo json_encode($respuesta);
    } else {
        $respuesta["recordsTotal"] = $respuesta["recordsFiltered"] = $data["total"];
        $respuesta["data"] = $data["datos"];
        echo json_encode($respuesta);
    }
}

function Imprimir(){
    

}

function Calculate_Payroll($post){
    $missing_hours = $post['missing_hours'];
    $description_bonus="";
    if($post['description_bonus'] !="Select Description Bonus"){
        $description_bonus = $post['description_bonus'];
    }
    
    $bonus=$post['bonus'];
    $deductions = $post['deductions'];
    $description_deduction="";
    if($post['description_deduction'] != "Select Description Deduction"){
        $description_deduction = $post['description_deduction'];
    }
    
    $subtotal =number_format($post['subtotal'], 2, '.', '');
    $val_tax =  number_format($post['val_tax'], 2, '.', '') ;
    $net_pay=number_format($post['net_pay'], 2, '.', '') ;
    $id_success_employee = $post['id_success_employee'];
    $missing_over_time =$post['missing_over_time'];

    $hour_reg=$post['hour_reg'];
    $total_ger_val=number_format($post['total_ger_val'], 2, '.', '');
    $hour_pto = $post['hour_pto'];
    $total_pto_val =number_format($post['total_pto_val'], 2, '.', '');
    $hour_ot = $post['hour_ot'];
    $total_ot_val =number_format( $post['total_ot_val'], 2, '.', '');

    $overtime=$post['overtime'];
    $hourvalue=$post['hourvalue'];

    $data = UploadPayRollModel::Calculate_Payroll( $missing_hours,$description_bonus,$bonus,$deductions,$description_deduction,$subtotal,$val_tax,$net_pay,$id_success_employee,$missing_over_time,
    $hour_reg,$total_ger_val,$hour_pto,$total_pto_val,$hour_ot,$total_ot_val,$overtime,$hourvalue);
    $json= json_encode($post);
    $datos_array = str_replace('"', "", $json);
    LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'CalculatePayroll',$data['query'],$datos_array);
    $data['query']="";
    echo json_encode($data);
}

function Delete_Payroll($post){
    $id = $post['id'];
    $data = UploadPayRollModel::Delete_Payroll($id);
    echo json_encode($data);
}

function Detalle_exitoso($post){

    $id = $post['id'];
    $data = UploadPayRollModel::Detalle_exitoso($id);
    echo json_encode($data);
}


function List_historic($dataPost){
 
    $columns = $dataPost['columns'];
    
    $start = $dataPost['start'];
    $length = $dataPost['length'];

    $searchArray = $dataPost['search'];
    $search = $searchArray['value'];
   
    $orderArray = $dataPost['order'];
    $orderNumberField = $orderArray[0]['column'];
    $orderField = $columns[$orderNumberField]['data'];
    $orderDir = $orderArray[0]['dir'];
    
    $respuesta["recordsTotal"] = $respuesta["recordsFiltered"] = 0;
    
    $dates =$dataPost['date'];   
    
    $respuesta["data"] = array();
    $data = UploadPayRollModel::List_historic($start, $length, $search, $orderField, $orderDir,$dates);
    LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'CalculatePayroll',"SELECT * FROM payroll","");
    if (empty($data)) {
        echo json_encode($respuesta);
    } else {
        $respuesta["recordsTotal"] = $respuesta["recordsFiltered"] = $data["total"];
        $respuesta["data"] = $data["datos"];
        echo json_encode($respuesta);
    }
}

function List_Success_Print($dataPost){
    $columns = $dataPost['columns'];
    
    $start = $dataPost['start'];
    $length = $dataPost['length'];

    $searchArray = $dataPost['search'];
    $search = $searchArray['value'];
   
    $orderArray = $dataPost['order'];
    $orderNumberField = $orderArray[0]['column'];
    $orderField = $columns[$orderNumberField]['data'];
    $orderDir = $orderArray[0]['dir'];
    $id=$dataPost['id'];
    $respuesta["recordsTotal"] = $respuesta["recordsFiltered"] = 0;
    
    $respuesta["data"] = array();
    $data = UploadPayRollModel::TablaDetalleSuccess_Print($start, $length, $search, $orderField, $orderDir,$id);
    
    if (empty($data)) {
        echo json_encode($respuesta);
    } else {
        $respuesta["recordsTotal"] = $respuesta["recordsFiltered"] = $data["total"];
        $respuesta["data"] = $data["datos"];
        echo json_encode($respuesta);
    }
}

function List_Success($dataPost){
    $columns = $dataPost['columns'];
    
    $start = $dataPost['start'];
    $length = $dataPost['length'];

    $searchArray = $dataPost['search'];
    $search = $searchArray['value'];
   
    $orderArray = $dataPost['order'];
    $orderNumberField = $orderArray[0]['column'];
    $orderField = $columns[$orderNumberField]['data'];
    $orderDir = $orderArray[0]['dir'];
    $id=$dataPost['id'];
    $respuesta["recordsTotal"] = $respuesta["recordsFiltered"] = 0;
    
    $respuesta["data"] = array();
    $data = UploadPayRollModel::TablaDetalleSuccess($start, $length, $search, $orderField, $orderDir,$id);
    
    if (empty($data)) {
        echo json_encode($respuesta);
    } else {
        $respuesta["recordsTotal"] = $respuesta["recordsFiltered"] = $data["total"];
        $respuesta["data"] = $data["datos"];
        echo json_encode($respuesta);
    }
}


function Table_Details_Fails($dataPost){
    $columns = $dataPost['columns'];
    
    $start = $dataPost['start'];
    $length = $dataPost['length'];

    $searchArray = $dataPost['search'];
    $search = $searchArray['value'];
   
    $orderArray = $dataPost['order'];
    $orderNumberField = $orderArray[0]['column'];
    $orderField = $columns[$orderNumberField]['data'];
    $orderDir = $orderArray[0]['dir'];
    $id=$dataPost['id'];
    $respuesta["recordsTotal"] = $respuesta["recordsFiltered"] = 0;
    
    $respuesta["data"] = array();
    $data = UploadPayRollModel::TablaDetalleFallos($start, $length, $search, $orderField, $orderDir,$id);
    
    if (empty($data)) {
        echo json_encode($respuesta);
    } else {
        $respuesta["recordsTotal"] = $respuesta["recordsFiltered"] = $data["total"];
        $respuesta["data"] = $data["datos"];
        echo json_encode($respuesta);
    }
}

function Upload($post){
    
    
    
     $allowedFileType = [
        'application/vnd.ms-excel',
        'text/xls',
        'text/xlsx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ];

    if (in_array($_FILES["file"]["type"], $allowedFileType)) {
        move_uploaded_file($_FILES  ['file']['tmp_name'], '../temp/' . $_FILES['file']['name']);
        $path = $GLOBALS['path'];
       $protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
       $data['Path'] = $protocol."://".$_SERVER['HTTP_HOST'].$path.'/temp/' . $_FILES['file']['name'];
       $data['Name'] = $_FILES['file']['name'];
       $data['status'] = 200;
       $data['state'] = true;
       $data['data'] = $data;
       echo json_encode($data);
    }else{
        $data['status'] = 200;
        $data['mensaje'] = 'Invalid File Type. Upload Excel File.';
       $data['state'] = true;
       $data['data'] = null;
       echo json_encode($data);
    }

    
}


function ConsultarEmpleado_Plantilla($empleado){
        
    //$porciones = explode(": ", $empleado);
    
    /*
    $pos = strpos($porciones[0], '-');

    if($pos=== false){
        $apellidos = str_replace(" ", "",$porciones[0]);
    }else{
        $apellidos = str_replace("-", "",$porciones[0]);
        $apellidos = str_replace(" ", "",$apellidos);
    }
    */
    return UploadPayRollModel::ValidarNombreCompletoPorId($empleado);      
}


function Upload_excel($post){

    $data =array();
    try{

        $exitos = array();
        $fallidos=array();
        $path = '../temp/'.$post['name'];
        $excelReader = PHPExcel_IOFactory::createReaderForFile( $path);
            $excelObj = $excelReader->load($path);
            $worksheet = $excelObj->getSheet(0);
           
            $i=0;
            $j=0;
            $val_reg = 0;
            $val_pto=0;
            $val_ot = 0;
            $k=0;
            $detalle = array();
            $d=0;
            $existe_empleado = true;
                
            if($worksheet->getCell('A4')->getValue()=="ID EMPLOYEE" || $worksheet->getCell('B4')->getValue()=="EMPLOYEE NAME"){
                $fecha = $worksheet->getCell('A3')->getValue();

                if (strpos($fecha , 'to')) {
                    $arrayFecha = explode(" to ",$fecha);
                }else{
                    $arrayFecha = explode(" - ",$fecha);
                }
                

                $stack = $worksheet->getCell('A1')->getValue();
                if( $stack==""){
                    $porciones=array();
                    $porciones[1] = "";
                    $id_HostCompany=0;
                    $staff_c["datos"][0]['name']="";
                }else{
                    $porciones=array();
                    $porciones[1] = $stack;
                    $empleado=false;
                    $staff_c = ConsultarHostCompany($stack);
                    $id_HostCompany = count($staff_c["datos"]);
                }

                    

                $id_payroll=UploadPayRollModel::Guardar_Payroll($fecha,$staff_c["datos"][0]['name'],$arrayFecha[0],$arrayFecha[1]);
                
                if($id_HostCompany == 0){
                    $fallidos[$i]='Not exist staff company: '.$stack;
                    $i++;
                    $val_reg = 0;
                    $val_pto=0;
                    $val_ot = 0;
                    $d=0;
                    $detalle = array();
                   
                 }else{


                    $impuesto =UploadPayRollModel:: LlaveConfig('tax')['datos'][0]['value'];
                    $worksheet1 = $excelObj->getSheet(0);
                    $lastRow = $worksheet1->getHighestRow();
                   
                    $z=1;
                    for ($row = 5; $row <= $lastRow; $row++) {
                        $val_reg = 0;
                        $val_pto=0;
                        $val_ot = 0; 
						
						if($worksheet1->getCell('A'.$row)->getValue()=="" || $worksheet1->getCell('A'.$row)->getValue()== null){
							continue;
						}
						
                        $id_empleado = ConsultarEmpleado_Plantilla($worksheet1->getCell('A'.$row)->getValue());
                       
                        if( $id_empleado == 0){
                            $fallidos[$i]='Not exist employee: ID:'.$worksheet1->getCell('A'.$row)->getValue();
                           
                            $i++;
                            $val_reg = 0;
                            $val_pto=0;
                            $val_ot = 0;
                            
                            $detalle = array();
                            continue;
                         }

                         $datos_empleado=UploadPayRollModel::Datos_Empleado($id_empleado);
                         if($worksheet1->getCell('E'.$row)->getValue() ==null || $worksheet1->getCell('E'.$row)->getValue() =="" ||$worksheet1->getCell('E'.$row)->getValue() =="E" ||$worksheet1->getCell('E'.$row)->getValue() =="0.0" ){
                            $val_reg =$worksheet1->getCell('C'.$row)->getValue();
                            $val_ot =$worksheet1->getCell('D'.$row)->getValue();
                            $val_pto=$worksheet1->getCell('F'.$row)->getValue();
                            $val_bonus=$worksheet1->getCell('G'.$row)->getValue();
                            $total_regular =  number_format($datos_empleado['datos'][0]['hourvalue']*$val_reg, 2, '.', '');
                            //total PTO 
                            $total_pto =  number_format($datos_empleado['datos'][0]['hourvalue']*$val_pto, 2, '.', '');
                            //total ot
                            $total_ot =  number_format($datos_empleado['datos'][0]['overtime']*$val_ot, 2, '.', '');
                            
                            $subtotal =  $total_regular+$total_pto+$total_ot+$val_bonus;
                         }else{
                            $val_reg =$worksheet1->getCell('C'.$row)->getValue();
                            $val_ot =$worksheet1->getCell('D'.$row)->getValue();
                            $val_pto=$worksheet1->getCell('F'.$row)->getValue();
                            $total_regular =  number_format($datos_empleado['datos'][0]['hourvalue']*$val_reg, 2, '.', '');
                            //total PTO 
                            $total_pto =  number_format($datos_empleado['datos'][0]['hourvalue']*$val_pto, 2, '.', '');
                            //total ot
                            $total_ot =  number_format($datos_empleado['datos'][0]['overtime']*$val_ot, 2, '.', '');
                           
                            $salario =$worksheet1->getCell('E'.$row)->getValue();
                            $val_bonus=$worksheet1->getCell('G'.$row)->getValue();
                            $subtotal =  $salario+$val_bonus;
                         }

                         $val_tax = $impuesto;
                         $tax =  number_format((($subtotal * $val_tax)/100), 2, '.', '');
                         $total =   number_format($subtotal -(($subtotal * $val_tax)/100), 2, '.', '');
                         $subtotal= number_format($subtotal, 2, '.', '');
                         UploadPayRollModel::GuardarDatosPayRoll($id_payroll,$id_empleado,$staff_c["datos"][0]['id'],$val_reg,$total_regular,$val_pto,
                         $total_pto,$val_ot,$total_ot,$tax,$subtotal,$total,$val_tax,$arrayFecha[0], $val_bonus);
                         

                    }
                 }

                 $fallos = array_unique($fallidos);
              
                 UploadPayRollModel::GuardarFallosPayRoll($id_payroll,$fallos);
                 $data['mensaje'] = 'successfully upload payroll!';
                 $data['status']='success';
                 $data['data']=$id_payroll;
                 $query ="INSERT INTO payroll (date,host_company,desde,hasta) 
                 VALUES (".$fecha.','.$porciones[1].','.$arrayFecha[0].','.$arrayFecha[1].")";
                 $json= json_encode($post);
                 $datos_array = str_replace('"', "", $json);
                 LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'UploadPayroll',$query,$datos_array);
                 $data['query']="";
            }else{

                
                $fecha = $worksheet->getCell('E1')->getValue();
             
                $arrayFecha = explode(" - ",$fecha);
                $id_empleado=0;
                $stack = $worksheet->getCell('A2')->getValue();
                if( $stack==""){
                    $porciones=array();
                    $porciones[1] = "";
                    $id_HostCompany=0;
                    $staff_c["datos"][0]['name']="";
                }else{
                    $porciones = explode(": ",$stack);
                    $empleado=false;
                    $staff_c = ConsultarHostCompany($porciones[1]);
                    $id_HostCompany = count($staff_c["datos"]);
                }
              
                $id_payroll=UploadPayRollModel::Guardar_Payroll($fecha,$staff_c["datos"][0]['name'],$arrayFecha[0],$arrayFecha[1]);
                
                $suma = true;
                if($id_HostCompany == 0){
                    $fallidos[$i]='Not exist staff company: '.$porciones[1];
                    $i++;
                    $val_reg = 0;
                    $val_pto=0;
                    $val_ot = 0;
                    $d=0;
                    $detalle = array();
                   
                 }else{
                    $impuesto =UploadPayRollModel:: LlaveConfig('tax')['datos'][0]['value'];
                    $worksheet1 = $excelObj->getSheet(1);
                    $lastRow = $worksheet1->getHighestRow();
                   
                    $z=1;
                    for ($row = 1; $row <= $lastRow; $row++) {
                        $z++;
                      
                        $pos = strpos($worksheet1->getCell('A'.$row)->getValue(),'D:');
                      
                        if($pos==true){
                        
                            $val_reg = 0;
                            $val_pto=0;
                            $val_ot = 0; 
                     $id_empleado = ConsultarEmpleado($worksheet1->getCell('A'.$row)->getValue());
                 
                     if( $id_empleado == 0){
                         $fallidos[$i]='Not exist employee: '.$worksheet1->getCell('A'.$row)->getValue();
                        
                         $i++;
                         $val_reg = 0;
                         $val_pto=0;
                         $val_ot = 0;
                         
                         $detalle = array();
                         $empleado=false;
                         continue;
                      }else{
                        $empleado=true;
                      } 
                        }else{
                            if($empleado==false){
                            
                                continue;
                            }else{
                              if($worksheet1->getCell('N'.$row)->getValue() !="" && $worksheet1->getCell('N'.$row)->getValue() !="Pay Type") {
           
                                
                                $val_reg =$val_reg+$worksheet1->getCell('G'.$row)->getValue();
                                $val_ot =$val_ot+$worksheet1->getCell('I'.$row)->getValue();
                                $val_pto=$val_pto+$worksheet1->getCell('K'.$row)->getValue();
                                $suma=true;
                              }else{
                                  if($worksheet1->getCell('N'.$row)->getValue() ==""){
                                        if($suma== true){                  
                                        $val_ot = number_format($val_ot, 2, '.', '');
                                        $val_reg = number_format($val_reg, 2, '.', '');
                                        $val_pto = number_format($val_pto, 2, '.', '');
    
                        $datos_empleado=UploadPayRollModel::Datos_Empleado($id_empleado);
                      
                        //total regular
                        $total_regular =  number_format($datos_empleado['datos'][0]['hourvalue']*$val_reg, 2, '.', '');
                        //total PTO 
                        $total_pto =  number_format($datos_empleado['datos'][0]['hourvalue']*$val_pto, 2, '.', '');
                        //total ot
                        $total_ot =  number_format($datos_empleado['datos'][0]['overtime']*$val_ot, 2, '.', '');
                        $subtotal =  $total_regular+$total_pto+$total_ot;
                        $val_tax = $impuesto;
                        $tax =  number_format((($subtotal * $val_tax)/100), 2, '.', '');
                        $total =   number_format($subtotal -(($subtotal * $val_tax)/100), 2, '.', '');
                        $subtotal= number_format($subtotal, 2, '.', '');
                        UploadPayRollModel::GuardarDatosPayRoll($id_payroll,$id_empleado,$staff_c["datos"][0]['id'],$val_reg,$total_regular,$val_pto,
                        $total_pto,$val_ot,$total_ot,$tax,$subtotal,$total,$val_tax,$arrayFecha[0],null);
    
                                        }
                                    $suma=false;
                                    continue;
                                  }
                              }
                            }
    
                        }
                    }
                 }
                 
                 //$fallos = array_unique($fallidos);
                //echo $fecha;
                //echo $stack;
    
                //$worksheet1 = $excelObj->getSheet(1);
                //$id=$worksheet1->getCell('C1')->getValue();
                //echo $id;
                $fallos = array_unique($fallidos);
              
                UploadPayRollModel::GuardarFallosPayRoll($id_payroll,$fallos);
                $data['mensaje'] = 'successfully upload payroll!';
                $data['status']='success';
                $data['data']=$id_payroll;
                $query ="INSERT INTO payroll (date,host_company,desde,hasta) 
                VALUES (".$fecha.','.$porciones[1].','.$arrayFecha[0].','.$arrayFecha[1].")";
                $json= json_encode($post);
                $datos_array = str_replace('"', "", $json);
                LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'UploadPayroll',$query,$datos_array);
                $data['query']="";
            }

        }Catch(exception $ex){

            $data['mensaje'] = "Had a error, please try again.";
            $data['status']='error';
            $data['data']=0;
        }
        echo json_encode($data);

  
    }



    function ConsultarHostCompany($host){

        $nombre = explode(" ",$host);

        return   UploadPayRollModel::ValidarHostCompany($nombre[0]);      
    } 

    function ConsultarEmpleado($empleado){
        
        $porciones = explode(": ", $empleado);
        
        /*
        $pos = strpos($porciones[0], '-');

        if($pos=== false){
            $apellidos = str_replace(" ", "",$porciones[0]);
        }else{
            $apellidos = str_replace("-", "",$porciones[0]);
            $apellidos = str_replace(" ", "",$apellidos);
        }
        */
        return UploadPayRollModel::ValidarNombreCompletoPorId($porciones[1]);      
    }



    function ListDetails($dataPost) {
        $columns = $dataPost['columns'];
    
        $start = $dataPost['start'];
        $length = $dataPost['length'];
    
        $searchArray = $dataPost['search'];
        $search = $searchArray['value'];
       
        $orderArray = $dataPost['order'];
        $orderNumberField = $orderArray[0]['column'];
        $orderField = $columns[$orderNumberField]['data'];
        $orderDir = $orderArray[0]['dir'];
        $id=$dataPost['id'];
        $respuesta["recordsTotal"] = $respuesta["recordsFiltered"] = 0;
        
        $respuesta["data"] = array();
        $data = UploadPayRollModel::TablaDetalle($start, $length, $search, $orderField, $orderDir,$id);
        
        if (empty($data)) {
            echo json_encode($respuesta);
        } else {
            $respuesta["recordsTotal"] = $respuesta["recordsFiltered"] = $data["total"];
            $respuesta["data"] = $data["datos"];
            echo json_encode($respuesta);
        }
    }
    