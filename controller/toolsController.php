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

$GLOBALS['path'] ='/proyecto_1_nomina';
//$GLOBALS['path'] ='';
require_once(dirname(__FILE__) . "/../model/ToolsModel.php");
require_once(dirname(__FILE__) . "/../model/LogsModel.php");



switch ($post['tipo']) {
    case "LIST":
    Lista();
    break;
    case "UPDATE_TOOLS":
    Update($post);
    break;
    default: echo('Error, no existe el dato "TIPO" en el objeto POST');
    break;
}


function Lista(){
    $data = ToolsModel::Lista();
    $data['cantidad'] = count($data['datos']);
    echo json_encode($data);
}

function Update($post){
   $tax = $post['tax'];
  
    $data = ToolsModel::Update($tax,'tax');

    echo json_encode($data);
}

