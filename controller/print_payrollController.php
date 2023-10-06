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


require_once(dirname(__FILE__) . "/../model/Print_payrollModel.php");
require_once(dirname(__FILE__) . "/../model/LogsModel.php");

switch ($post['tipo']) {
    case "LIST_PRINT":
    List_Print();
    break;
    default: echo('Error, no existe el dato "TIPO" en el objeto POST');
    break;
}


function List_Print(){
    $data = Print_payrollModel::List_Print();
    
    $return  = array();
 
    foreach($data['datos'] as $item){
        $datos = Print_payrollModel::PayRoll_Last($item['name']);
        
        $return= array_merge($return,$datos['datos']);
    }
  
   
    $return['cant'] = count($return);
    echo json_encode($return);
}
