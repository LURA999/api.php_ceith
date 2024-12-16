<?php
require '../Config/Database.php';
class ExamenesEmpleados extends Database{
    
    function listExamenes($idempleado){
        $query = "select tx.cve_examenesempleado,tx.cve_examen,e.descripcion, tx.fecha, p.fecha_inicio, p.fecha_fin, p.cve_periodo from texamenesempleados tx 
        inner join texamen e on tx.cve_examen = e.cve_examen
        left join tperiodo p on tx.cve_periodo = p.cve_periodo
         where cve_empleado = :idempleado";
        $sql = $this->connect()->prepare($query);
        $sql->bindParam(':idempleado',$idempleado);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function getTest($idexamenempleado){
        $query = "
        select e.nombre,e.numero_empleado,emp.nombre as empresa,s.nombre as sucursal,exem.* from texamenesempleados exem
        inner join templeado e on e.cve_empleado = exem.cve_empleado
        inner join tsucursal s on e.cve_sucursal = s.cve_sucursal
        inner join tempresa emp on s.cve_empresa = emp.cve_empresa
        where exem.cve_examenesempleado = :id";

        $sql = $this->connect()->prepare($query);
        $sql->bindParam(':id',$idexamenempleado);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    function insertarResultados($params){
        $query = 'insert into texamenesempleados values(
            null,
            :cve_empleado,
            :cve_examen,
            :periodo,
            CURRENT_TIMESTAMP(),
            1,
            :json,
            :resultado
        )';
        $sql = $this->connect()->prepare($query);
        $sql->bindparam(':cve_empleado', $params['cve_empleado']);
        $sql->bindparam(':cve_examen', $params['cve_examen']);
        $sql->bindparam(':periodo', $params['periodo']);
        $sql->bindparam(':json', $params['json']);
        $sql->bindparam(':resultado', $params['resultado']);
        $sql->execute();
        return $sql;
    }
}

?>