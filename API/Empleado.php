<?php
include "../Config/Config.php";
include "../Controllers/EmpleadosController.php";

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    try{
        $controlador = new EmpleadoController();
        if(isset($_GET['idsucursal']) && !isset($_GET['empleado']) ){
            echo $controlador->getEmpleados($_GET['idsucursal']);
            exit();
        } 

        if(isset($_GET['empleado']) ){
            echo $controlador->getEmpleadosBuscador($_GET['idsucursal'],$_GET['empleado']);
            exit();
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
        $controler = new EmpleadoController();
        $params = json_decode(file_get_contents('php://input'), true);
        echo $controler->agregarEmpleado($params); 
    }catch(Exception $e){ 
        echo  json_encode(array('estatus'=>"error",
        'info'=>"error en servidor",
        'contenido'=>$e));
    }
}

?>