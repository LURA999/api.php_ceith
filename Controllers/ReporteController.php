<?php
include_once '../Application/Reporte.php';

class ReporteController{
 
    function poblacionSexo($cve_periodo,$cve_sucursal){
        $obj = new Reporte();
        $result = $obj->poblacionSexo($cve_periodo, $cve_sucursal);
        if($result == false){
            return  json_encode(array('estatus'=>"not found",
            'info'=>"Sin resultados",
            'contenido'=>null));
        }else{
            return  json_encode(array('estatus'=>"ok",
            'info'=>"Resultados encontrados",
            'contenido'=>$result));
        }
    }

    function examenesPorPeriodo($periodo){
        $obj = new Reporte();
        $result = $obj->examenesPorPeriodo($periodo);
        if($result == false){
            return  json_encode(array('estatus'=>"not found",
            'info'=>"Sin resultados",
            'contenido'=>null));
        }else{
            return  json_encode(array('estatus'=>"ok",
            'info'=>"Resultados encontrados",
            'contenido'=>$result));
        }
    }

    function polacionPuesto($cve_periodo,$cve_sucursal){
        $obj = new Reporte();
        $result = $obj->poblacionPuesto($cve_periodo, $cve_sucursal);
        if($result == false){
            return  json_encode(array('estatus'=>"not found",
            'info'=>"Sin resultados",
            'contenido'=>null));
        }else{
            return  json_encode(array('estatus'=>"ok",
            'info'=>"Resultados encontrados",
            'contenido'=>$result));
        }
    }

    function datosEmpresa($cve_empresa, $cve_periodo){
        $obj = new Reporte();
        $result = $obj->datosEmpresa($cve_empresa, $cve_periodo);
        if($result == false){
            return  json_encode(array('estatus'=>"not found",
            'info'=>"Sin resultados",
            'contenido'=>null));
        }else{
            return  json_encode(array('estatus'=>"ok",
            'info'=>"Resultados encontrados",
            'contenido'=>$result));
        }
    }

    function ats($periodo){
        $obj = new Reporte();
        $result = $obj->ats($periodo);
        return $result;
    }

    function violencia($periodo){
        $obj = new Reporte();
        $result = $obj->violencia($periodo);
        return $result;
    }

    
    function referencia3($periodo){
        $obj = new Reporte();
        $result = $obj->ref3($periodo);
        return $result;
    }

    function referencia2($periodo){
        $obj = new Reporte();
        $result = $obj->ref2($periodo);
        return $result;
    }
}
?>