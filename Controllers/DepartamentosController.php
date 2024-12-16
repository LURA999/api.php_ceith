<?php
require '../Application/Departamentos.php';
class DepartamentosController
{
    function insertDepartamento($departamento)
    {
        $obj = new Departamentos();
        $obj->crearDepartamento($departamento);
        return  json_encode(array(
            'estatus' => "ok",
            'info' => "Departamento creado",
            'contenido' => null
        ));
    }

    function listaDepartamentos($idsucursal)
    {
        $obj = new Departamentos();
        $result = $obj->getDepartamentos($idsucursal);
        if ($result == "") {
            return  json_encode(array(
                'estatus' => "not found",
                'info' => "Sin resultados",
                'contenido' => null
            ));
        } else {
            return  json_encode(array(
                'estatus' => "ok",
                'info' => "Sucursales encontradas",
                'contenido' => $result
            ));
        }
    }
}

?>