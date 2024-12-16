<?php
include "../Config/Config.php";
include "../Controllers/SetupsController.php";

try {

    $method = $_SERVER['REQUEST_METHOD'];

    $controlador = new SetupsController();

    if ($method == 'GET') {
        $id = $_GET['idsucursal'];
        echo $controlador->getExamenesSucursal($id);
    }

    if ($method == 'POST') {
        $idsucursal = $_GET['idsucursal'];
        $idexamen = $_GET['idexamen'];
        echo $controlador->crearExamenSucursal($idsucursal, $idexamen);
    }
} catch (Exception $e) {
    echo  json_encode(array(
        'estatus' => "error",
        'info' => $e
    ));
}
