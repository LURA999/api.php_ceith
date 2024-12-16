<?php
include "../Config/Config.php";
include "../Controllers/SetupsController.php";

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    try{
        $controlador = new SetupsController();
        echo $controlador->getPoblaciones();
    }catch(Exception $e){
        echo  json_encode(array('estatus'=>"error",
        'info'=>"error en servidor",
        'contenido'=>$e));
    }
}

?>