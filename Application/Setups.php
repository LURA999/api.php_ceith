<?php
require '../Config/Database.php';
class Setups extends Database{

    function listaPoblaciones(){
        $poblaciones = $this->connect()->query('Select * from tpoblacion');
        $result = $poblaciones->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function getExamenesSucursal($idsucursal){
        $examenes = $this->connect()->prepare('select * from 
        texamensucursal es
        inner join texamen ex on es.cve_examen = ex.cve_examen where
        es.cve_sucursal = :cve_sucursal');
        $examenes->bindParam(':cve_sucursal',$idsucursal);
        $examenes->execute();
        $result = $examenes->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function getExamenesPoblacion($idpoblacion){
        $examenes = $this->connect()->prepare('select * from texamenespoblacion where cve_poblacion = :cve_poblacion');
        $examenes->bindParam(':cve_poblacion',$idpoblacion);
        $examenes->execute();
        $result = $examenes->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function insertExamenesSucursal($idsucursal, $idexamen){
        $examenes = $this->connect()->prepare('insert into texamensucursal values(
            :idsucursal,
            :idexamen
        )');
        $examenes->bindParam(':idsucursal',$idsucursal);
        $examenes->bindParam(':idexamen', $idexamen);
        $examenes->execute();
        return "ok";
    }
}

?>