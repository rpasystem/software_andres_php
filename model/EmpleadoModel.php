<?php
require_once("../config/conexion.php");

class EmpleadoModel {


    public static function Editar($first_name ,$second_name ,$surname,$second_surname,$identification,$address ,$id_state ,$id_city ,$postcode ,$phone,$emergency ,$birth ,
        $gender,$nationality ,$email,$admission ,$host_company ,$staff_company,$position,$hourvalue ,$overtime,$ruta,$password,$shift,$work_place,$idEmployee,$fecha_retiro,$identificacion_sin_guion,$id_employee_edit,$password_sin_encrypt,$observation,$nacimiento){
        $data = array();
        $db=Conectar::conexion();

        $querypass="";
        $queryLog = "";
        if($password != ''){
            $querypass= " , pass='".$password."' ";
            $queryLog= " , pass=".$password ;
        }

        try{

        //consulta si ya existe la empresa inscrita
        $sqlCount = "select count(*) as total  from emplyee  where  identification ='".$identification ."' AND state = 1 AND id <>".$idEmployee;
        $resultadoTotal = $db->query($sqlCount);
        $row = $resultadoTotal->fetch_row();

        if (intval($row[0]) > 0) {
            $return['mensaje'] ="Identification is already registered ";
            $return["status"] = 'warning';
            return $return;
        }

            $sql="UPDATE `emplyee` SET nacimiento='".$nacimiento."', `url_photo`='".$ruta."',`first_name`='".$first_name."',`second_name`='".$second_name."',`surname`='".$surname."',
            `second_surname`='".$second_surname."',`identification`='".$identification."',`address`='".$address."',`id_state`=$id_state,`id_city`=$id_city,`postcode`=$postcode,`phone`='".$phone."',`emergency`='".$emergency."',`birth`='".$birth."',
            `id_gender`=$gender,`id_nationality`=$nationality,`email`='".$email."',`admission`='".$admission."',`id_host_company`=$host_company,`id_staff_company`=$staff_company,
            `position`='".$position."',`hourvalue`='".$hourvalue."',`overtime`='".$overtime."',`id_work_place`=$work_place,`shift`='".$shift."' ".$querypass.
             " ,fecha_retiro ='".$fecha_retiro."', identificacion_sin_guion= '".$identificacion_sin_guion."',id_employee=".$id_employee_edit.",password_sin_encrypt='".$password_sin_encrypt."', observation='".$observation."' WHERE  id=".$idEmployee;
            
            $result1 = $db->query($sql);
        }
        catch(Exception $ex){
            $return["status"] = 'error';
            return $return;
        }
        $return["status"] = 'success';
        $return["query"] = "UPDATE `emplyee` SET `url_photo`=".$ruta.",`first_name`=".$first_name.",`second_name`=".$second_name.",`surname`=".$second_name.",
        `second_surname`=".$second_surname.",`identification`=".$identification.",`address`=".$address.",`id_state`=$id_state,`id_city`=$id_city,`postcode`=$postcode,`phone`=$phone,`emergency`=$emergency,`birth`=".$birth.",
        `id_gender`=$gender,`id_nationality`=$nationality,`email`=".$email.",`admission`=".$admission.",`id_host_company`=$host_company,`id_staff_company`=$staff_company,
        `position`=".$position.",`hourvalue`=".$hourvalue.",`overtime`=".$overtime.",`id_work_place`=$work_place,`shift`=".$shift." ".$queryLog.
         " WHERE  id=".$idEmployee;
        return  $return;

    }


