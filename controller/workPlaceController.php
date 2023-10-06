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


require_once(dirname(__FILE__) . "/../model/WorkPlaceModel.php");
require_once(dirname(__FILE__) . "/../model/LogsModel.php");

switch ($post['tipo']) {
    case "CREATEWORK":
    CreateWork($post);
    break;
    case "LISTAWORK_PLACE":
    ListWorkPlace($post);
    break;
    case "INACTIVATEWORK":
    DeleteWork($post);
    break;
    case "DETALLE":
    Detalle($post);
    break;
    case "EDITWORK":
    EditWorkCompany($post);
    break;
    default: echo('Error, no existe el dato "TIPO" en el objeto POST');
    break;
}

function EditWorkCompany($post){
    $name = $post['name_work_edit'];
    $id = $post['id'];
    $id_host_company = $post['id_host_company_work_edit'];
    $data = WorkPlaceModel::Edit($name,$id,$id_host_company);
            if($data['status']=='success'){
                $json= json_encode($post);
                $datos_array = str_replace('"', "", $json);
                LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'Editworkplace',$data['query'],$datos_array);   
            }
        echo json_encode($data);
}

function Detalle($post){
    $id = $post['id'];
    $data = WorkPlaceModel::Detalle($id);
    if($data['status']=='success'){
        $json= json_encode($post);
        $datos_array = str_replace('"', "", $json);
        LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'ViewWorkCompany',$data['query'],$datos_array);
    }
    $data['query']="";
    echo json_encode($data);

}

function DeleteWork($post){
    $id = $post['id'];
    $estado = 0;
    $data = WorkPlaceModel::CambiarEstado($id,$estado);
    if($data['status']=='success'){
        $json= json_encode($post);
        $datos_array = str_replace('"', "", $json);
        LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'InactivateWorkPlace',$data['query'],$datos_array);
    }
    $data['query']="";
    echo json_encode($data);
}

function ListWorkPlace($dataPost) {
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
    $data = WorkPlaceModel::Tabla($start, $length, $search, $orderField, $orderDir,$filtro);
    
    if (empty($data)) {
        echo json_encode($respuesta);
    } else {
        $respuesta["recordsTotal"] = $respuesta["recordsFiltered"] = $data["total"];
        $respuesta["data"] = $data["datos"];
        echo json_encode($respuesta);
    }
}


function CreateWork($post){
    $id_host = $post['id_host_company_work'];
    $name =  $post['name_work'];
    $data = WorkPlaceModel::Crear($id_host,$name);
            if($data['status']=='success'){
                $json= json_encode($post);
                $datos_array = str_replace('"', "", $json);
                LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'CreateWorkPlace',$data['query'],$datos_array);
            }
     echo json_encode($data);
}