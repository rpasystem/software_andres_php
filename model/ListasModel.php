<?php
require_once("../config/conexion.php");

class ListasModel {

    public static function Delete($id){
        $data = array();
        $db=Conectar::conexion();
        $sql="DELETE FROM `payroll` WHERE id=".$id;

            $result1 = $db->query($sql);
    
            $sql="DELETE FROM `payrool_employ` WHERE id_payroll=".$id;
    
            $result1 = $db->query($sql);
    
            $sql="DELETE FROM `fails_payrolls` WHERE id_payroll=".$id;
    
            $result1 = $db->query($sql);

            return $data;
    }

    public static function Admin(){
        $data = array();
        $db=Conectar::conexion();
        $data["datos"] = array();
        $sql = "SELECT id,concat(firstname,' ',second_name,' ',surename,' ',second_surname) as name FROM `adminisitrator` ORDER BY firstname asc";
        $resultadoTotal = $db->query($sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
            $data["datos"][$i] = $row;
            $i++;
        }
        
        return $data;
    }

    public static function Dates(){
        $data = array();
        $db=Conectar::conexion();
        $data["datos"] = array();
        $sql = "SELECT DISTINCT date as name from payroll";
        
        $resultadoTotal = $db->query($sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
            $data["datos"][$i] = $row;
            $i++;
        }
        return $data;
    }


    public static function Workplaces($id){
        $data = array();
        $db=Conectar::conexion();
        $data["datos"] = array();
        $sql = "SELECT name,id FROM work_place where id_host_company=$id  ORDER BY name";
        
        $resultadoTotal = $db->query($sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
            $data["datos"][$i] = $row;
            $i++;
        }
        return $data;
    }
  

    public static function State(){
        $data = array();
        $db=Conectar::conexion();
        $data["datos"] = array();
        $sql = "SELECT id,state,state_code FROM `states` ORDER BY state";
        $resultadoTotal = $db->query($sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
            $data["datos"][$i] = $row;
            $i++;
        }
        
        return $data;
    }

    public static function HostCompany(){
        $data = array();
        $db=Conectar::conexion();
        $sql = "SELECT id,name FROM `host_company` where state = 1 ORDER BY name";
        $resultadoTotal = $db->query($sql);
        $i = 0;
        $data["datos"] = array();
        while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
            $data["datos"][$i] = $row;
            $i++;
        }
        
        return $data;
    }

    public static function StaffComany($id){
        $data = array();
        $db=Conectar::conexion();
        $data["datos"] = array();
        $sql = "SELECT id,name FROM `staff_company` WHERE id_work_place = $id  AND state = 1 ORDER BY name";
        $resultadoTotal = $db->query($sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
            $data["datos"][$i] = $row;
            $i++;
        }
        
        return $data;
    }
    public static function Nationality(){
        $data = array();
        $db=Conectar::conexion();
        $data["datos"] = array();
        $sql = "SELECT id,name FROM `country` ORDER BY name";
        $resultadoTotal = $db->query($sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
            $data["datos"][$i] = $row;
            $i++;
        }
        
        return $data;
    }
    public static function Gender(){
        $data = array();
        $db=Conectar::conexion();
        $data["datos"] = array();
        $sql = "SELECT id,name FROM `gender` ORDER BY name";
        $resultadoTotal = $db->query($sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
            $data["datos"][$i] = $row;
            $i++;
        }
        
        return $data;
    }
    public static function Cities($id){
        $data = array();
        $db=Conectar::conexion();
        $data["datos"] = array();
        $sql = "SELECT id,city  FROM `cities` WHERE state_code = (SELECT state_code from states where id=".$id.") ORDER BY city";
        $resultadoTotal = $db->query($sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
            $data["datos"][$i] = $row;
            $i++;
        }
        
        return $data;
    }

    public static function StaffByHostCompany($id){
        $data = array();
        $db=Conectar::conexion();
        $data["datos"] = array();
        $sql = "SELECT id,name FROM `staff_company` WHERE id_host_company = $id  AND state = 1 ORDER BY name";
        $resultadoTotal = $db->query($sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
            $data["datos"][$i] = $row;
            $i++;
        }
        
        return $data;
    }


    public static function AllStaffCompany(){
        $data = array();
        $db=Conectar::conexion();
        $data["datos"] = array();
        $sql = "SELECT id,name FROM `staff_company` WHERE state = 1 ORDER BY name";
        $resultadoTotal = $db->query($sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
            $data["datos"][$i] = $row;
            $i++;
        }
        
        return $data;
    }

    public static function AllStaffCompany_No_ID(){
        $data = array();
        $db=Conectar::conexion();
        $data["datos"] = array();
        $sql = "SELECT distinct name as id,name FROM `staff_company` WHERE state = 1 ORDER BY name";
        $resultadoTotal = $db->query($sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
            $data["datos"][$i] = $row;
            $i++;
        }
        
        return $data;
    }

    
    public static function AllEmployee(){
        $data = array();
        $db=Conectar::conexion();
        $data["datos"] = array();
        $sql = "SELECT id,concat(first_name,' ',second_name,' ',surname,' ',second_surname) as name FROM `emplyee` WHERE state = 1 order by first_name asc";
        $resultadoTotal = $db->query($sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
            $data["datos"][$i] = $row;
            $i++;
        }
        
        return $data;
    }
}