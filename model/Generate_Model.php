<?php
require_once("../config/conexion.php");

class Generate_Model {
    public static function Detalle_Staff($id){
        $data = array();
        $db=Conectar::conexion();
        $data["datos"] = array();
        $sql = "SELECT * FROM `staff_company` WHERE name='".$id."' limit 1";
       
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

    public static function Datos_empleado($staff,$inicio,$end){
        $data = array();
        $db=Conectar::conexion();
        $data["datos"] = array();
        $sql = "SELECT case when emp.state = 1 THEN 'Active' ELSE 'Inactive' END AS estado, emp.identification,concat(emp.first_name,' ',emp.second_name,' ',emp.surname,' ',emp.second_surname) as fullname,emp.address,concat(ci.city,'-',sta.state,'-',co.name,'-',emp.postcode) as lugar,
        (select sum(pay.subtotal) 
        from payrool_employ pay where pay.estado= 1 AND pay.id_employee = emp.id  AND  STR_TO_DATE(pay.fecha_creacion,'%m/%d/%Y')  BETWEEN STR_TO_DATE('".$inicio."','%m/%d/%Y')   AND    STR_TO_DATE('".$end."','%m/%d/%Y')) as subtotal,
        (select sum(tax.val_tax) from payrool_employ tax  
        where tax.estado = 1 and tax.id_employee = emp.id AND  STR_TO_DATE(tax.fecha_creacion,'%m/%d/%Y')   BETWEEN  
        STR_TO_DATE('".$inicio."','%m/%d/%Y')    AND  STR_TO_DATE('".$end."','%m/%d/%Y') ) as val_tax 
        FROM emplyee emp
        LEFT JOIN country co ON emp.id_nationality = co.id
        INNER JOIN states sta ON emp.id_state = sta.id
        INNER JOIN staff_company staff ON emp.id_staff_company = staff.id
        INNER JOIN cities ci ON emp.id_city =ci.id WHERE staff.name='".$staff."'";
        
        $resultadoTotal = $db->query($sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
            $data["datos"][$i] = $row;
            $i++;
        }
        $data["status"]='success';
        $data["query"]="SELECT emp.identification,concat(emp.first_name,emp.second_name,emp.surname,,emp.second_surname) as fullname,emp.address,concat(ci.city,-,sta.state,-,co.name,-,emp.postcode) as lugar,(select sum(pay.subtotal) from payrool_employ pay where pay.id_employee = emp.id) as subtotal,(select sum(tax.val_tax) from payrool_employ tax where tax.id_employee = emp.id) as val_tax FROM emplyee emp
        LEFT JOIN country co ON emp.id_nationality = co.id
        INNER JOIN states sta ON emp.id_state = sta.id
        INNER JOIN cities ci ON emp.id_city =ci.id WHERE emp.id_staff_company=".$staff;
        return $data;
    }

    public static function getFastCheck(){
        $data = array();
        $db=Conectar::conexion();
        $data["datos"] = array();
          $sql = "SELECT f.*,CONCAT(a.firstname,' ',a.surename) as admin  FROM fast_check f INNER JOIN adminisitrator a ON f.id_admin = a.id";
    
        
        $resultadoTotal = $db->query($sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
            $data["datos"][$i] = $row;
            $i++;
        }
        $data["status"]='success';
        $data["query"]="SELECT f.*,CONCAT(a.firstname,' ',a.surename) as admin  FROM fast_check f INNER JOIN adminisitrator a ON f.id_admin = a.id";
        return $data;
    }


    public static function Datos_empleado_Staff($staff){
        $data = array();
        $db=Conectar::conexion();
        $data["datos"] = array();
          $sql = "SELECT  case when emp.state = 1 THEN 'Active' ELSE 'Inactive' END AS estado,
        emp.id_employee,emp.first_name,emp.second_name,emp.surname,emp.second_surname,emp.identification,concat(emp.address,', ',stat.state,', ',ci.city,', ', emp.postcode) as address,emp.emergency,
        emp.admission,emp.birth,co.name as nationality,emp.email,emp.fecha_retiro,ho.name as host_name,
        wo.name as work_place,sta.name as staff,emp.position,emp.hourvalue,emp.overtime,emp.shift,emp.phone,emp.nacimiento,
        case when emp.id_gender = 2 THEN 'Male' ELSE 'Female' END AS genero
        from emplyee emp 
        LEFT JOIN country co ON emp.id_nationality = co.id
        inner join states stat ON emp.id_state = stat.id
        INNER JOIN cities ci ON emp.id_city = ci.id
        INNER JOIN host_company ho ON emp.id_host_company = ho.id
        INNER JOIN work_place wo ON emp.id_work_place = wo.id
        INNER JOIN staff_company sta ON emp.id_staff_company = sta.id and  sta.name='".$staff."'";
    
        
        $resultadoTotal = $db->query($sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
            $data["datos"][$i] = $row;
            $i++;
        }
        $data["status"]='success';
        $data["query"]="SELECT emp.identification,concat(emp.first_name,emp.second_name,emp.surname,,emp.second_surname) as fullname,emp.address,concat(ci.city,-,sta.state,-,co.name,-,emp.postcode) as lugar,(select sum(pay.subtotal) from payrool_employ pay where pay.id_employee = emp.id) as subtotal,(select sum(tax.val_tax) from payrool_employ tax where tax.id_employee = emp.id) as val_tax FROM emplyee emp
        left JOIN country co ON emp.id_nationality = co.id
        INNER JOIN states sta ON emp.id_state = sta.id
        INNER JOIN cities ci ON emp.id_city =ci.id WHERE emp.id_staff_company=".$staff;
        return $data;
    }

    public static function LlaveConfig($key){

        $data = array();
        $db=Conectar::conexion();
        $sql = "SELECT value from parametros where llave ='".$key."'";
        
        $resultadoTotal = $db->query($sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
            $data["datos"][$i] = $row;
            $i++;
        }
        
        return $data;        
}

    public static function Datos_empleado_1055($staff,$inicio,$end){
        $data = array();
        $db=Conectar::conexion();
        $data["datos"] = array();
        $sql = "SELECT emp.overtime, emp.hourvalue,w.name as work,emp.identification,concat(emp.surname,' ',emp.second_surname,' ',emp.first_name,' ',emp.second_name) as fullname,(select (pay.hour_reg) 
        from payrool_employ pay where pay.estado=1 AND pay.id_employee = emp.id  AND STR_TO_DATE(pay.fecha_creacion,'%m/%d/%Y') BETWEEN STR_TO_DATE('".$inicio."','%m/%d/%Y')  AND   STR_TO_DATE('".$end."','%m/%d/%Y')  order by pay.id desc limit 1 ) as total_reg,
        (select (tax.hour_ot) from payrool_employ tax  
        where tax.estado=1 AND tax.id_employee = emp.id AND STR_TO_DATE(tax.fecha_creacion,'%m/%d/%Y') BETWEEN  
        STR_TO_DATE('".$inicio."','%m/%d/%Y')  AND STR_TO_DATE('".$end."','%m/%d/%Y') order by tax.id desc limit 1 ) as total_ot ,
        (select sum(ptoo.hour_pto) from payrool_employ ptoo  
        where ptoo.estado=1 AND ptoo.id_employee = emp.id AND STR_TO_DATE(ptoo.fecha_creacion,'%m/%d/%Y') BETWEEN  
        STR_TO_DATE('".$inicio."','%m/%d/%Y')  AND STR_TO_DATE('".$end."','%m/%d/%Y') order by ptoo.id  ) as total_pto ,
        (select (bon.bonus) from payrool_employ bon  
        where bon.estado= 1 AND bon.id_employee = emp.id AND STR_TO_DATE(bon.fecha_creacion,'%m/%d/%Y') BETWEEN  
        STR_TO_DATE('".$inicio."','%m/%d/%Y')  AND STR_TO_DATE('".$end."','%m/%d/%Y') order by bon.id desc limit 1 ) as bonus
        FROM emplyee emp
        INNER JOIN staff_company staff ON emp.id_staff_company = staff.id
        INNER JOIN work_place w ON emp.id_work_place = w.id
        WHERE emp.state= 1  and  staff.name='".$staff."' ORDER BY emp.surname ASC";
        
        $resultadoTotal = $db->query($sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
            $data["datos"][$i] = $row;
            $i++;
        }
        $data["status"]='success';
        $data["query"]="SELECT emp.identification,concat(emp.first_name,emp.second_name,emp.surname,,emp.second_surname) as fullname,emp.address,concat(ci.city,-,sta.state,-,co.name,-,emp.postcode) as lugar,(select sum(pay.subtotal) from payrool_employ pay where pay.id_employee = emp.id) as subtotal,(select sum(tax.val_tax) from payrool_employ tax where tax.id_employee = emp.id) as val_tax FROM emplyee emp
        LEFT JOIN country co ON emp.id_nationality = co.id
        INNER JOIN states sta ON emp.id_state = sta.id
        INNER JOIN cities ci ON emp.id_city =ci.id WHERE emp.id_staff_company=".$staff;
        return $data;
    }
}