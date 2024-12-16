<?php
include "../Config/Config.php";
include "../Controllers/PeriodoController.php";


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $controlador = new PeriodoController();
  

    try {

        if(!isset($_GET['cveEmpleado'])){ 
            $operacion = $_GET['operacion'];
                if ($operacion == 0) {
                    $result = $controlador->getPeriodoPorEmpresa($_GET['cve_empresa']);
                    echo $result;
                } else {
                    $result = $controlador->selectPeriodoActivo($_GET['cve_empresa']);
                    echo $result;
                }
        }
        if(isset($_GET['cveEmpleado'])){
            $result = $controlador->getPeriodoEmpleado($_GET['cveEmpleado']);
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
    $params = json_decode(file_get_contents('php://input'), true);
    $controlador = new PeriodoController();
    try {
        $result = $controlador->insertPeriodo($params);
        echo $result;
    } catch (Exception $e) {
        echo  json_encode(array(
            'estatus' => "error",
            'info' => "Error en servidor",
            'contenido' => $e
        ));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    $params = json_decode(file_get_contents('php://input'), true);
    $controlador = new PeriodoController();
    try {
        $result = $controlador->updatePeriodo($params);
        echo $result;
    } catch (Exception $e) {
        echo  json_encode(array(
            'estatus' => "error",
            'info' => "Error en servidor",
            'contenido' => $e
        ));
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $controlador = new PeriodoController();
    try {
        $result = $controlador->deletePeriodo($_GET['cve_periodo']);
        echo $result;
    } catch (Exception $e) {
        echo  json_encode(array(
            'estatus' => "error",
            'info' => "Error en servidor",
            'contenido' => $e
        ));
    }
}
