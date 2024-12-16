<?php
include "../Config/Config.php";
include "../Controllers/SetupsController.php";

try {

    $method = $_SERVER['REQUEST_METHOD'];

    $controlador = new SetupsController();

    if ($method == 'GET') {
        $id = $_GET['idpoblacion'];
        echo $controlador->getExamenesPoblacion($id);
    }
} catch (Exception $e) {
    echo  json_encode(array(
        'estatus' => "error",
        'info' => $e
    ));
}
