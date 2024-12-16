<?php
require '../Config/Database.php';
class Puestos extends Database{

    function crearPuesto($params){
        $query = "insert into tpuesto values(
            null,
            :descripcion,
            :cve_sucursal,
            1,
            CURRENT_TIMESTAMP(),
            CURRENT_TIMESTAMP()				
        )";

        $sql = $this->connect()->prepare($query);
        $sql->bindParam(':descripcion',$params['descripcion']);
        $sql->bindParam(':cve_sucursal',$params['cve_sucursal']);
        $sql->execute();
        return $sql;
    }

    function getPuestos($idsucursal){
        $query = "select * from tpuesto where cve_sucursal = :idsucursal";
        $sql = $this->connect()->prepare($query);
        $sql->bindParam(':idsucursal',$idsucursal);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
}

?>