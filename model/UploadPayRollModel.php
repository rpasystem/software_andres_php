<?php
require_once("../config/conexion.php");

class UploadPayRollModel {


    public static function Calculate_Payroll($missing_hours,$description_bonus,$bonus,$deductions,$description_deduction,$subtotal,$val_tax,$net_pay,$id_success_employee,$missing_over_time,
    $hour_reg,$total_ger_val,$hour_pto,$total_pto_val,$hour_ot,$total_ot_val,$overtime,$hourvalue){
        $data = array();
        $db=Conectar::conexion();
        
            $sql = "UPDATE payrool_employ SET total_ot_val='".$total_ot_val."', hour_ot='".$hour_ot."', total_pto_val='".$total_pto_val."', hour_reg = '".$hour_reg."' ,total_ger_val='".$total_ger_val."',hour_pto='".$hour_pto."' , missing_over_time='".$missing_over_time."', subtotal='".$subtotal."',val_tax='".$val_tax."',net_pay='".$net_pay."',missing_hours='".$missing_hours."',bonus='".$bonus."',description_bonus='".$description_bonus."',deductions='".$deductions."',description_deduction='".$description_deduction."' WHERE id=".$id_success_employee;
            $result1 = $db->query($sql);

            $sqlCount = "SELECT id_employee as total FROM `payrool_employ` WHERE  id=".$id_success_employee;
         
            $resultadoTotal = $db->query($sqlCount);
            $row = $resultadoTotal->fetch_row();
            $id_employe = $row[0];

            $sql_update = "UPDATE emplyee set overtime = '".$overtime ."', hourvalue='".$hourvalue."' WHERE id = ".$id_employe ;
            $result1 = $db->query($sql_update);

            $data['query']="UPDATE payrool_employ SET  total_ot_val=".$total_ot_val.", hour_ot=".$hour_ot.", total_pto_val=".$total_pto_val.", hour_reg = ".$hour_reg." ,total_ger_val=".$total_ger_val.",hour_pto=".$hour_pto." , subtotal=".$subtotal.",val_tax=".$val_tax.",net_pay=".$net_pay.",missing_hours=".$missing_hours.",bonus=".$bonus.",description_bonus=".$description_bonus.",deductions=".$deductions.",description_deduction=".$description_deduction." WHERE id=".$id_success_employee;
            $data['status']='success';
            return $data;
    }


    
    public static function Delete_Payroll($id){
        $data = array();
        $db=Conectar::conexion();
        
            $sql = "DELETE FROM `payroll` WHERE id=".$id;
            $result1 = $db->query($sql);

            $sql = "DELETE FROM `payroll_details` WHERE id_payroll=".$id;
            $result1 = $db->query($sql);

            $sql = "DELETE FROM `payrool_employ` WHERE id_payroll=".$id;
            $result1 = $db->query($sql);

            $sql = "DELETE FROM `fails_payrolls` WHERE id_payroll=".$id;
            $result1 = $db->query($sql);
            $data['query']="DELETE FROM `payroll` WHERE id=".$id;
            $data['status']='success';
            return $data;
    }


    public static function Detalle_exitoso($id){
        $data = array();
            $db=Conectar::conexion();
            $sql = "SELECT pay.*,emp.hourvalue,emp.overtime from payrool_employ pay INNER JOIN emplyee emp ON emp.id=pay.id_employee where pay.id =".$id;
            $resultadoTotal = $db->query($sql);
            $i = 0;
            while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
                $data["datos"][$i] = $row;
                $i++;
            }
            
