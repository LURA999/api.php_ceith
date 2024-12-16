<?php

include_once '../Application/Empleado.php';

class EmpleadoController
{

    function getEmpleados($idsucursal)
    {
        $empleado = new Empleado();
        $response = $empleado->listEmpleados($idsucursal);
        if($response == ""){
            return  json_encode(array('estatus'=>"not found",
            'info'=>"Sin resultados",
            'contenido'=>null));
        }else{
            return  json_encode(array('estatus'=>"ok",
            'info'=>"Empleados encontrados",
            'contenido'=>$response));
        }
    }

    function getEmpleadosBuscador($idSucursal,$nomempleado)
    {
        $empleado = new Empleado();
        $response = $empleado->buscarEmpleado($idSucursal,$nomempleado);
        if($response == ""){
            return  json_encode(array('estatus'=>"not found",
            'info'=>"Sin resultados",
            'contenido'=>null));
        }else{
            return  json_encode(array('estatus'=>"ok",
            'info'=>"Empleados encontrados",
            'contenido'=>$response));
        }
    }

    function agregarEmpleado($params){
        $empleado = new Empleado();
        $resp = $empleado->insertEmpleado($params); 
        return  json_encode(array('estatus'=>"ok",
        'info'=>"Empleado agregado",
        'contenido'=>null));
    }
}
