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

require_once(dirname(__FILE__) . "/../model/LoginModel.php");
require_once(dirname(__FILE__) . "/../model/LogsModel.php");


switch ($post['tipo']) {
    case "Login" :
        Login($post);
        break;
        case "Cerrar" :
            Cerrar();
            break;
        case "Cerrar" :
            Cerrar();
            break;
    default: echo('Error, no existe el dato "TIPO" en el objeto POST');
        break;
}

function Cerrar() {
    $data = LoginModel::Cerrar();
    
    echo json_encode($data);
}


function Login($post) {
    
    $username = $post['username'];
    $rol = $post['state'];
    $pass = $post['pass'];
    
// verify the response


    // valid submission
    $data = LoginModel::login($username, $pass,$rol);
    
    if($data['status'] =='success'){
        $json= json_encode($_SESSION['user_login_status']);
        $aaa = str_replace('"', "", $json);
   
        LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'login',$data['query'],$aaa);
    }
    $data['query']="";
    echo json_encode($data);
    
}

