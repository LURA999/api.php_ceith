<?php

require '../Config/Database.php';

class Login extends Database{

    function getUserData($user,$password){
        $user = base64_decode($_GET['user']);
        $password = base64_decode($_GET['password']);
        $cmd = $this->connect()->prepare('Select cve_nivel, cve_usuario, email, nombre from tusuario where nombre = :user and contrasena = :contrasena and estatus=1');
        $cmd->bindparam(':user', $user);
        $cmd->bindparam(':contrasena', $password);
        $cmd->execute();
        return $cmd->fetch(PDO::FETCH_ASSOC);
    }

    function getEmpleado($centro,$empleado,$numero){
        $cmd = $this->connect()->prepare('select 
        e.cve_empleado,
        e.nombre, 
        d.descripcion as departamento, 
        t.descripcion as puesto , 
        s.nombre as sucursal,
        emp.nombre as empresa,
        s.cve_sucursal as csucursal,
        emp.cve_empresa as cempresa,
        e.administrador as administrador,
        (select cve_periodo from tperiodo where cve_empresa = emp.cve_empresa and estatus = 2) as periodo
        from templeado e 
        left join tdepartamento d on d.cve_departamento = e.cve_departamento   
        left join tpuesto t on t.cve_puesto = e.cve_puesto   
        left join tsucursal s on s.cve_sucursal = e.cve_sucursal
        left join tempresa emp on emp.cve_empresa = s.cve_empresa
        where e.cve_sucursal = :centro and e.cve_empleado = :empleado and e.password = :numero');
        $cmd->bindparam(':centro', $centro);
        $cmd->bindparam(':empleado', $empleado);
        $cmd->bindparam(':numero', $numero);
        $cmd->execute();
        return $cmd->fetch(PDO::FETCH_ASSOC);
    }


}


?>