<?php
require '../Config/Database.php';
class Departamentos extends Database{

    function crearDepartamento($params){
        $query = "insert into tdepartamento values(
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

    function getDepartamentos($idsucursal){
        $query = "select * from tdepartamento where cve_sucursal = :idsucursal";
        $sql = $this->connect()->prepare($query);
        $sql->bindParam(':idsucursal',$idsucursal);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
}

?>