<?php
include_once '../Application/ExamenesEmpleados.php';

class ExamenesEpleadosController{

    function listaExamenes($idempleado){
        $obj = new ExamenesEmpleados();
        $result = $obj->listExamenes($idempleado);
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

    function examenTotal($idexamenempleado){
        $obj = new ExamenesEmpleados();
        $result = $obj->getTest($idexamenempleado);
        if($result == ""){
            return  json_encode(array('estatus'=>"not found",
            'info'=>"Sin resultados",
            'contenido'=>null));
        }else{
            return  json_encode(array('estatus'=>"ok",
            'info'=>"Examen encontrado",
            'contenido'=>$result));
        }
    }

    function insertarExamen($params){
        $obj = new ExamenesEmpleados();
        $result = $obj->insertarResultados($params);
        return  json_encode(array('estatus'=>"ok",
        'info'=>"Resultados guardados",
        'contenido'=>null));
    }


}
?>