<?php
    include "../Config/Config.php";
    include "../Controllers/ExamenesController.php";

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        try{
            $controlador = new ExamenesController();
            echo $controlador->getExamenes();
        }catch(Exception $e){
            echo  json_encode(array('estatus'=>"error",
            'info'=>"error en servidor",
            'contenido'=>$e));
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        try{
            $params = json_decode(file_get_contents('php://input'), true);
            $controlador = new ExamenesController();
            echo $controlador->insertarExamenSucursal($params['cve_sucursal'],$params['cve_examen']);
        }catch(Exception $e){
            echo  json_encode(array('estatus'=>"error",
            'info'=>"error en servidor",
            'contenido'=>$e));
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
        try{
            $controlador = new ExamenesController();
            echo $controlador->deleteexamensucursal($_GET['cve_sucursal'],$_GET['cve_examen']);
        }catch(Exception $e){
            echo  json_encode(array('estatus'=>"error",
            'info'=>"error en servidor",
            'contenido'=>$e));
        }
    }

?>