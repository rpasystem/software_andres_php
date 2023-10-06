<?php
session_start();
header("Content-Type: text/html;charset=utf-8");
ob_start();
if (!isset($_POST)) {
    die('Error, no exite el objeto POST.');
}
$post = $_POST;

if (!isset($post["tipo"])) {
    die('Error, no existe el dato "TIPO" el objeto POST.');
}

$GLOBALS['path'] ='/application';
//$GLOBALS['path'] ='';

require_once(dirname(__FILE__) . "/../model/EmpleadoModel.php");
require_once(dirname(__FILE__) . "/../model/LogsModel.php");
switch ($post['tipo']) {
    case "UPLOAD":
    Upload($post);
    break;
    case "CREAREMPLEADO";
    CrearEmpleado($post);
    break;
    case "LISTEMPLOYEE":
    ListEmployee($post);
    break;
    case "INACTIVATEEMPLOYEE":
    Inactivated($post);
    break;
    case "DETALLE":
    Detalle($post);
    break;
    case "EDITEMPLEADO":
    EditEmployee($post);
    break;
     case "ACTIVATEEMPLOYEE":
        Activated($post);
    break;
    default: echo('Error, no existe el dato "TIPO" en el objeto POST');
    break;
}

function Activated($post){
    $id = $post['id'];
    $estado = 1;
    $data = EmpleadoModel::CambiarEstado($id,$estado);
    if($data['status']=='success'){
        $json= json_encode($post);
        $datos_array = str_replace('"', "", $json);
        LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'ActivateEmployee',$data['query'], $datos_array);
    }
    $data['query']="";
    echo json_encode($data);
}

function EditEmployee($post){
    $first_name = $post['first_name'];
    $second_name = $post['second_name'];
    $surname= $post['surname'];
    $second_surname= $post['second_surname'];
    $identification = $post['identification'];
    $address = $post['address'];
    $id_state = $post['state'];
    $id_city = $post['city'];
    $postcode = $post['postcode'];
    $phone =$post['phone'];
    $emergency = $post['emergency'];
    $birth = $post['birth'];
    $gender = $post['gender'];
    $nationality = $post['nationality'];
    $email = $post['email'];
    $admission = null;
    $host_company = $post['host_company'];
    $staff_company= $post['staff_company'];
    $position= $post['position'];
    $hourvalue =$post['hourvalue'];
    $overtime =$post['overtime'];
    $foto =$post['foto'];
    $nombre_imagen=$post['nombre_imagen'];
    $ruta =$post['foto'];
    $shift=$post['shift'];
    $work_place=$post['work_place'];
    $fecha_retiro = $post['fecha_retiro'];
    $nacimiento = $post['nacimiento'];
    $identificacion_sin_guion = str_replace("-","",$post['identification']);
    $observation = $post['observation'];
    if($post['password'] != ""){
        $password=password_hash($post['password'],PASSWORD_DEFAULT) ;
    }else{
        $password=$post['password'];
    }
    

    $idEmployee = $post['id_emplyee'];;

    $id_employee_edit = $post['id_employee_edit'];
    $password_sin_encrypt = $post['password'];
    
    try{
        if($nombre_imagen != ""){
            $formato = explode(".",$nombre_imagen);
            $nombre = rand(1, 999999);
                $ruta = dirname(__FILE__) .'/../uploads/employee/'.$idEmployee.'.'.$formato[1];
                copy(dirname(__FILE__) .'/../temp/'.$nombre_imagen,$ruta);
                $path2 = $GLOBALS['path'];
                $protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
                $ruta = $protocol."://".$_SERVER['HTTP_HOST'].$path2.'/uploads/employee/'.$idEmployee.'.'.$formato[1];
        }
        

            $data = EmpleadoModel::Editar($first_name ,$second_name ,$surname,$second_surname,$identification,$address ,$id_state ,$id_city ,$postcode ,$phone,$emergency ,$birth ,$gender,$nationality ,$email,$admission ,$host_company ,$staff_company,$position,$hourvalue ,$overtime,$ruta,$password,$shift,$work_place,$idEmployee,$fecha_retiro,$identificacion_sin_guion,$id_employee_edit,$password_sin_encrypt,$observation,$nacimiento);
            if($data['status']=='success'){
                $json= json_encode($post);
                $datos_array = str_replace('"', "", $json);
                
                LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'EditEmployee',$data['query'],$datos_array);
                
            }
            $data['query']="";
            echo json_encode($data);
    }catch(Exception $ex){
        
    }
}

