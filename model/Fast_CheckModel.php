<?php
require_once("../config/conexion.php");

class Fast_CheckModel {


    public static function Crear_Fast_Check($name,$valor,$razon,$tax,$numero,$id_admin){
        $data = array();
        $db=Conectar::conexion();


        $subtotal =$valor-(($valor*$tax)/100);
        $val_tax =(($valor*$tax)/100);

        $sql="INSERT INTO fast_check (id_admin,val_tax,subtotal,nombre,val_total,description,tax,id_check) 
                                VALUES (".$id_admin.",'".$val_tax."','".$subtotal."','".$name."','".$valor."','".$razon."','".$tax."','".$numero."')";

        $result1 = $db->query($sql);
        $id = $db->insert_id;
        $data['status']="success";
        $data["id"]=$id;
        return $data;
    }

    public static function guardar($nombre){
        $data = array();

        $db=Conectar::conexion();

        $sql="INSERT INTO `fast_check`(`fecha_creacion`, `nombre`, `estado`) VALUES (NOW(),'".$nombre."',0)";

        $result1 = $db->query($sql);
        $id = $db->insert_id;
        return $id;
    }

    public static function GuardarFallos($id_fast_check,$fallos){
        $data = array();
        $db=Conectar::conexion();
        foreach( $fallos as $items){
            $sql = "INSERT INTO `fails_fast_check`(`id_fast_check`, `descripcion`) VALUES
                                                (".$id_fast_check.",'".$items."')";
            $result1 = $db->query($sql);
        }
    }



    
    public static function TablaDetalle($start, $length, $search, $orderField, $orderDir,$filtro) {
        $sqlFromJoin = " FROM `fast_check` pa ";

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
            
            $sql = "SELECT pa.id,pa.nombre, pa.fecha_creacion as dates,(SELECT COUNT(*) FROM fails_fast_check fa where fa.id_fast_check = pa.id) as fails,
            (SELECT COUNT(*) from detalle_fast_check det WHERE det.id_fast_check = pa.id) as success "
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


    
    public static function TablaDetalleFallos($start, $length, $search, $orderField, $orderDir,$filtro) {
        $sqlFromJoin = " FROM `fails_fast_check`  ";

        ///SQL filtro
        $sqlWhere = " WHERE 1 = 1 AND id_fast_check=".$filtro;



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


    
    
    public static function TablaDetalleSuccess($start, $length, $search, $orderField, $orderDir,$filtro) {
        $sqlFromJoin = " FROM `detalle_fast_check` ";

        ///SQL filtro
        $sqlWhere = " WHERE 1 = 1 AND id_fast_check=".$filtro;



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
            
            $sql = "SELECT `id`, `id_fast_check`, `nombre`, `val_total`, `description`, `tax`, `id_check` "
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

    public static function Detalle_exitoso($id){
        $data = array();
            $db=Conectar::conexion();
            $sql = "SELECT * from detalle_fast_check where id =".$id;
            $resultadoTotal = $db->query($sql);
            $i = 0;
            while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
                $data["datos"][$i] = $row;
                $i++;
            }
            
            return $data;  
    }


    public static function Editar($id_success_check,$full_name,$total_val,$description,$tax_check, $id_check){
        $data = array();
        $db=Conectar::conexion();
        
        $subtotal =$total_val-(($total_val*$tax_check)/100);
        $val_tax =(($total_val*$tax_check)/100);



            $sql = "UPDATE `detalle_fast_check` SET subtotal='".$subtotal."',val_tax='".$val_tax."', nombre = '".$full_name."',val_total='".$total_val."',description='".$description."',tax='".$tax_check."',id_check='".$id_check."' where id=".$id_success_check;
            $result1 = $db->query($sql);


        $data['query']="UPDATE `detalle_fast_check` SET nombre = ".$full_name.",val_total=".$total_val.",description=".$description.",tax=".$tax_check.",id_check=".$id_check." where id=".$id_success_check;
        $data['status']='success';
        return $data;
    }


    
    public static function Aceptar($id){
        $data = array();
        $db=Conectar::conexion();
        
            $sql = "UPDATE fast_check set estado = 1 WHERE id=".$id;
            $result1 = $db->query($sql);

            $sql = "UPDATE `payrool_employ` SET estado = 1 WHERE fast_check=".$id;
            $result1 = $db->query($sql);
            $data['status']='success';
            return $data;
    }


    public static function Delete_Payroll($id){
        $data = array();
        $db=Conectar::conexion();
        
            $sql = "DELETE FROM `fast_check` WHERE id=".$id;
            $result1 = $db->query($sql);

            $sql = "DELETE FROM `detalle_fast_check` WHERE id_fast_check=".$id;
            $result1 = $db->query($sql);
            $sql = "DELETE FROM `fails_fast_check` WHERE id_fast_check=".$id;
            $result1 = $db->query($sql);
            $data['query']="DELETE FROM `fast_check` WHERE id=".$id;
            $data['status']='success';
            return $data;
    }
    public static function List_historic($start, $length, $search, $orderField, $orderDir) {
        $sqlFromJoin = " FROM `fast_check` f INNER JOIN adminisitrator adm on f.id_admin = adm.id  ";

        ///SQL filtro
        $sqlWhere = " WHERE 1 = 1 ";

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
            
            $sql = "SELECT f.*,CONCAT(firstname, ' ', surename) as admin "
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