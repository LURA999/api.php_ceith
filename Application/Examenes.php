<?php

require "../Config/Database.php";
class Examenes extends Database{
    function listExamenes(){
        $examenes = $this->connect()->query('select * from texamen');
        $result = $examenes->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function agregarexamensucursal($cve_sucursal, $cve_examen){
        $examen = $this->connect()->prepare('
          insert into texamensucursal values(:sucursal, :examen)
        ');
        $examen->bindParam(':sucursal', $cve_sucursal);
        $examen->bindParam(':examen', $cve_examen);
        $examen->execute();
        return $examen;
    }

    function eliminarexamensucursal($cve_sucursal, $cve_examen){
        $examen = $this->connect()->prepare('
          delete from texamensucursal where cve_sucursal = :sucursal and cve_examen = :examen
        ');
        $examen->bindParam(':sucursal', $cve_sucursal);
        $examen->bindParam(':examen', $cve_examen);
        $examen->execute();
        return $examen;
    }
}


?>