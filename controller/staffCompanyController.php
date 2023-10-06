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


require_once(dirname(__FILE__) . "/../model/StaffCompanyModel.php");
require_once(dirname(__FILE__) . "/../model/LogsModel.php");

switch ($post['tipo']) {
    case "LISTASTAFFCOMPANY":
    ListStaffCompany($post);
    break;
    case "CREATESTAFF":
    CreateCompany($post);
    break;
    case "INACTIVATESTAFF":
    DeleteStaff($post);
    break;
    case "DETALLE":
    Detalle($post);
    break;
    case "EDITSTAFF":
    EditarStaff($post);
    break;
    default: echo('Error, no existe el dato "TIPO" en el objeto POST');
    break;
}

function EditarStaff($post){
    $id_host_company_edit = $post['id_host_company_edit'];
    $id_work_place_edit=$post['id_work_place_edit'];
    $name = $post['name_edit'];
    $id = $post['id'];
    $address = $post['address'];
    $phone = $post['phone'];
    $payer =$post['payer'];
    $data = StaffCompanyModel::Edit($name,$id,$id_host_company_edit,$id_work_place_edit,$address,$phone,$payer);
            if($data['status']=='success'){
                $json= json_encode($post);
                $datos_array = str_replace('"', "", $json);
                LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'EditStaffComapany',$data['query'],$datos_array );   
            }
        echo json_encode($data);
}


function Detalle($post){
    $id = $post['id'];
    $data = StaffCompanyModel::Detalle($id);
    if($data['status']=='success'){
        $json= json_encode($post);
                $datos_array = str_replace('"', "", $json);
        LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'ViewStaffCompany',$data['query'],$datos_array);
    }
    $data['query']="";
    echo json_encode($data);

}


function DeleteStaff($post){
    $id = $post['id'];
    $estado = 0;
    $data = StaffCompanyModel::CambiarEstado($id,$estado);
    if($data['status']=='success'){
        $json= json_encode($post);
                $datos_array = str_replace('"', "", $json);
        LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'InactivateEmployee',$data['query'],$datos_array);
    }
    $data['query']="";
    echo json_encode($data);
}

function CreateCompany($post){
    $name = $post['name'];
    $id_work_place = $post['id_work_place'];
    $id_host_company = $post['id_host_company'];
    $address = $post['address'];
    $phone = $post['phone'];
    $payer = $post['payer'];
    $data = StaffCompanyModel::Crear($name,$id_work_place,$id_host_company,$address,$phone,$payer);
            if($data['status']=='success'){
                $json= json_encode($post);
                $datos_array = str_replace('"', "", $json);
                LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'CreateStaffcompany',$data['query'],$datos_array);   
            }
            echo json_encode($data);
}


function ListStaffCompany($dataPost) {
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
    $respuesta["data"] = array();
    $data = StaffCompanyModel::Tabla($start, $length, $search, $orderField, $orderDir,$filtro);
    
    if (empty($data)) {
        echo json_encode($respuesta);
    } else {
        $respuesta["recordsTotal"] = $respuesta["recordsFiltered"] = $data["total"];
        $respuesta["data"] = $data["datos"];
        echo json_encode($respuesta);
    }
}

