<?php
require_once("../config/conexion.php");

class AdministradorModel {


    public static function Editar($first_name,$second_name,$surname,$second_surname,$identification,$email,$pass,$id,$identificacion_sin_guion,$password_sin_encrypt){
        $data = array();
        $db=Conectar::conexion();

        $querypass="";
        $queryLog = "";
        if($pass != ''){
            $querypass= " , password='".$pass."' ";
            $queryLog= " , password=".$pass ;
        }

        try{

            $sql="UPDATE adminisitrator SET firstname='".$first_name."',surename='".$surname."',email='".$email."',
            identification='".$identification."',second_name='".$second_name."',second_surname='".$second_surname."'".$querypass.
             ",identificacion_sin_guion='".$identificacion_sin_guion."', password_sin_encrypt= '".$password_sin_encrypt."' WHERE id=".$id;
            $result1 = $db->query($sql);
        }
        catch(Exception $ex){
            $return["status"] = 'error';
            return $return;
        }
        $return["status"] = 'success';
        $return["query"] = "UPDATE adminisitrator SET firstname=".$first_name.",surename=".$surname.",email=".$email.",
        identification=".$identification.",second_name=".$second_name.",second_surname=".$second_surname.".$queryLog 
         WHERE id=".$id;
        return  $return;
    }

    public static function Detalle($id){
        $data = array();
        try{
           
            $db=Conectar::conexion();
            $data["datos"] = array();
            $sql = "SELECT * FROM adminisitrator where id=".$id;
            
            $resultadoTotal = $db->query($sql);
            $i = 0;
            while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
                $data["datos"][$i] = $row;
                $i++;
            }
            $data['query']=$sql;
            $data['status']='success';
            return $data;
        }catch(Excetion $ex){

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

            $sql="UPDATE adminisitrator SET state = $estado WHERE id=".$id;

                                $result1 = $db->query($sql);
        }
        catch(Exception $ex){
            $return["status"] = 'error';
            return $return;
        }
        $return["status"] = 'success';
        $return["query"] = "UPDATE adminisitrator SET state = $estado WHERE id=".$id;
        return  $return;
    }


    public static function Crear($first_name,$second_name,$surname,$second_surname,$identification,$email,$password,$identificacion_sin_guion,$password_sin_encrypt){

        $data = array();
        $db=Conectar::conexion();
        try{


        //consulta si ya existe la empresa inscrita
        $sqlCount = "select count(*) as total  from adminisitrator  where  identification ='".$identification ."' AND state = 1 ";
        $resultadoTotal = $db->query($sqlCount);
        $row = $resultadoTotal->fetch_row();

        if (intval($row[0]) > 0) {
            $return['mensaje'] ="Identification is already registered ";
            $return["status"] = 'warning';
            return $return;
        }


            $sql="INSERT INTO `adminisitrator`(`firstname`, `surename`, `id_role`, `email`, `password`, `state`, `identification`, `second_name`, `second_surname`,identificacion_sin_guion,password_sin_encrypt) VALUES
            ('".$first_name."','".$surname."',2,'".$email."','".$password."',1,'".$identification."','".$second_name."','".$second_surname."','".$identificacion_sin_guion."','".$password_sin_encrypt."')";

                                $result1 = $db->query($sql);
        }
        catch(Exception $ex){
            $return["status"] = 'error';
            return $return;
        }
        $return["status"] = 'success';
        $return["query"] = "INSERT INTO `adminisitrator`(`firstname`, `surename`, `id_role`, `email`, `password`, `state`, `identification`, `second_name`, `second_surname`) VALUES
        (".$first_name.",".$surname.",2,".$email.",".$password.",1,".$identification.",".$second_name.",".$second_surname.")";
        return  $return;
    }

    public static function Tabla($start, $length, $search, $orderField, $orderDir,$filtro) {
        $sqlFromJoin = " from adminisitrator ";

        ///SQL filtro
        $sqlWhere = " WHERE 1 = 1 AND id_role <> 1 ";


                
        if($filtro != ""){
            $sqlWhere=$sqlWhere." AND ( firstname like '%".$filtro."%' OR second_name like '%".$filtro."%' OR   surename like '%".$filtro."%' OR   second_surname like '%".$filtro."%' OR   email like '%".$filtro."%' OR    identification like '%".$filtro."%' OR   id like '%".$filtro."%'  ) ";
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
            
            $sql = "select CASE WHEN state = 0 THEN 'Inactive' ELSE 'Active' END AS state,id,CONCAT(firstname,' ',second_name,' ',surename,' ',second_surname) as fullname,email,identification "
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

