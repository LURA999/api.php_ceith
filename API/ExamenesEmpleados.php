<?php
include "../Config/Config.php";
include "../Controllers/ExamenesEmpleadosController.php";


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $controlador = new ExamenesEpleadosController();
    try {
        if(isset($_GET['idexamenempleado'])){
            $result = $controlador->examenTotal($_GET['idexamenempleado']);
            echo $result;
        }else{
            $result = $controlador->listaExamenes($_GET['id']);
            echo $result;
        }
    } catch (Exception $e) {
        echo  json_encode(array(
            'estatus' => "error",
            'info' => "Error en servidor",
            'contenido' => $e
        ));
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $controlador = new ExamenesEpleadosController();
        $params = json_decode(file_get_contents('php://input'), true);
        $resultado = $controlador->insertarExamen($params);
        echo $resultado;
    } catch (Exception $e) {
        echo  json_encode(array(
            'estatus' => "error",
            'info' => "error en servidor",
            'contenido' => $e
        ));
    }
}
