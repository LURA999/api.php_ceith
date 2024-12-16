<?php
    include_once '../Application/Examenes.php';

    class ExamenesController{
        function getExamenes(){
            $obj = new Examenes();
            $result = $obj->listExamenes();
            if($result == ""){
                return  json_encode(array('estatus'=>"not found",
                'info'=>"Sin resultados",
                'contenido'=>null));
            }else{
                return  json_encode(array('estatus'=>"ok",
                'info'=>"Examenes encontrados",
                'contenido'=>$result));
            }
        }

        function insertarExamenSucursal($cve_sucursal, $cve_examen){
            $obj = new Examenes();
            $obj->agregarexamensucursal($cve_sucursal, $cve_examen);
            return  json_encode(array('estatus'=>"ok",
            'info'=>"Resultados guardados",
            'contenido'=>null));
        }

        function deleteexamensucursal($cve_sucursal, $cve_examen){
            $obj = new Examenes();
            $obj->eliminarexamensucursal($cve_sucursal, $cve_examen);
            return  json_encode(array('estatus'=>"ok",
            'info'=>"Examen eliminado",
            'contenido'=>null));
        }
    }