function Detalle($post){
    $id = $post['id'];
    $data = EmpleadoModel::Detalle($id);
    if($data['status']=='success'){
        $json= json_encode($post);
        $datos_array = str_replace('"', "", $json);
        LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'ViewAdmin',$data['query'],$datos_array);
    }
    $data['query']="";
    echo json_encode($data);
}

function Inactivated($post){
    $id = $post['id'];
    $estado = 0;
    $data = EmpleadoModel::CambiarEstado($id,$estado);
    if($data['status']=='success'){
        $json= json_encode($post);
        $datos_array = str_replace('"', "", $json);
        LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'InactivateEmployee',$data['query'], $datos_array);
    }
    $data['query']="";
    echo json_encode($data);
}

function ListEmployee($dataPost) {

    
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
    $filtro=$dataPost['parametro']; 
    $host_company=$dataPost['host_company'];       
    $staff_company=$dataPost['staff_company'];       
    $respuesta["data"] = array();
    $data = EmpleadoModel::Tabla($start, $length, $search, $orderField, $orderDir,$filtro,$host_company,$staff_company);
    
    if (empty($data)) {
        echo json_encode($respuesta);
    } else {
        $respuesta["recordsTotal"] = $respuesta["recordsFiltered"] = $data["total"];
        $respuesta["data"] = $data["datos"];
        echo json_encode($respuesta);
    }
}


function  CrearEmpleado($post){
    
    $first_name = $post['first_name'];
    $second_name = $post['second_name'];
    $surname= $post['surname'];
    $second_surname= $post['second_surname'];
    $identification = $post['identification'];
    $address = $post['address'];
    $id_state = $post['state'];
    $id_city = $post['city'];
    $postcode = $post['postcode'];
    $phone =$post['phone'];
    $emergency = $post['emergency'];
    $birth = $post['birth'];
    $gender = $post['gender'];
    $nationality = $post['nationality'];
    $email = $post['email'];
    $admission = null;
    $host_company = $post['host_company'];
    $staff_company= $post['staff_company'];
    $position= $post['position'];
    $hourvalue =$post['hourvalue'];
    $overtime =$post['overtime'];
    $foto =$post['foto'];
    $nombre_imagen=$post['nombre_imagen'];
    $fecha_retiro = $post['fecha_retiro'];
    $shift=$post['shift'];
    $work_place=$post['work_place'];
    $obervation =$post['obervation'];
    $identificacion_sin_guion = str_replace("-","",$post['identification']);
    $password=password_hash($post['password'],PASSWORD_DEFAULT) ;
    $id_employee = $post['id_employee'];
    $password_sin_encrypt = $post['password'];
    $nacimiento = $post['nacimiento'];

    $idEmployee = EmpleadoModel::IdEmpleado();
    $idEmployee++;
    try{
        $formato = explode(".",$nombre_imagen);
        $nombre = rand(1, 999999);
            $ruta = dirname(__FILE__) .'/../uploads/employee/'.$idEmployee.'.'.$formato[1];
            copy(dirname(__FILE__) .'/../temp/'.$nombre_imagen,$ruta);
            $path2 = $GLOBALS['path'];
            $protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
            $ruta = $protocol."://".$_SERVER['HTTP_HOST'].$path2.'/uploads/employee/'.$idEmployee.'.'.$formato[1];

            $data = EmpleadoModel::Crear($first_name ,$second_name ,$surname,$second_surname,$identification,$address ,$id_state ,$id_city ,$postcode ,$phone,$emergency ,$birth ,$gender,$nationality ,$email,$admission ,$host_company ,$staff_company,$position,$hourvalue ,$overtime,$ruta,$password,$shift,$work_place,$fecha_retiro,$identificacion_sin_guion,$id_employee,$password_sin_encrypt,$obervation,$nacimiento);
            if($data['status']=='success'){
                $json= json_encode($post);
                $datos_array = str_replace('"', "", $json);
                LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'CreateEmployee',$data['query'],$datos_array);
                
            }
            $data['query']="";
            echo json_encode($data);
    }catch(Exception $ex){
        
    }

}



function Upload($post){
    move_uploaded_file($_FILES  ['file']['tmp_name'], '../temp/' . $_FILES['file']['name']);
     $path = $GLOBALS['path'];
    $protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    $data['Path'] = $protocol."://".$_SERVER['HTTP_HOST'].$path.'/temp/' . $_FILES['file']['name'];
    $data['Name'] = $_FILES['file']['name'];
    $data['status'] = 200;
    $data['state'] = true;
    $data['data'] = $data;
    echo json_encode($data); 
}
