<?php
include "../Config/Config.php";
include "../Controllers/GraficasController.php";

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    try{
        $operacion = $_GET['index'];
        $clave = $_GET['cve'];
    
        $obj = new GraficasController();

        if($operacion == 1){
            $response = $obj->generalEmpresa($clave, $_GET['empresa']);
            echo $response;
        }

        if($operacion == 2){
            $response = $obj->participacion($clave);
            echo $response;
        }

    }catch(Exception $e){
        $dbcon = null; 
        echo  json_encode(array('estatus'=>"error",
        'info'=>"error en servidor",
        'contenido'=>$e));
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    try{
        $obj = new GraficasController();
        $params = json_decode(file_get_contents('php://input'), true);
        $result = $obj->examenesRealizados($params['cve_periodo'],$params['pagina'],$params['cantidad'],$params['sucursal']);
        echo $result;
    }catch(Exception $e){
        $dbcon = null; 
        echo  json_encode(array('estatus'=>"error",
        'info'=>"error en servidor",
        'contenido'=>$e));
    }
}


?>