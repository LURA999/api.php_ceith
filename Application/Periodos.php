<?php
require "../Config/Database.php";

class Periodos extends Database
{
    function periodosPorEmpresa($empresa)
    {
        $periodos = $this->connect()->prepare("
        select * from tperiodo where cve_empresa = :cve_empresa and estatus in (1,2,3)");
        $periodos->bindParam(":cve_empresa", $empresa);
        $periodos->execute();
        $result = $periodos->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function crearPeriodo($cve_empresa, $inicio, $fin)
    {
        $periodo = $this->connect()->prepare('
        insert into tperiodo values(null,:empresa,:inicio,:fin,1)');
        $periodo->bindParam(":empresa", $cve_empresa);
        $periodo->bindParam(":inicio", $inicio);
        $periodo->bindParam(":fin", $fin);
        $periodo->execute();
        return true;
    }

    function periodoActivo($cve_empresa)
    {
        $periodo = $this->connect()->prepare('
        select cve_periodo from tperiodo where cve_empresa = :cve_empresa
        ');
        $periodo->bindParam("empresa", $cve_empresa);
        $periodo->execute();
        return true;
    }

    function editarPeriodo($cve_periodo, $inicio, $fin, $estatus)
    {
        $periodo = $this->connect()->prepare('
        update tperiodo set fecha_inicio = :inicio, fecha_fin = :fin, estatus= :estatus where cve_periodo = :periodo
    ');
        $periodo->bindParam(":inicio", $inicio);
        $periodo->bindParam(":fin", $fin);
        $periodo->bindParam(":estatus", $estatus);
        $periodo->bindParam(":periodo", $cve_periodo);
        $periodo->execute();
        return true;
    }

    function desactivarPeriodo($cve_periodo)
    {
        $periodo = $this->connect()->prepare('
            update tperiodo set estatus = 0 where cve_periodo = :periodo
        ');
        $periodo->bindParam(":periodo", $cve_periodo);
        $periodo->execute();
        return true;
    }

    function obtenerPeriodoEmpleado($cveEmpleado)
    {
        $periodo = $this->connect()->prepare("
        select tper.cve_periodo, concat(tper.fecha_inicio,' - ',tper.fecha_fin) periodo from tperiodo tp 
        inner join tempresa te on tp.cve_empresa = te.cve_empresa 
        inner join tsucursal ts on ts.cve_empresa = te.cve_empresa
        inner join templeado tem on tem.cve_sucursal = ts.cve_sucursal
        inner join tperiodo tper on tper.cve_empresa = ts.cve_empresa where cve_empleado = :cveEmpleado group by periodo
        ");
        $periodo->bindParam(":cveEmpleado", $cveEmpleado);
        $periodo->execute();
        return  $periodo->fetchAll(PDO::FETCH_ASSOC);
    }
}
