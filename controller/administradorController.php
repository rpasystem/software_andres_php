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


require_once(dirname(__FILE__) . "/../model/AdministradorModel.php");
require_once(dirname(__FILE__) . "/../model/LogsModel.php");
switch ($post['tipo']) {
    case "LISTADMIN":
    ListAdmin($post);
    break;
    case "CREARADMIN":
    CrearAdmin($post);
    break;
    case "INACTIVATEADMIN":
    Inactivated($post);
    break;
    case "DETALLE":
    Detalle($post);
    break;
    case "EDITADMIN":
    Edit($post);
    break;
    default: echo('Error, no existe el dato "TIPO" en el objeto POST');
    break;
}

function Edit($post){
    $first_name = $post['first_name'];
    $second_name = $post['second_name'];
    $surname= $post['surname'];
    $second_surname= $post['second_surname'];
    $identification = $post['identification'];
    $email = $post['email'];
    $password=$post['password'];
    $password_sin_encrypt=$post['password'];
    $id=$post['id_admin'];
        $identificacion_sin_guion = str_replace("-","",$post['identification']);

    if($post['password'] != ""){
        $pass = password_hash($post['password'],PASSWORD_DEFAULT) ;
    }else{
        $pass = $post['password'];
    }
    
    $data = AdministradorModel::Editar($first_name,$second_name,$surname,$second_surname,$identification,$email,$pass,$id,$identificacion_sin_guion,$password_sin_encrypt);
    if($data['status']=='success'){
        $json= json_encode($post);
                $datos_array = str_replace('"', "", $json);
        LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'EditAdministrator',$data['query'],$datos_array );
    }
    $data['query']="";
    echo json_encode($data);
}

function Detalle($post){
    $id = $post['id'];
    $data = AdministradorModel::Detalle($id);
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
    $data = AdministradorModel::CambiarEstado($id,$estado);
    if($data['status']=='success'){
        $json= json_encode($post);
        $datos_array = str_replace('"', "", $json);
        LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'InactivateAdmin',$data['query'],$datos_array);
    }
    $data['query']="";
    echo json_encode($data);
}


function CrearAdmin($post){
    $first_name = $post['first_name'];
    $second_name = $post['second_name'];
    $surname= $post['surname'];
    $second_surname= $post['second_surname'];
    $identification = $post['identification'];
    $email = $post['email'];
    $password_sin_encrypt=$post['password'];
    $pass =  password_hash($post['password'],PASSWORD_DEFAULT) ;
    $identificacion_sin_guion = str_replace("-","",$post['identification']);
    $data = AdministradorModel::Crear($first_name,$second_name,$surname,$second_surname,$identification,$email,$pass,$identificacion_sin_guion,$password_sin_encrypt);
    if($data['status']=='success'){
        $json= json_encode($post);
        $datos_array = str_replace('"', "", $json);
        LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'CreateAdministrator',$data['query'],$datos_array );
    }
    $data['query']="";
    echo json_encode($data);
}

function ListAdmin($dataPost) {
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
    $data = AdministradorModel::Tabla($start, $length, $search, $orderField, $orderDir,$filtro);
    
    if (empty($data)) {
        echo json_encode($respuesta);
    } else {
        $respuesta["recordsTotal"] = $respuesta["recordsFiltered"] = $data["total"];
        $respuesta["data"] = $data["datos"];
        echo json_encode($respuesta);
    }
}