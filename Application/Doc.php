<?php
require "../Config/Database.php";
class Doc extends Database
{
    function getDocs($cveEmpleado)
    {
        $sql = $this->connect()->prepare("select idTarchivo,archivo,nombre,cve_periodo,concat(fecha_inicio,' - ',fecha_fin) periodo, tipo from tarchivo inner join tPeriodo on cvePeriodo = cve_periodo
        where cveEmpleado = :cveEmpleado order by idTarchivo desc");
        $sql->bindParam(':cveEmpleado',$cveEmpleado,PDO::PARAM_INT);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function postDocs($input){
        $sql = $this->connect()->prepare("insert into tarchivo (cveEmpleado,cvePeriodo,archivo,nombre,tipo)  
        values(:cveEmpleado,:cvePeriodo,:archivo,:nombre,:tipo)");
        $sql->bindParam(':cveEmpleado',$input["cveEmpleado"],PDO::PARAM_INT);
        $sql->bindParam(':cvePeriodo',$input["cvePeriodo"],PDO::PARAM_INT);
        $sql->bindParam(':archivo',$input["archivo"],PDO::PARAM_STR);
        $sql->bindParam(':nombre',$input["nombre"],PDO::PARAM_STR,85);
        $sql->bindParam(':tipo',$input["tipo"],PDO::PARAM_STR,25);

        $sql->execute();
        return $sql;
    }

    
    function patchDocs($input){
        $sql = $this->connect()->query("update tarchivo set nombre = :nombre where
        where cveEmpleado = :cveEmpleado and cvePeriodo = :cvePeriodo");
        $sql->bindParam(':cveEmpleado',$input["cveEmpleado"],PDO::PARAM_INT);
        $sql->bindParam(':cvePeriodo',$input["cvePeriodo"],PDO::PARAM_INT);
        $sql->bindParam(':nombre',$input["nombre"],PDO::PARAM_STR,85);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    
    function DeleteDocs($idTarchivo){
        $sql = $this->connect()->prepare("delete from tarchivo where idTarchivo= :idTarchivo");
        $sql -> bindParam(":idTarchivo", $idTarchivo, PDO::PARAM_INT);
        $result = $sql->fetch(PDO::FETCH_ASSOC);
        $sql->execute();

        return $result;
    }
}