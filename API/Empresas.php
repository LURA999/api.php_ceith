<?php
include "../Config/Config.php";
include "../Controllers/EmpresasController.php";


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $controlador = new EmpresasController();
    try {
        if (isset($_GET['id'])) {
            $resultado = $controlador->empresabyid($_GET['id']);
            echo $resultado;
        } else if(isset($_GET['nombreEmpresa'])){
            $resultado = $controlador->buscarEmpresaNombre($_GET['nombreEmpresa']);
            echo $resultado;
        } else {
            $resultado = $controlador->listaEmpresas();
            echo $resultado;
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
        $controlador = new EmpresasController();
        $params = json_decode(file_get_contents('php://input'), true);
        $resultado = $controlador->agregarEmpresa($params);
        echo $resultado;
    } catch (Exception $e) {
        echo  json_encode(array(
            'estatus' => "error",
            'info' => "error en servidor",
            'contenido' => $e
        ));
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    try {
        $controlador = new EmpresasController();
        $params = json_decode(file_get_contents('php://input'), true);
        if(isset($_GET["link"])){
            $resultado = $controlador->actualizarLink($params); 
        }else{
            $resultado = $controlador->actualizarEmpresa($params);
        }
        echo $resultado;
    } catch (Exception $e) {
        echo  json_encode(array(
            'estatus' => "error",
            'info' => "error en servidor",
            'contenido' => $e
        ));
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    try {
        $controlador = new EmpresasController();
        $resultado = $controlador->eliminarEmpresa($_GET['id']);
        echo $resultado;
    } catch (Exception $e) {
        echo  json_encode(array(
            'estatus' => "error",
            'info' => "error en servidor",
            'contenido' => $e
        ));
    }
}
