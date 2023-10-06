<?php
require_once("../config/conexion.php");

class AuditoriaModel {
    public static function Datos_admin($id){
        $data = array();
        $db=Conectar::conexion();
        $data["datos"] = array();
        $sql = "SELECT * FROM `adminisitrator` WHERE id=".$id;
       
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

    public static function Datos_Logs($admin,$inicio,$end){
        $data = array();
        $db=Conectar::conexion();
        $data["datos"] = array();
        $sql = "SELECT * FROM `logs` WHERE type_user=1 AND id_user=".$admin." AND fecha between '".$inicio."' AND '".$end."'";
     
        $resultadoTotal = $db->query($sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
            $data["datos"][$i] = $row;
            $i++;
        }
        $data["status"]='success';
        $data["query"]="SELECT * FROM `logs` WHERE type_user=1 AND id_user=".$admin." AND fecha between ".$inicio." AND ".$end;
        return $data;
    }
}