            return $data;  
    }


    public static function List_historic_Employee($start, $length, $search, $orderField, $orderDir,$id){
        $sqlFromJoin = " from payrool_employ emp 
        INNER JOIN payroll pay ON pay.id = emp.id_payroll
        INNER JOIN staff_company staff ON emp.id_host_company = staff.id
        ";

        ///SQL filtro
        $sqlWhere = " WHERE 1 = 1 AND emp.estado =1 AND pay.estado= 1 AND emp.id_employee =".$id;

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
            
            $sql = "select emp.id as id,staff.name as staff,pay.date as rango "
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

    public static function List_historic($start, $length, $search, $orderField, $orderDir,$dates) {
        $sqlFromJoin = " FROM `payroll` pa ";

        ///SQL filtro
        $sqlWhere = " WHERE 1 = 1 AND pa.estado= 1 ";

    
        if( $dates != null){
            $sqlWhere =$sqlWhere." AND  '".$dates."'  BETWEEN   pa.desde AND  pa.hasta ";
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
            
            $sql = "SELECT pa.host_company, pa.date_add, pa.id, pa.date as dates,(SELECT COUNT(*) FROM fails_payrolls fa where fa.id_payroll = pa.id) as fails,
            (SELECT COUNT(*) from payrool_employ det WHERE det.id_payroll = pa.id) as success "
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


public static function  TablaDetalleSuccess_Print($start, $length, $search, $orderField, $orderDir,$filtro){
    $sqlFromJoin = " FROM `payrool_employ` pay
    INNER JOIN emplyee emp on emp.id = pay.id_employee
    INNER JOIN staff_company ho ON pay.id_host_company=ho.id ";

    ///SQL filtro
    $sqlWhere = " WHERE 1 = 1 AND pay.estado=1 AND  pay.id_payroll=".$filtro;



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
        
        $sql = "SELECT pay.*,(pay.hour_reg + pay.hour_pto +pay.hour_ot) as total_hours,ho.name as host_name,pay.id as id,concat(emp.first_name,' ',emp.surname,' ',emp.second_surname) as fullname "
                . $sqlFromJoin
                . $sqlWhere
                . $sqlOrder;
                
        
        $Total = $db->query($sql);
        while ($row = $Total->fetch_array()) {
            $data["datos"][] = $row;
        }
    }
    return $data;
}

    
    public static function TablaDetalleSuccess($start, $length, $search, $orderField, $orderDir,$filtro) {
        $sqlFromJoin = " FROM `payrool_employ` pay
        INNER JOIN emplyee emp on emp.id = pay.id_employee
        INNER JOIN payroll ho ON  pay.id_payroll=ho.id ";

        ///SQL filtro
        $sqlWhere = " WHERE 1 = 1 AND pay.id_payroll=".$filtro;



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
            
            $sql = "SELECT pay.*,ROUND((pay.hour_reg + pay.hour_pto +pay.hour_ot),2) as total_hours,ho.host_company as host_name,pay.id as id,concat(emp.first_name,' ',emp.surname,' ',emp.second_surname) as fullname "
                    . $sqlFromJoin
                    . $sqlWhere
                    . $sqlOrder
                    ;
            
            $Total = $db->query($sql);
            while ($row = $Total->fetch_array()) {
                $data["datos"][] = $row;
            }
        }
        return $data;
    }


    public static function TablaDetalleFallos($start, $length, $search, $orderField, $orderDir,$filtro) {
        $sqlFromJoin = " FROM `fails_payrolls`  ";

        ///SQL filtro
        $sqlWhere = " WHERE 1 = 1 AND id_payroll=".$filtro;



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
            
            $sql = "  SELECT * "
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



    public static function TablaDetalle($start, $length, $search, $orderField, $orderDir,$filtro) {
        $sqlFromJoin = " FROM `payroll` pa ";

        ///SQL filtro
        $sqlWhere = " WHERE 1 = 1 AND pa.id=".$filtro;

    

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
            
            $sql = "SELECT pa.id,pa.host_company, pa.date as dates,(SELECT COUNT(*) FROM fails_payrolls fa where fa.id_payroll = pa.id) as fails,
            (SELECT COUNT(*) from payrool_employ det WHERE det.id_payroll = pa.id) as success "
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

    public static function GuardarFallosPayRoll($id_payroll,$fallos){
        $data = array();
        $db=Conectar::conexion();
        foreach( $fallos as $items){
            $sql = "INSERT INTO `fails_payrolls`(`id_payroll`, `descripcion`) VALUES
                                                (".$id_payroll.",'".$items."')";
            $result1 = $db->query($sql);
        }
    }

    public static function GuardarDatosPayRoll($id_payroll,$id_empleado,$id_HostCompany,$val_reg,$total_regular,$val_pto,
    $total_pto,$val_ot,$total_ot,$tax,$subtotal,$total,$val_tax,$fecha_desde){
        $data = array();
        $db=Conectar::conexion();
        $sql="INSERT INTO payrool_employ (id_employee,id_host_company,hour_reg,total_ger_val,hour_pto,total_pto_val,hour_ot,total_ot_val,subtotal,val_tax,net_pay,id_payroll,tax,fecha_creacion,estado) 
                                VALUES (".$id_empleado.",".$id_HostCompany.",'".$val_reg."','".$total_regular."','".$val_pto."','".$total_pto."','".$val_ot."','".$total_ot."','".$subtotal."','".$tax."','".$total."',".$id_payroll.",'".$val_tax."','".$fecha_desde."',0)";

        $result1 = $db->query($sql);
        /*
        foreach( $detalle as $items ){
            $sql = "INSERT INTO `payroll_details`(`id_payroll`, `date`, `day`, `punches`, `deductions`, `worked_departament`, `earing_code`,`hours`, `notes`,id_employee,id__host_company) VALUES
                                                (".$id_payroll.",'".$items['fecha']."','".$items['day']."','".$items['punches']."','".$items['deductions']."','".$items['worked_Department']."'
                                                ,'".$items['earning_Code']."','".$items['hours']."','".$items['notes']."',".$items['empleado'].",".$items['host_company'].")";
            $result1 = $db->query($sql);
        }*/
    }

    public static function Guardar_Payroll($rango_fechas,$host_company,$desde,$hasta){
        $data = array();

        $db=Conectar::conexion();


        /*  
        $sql = "SELECT id from payroll where date ='".$rango_fechas."' AND  host_company='".$host_company."'";
            
        $resultadoTotal = $db->query($sql);
        $i = 0;
        $data["datos"]= array();
        while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
            $data["datos"][$i] = $row;
            $i++;
        }

        if(count($data["datos"]) != 0){
            $sql="DELETE FROM `payroll` WHERE id=".$data["datos"][0]['id'];

            $result1 = $db->query($sql);
    
            $sql="DELETE FROM `payrool_employ` WHERE id_payroll=".$data["datos"][0]['id'];
    
            $result1 = $db->query($sql);
    
            $sql="DELETE FROM `fails_payrolls` WHERE id_payroll=".$data["datos"][0]['id'];
    
            $result1 = $db->query($sql);
        }
       */


        $sql="INSERT INTO payroll (date,host_company,desde,hasta,estado) 
                                VALUES ('".$rango_fechas."','".$host_company."','".$desde."','".$hasta."',0)";

        $result1 = $db->query($sql);
        $id = $db->insert_id;
        return $id;
    }


    public static function Datos_Empleado($id_empleado){
        $data = array();
        try{
           
            $db=Conectar::conexion();
            $data["datos"] = array();
            $sql = "SELECT hourvalue,overtime FROM emplyee where id=".$id_empleado;
            $resultadoTotal = $db->query($sql);
            $i = 0;
            while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
                $data["datos"][$i] = $row;
                $i++;
            }
            $data['query']=$sql;
            $data['status']='success';
            return $data;
        }catch(Exception $ex){

            $data["datos"] = array();
            $data['mensaje']='An error has occurred, please try again';
            $data['status']='error';
            return $data;
        }
     
    }

    public static function ValidarHostCompany($host){
         $data = array();
        try{
           
            $db=Conectar::conexion();
            $data["datos"] = array();
            $sql = "select  * from staff_company  where  state=1 AND UPPER(name) like UPPER('%".$host ."%') LIMIT 1 ";
             
            $resultadoTotal = $db->query($sql);
            $i = 0;
            while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
                $data["datos"][$i] = $row;
                $i++;
            }
            $data['query']=$sql;
            $data['status']='success';
            return $data;
        }catch(Exception $ex){

            $data["datos"] = array();
            $data['mensaje']='An error has occurred, please try again';
            $data['status']='error';
            return $data;
        }
     

    }

    public static function ValidarNombreCompleto($nombre,$apellidos){
        $return = array();
        $db=Conectar::conexion();
        //consulta si ya existe la empresa inscrita
         $sqlCount = "SELECT id as total FROM `emplyee` WHERE UPPER(first_name) like UPPER('%".$nombre."%') AND UPPER(concat(surname,COALESCE (second_surname,'')))  like UPPER('%".$apellidos."%') AND state=1";
         
         $resultadoTotal = $db->query($sqlCount);
         $row = $resultadoTotal->fetch_row();
         return intval($row[0]);
    }

    public static function ValidarNombreCompletoPorId($id){
        $return = array();
        $db=Conectar::conexion();
        //consulta si ya existe la empresa inscrita
         $sqlCount = "SELECT id as total FROM `emplyee` WHERE  state=1 AND id_employee=".$id;
         
         $resultadoTotal = $db->query($sqlCount);
         $row = $resultadoTotal->fetch_row();
         return intval($row[0]);
    }


    public static function Aceptar_Payroll($id){
        $data = array();
        $db=Conectar::conexion();
        
            $sql = "UPDATE payroll set estado = 1 WHERE id=".$id;
            $result1 = $db->query($sql);

            $sql = "UPDATE `payrool_employ` SET estado = 1 WHERE id_payroll=".$id;
            $result1 = $db->query($sql);
            $data['status']='success';
            return $data;
    }
}