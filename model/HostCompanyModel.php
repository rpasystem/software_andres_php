<?php
require_once("../config/conexion.php");

class HostCompanyModel {

    public static function Detalle($id){
        $data = array();
        $db=Conectar::conexion();
        $data["datos"] = array();
        $sql = "SELECT name FROM `host_company` WHERE id=".$id;
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

            $sql="UPDATE host_company SET state = $estado WHERE id=".$id;

                                $result1 = $db->query($sql);
        }
        catch(Exception $ex){
            $return["status"] = 'error';
            return $return;
        }
        $return["status"] = 'success';
        $return["query"] = "UPDATE host_company SET state = $estado WHERE id=".$id;
        return  $return;
    }


    public static function Tabla($start, $length, $search, $orderField, $orderDir,$filtro) {
        $sqlFromJoin = " from host_company ";

        ///SQL filtro
        $sqlWhere = " WHERE 1 = 1 AND state = 1  ";

        
        if($filtro != ""){
            $sqlWhere=$sqlWhere." AND name like '%".$filtro."%' OR id like '%".$filtro."%'";
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
            
            $sql = "select * "
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

    public static function  Edit($name,$id){
        $data = array();
        $db=Conectar::conexion();
        try{


             //consulta si ya existe la empresa inscrita
             $sqlCount = "select count(*) as total  from host_company  where  name ='".$name ."' AND state = 1 AND id <> ".$id;
             $resultadoTotal = $db->query($sqlCount);
             $row = $resultadoTotal->fetch_row();
 
             if (intval($row[0]) > 0) {
                 $return['mensaje'] ="Host company is already registered ";
                 $return["status"] = 'warning';
                 return $return;
             }


            $sql="UPDATE host_company SET name='".$name."' WHERE id=".$id;
                                $result1 = $db->query($sql);
        }
        catch(Exception $ex){
            $return["status"] = 'error';
            return $return;
        }
        $return["status"] = 'success';
        $return["query"] = "UPDATE host_company SET name=".$name." WHERE id=".$id;;
        return  $return;
    }


    public static function Crear($name){
        $data = array();
        $db=Conectar::conexion();
        try{

             //consulta si ya existe la empresa inscrita
             $sqlCount = "select count(*) as total  from host_company  where  name ='".$name ."' AND state = 1 ";
             $resultadoTotal = $db->query($sqlCount);
             $row = $resultadoTotal->fetch_row();
 
             if (intval($row[0]) > 0) {
                 $return['mensaje'] ="Host company is already registered ";
                 $return["status"] = 'warning';
                 return $return;
             }

            $sql="INSERT INTO `host_company`( name) 
                                VALUES ('".$name."')";

                                $result1 = $db->query($sql);
        }
        catch(Exception $ex){
            $return["status"] = 'error';
            return $return;
        }
        $return["status"] = 'success';
        $return["query"] = "INSERT INTO `host_company`( name) VALUES (".$name.")";
        return  $return;
    }



}