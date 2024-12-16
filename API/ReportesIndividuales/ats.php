<?php
include "../../Config/Config.php";
include "../../Application/ReportesIndividuales/ats.php";


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $controlador = new Ats();
    try {
        $periodo = $_GET['periodo'];
        $sucursal = $_GET['sucursal'];
        $opc = $_GET['opc'];
        $result = $controlador->getReporte($periodo,$sucursal,$opc);
        echo  json_encode(array(
            'estatus' => "ok",
            'info' => "",
            'contenido' => $result
        ));
    } catch (Exception $e) {
        echo  json_encode(array(
            'estatus' => "error",
            'info' => "Error en servidor",
            'contenido' => $e
        ));
    }
}

?>