<?php
require_once("../config/conexion.php");

class StaffCompanyModel {


    public static function  Edit($name,$id,$id_host_company_edit,$id_work_place_edit,$address,$phone,$payer){
        $data = array();
        $db=Conectar::conexion();
        try{

            $sql="UPDATE staff_company SET payer='".$payer."', name='".$name."' ,id_work_place=$id_work_place_edit,id_host_company=$id_host_company_edit ,phone='".$phone."',address='".$address."'  WHERE id=".$id;
        
                                $result1 = $db->query($sql);
        }
        catch(Exception $ex){
            $return["status"] = 'error';
            return $return;
        }
        $return["status"] = 'success';
        $return["query"] = "UPDATE staff_company SET name=".$name.", id_work_place=$id_work_place_edit,id_host_company=$id_host_company_edit WHERE id=".$id;
        return  $return;
    }

    public static function Detalle($id){
        $data = array();
        $db=Conectar::conexion();
        $data["datos"] = array();
        $sql = "SELECT * FROM `staff_company` WHERE id=".$id;
        $resultadoTotal = $db->query($sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
            $data["datos"][$i] = $row;
            $i++;
        }
        $data["status"]='success';
        $data["query"]=$sql;
        return $data;
    }


    public static function CambiarEstado($id,$estado){
        $data = array();
        $db=Conectar::conexion();
        try{

            $sql="UPDATE staff_company SET state = $estado WHERE id=".$id;

                                $result1 = $db->query($sql);
        }
        catch(Exception $ex){
            $return["status"] = 'error';
            return $return;
        }
        $return["status"] = 'success';
        $return["query"] = "UPDATE staff_company SET state = $estado WHERE id=".$id;
        return  $return;
    }


    public static function Crear($name,$id,$id_host_company,$address,$phone,$payer){
        $data = array();
        $db=Conectar::conexion();
        try{

            $sql="INSERT INTO `staff_company`( name,id_work_place,id_host_company,address,phone,payer) 
                                VALUES ('".$name."',$id,$id_host_company,'".$address."','".$phone."','".$payer."')";

                                $result1 = $db->query($sql);
        }
        catch(Exception $ex){
            $return["status"] = 'error';
            return $return;
        }
        $return["status"] = 'success';
        $return["query"] = "INSERT INTO `staff_company`(name,id_work_place,id_host_company,payer) VALUES (".$name.",$id,$id_host_company,$payer)";
        return  $return;
    }



    public static function Tabla($start, $length, $search, $orderField, $orderDir,$filtro) {
        $sqlFromJoin = "  FROM `staff_company` staff INNER JOIN work_place wor on staff.id_work_place = wor.id INNER JOIN host_company hos ON wor.id_host_company = hos.id";

        ///SQL filtro
        $sqlWhere = " WHERE 1 = 1  AND staff.state = 1  ";


        if($filtro != ""){
            $sqlWhere=$sqlWhere." AND  staff.name like '%".$filtro."%' OR  hos.name like '%".$filtro."%'  OR  wor.name like '%".$filtro."%' OR  staff.id like '%".$filtro."%'";
        }


        ///SQL orden
        $sqlOrder = "";
        if ($orderField != null) {
            //$sqlOrder = " ORDER BY soli.idSolicitud " . $orderDir . " "; 
			$sqlOrder = " ORDER BY " .$orderField. " " . $orderDir . " "; 
		}
		
        $db=Conectar::conexion();
        ///SQL total de registros
        $sqlCount = "select count(*) as total " . $sqlFromJoin. $sqlWhere;
        
        $resultadoTotal = $db->query($sqlCount);
        $row = $resultadoTotal->fetch_row();
        $data['total'] = $row;
        if (!$resultadoTotal) {
            //die('Consulta no válida: ' . mysql_error());
            return false;
        }
        
        
        $data["datos"] = array();

        if (intval($row[0]) > 0) {
            
            $sql = "SELECT staff.id, staff.name,wor.name as work_place,hos.name as host_compnay,staff.date "
                    . $sqlFromJoin
                    . $sqlWhere
                    . $sqlOrder
                    . "limit " . $length . " "
                    . "OFFSET " . $start;
            
            $Total = $db->query($sql);
            while ($row = $Total->fetch_array()) {
                $data["datos"][] = $row;
            }
        }
        return $data;
    }

}