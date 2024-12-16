<?php
require "../Config/Config.php";
require "../Controllers/SucursalesController.php";

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    try{
        $controlador = new SucursalesController();
        echo $controlador->getSucursales($_GET['id']);
    }catch(Exception $e){
        echo  json_encode(array('estatus'=>"error",
        'info'=>"error en servidor",
        'contenido'=>$e));
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    try{
        $params = json_decode(file_get_contents('php://input'), true);
        $controlador = new SucursalesController();
        echo $controlador->insertarSucursal($params);
    }catch(Exception $e){
        echo  json_encode(array('estatus'=>"error",
        'info'=>"error en servidor",
        'contenido'=>$e));
    }
}

if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    try{
        $controlador = new SucursalesController();
        echo $controlador->deleteSucursal($_GET['id']);
    }catch(Exception $e){
        echo  json_encode(array('estatus'=>"error",
        'info'=>"error en servidor",
        'contenido'=>$e));
    }
}

?>



