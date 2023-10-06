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

require_once(dirname(__FILE__) . "/../model/ListasModel.php");



switch ($post['tipo']) {
    case "STATE" :
        State($post);
        break;
        case "CITIES":
        cities($post);
        break;
        case "GENDER":
        Gender($post);
        break;
        case "NATIONALITY":
        Nationality();
        break;
        case "HOSTCOMPANY":
        HostCompany();
        break;
        case "STAFF_COMPANY":
        StaffComany($post);
        break;
        
        case "WORKPLACE":
        WorkPlace($post);
        break;
        case "STAFFBYHOSTCOMPANY":
        StaffByHostCompany($post);
        break;
        case "DATES":
        Dates();
        break;
        case "ALLSTAFFCOMPANY":
            AllStaffCompany();
        break;
        case "ALLEMPLOYEE":
            AllEmployee();
        break;
        case "ALLSTAFFCOMPANY_NOID":
            AllStaffCompany_No_ID();
        break;
        case "LIST_ADMIN":
            List_Admin();
        break;
        case "delete":
            Delete($post);
         break;
    default: echo('Error, no existe el dato "TIPO" en el objeto POST');
        break;
}

function Delete($post){
    $id = $post['id'];
    $data = ListasModel::Delete($id);
    echo json_encode($data);
}

function List_Admin(){
    $data = ListasModel::Admin();
    $data['cant'] = count($data['datos']);
    echo json_encode($data);

}

function Dates(){
    $data = ListasModel::Dates();
    $data['cant'] = count($data['datos']);
    echo json_encode($data);
}

function StaffByHostCompany($post){
    $id = $post['id'];
    $data = ListasModel::StaffByHostCompany($id);
    $data['cant'] = count($data['datos']);
    echo json_encode($data);
}

function WorkPlace($post){
    $id = $post['id'];
    $data = ListasModel::Workplaces($id);
    $data['cant'] = count($data['datos']);
    echo json_encode($data);
}

function cities($post){
    $id = $post['id_state'];
    $data = ListasModel::Cities($id);
    $data['cant'] = count($data['datos']);
    echo json_encode($data);
}


function State($post){
    $data = ListasModel::State();
    $data['cant'] = count($data['datos']);
    echo json_encode($data);
}

function Gender($post){
    $data = ListasModel::Gender();
    $data['cant'] = count($data['datos']);
    echo json_encode($data);
}

function Nationality(){
    $data = ListasModel::Nationality();
    $data['cant'] = count($data['datos']);
    echo json_encode($data);
}

function HostCompany(){
    $data = ListasModel::HostCompany();
    $data['cant'] = count($data['datos']);
    echo json_encode($data);
}

function StaffComany($post){
    $id = $post['id'];
    $data = ListasModel::StaffComany($id);
    $data['cant'] = count($data['datos']);
    echo json_encode($data);
}

function AllStaffCompany(){
    $data = ListasModel::AllStaffCompany();
    $data['cant'] = count($data['datos']);
    echo json_encode($data);
}

function AllEmployee(){
    $data = ListasModel::AllEmployee();
    $data['cant'] = count($data['datos']);
    echo json_encode($data);
}

function AllStaffCompany_No_ID(){
    $data = ListasModel::AllStaffCompany_No_ID();
    $data['cant'] = count($data['datos']);
    echo json_encode($data);
}