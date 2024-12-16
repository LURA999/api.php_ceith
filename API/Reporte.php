<?php
include "../Config/Config.php";
include "../Controllers/ReporteController.php";

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    try{
        $operacion = $_GET['index'];
        $obj = new ReporteController();

        if($operacion == 0){
            $cve_empresa = $_GET['cve_empresa'];
            $cve_periodo = $_GET['cve_periodo'];
            $responser = $obj->datosEmpresa($cve_empresa, $cve_periodo);
            echo $responser;
        }

        if($operacion == 1){
            $cve_periodo = $_GET['periodo'];
            $cve_sucursal = $_GET['sucursal'];
            $response = $obj->poblacionSexo($cve_periodo, $cve_sucursal);
            echo $response;
        }

        if($operacion == 2){
            $cve_periodo = $_GET['periodo'];
            $cve_sucursal = $_GET['sucursal'];
            $response = $obj->polacionPuesto($cve_periodo, $cve_sucursal);
            echo $response;
        }

        if($operacion == 3){
            $periodo = $_GET['periodo'];
            $response = $obj->examenesPorPeriodo($periodo);
            echo $response;
        }

        if($operacion == 4){
            $cve_periodo = $_GET['periodo'];
            $response = $obj->ats($cve_periodo);
            echo $response;
        }

        if($operacion == 5){
            $cve_periodo = $_GET['periodo'];
            $response = $obj->violencia($cve_periodo);
            echo $response;
        }

        if($operacion == 6){
            $cve_periodo = $_GET['periodo'];
            $response = $obj->referencia3($cve_periodo);
            echo $response;
        }

        if($operacion == 7){
            $cve_periodo = $_GET['periodo'];
            $response = $obj->referencia2($cve_periodo);
            echo $response;
        }



    }catch(Exception $e){
        $dbcon = null; 
        echo  json_encode(array('estatus'=>"error",
        'info'=>"error en servidor",
        'contenido'=>$e));
    }
}

?>