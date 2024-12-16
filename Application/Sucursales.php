<?php
require '../Config/Database.php';
class Sucursales extends Database{

    function listaSucursales($idEmpresa){
        $query = $this->connect()->prepare("select *, (select count(cve_empleado) from templeado e where e.cve_sucursal=s.cve_sucursal) as totalEmpleados from tsucursal s where s.estatus = 1 and s.cve_empresa = :id");
        $query->bindParam(':id', $idEmpresa);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function sucursalbyid($id){
        $query = $this->connect()->prepare("select *, (select count(cve_empleado) from templeado e where e.cve_sucursal=s.cve_sucursal) from tsucursal s where cve_empresa = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function crearSucursal($params){
        $cmd = $this->connect()->prepare('insert into tsucursal values(
            null,
            :empresa,
            :nombre,
            1,
            CURRENT_TIMESTAMP(),
            CURRENT_TIMESTAMP(),
            :poblacion
        )');
        $cmd->bindParam(':empresa',$params['empresa'], PDO::PARAM_INT);
        $cmd->bindParam(':nombre',$params['nombre']);
        $cmd->bindParam(':poblacion',$params['poblacion']);
        $cmd->execute();
        return $cmd;
    }

    function eliminarSucursal($id){
        $sql = $this->connect()->prepare("update tsucursal set estatus = 0 where cve_sucursal = :id");
        $sql->bindParam(':id',$id);
        $sql->execute();
        return $sql;
    }
}

?>