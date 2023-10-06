<?php
require_once("../config/conexion.php");

class Print_payrollModel {

 
    public static function Data_Membrete($id){
        $data = array();
        $db=Conectar::conexion();
        $data["datos"] = array();
        $sql = "SELECT emp.position, staff.name as staff, staff.address as addres_staff,(concat(emp.first_name,' ',emp.second_name,' ',emp.surname,' ',emp.second_surname )) as name_emp,
        concat( MONTHNAME(date_format(str_to_date(birth, '%m-%d-%Y'), '%Y-%m-%d')),DAY(date_format(str_to_date(birth, '%m-%d-%Y'), '%Y-%m-%d')) ,',',YEAR(date_format(str_to_date(birth, '%m-%d-%Y'), '%Y-%m-%d'))) as fecha_contratacion, emp.hourvalue as rate
        
        FROM `emplyee` emp 
        INNER JOIN staff_company staff ON emp.id_staff_company = staff.id
        WHERE emp.id =".$id;

        $resultadoTotal = $db->query($sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
                $data["datos"][$i] = $row;
                $i++;
        }
      
        $data['query'] ="SELECT staff.name as staff, staff.address as addres_staff,(concat(emp.first_name,emp.second_name,emp.surname,emp.second_surname)) as name_emp,
        concat( MONTHNAME(date_format(str_to_date(birth, %m-%d-%Y), %Y-%m-%d)),DAY(date_format(str_to_date(birth, %m-%d-%Y), %Y-%m-%d)),YEAR(date_format(str_to_date(birth, %m-%d-%Y), %Y-%m-%d))) as fecha_contratacion, emp.hourvalue as rate
        FROM emplyee emp 
        INNER JOIN staff_company staff ON emp.id_staff_company = staff.id
        WHERE emp.id =".$id;
        return $data;
    }
    
public static function Data_Cheque($id_payroll){
    $data = array();
    $db=Conectar::conexion();
    $data["datos"] = array();
    $sql = "SELECT pay.missing_over_time, staff.name as staff,staff.address as staff_direccion ,(select sum(net.net_pay) from payrool_employ net where pay.id_employee = net.id_employee and year(net.date_add) =YEAR(CURDATE()) ) as all_pay,(select sum(tax.val_tax) from payrool_employ tax where tax.id_employee = pay.id_employee  and year(tax.date_add) =YEAR(CURDATE())) as all_tax,(select sum(sub.subtotal) from payrool_employ sub where sub.id_employee = pay.id_employee  and year(sub.date_add) =YEAR(CURDATE())) as all_subtotal 
    , emp.postcode, emp.overtime,emp.hourvalue, emp.identification as identification,UPPER(concat(emp.first_name,' ',emp.second_name,' ',emp.surname,' ',emp.second_surname)) as name, UPPER(emp.address) as direccion, UPPER(CONCAT(ci.city,', ',sta.state_code)) as ciudad ,pay.*,p.date as rango
    FROM `payrool_employ` pay
    INNER JOIN emplyee emp ON pay.id_employee = emp.id
    INNER JOIN staff_company staff ON pay.id_host_company = staff.id 
    INNER JOIN cities ci ON emp.id_city = ci.id
    INNER JOIN states sta ON ci.state_code = sta.state_code 
    INNER JOIN payroll p ON pay.id_payroll = p.id WHERE pay.estado= 1 AND pay.id =".$id_payroll;
    $resultadoTotal = $db->query($sql);
    $i = 0;
    while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
            $data["datos"][$i] = $row;
            $i++;
    }
  
    $data['query'] ="SELECT (select sum(net.net_pay) from payrool_employ net where pay.id_employee = net.id_employee) as all_pay,(select sum(tax.val_tax) from payrool_employ tax where tax.id_employee = pay.id_employee) as all_tax,(select sum(sub.subtotal) from payrool_employ sub where sub.id_employee = pay.id_employee) as all_subtotal , 
    emp.overtime,emp.hourvalue, emp.identification as identification, UPPER(concat(emp.first_name,emp.second_name,emp.surname,emp.second_surname)) as name, UPPER(emp.address) as direccion, UPPER(CONCAT(ci.city,sta.state_code)) as ciudad ,pay.*,p.date as rango FROM payrool_employ pay
    INNER JOIN emplyee emp ON pay.id_employee = emp.id
    INNER JOIN cities ci ON emp.id_city = ci.id
    INNER JOIN states sta ON ci.state_code = sta.state_code 
    INNER JOIN payroll p ON pay.id_payroll = p.id WHERE pay.id = ".$id_payroll;
    return $data;
}

public static function PayRoll_Last($staff){
    $data = array();
    $db=Conectar::conexion();
    $data["datos"] = array();
    $sql = "SELECT * FROM `payroll` WHERE estado = 1 AND host_company like '%".$staff."%' ORDER BY `id` DESC LIMIT 5";
    
    $resultadoTotal = $db->query($sql);
    $i = 0;
    while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
            $data["datos"][$i] = $row;
            $i++;
    }
  
    return $data;
}



    public static function List_Print(){
        $data = array();
        $db=Conectar::conexion();
        $data["datos"] = array();
        $sql = "SELECT DISTINCT name as name from staff_company WHERE state = 1";
        
        $resultadoTotal = $db->query($sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
                $data["datos"][$i] = $row;
                $i++;
        }
        return $data;
    }
}