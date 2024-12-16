<?php
include "../Config/Config.php";
include "../Controllers/PuestosController.php";

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    try{
        $controlador = new PuestosController();
        echo $controlador->listaDepartamentos($_GET['id']);
    }catch(Exception $e){
        echo  json_encode(array('estatus'=>"error",
        'info'=>"error en servidor",
        'contenido'=>$e));
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    try{
        $params = json_decode(file_get_contents('php://input'), true);
        $controlador = new PuestosController();
        echo $controlador->insertarPuesto($params);
    }catch(Exception $e){
        echo  json_encode(array('estatus'=>"error",
        'info'=>"error en servidor",
        'contenido'=>$e));
    }
}

?>