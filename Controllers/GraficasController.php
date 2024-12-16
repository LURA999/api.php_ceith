<?php
include_once '../Application/Graficas.php';

class GraficasController{

    function generalEmpresa($cve_periodo, $cve_empresa){
        $obj = new Graficas();
        $result = $obj->generalEmpresa($cve_periodo, $cve_empresa);
        if($result == ""){
            return  json_encode(array('estatus'=>"not found",
            'info'=>"Sin resultados",
            'contenido'=>null));
        }else{
            return  json_encode(array('estatus'=>"ok",
            'info'=>"resultados encontrados",
            'contenido'=>$result));
        }
    }

    function examenesRealizados($cve_periodo, $pagina, $cantidad, $sucursal){
        $obj = new Graficas();
        $result = $obj->examenesRealizados($cve_periodo, $pagina, $cantidad, $sucursal);
        if($result == ""){
            return  json_encode(array('estatus'=>"not found",
            'info'=>"Sin resultados",
            'contenido'=>null));
        }else{
            return  json_encode(array('estatus'=>"ok",
            'info'=>"resultados encontrados",
            'contenido'=>$result));
        }
    }

    function participacion($sucursal){
        $obj = new Graficas();
        $result = $obj->participacionSucursal($sucursal);
        if($result == ""){
            return  json_encode(array('estatus'=>"not found",
            'info'=>"Sin resultados",
            'contenido'=>null));
        }else{
            return  json_encode(array('estatus'=>"ok",
            'info'=>"resultados encontrados",
            'contenido'=>$result));
        }
    }
}
?>