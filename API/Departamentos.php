<?php
include "../Config/Config.php";
include "../Controllers/DepartamentosController.php";

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    try{
        $controlador = new DepartamentosController();
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
        $controlador = new DepartamentosController();
        echo $controlador->insertDepartamento($params);
    }catch(Exception $e){
        $dbcon = null; 
        echo  json_encode(array('estatus'=>"error",
        'info'=>"error en servidor",
        'contenido'=>$e));
    }
}

?>