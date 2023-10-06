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


require_once(dirname(__FILE__) . "/../model/HostCompanyModel.php");
require_once(dirname(__FILE__) . "/../model/LogsModel.php");

switch ($post['tipo']) {
    case "LISTAHOSTCOMPANY":
    ListHostCompany($post);
    break;
    case "CREATECOMPANY":
    CreateCompany($post);
    break;
    case "INACTIVATEHOST":
    DeleteHost($post);
    break;
    case "DETALLE":
    Detalle($post);
    break;
    case "EDITCOMPANY":
    EditCompany($post);
    break;
    default: echo('Error, no existe el dato "TIPO" en el objeto POST');
    break;
}

function EditCompany($post){
    $name = $post['edit_name'];
    $id = $post['id'];
    $data = HostCompanyModel::Edit($name,$id);
            if($data['status']=='success'){
                $json= json_encode($post);
                $datos_array = str_replace('"', "", $json);
                LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'EditHostCompany',$data['query'],$datos_array);   
            }
        echo json_encode($data);
}

function Detalle($post){
    $id = $post['id'];
    $data = HostCompanyModel::Detalle($id);
    if($data['status']=='success'){
        $json= json_encode($post);
                $datos_array = str_replace('"', "", $json);
        LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'ViewHostCompany',$data['query'],$datos_array );
    }
    $data['query']="";
    echo json_encode($data);
}

function DeleteHost($post){
    $id = $post['id'];
    $estado = 0;
    $data = HostCompanyModel::CambiarEstado($id,$estado);
    if($data['status']=='success'){
        $json= json_encode($post);
                $datos_array = str_replace('"', "", $json);
        LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'InactivateHostCompany',$data['query'],$datos_array);
    }
    $data['query']="";
    echo json_encode($data);
}

function CreateCompany($post){
    $name = $post['name'];
    $data = HostCompanyModel::Crear($name);
            if($data['status']=='success'){
                $json= json_encode($post);
                $datos_array = str_replace('"', "", $json);
                LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'CreateHostCompany',$data['query'],$datos_array);
                
            }

            echo json_encode($data);
}

function ListHostCompany($dataPost) {
    $columns = $dataPost['columns'];

    $start = $dataPost['start'];
    $length = $dataPost['length'];

    $searchArray = $dataPost['search'];
    $search = $searchArray['value'];
   
    $orderArray = $dataPost['order'];
    $orderNumberField = $orderArray[0]['column'];
    $orderField = $columns[$orderNumberField]['data'];
    $orderDir = $orderArray[0]['dir'];
    $filtro=$dataPost['parametro'];
    $respuesta["recordsTotal"] = $respuesta["recordsFiltered"] = 0;
    
    $respuesta["data"] = array();
    $data = HostCompanyModel::Tabla($start, $length, $search, $orderField, $orderDir,$filtro);
    
    if (empty($data)) {
        echo json_encode($respuesta);
    } else {
        $respuesta["recordsTotal"] = $respuesta["recordsFiltered"] = $data["total"];
        $respuesta["data"] = $data["datos"];
        echo json_encode($respuesta);
    }
}

