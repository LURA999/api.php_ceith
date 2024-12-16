<?php
require '../Config/Database.php';

class Usuario extends Database{
    
    function listaUsuarios(){

        $query = "select cve_usuario, nombre, email, cve_nivel,estatus, cve_centro from tusuario";
        $sql = $this->connect()->prepare($query);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function usuarioById($cve_usuario){
        $query = "select * from tusuario where cve_usuario = :cve_usuario";
        $sql = $this->connect()->prepare($query);
        $sql->bindParam(':cve_usuario',$cve_usuario);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function insertarUsuario($params){
        $query = 'insert into tusuario values(
            UUID(),
            :nombre,
            :email,
            :cve_nivel,
            :contrasena,
            1,
            0
        )';
        $sql = $this->connect()->prepare($query);
        $sql->bindparam(':nombre', $params['nombre']);
        $sql->bindparam(':email', $params['email']);
        $sql->bindparam(':cve_nivel', $params['cve_nivel']);
        $sql->bindparam(':contrasena', $params['contrasena']);
        $sql->execute();
        return $sql;
    }

    function actualizarUsuario($params){
        $query = 'update tusuario set
            nombre = :nombre,
            email = :email,
            cve_nivel = :cve_nivel,
            contrasena = :contrasena,
            estatus = :estatus,
            cve_centro = :cve_centro
            where cve_usuario = :cve_usuario
        ';
        $sql = $this->connect()->prepare($query);
        $sql->bindparam(':cve_usuario', $params['cve_usuario']);
        $sql->bindparam(':nombre', $params['nombre']);
        $sql->bindparam(':email', $params['email']);
        $sql->bindparam(':cve_nivel', $params['cve_nivel']);
        $sql->bindparam(':contrasena', $params['contrasena']);
        $sql->bindparam(':estatus', $params['estatus']);
        $sql->bindparam(':cve_centro', $params['cve_centro']);
        $sql->execute();
        return $sql;
    }
}

?>