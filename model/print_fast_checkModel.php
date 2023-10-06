<?php
require_once("../config/conexion.php");

class Print_fast_checkModel {

    public static function Data_Cheque($id_payroll){
        $data = array();
        $db=Conectar::conexion();
        $data["datos"] = array();
        $sql = "SELECT d.*,(select sum(s.subtotal) from fast_check s WHERE s.nombre = d.nombre ) as subtotal,
        (select sum(tax.val_tax) from fast_check tax WHERE tax.nombre = d.nombre ) as total_tax,
        (select sum(tot.val_total) from fast_check tot WHERE tot.nombre = d.nombre ) as total
        FROM `fast_check` d WHERE id = ".$id_payroll;
        $resultadoTotal = $db->query($sql);
        $i = 0;
        while ($row = mysqli_fetch_array($resultadoTotal,MYSQLI_ASSOC)) {
                $data["datos"][$i] = $row;
                $i++;
        }
      
        $data['query'] ="SELECT d.*,(select sum(s.subtotal) from detalle_fast_check s WHERE s.nombre = d.nombre ) as subtotal,
        (select sum(tax.val_tax) from detalle_fast_check tax WHERE tax.nombre = d.nombre ) as total_tax,
        (select sum(tot.val_total) from detalle_fast_check tot WHERE tot.nombre = d.nombre ) as total
        FROM `fast_check` d WHERE id = ".$id_payroll;
        return $data;
    }

}