<?php
include "../Config/Config.php";
include "../Controllers/LoginController.php";

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    try{
        $c = $_GET['centro'];
        $e = $_GET['empleado'];
        $n = $_GET['numero'];
        $obj = new LoginController();
        $response = $obj->loginEmpleado($c,$e,$n);
        echo $response;
    }catch(Exception $e){
        $dbcon = null; 
        echo  json_encode(array('estatus'=>"error",
        'info'=>"error en servidor",
        'contenido'=>$e));
    }
}

?>