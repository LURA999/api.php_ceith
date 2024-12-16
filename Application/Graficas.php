<?php

require "../Config/Database.php";
class Graficas extends Database{


    function generalEmpresa($cve_periodo, $cve_empresa){
        $conn = $this->connect()->prepare("
        select count(emp.cve_empleado) empleados, 
        (select count(cve_examen) from texamenesempleados where cve_periodo = :periodo) as hechos, 
        (select count(cve_examen) from texamensucursal es inner join tsucursal s on es.cve_sucursal = s.cve_sucursal inner join tempresa e on s.cve_empresa = e.cve_empresa where e.cve_empresa = :cve_empresa) as total
        from tempresa e 
        inner join tsucursal s on e.cve_empresa = s.cve_empresa
        inner join templeado emp on s.cve_sucursal = emp.cve_sucursal
        where emp.estatus = 1 and e.cve_empresa = :empresa");
        $conn->bindParam(":periodo", $cve_periodo);
        $conn->bindParam(":empresa", $cve_empresa);
        $conn->bindParam(":cve_empresa", $cve_empresa);
        $conn->execute();
        $result = $conn->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function examenesRealizados($cve_periodo,$pagina,$cantidad, $sucursal){
        $query = "";
        if($sucursal != 0){
            $query = "SELECT count(cve_examenesempleado) examenes FROM texamenesempleados ee inner join templeado e on ee.cve_empleado = e.cve_empleado
            WHERE ee.cve_periodo = :periodo and e.cve_sucursal = '".$sucursal."';";
        }else{
            $query = "SELECT count(cve_examenesempleado) examenes FROM texamenesempleados WHERE cve_periodo = :periodo;";
        }

        $conn = $this->connect()->prepare($query);
        $conn->bindParam(":periodo",$cve_periodo);
        $conn->execute();
        $totalExamenes = $conn->fetchAll(PDO::FETCH_ASSOC);
        $paginasTotales = ceil($totalExamenes[0]['examenes']/ $cantidad);
        $limSuperior = ($pagina * $cantidad);
        $limInferior = ($pagina * $cantidad)-($cantidad);
        $query2 = "SELECT ee.fecha, e.nombre, ex.descripcion as examen, s.nombre as sucursal from texamenesempleados ee
            LEFT JOIN templeado e on e.cve_empleado = ee.cve_empleado
            LEFT JOIN texamen ex on ex.cve_examen = ee.cve_examen 
            LEFT JOIN tsucursal s on s.cve_sucursal = e.cve_sucursal
            WHERE ee.cve_periodo = :periodo ";
        if($sucursal != 0){
            $query2 = $query2." and e.cve_sucursal = '".$sucursal."'" ;
        }

        $query2 = $query2." LIMIT :inferior,:superior;";
         
        $conn = $this->connect()->prepare($query2);
        $conn->bindParam(":periodo",$cve_periodo);
        $conn->bindParam(":inferior",$limInferior, PDO::PARAM_INT);
        $conn->bindParam(":superior",$cantidad, PDO::PARAM_INT);
        $conn->execute();
        $result = $conn->fetchAll(PDO::FETCH_ASSOC);
        $response = array("pagina"=>$pagina,"totalPaginas"=>$paginasTotales,"resultado"=>$result);
        return $response;
    }

    function participacionSucursal($periodo){
        $query = "select count(distinct ee.cve_empleado) as empleados, e.cve_sucursal, s.nombre as sucursal from texamenesempleados ee 
        inner join templeado e on e.cve_empleado = ee.cve_empleado 
        inner join tsucursal s on s.cve_sucursal = e.cve_sucursal where ee.cve_periodo = :periodo GROUP by e.cve_sucursal, s.nombre";
        $conn = $this->connect()->prepare($query);
        $conn->bindParam(":periodo",$periodo);
        $conn->execute();
        $result = $conn->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}


?>