<?php
require_once("../config/conexion.php");

class LogModel {
    public static function Registrar($id,$idrol,$accion,$query,$array) {
        $fecha =  date("n-j-Y");

        $db=Conectar::conexion();
        $sql = "INSERT INTO `logs`(`id_user`, `type_user`, `action`, `query`,data,fecha) VALUES (".$id.",".$idrol.",'".$accion."','".$query."','".$array."','".$fecha."')";
        
        $result1 = $db->query($sql);
    }
}