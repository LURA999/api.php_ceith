<?php
require '../Config/Database.php';
class Empleado extends Database{
    
    function listEmpleados($idsucursal){
        $query = "select e.cve_empleado,
        e.nombre, 
        e.password,
        e.cve_sucursal as sucursal,
        d.descripcion as departamento, 
        t.descripcion as puesto  
        from templeado e 
        left join tdepartamento d on d.cve_departamento = e.cve_departamento   
        left join tpuesto t on t.cve_puesto = e.cve_puesto   
        where e.cve_sucursal = :idsucursal order by e.cve_empleado desc";
        $sql = $this->connect()->prepare($query);
        $sql->bindParam(':idsucursal',$idsucursal);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function buscarEmpleado($idsucursal,$empleado){
        $var = "%".$empleado."%";
        $query = "select e.cve_empleado,
        e.nombre, 
        e.password,
        e.cve_sucursal as sucursal,
        d.descripcion as departamento, 
        t.descripcion as puesto  
        from templeado e 
        left join tdepartamento d on d.cve_departamento = e.cve_departamento   
        left join tpuesto t on t.cve_puesto = e.cve_puesto   
        where e.cve_sucursal = :idsucursal and e.nombre like :empleado order by e.cve_empleado desc";
        $sql = $this->connect()->prepare($query);
        $sql->bindParam(':idsucursal',$idsucursal);
        $sql->bindParam(':empleado',$var);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function insertEmpleado($params){
        $query = 'insert into templeado values(
            null,
            :cve_puesto,
            :cve_departamento,
            :cve_sucursal,
            :seccion_area,
            :tipo_puesto,
            :nombre,
            :edad,
            :no_dependientes,
            :experiencia_actual,
            :experiencia_laboral,
            :tipo_contratacion,
            :cantidad_de_trabajos,
            :sexo,
            :estado_civil,
            :escolaridad,
            :no_personas_acargo,
            :horas_diarias_laboradas,
            :numero_empleado,
            :tipo_personal,
            :rota_turnos,
            :tipo_jornada,
            :otros,
            1,
            :administrador,
            :password
        )';
        $sql = $this->connect()->prepare($query);
        $sql->bindparam(':cve_puesto', $params['cve_puesto']);
        $sql->bindparam(':cve_departamento', $params['cve_departamento']);
        $sql->bindparam(':cve_sucursal', $params['cve_sucursal']);
        $sql->bindparam(':seccion_area', $params['seccion_area']);
        $sql->bindparam(':tipo_puesto', $params['tipo_puesto']);
        $sql->bindparam(':nombre', $params['nombre']);
        $sql->bindparam(':edad', $params['edad']);
        $sql->bindparam(':no_dependientes', $params['no_dependientes']);
        $sql->bindparam(':experiencia_actual', $params['experiencia_actual']);
        $sql->bindparam(':experiencia_laboral', $params['experiencia_laboral']);
        $sql->bindparam(':tipo_contratacion', $params['tipo_contratacion']);
        $sql->bindparam(':cantidad_de_trabajos', $params['cantidad_de_trabajos']);
        $sql->bindparam(':sexo', $params['sexo']);
        $sql->bindparam(':estado_civil', $params['estado_civil']);
        $sql->bindparam(':escolaridad', $params['escolaridad']);
        $sql->bindparam(':no_personas_acargo', $params['no_personas_acargo']);
        $sql->bindparam(':horas_diarias_laboradas', $params['horas_diarias_laboradas']);
        $sql->bindparam(':numero_empleado', $params['numero_empleado']);
        $sql->bindparam(':tipo_personal', $params['tipo_personal']);
        $sql->bindparam(':rota_turnos', $params['rota_turnos']);
        $sql->bindparam(':tipo_jornada', $params['tipo_jornada']);
        $sql->bindparam(':otros', $params['otros']);
        $sql->bindparam(':administrador', $params['administrador']);
        $sql->bindparam(':password', $params['password']);
        $sql->execute();
        return $sql;
    }
}

?>