    public static function Detalle($id){
        $data = array();
        try{
           
            $db=Conectar::conexion();
            $data["datos"] = array();
            $sql = "SELECT * FROM emplyee where id=".$id;
            
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

    public static function CambiarEstado($id,$estado){
        $data = array();
        $db=Conectar::conexion();
        try{

            $sql="UPDATE emplyee SET state = $estado WHERE id=".$id;

                                $result1 = $db->query($sql);
        }
        catch(Exception $ex){
            $return["status"] = 'error';
            return $return;
        }
        $return["status"] = 'success';
        $return["query"] = "UPDATE emplyee SET state = $estado WHERE id=".$id;
        return  $return;
    }


    public static function State(){
        $data = array();
        $db=Conectar::conexion();
        $sql = "SELECT id,state,state_code FROM `states` ORDER BY state";
        $resultadoTotal = $db->query($sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
            $data["datos"][$i] = $row;
            $i++;
        }
        
        return $data;
    }

    public static function IdEmpleado(){
        $db=Conectar::conexion();
        $sqlCount = "SELECT COUNT(*) FROM emplyee";
         $resultadoTotal = $db->query($sqlCount);
         $row = $resultadoTotal->fetch_row();
         return intval($row[0]);
    }




    public static function Crear($first_name ,$second_name ,$surname,$second_surname,$identification,$address ,$id_state ,$id_city ,$postcode ,$phone,$emergency ,$birth ,$gender,$nationality ,$email,$admission ,$host_company ,$staff_company,$position,$hourvalue ,$overtime,$ruta,$password,$shift,$work_place,$fecha_retiro,$identificacion_sin_guion,$id_employee,$password_sin_encrypt,$obervation,$nacimiento){
        $data = array();
        $db=Conectar::conexion();
        try{

            //consulta si ya existe la empresa inscrita
            $sqlCount = "select count(*) as total  from emplyee  where  identification ='".$identification ."' AND state = 1 ";
            $resultadoTotal = $db->query($sqlCount);
            $row = $resultadoTotal->fetch_row();

            if (intval($row[0]) > 0) {
                $return['mensaje'] ="Identification is already registered ";
                $return["status"] = 'warning';
                return $return;
            }



            $sql="INSERT INTO `emplyee`(nacimiento, `url_photo`, `first_name`, `second_name`, `surname`, `second_surname`, `identification`, `address`, `id_state`, `id_city`, `postcode`, `phone`, `emergency`, `birth`, `id_gender`, `id_nationality`, `email`, `admission`, `id_host_company`, `id_staff_company`, `position`, `hourvalue`, `overtime`, `state`,`pass`, `shift`,`id_work_place`,`fecha_retiro`,identificacion_sin_guion,id_employee,password_sin_encrypt,observation) 
                                VALUES ('".$nacimiento."','".$ruta."','".$first_name."','".$second_name."','".$surname."','".$second_surname."','".$identification."','".$address."',".$id_state.",".$id_city.",".$postcode.",'".$phone."','".$emergency."','".$birth."',".$gender.",".$nationality.",'".$email."','".$admission."',".$host_company.",".$staff_company.",'".$position."','".$hourvalue."','".$overtime."',1,'".$password."','".$shift."',".$work_place.",'".$fecha_retiro."','".$identificacion_sin_guion."',".$id_employee.",'".$password_sin_encrypt."','".$obervation."')";

                                $result1 = $db->query($sql);
        }
        catch(Exception $ex){
            $return["status"] = 'error';
            return $return;
        }
        $return["status"] = 'success';
        $return["query"] = "INSERT INTO `emplyee`( nacimiento,`url_photo`, `first_name`, `second_name`, `surname`, `second_surname`, `identification`, `address`, `id_state`, `id_city`, `postcode`, `phone`, `emergency`, `birth`, `id_gender`, `id_nationality`, `email`, `admission`, `id_host_company`, `id_staff_company`, `position`, `hourvalue`, `overtime`, `state`) 
        VALUES ('".$nacimiento."',".$ruta.",".$first_name.",".$second_name.",".$surname.",".$second_surname.",".$identification.",".$address.",".$id_state.",".$id_city.",".$postcode.",".$phone.",".$emergency.",".$birth.",".$gender.",".$nationality.",".$email.",".$admission.",".$host_company.",".$staff_company.",".$position.",".$hourvalue.",".$overtime.",1)";
        return  $return;
    }



    public static function Tabla($start, $length, $search, $orderField, $orderDir,$filtro,$host_company,$staff_company) {
        $sqlFromJoin = " from emplyee emp INNER JOIN staff_company staff ON emp.id_staff_company = staff.id";

        ///SQL filtro
        $sqlWhere = " WHERE 1 = 1  ";


                
        if($filtro != ""){
            $sqlWhere=$sqlWhere." AND ( emp.first_name like '%".$filtro."%' OR emp.second_name like '%".$filtro."%' OR   emp.surname like '%".$filtro."%' OR   emp.second_surname like '%".$filtro."%'  OR  emp.id_employee like '%".$filtro."%'  ) ";
        }

        if($host_company!=""){
            $sqlWhere=$sqlWhere." AND emp.id_host_company = ".$host_company;
        }

        if($staff_company!=""){
            $sqlWhere=$sqlWhere." AND emp.id_staff_company = ".$staff_company;
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
            
            $sql = "select emp.emergency,emp.email,emp.admission,emp.hourvalue,emp.overtime,emp.shift,emp.fecha_retiro,emp.observation,emp.nacimiento,emp.id_employee, CASE WHEN emp.state = 0 THEN 'Inactive' ELSE 'Active' END AS state,emp.id,CONCAT(emp.first_name,' ',emp.second_name,' ',emp.surname,' ',emp.second_surname) as fullname,emp.identification,emp.address,emp.phone,emp.position,emp.fecha_retiro,staff.name as staff "
                    . $sqlFromJoin
                    . $sqlWhere
                    . $sqlOrder
                    . "limit " . $length . " "
                    . "OFFSET " . $start;
            //echo $sql;
            $Total = $db->query($sql);

            while ($row = $Total->fetch_array()) {
                $data["datos"][] = $row;
            }
        }
        return $data;
    }

}