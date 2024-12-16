<?php
    include_once '../Application/Periodos.php';

    class PeriodoController{
        function getPeriodoPorEmpresa($cve_empresa){
            $obj = new Periodos();
            $result = $obj->periodosPorEmpresa($cve_empresa);
            if($result == null){
                return  json_encode(array('estatus'=>"not found",
                'info'=>"Sin resultados",
                'contenido'=>null));
            }else{
                return  json_encode(array('estatus'=>"ok",
                'info'=>"Periodos encontrados",
                'contenido'=>$result));
            }
        }

        function getPeriodoEmpleado($cveEmpleado){
            $obj = new Periodos();
            $result = $obj->obtenerPeriodoEmpleado($cveEmpleado);
            if($result == null){
                return  json_encode(array('estatus'=>"not found",
                'info'=>"Sin resultados",
                'contenido'=>null));
            }else{
                return  json_encode(array('estatus'=>"ok",
                'info'=>"Periodos encontrados",
                'contenido'=>$result));
            }
        }

        function insertPeriodo($params){
            $obj = new Periodos();
            $result = $obj->crearPeriodo($params['cve_empresa'], $params['fecha_inicio'], $params['fecha_fin']);
            if($result == true){
                return  json_encode(array('estatus'=>"ok",
                'info'=>"Periodo insertado",
                'contenido'=>null));
            }
        }

        function selectPeriodoActivo($cve_empresa){
            $obj =  new Periodos();
            $result = $obj->periodoActivo($cve_empresa);
            if($result != null || $result != false){
                return  json_encode(array('estatus'=>"ok",
                'info'=>"Periodo activo encontrado",
                'contenido'=>$result));
            }else{
                return  json_encode(array('estatus'=>"not found",
                'info'=>"Sin Periodo activo encontrado",
                'contenido'=>$result));
            }
        }

        function updatePeriodo($params){
            $obj = new Periodos();
            $result = $obj->editarPeriodo(
                $params['cve_periodo'], $params['fecha_inicio'], $params['fecha_fin'], $params['estatus']
            );
            if($result==true){
                return  json_encode(array('estatus'=>"ok",
                'info'=>"Periodo editado",
                'contenido'=>null));
            }
        }

        function deletePeriodo($cve_periodo){
            $obj = new Periodos();
            $result = $obj->desactivarPeriodo($cve_periodo);
            if($result==true){
                return  json_encode(array('estatus'=>"ok",
                'info'=>"Periodo eliminado",
                'contenido'=>null));
            }
        }

    }
?>