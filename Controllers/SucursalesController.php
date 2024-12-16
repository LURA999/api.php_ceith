<?php
include_once '../Application/Sucursales.php';

class SucursalesController{

    function getSucursales($idEmpresa){
        $obj = new Sucursales();
        $result = $obj->listaSucursales($idEmpresa);
        if($result == ""){
            return  json_encode(array('estatus'=>"not found",
            'info'=>"Sin resultados",
            'contenido'=>null));
        }else{
            return  json_encode(array('estatus'=>"ok",
            'info'=>"Sucursales encontradas",
            'contenido'=>$result));
        }
    }

    function insertarSucursal($sucursal){
        $obj = new Sucursales();
        $result = $obj->crearSucursal($sucursal);
        return  json_encode(array('estatus'=>"ok",
        'info'=>"Sucursal creada",
        'contenido'=>$result));
    }

    function deleteSucursal($id){
        $obj = new Sucursales();
        $result = $obj->eliminarSucursal($id);
        return  json_encode(array('estatus'=>"ok",
        'info'=>"Sucursal eliminada",
        'contenido'=>$result));
    }

}
?>