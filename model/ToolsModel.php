<?php
require_once("../config/conexion.php");

class ToolsModel {

    public static function Lista(){
        $data = array();
        $db=Conectar::conexion();
        $data["datos"] = array();
        $sql = "SELECT * from parametros";
        
        $resultadoTotal = $db->query($sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
            $data["datos"][$i] = $row;
            $i++;
        }
        return $data;
    }

    public static function Update($tax,$llave) {
        $data = array();
        $db=Conectar::conexion();
        try{

            $sql = "UPDATE parametros SET value='".$tax."' WHERE llave = '".$llave."'";
            $result1 = $db->query($sql);
        }
        catch(Exception $ex){
            $return["status"] = 'error';
            return $return;
        }
        $return["status"] = 'success';
        $return["query"] = "UPDATE parametros SET value=".$tax." WHERE llave = '".$llave."'";
        return  $return;
    }
  
}