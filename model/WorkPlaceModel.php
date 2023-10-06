<?php
require_once("../config/conexion.php");

class WorkPlaceModel {


    public static function  Edit($name,$id,$id_host_company){
        $data = array();
        $db=Conectar::conexion();
        try{

            $sql="UPDATE work_place SET name='".$name."',id_host_company=$id_host_company WHERE id=".$id;
                                $result1 = $db->query($sql);
        }
        catch(Exception $ex){
            $return["status"] = 'error';
            return $return;
        }
        $return["status"] = 'success';
        $return["query"] = "UPDATE work_place SET name=".$name.",id_host_company=$id_host_company WHERE id=".$id;
        return  $return;
    }




    public static function Detalle($id){
        $data = array();
        $db=Conectar::conexion();
        $data["datos"] = array();
        $sql = "SELECT id_host_company,name FROM `work_place` WHERE id=".$id;
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

            $sql="UPDATE work_place SET state = $estado WHERE id=".$id;

                                $result1 = $db->query($sql);
        }
        catch(Exception $ex){
            $return["status"] = 'error';
            return $return;
        }
        $return["status"] = 'success';
        $return["query"] = "UPDATE work_place SET state = $estado WHERE id=".$id;
        return  $return;
    }


    public static function Crear($id_host,$name){
        $data = array();
        $db=Conectar::conexion();
        try{

            $sql="INSERT INTO `work_place`( name,id_host_company) 
                                VALUES ('".$name."',$id_host)";

                                $result1 = $db->query($sql);
        }
        catch(Exception $ex){
            $return["status"] = 'error';
            return $return;
        }
        $return["status"] = 'success';
        $return["query"] = "INSERT INTO `work_place`( name,id_host_company) VALUES (".$name.",$id_host)";
        return  $return;
    }


    public static function Tabla($start, $length, $search, $orderField, $orderDir,$filtro) {
        $sqlFromJoin = " FROM `work_place` w INNER JOIN host_company h ON w.id_host_company = h.id ";

        ///SQL filtro
        $sqlWhere = " WHERE 1 = 1 AND w.state = 1  ";

        
        if($filtro != ""){
            $sqlWhere=$sqlWhere." AND  w.name like '%".$filtro."%' OR  h.name like '%".$filtro."%' OR  w.id like '%".$filtro."%'";
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
            
            $sql = "SELECT  w.id, w.name as work_place,w.date_add as date, h.name as host_company  "
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