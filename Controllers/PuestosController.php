<?php
require '../Application/Puestos.php';
class PuestosController
{

    function insertarPuesto($puesto)
    {
        $obj = new Puestos();
        $obj->crearPuesto($puesto);
        return  json_encode(array(
            'estatus' => "ok",
            'info' => "Puesto creado",
            'contenido' => null
        ));
    }

    function listaDepartamentos($idsucursal)
    {
        $obj = new Puestos();
        $result = $obj->getPuestos($idsucursal);
        if ($result == "") {
            return  json_encode(array(
                'estatus' => "not found",
                'info' => "Sin resultados",
                'contenido' => null
            ));
        } else {
            return  json_encode(array(
                'estatus' => "ok",
                'info' => "Puestos encontrados",
                'contenido' => $result
            ));
        }
    }
}

?>