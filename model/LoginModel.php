<?php
require_once("../config/conexion.php");

class LoginModel {

    public static function Cerrar() {
        // session_start();
        session_unset();
        session_destroy();
        $return["status"] = 'success';
        return $return;
    }


    public static function login($username, $pass,$rol) {
        if($rol == 1){

            $return = array();
            $db=Conectar::conexion();
            $sqlCount = "select count(*) as total  from emplyee  where id_employee = '" . $username . "' AND state= 1 ";
            
            $resultadoTotal = $db->query($sqlCount);
            $row = $resultadoTotal->fetch_row();
    
            if (intval($row[0]) == 0) {
                $return['mensaje'] ="Id or password not coincidence.";
                $return["status"] = 'error';
                return $return;
            }
            $sql = "SELECT url_photo as img,3 as rol,pass,CONCAT(first_name,' ',second_name,' ',surname,' ',second_surname) AS user,id from emplyee WHERE  id_employee = '" . $username . "' AND state= 1 ";
            $Total = $db->query($sql);
            
            if(!$Total){
                $return['mensaje'] ="Id  or password not coincidence.";
                $return["status"] = 'warnning';
                return $return;
            }
            $data["datos"] = array();
            while ($row = $Total->fetch_array()) {
                $data["datos"][] = $row;
            }
            if (count($data["datos"]) != 0) {
                $isPasswordCorrect = password_verify($pass,$data['datos'][0]['pass'] );
                
                if($isPasswordCorrect){
                    loginModel::session($data);
                    $return["status"] = 'success';
                    $return["query"] = "SELECT url_photo as img, 3 as rol,pass,CONCAT(first_name,' ',second_name,' ',surname,' ',second_surname) AS user,id from emplyee WHERE  id_employee =. $username .  AND state= 1 ";
                    return $return;
                  
                }
                else{
                    $return['mensaje'] ="Id number or password not coincidence.";
                    $return["status"] = 'warnning';
                    return $return;
                }
            }else{
                $return['mensaje'] ="Id number or password not coincidence.";
                $return["status"] = 'warnning';
                return $return;
            }
    

        }else{
        $return = array();
        $db=Conectar::conexion();
        $sqlCount = "select count(*) as total  from adminisitrator  where   identificacion_sin_guion = '" . $username . "' AND state= 1 ";
        $resultadoTotal = $db->query($sqlCount);
		
        $row = $resultadoTotal->fetch_row();

        if (intval($row[0]) == 0) {
            $return['mensaje'] ="Id number or password not coincidence.";
            $return["status"] = 'error';
            return $return;
        }
        $sql = "SELECT '' as img ,id_role as rol,password,CONCAT(firstname,' ',surename) AS user,id from adminisitrator WHERE  identificacion_sin_guion = '" . $username . "' AND state= 1 ";
        $Total = $db->query($sql);
        
        if(!$Total){
            $return['mensaje'] ="Id number or password not coincidence.";
            $return["status"] = 'warnning';
            return $return;
        }
        $data["datos"] = array();
        while ($row = $Total->fetch_array()) {
            $data["datos"][] = $row;
        }
        if (count($data["datos"]) != 0) {
            $isPasswordCorrect = password_verify($pass,$data['datos'][0]['password'] );
            if($isPasswordCorrect){
                loginModel::session($data);
                $return["status"] = 'success';
                $return["query"] = "SELECT 2 as rol,CONCAT(firstname,' ',surename) AS user,id from adminisitrator WHERE  identificacion_sin_guion =  $username  AND password = $pass  AND state= 1 ";
                return $return;
              
            }
            else{
                $return['mensaje'] ="Id number or password not coincidence.";
                $return["status"] = 'warnning';
                return $return;
            }
        }else{
            $return['mensaje'] ="Id number or password not coincidence.";
            $return["status"] = 'warnning';
            return $return;
        }

        }


        
        
        //var_dump($data);
    }

    public static function session($data) {
        $_SESSION['user_login_status']['id']=$data['datos'][0]['id'];
        $_SESSION['user_login_status']['user']=$data['datos'][0]['user'];
        $_SESSION['user_login_status']['rol']=$data['datos'][0]['rol'];
        $_SESSION['user_login_status']['foto']=$data['datos'][0]['img'];
    }


}