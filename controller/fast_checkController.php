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

$GLOBALS['path'] ='/application';
//$GLOBALS['path'] ='';
require_once(dirname(__FILE__) . "/../model/Fast_CheckModel.php");
require_once(dirname(__FILE__) . "/../model/LogsModel.php");



switch ($post['tipo']) {
    case "CREAR_FAST_CHECK":
        Crear_Fast_Check($post);
        break;
    case "EDIT_DATA":
        Edit_Data($post);
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
    case "DETAILS_SUCCESS":
            Detalle_exitoso($post);
            break;
    case "ACEPT":
        Aceptar($post);
        break;
    case "DELETE":
            Delete($post);
            break;
    case "LIST_HISTORIC":
            List_historic($post);
            break;
    default: echo('Error, no existe el dato "TIPO" en el objeto POST');
    break;
}

function Crear_Fast_Check($post){

    $name = $post['name'];
    $valor= $post['valor'];
    $razon= $post['razon'];
    $tax= $post['tax'];
    $numero= $post['numero'];
    $id_admin = $_SESSION['user_login_status']['id'];
    $data = Fast_CheckModel::Crear_Fast_Check($name,$valor,$razon,$tax,$numero,$id_admin);
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
    
    $respuesta["data"] = array();
    $data = Fast_CheckModel::List_historic($start, $length, $search, $orderField, $orderDir);
    LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'CalculatePayroll',"SELECT * FROM payroll","");
    if (empty($data)) {
        echo json_encode($respuesta);
    } else {
        $respuesta["recordsTotal"] = $respuesta["recordsFiltered"] = $data["total"];
        $respuesta["data"] = $data["datos"];
        echo json_encode($respuesta);
    }
}



function Delete($post){
    $id = $post['id'];
    $data = Fast_CheckModel::Delete_Payroll($id);
    echo json_encode($data);
}

function Aceptar($post){
    $id = $post['id'];
    $data = Fast_CheckModel::Aceptar($id);
    echo json_encode($data);
}

function  Edit_Data($post){
    $id_success_check=$post['id_success_check']; 
    $full_name=$post['full_name']; 
    $total_val=$post['total_val']; 
    $description=$post['description']; 
    $tax_check=$post['tax_check']; 
    $id_check=$post['id_check']; 
    $data = Fast_CheckModel::Editar($id_success_check,$full_name,$total_val,$description,$tax_check, $id_check);
    echo json_encode($data);
}

function Detalle_exitoso($post){

    $id = $post['id'];
    $data = Fast_CheckModel::Detalle_exitoso($id);
    echo json_encode($data);
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
    $data = Fast_CheckModel::TablaDetalleFallos($start, $length, $search, $orderField, $orderDir,$id);
    
    if (empty($data)) {
        echo json_encode($respuesta);
    } else {
        $respuesta["recordsTotal"] = $respuesta["recordsFiltered"] = $data["total"];
        $respuesta["data"] = $data["datos"];
        echo json_encode($respuesta);
    }
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

        $worksheet1 = $excelObj->getSheet(0);
        $lastRow = $worksheet1->getHighestRow();
        $i=0;
        $id_check=Fast_CheckModel::guardar($post['name']);

        for ($row = 2; $row <= $lastRow; $row++) {

            if($worksheet1->getCell('A'.$row)->getValue()=="" || $worksheet1->getCell('A'.$row)->getValue()== null){
                $fallidos[$i]='Full name is required in row '.$row;
                $i++;
                continue;
            }

            if($worksheet1->getCell('B'.$row)->getValue()=="" || $worksheet1->getCell('B'.$row)->getValue()== null){
                $fallidos[$i]='Val_total is required in row '.$row;
                $i++;
                continue;
            }

            if($worksheet1->getCell('C'.$row)->getValue()=="" || $worksheet1->getCell('C'.$row)->getValue()== null){
                $fallidos[$i]='Description  is required in row '.$row;
                $i++;
                continue;
            }

            if($worksheet1->getCell('D'.$row)->getValue()=="" || $worksheet1->getCell('D'.$row)->getValue()== null){
                $fallidos[$i]='Tax  is required in row '.$row;
                $i++;
                continue;
            }
            if($worksheet1->getCell('E'.$row)->getValue()=="" || $worksheet1->getCell('E'.$row)->getValue()== null){
                $fallidos[$i]='Id_check is required in row '.$row;
                $i++;
                continue;
            }

            /*
            Fast_CheckModel::Guardar_Datos($id_check,
            $worksheet1->getCell('A'.$row)->getValue(),
            $worksheet1->getCell('B'.$row)->getValue(),
            $worksheet1->getCell('C'.$row)->getValue(),
            $worksheet1->getCell('D'.$row)->getValue(),
            $worksheet1->getCell('E'.$row)->getValue());*/
        }

        $fallos = array_unique($fallidos);

        Fast_CheckModel::GuardarFallos($id_check,$fallos);
        $data['mensaje'] = 'successfully upload template fast check!';
        $data['status']='success';
        $data['data']=$id_check;
        $query ="INSERT INTO `fast_check`(`fecha_creacion`, `nombre`, `estado`) VALUES ('NOW()','".$post['name']."',0)";
        $json= json_encode($post);
        $datos_array = str_replace('"', "", $json);
        LogModel::Registrar($_SESSION['user_login_status']['id'],$_SESSION['user_login_status']['rol'],'UploadPayroll',$query,$datos_array);
        $data['query']="";     
    }Catch(exception $ex){
        $data['mensaje'] = 'Had a error, please try again.';
        $data['status']='error';
        $data['data']=0;
    }
    echo json_encode($data);

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
    $data = Fast_CheckModel::TablaDetalle($start, $length, $search, $orderField, $orderDir,$id);
    
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
    $data = Fast_CheckModel::TablaDetalleSuccess($start, $length, $search, $orderField, $orderDir,$id);
    
    if (empty($data)) {
        echo json_encode($respuesta);
    } else {
        $respuesta["recordsTotal"] = $respuesta["recordsFiltered"] = $data["total"];
        $respuesta["data"] = $data["datos"];
        echo json_encode($respuesta);
    }
}