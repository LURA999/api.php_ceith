<?php
require "../Config/Database.php";
class Empresas extends Database
{
    function listEmpresas()
    {
        $empresas = $this->connect()->query('select *,(
            select count(cve_empleado) from tempresa e 
            inner join tsucursal s on e.cve_empresa = s.cve_empresa
            inner join templeado emp on s.cve_sucursal = emp.cve_sucursal
            where e.cve_empresa = empresa.cve_empresa
        ) as total_empleados,
        (select count(cve_sucursal) from tsucursal where cve_empresa = empresa.cve_empresa and estatus = 1) as sucursales,
        (select count(cve_periodo) from tperiodo where cve_empresa = empresa.cve_empresa and estatus=2) as periodo
        from tempresa empresa where estatus=1 order by cve_empresa desc');
        $result = $empresas->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function empresapornombre($nombre){
        $var = "%".$nombre."%";
        $empresa = $this->connect()->prepare("select *, (
            select count(cve_empleado) from tempresa e 
            inner join tsucursal s on e.cve_empresa = s.cve_empresa
            inner join templeado emp on s.cve_sucursal = emp.cve_sucursal
            where e.cve_empresa = empresa.cve_empresa
        ) as total_empleados from tempresa empresa where empresa.nombre like :nombre  and empresa.estatus = 1 order by cve_empresa desc");
        $empresa->bindParam(':nombre', $var);
        $empresa->execute();
        $result = $empresa->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function empresabyid($id)
    {
        $empresa = $this->connect()->prepare('select *, (
            select count(cve_empleado) from tempresa e 
            inner join tsucursal s on e.cve_empresa = s.cve_empresa
            inner join templeado emp on s.cve_sucursal = emp.cve_sucursal
            where e.cve_empresa = empresa.cve_empresa
        ) as total_empleados from tempresa empresa where cve_empresa = :id');
        $empresa->bindParam(':id', $id);
        $empresa->execute();
        $result = $empresa->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function crearEmpresa($empresa)
    {
        
        $query = 'insert into tempresa values(
            null,
            0,
            :nombre,
            :denominacion,
            :actividad_principal,
            :razon_social,
            :domicilio,
            :objetivo,
            1,
            CURRENT_TIMESTAMP(),
            CURRENT_TIMESTAMP(),
            null		
        )';
        $sql = $this->connect()->prepare($query);
        $sql->bindparam(':nombre', $empresa['nombre']);
        $sql->bindparam(':denominacion', $empresa['denominacion']);
        $sql->bindparam(':actividad_principal', $empresa['actividad_principal']);
        $sql->bindparam(':razon_social', $empresa['razon_social']);
        $sql->bindparam(':domicilio', $empresa['domicilio']);
        $sql->bindparam(':objetivo', $empresa['objetivo']);
        $sql->execute();
        return $sql;
    }

    function actualizarEmpresa($params)
    {
        $sql = $this->connect()->prepare('update tempresa set
        nombre = :nombre,
        denominacion = :denominacion,
        actividad_principal = :actividad_principal,
        razon_social = :razon_social,
        domicilio = :domicilio,
        objetivo = :objetivo,
        actualizada = CURRENT_TIMESTAMP()	
        where cve_empresa = :id');

        $sql->bindparam(':nombre', $params['nombre']);
        $sql->bindparam(':denominacion', $params['denominacion']);
        $sql->bindparam(':actividad_principal', $params['actividad_principal']);
        $sql->bindparam(':razon_social', $params['razon_social']);
        $sql->bindparam(':domicilio', $params['domicilio']);
        $sql->bindparam(':objetivo', $params['objetivo']);
        $sql->bindparam(':id', $params['id'], PDO::PARAM_INT);
        $sql->execute();
        return $sql;
    }

    function desactivarEmpresa($id){
        $result = $this->connect()->query('update tempresa set estatus =0 where cve_empresa = '.$id);
        return $result;
    }

    function actualizarLink($params){
        $result = $this->connect()->query('update tempresa set link =:link where cve_empresa = :cveEmpresa');
        $sql->bindparam(':cveEmpresa', $params['cveEmpresa']);
        $sql->bindparam(':link', $params['link']);
        $sql->execute();
        return $result;
    }
}
