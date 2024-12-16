<?php
include "../Config/Config.php";
include "../Controllers/LoginController.php";

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    try{
        $u = base64_decode($_GET['user']);
        $p = base64_decode($_GET['password']);
        $obj = new LoginController();
        $response = $obj->login($u,$p);
        if($response == ""){
            echo json_encode(array('estatus'=>"no found",
            'info'=>"Usuario no encontrado",
            'contenido'=>$response));
        }else{
            echo json_encode(array('estatus'=>"ok",
            'info'=>"Usuario encontrado",
            'contenido'=>$response));
        }

    }catch(Exception $e){
        $dbcon = null; 
        echo  json_encode(array('estatus'=>"error",
        'info'=>"error en servidor",
        'contenido'=>$e));
    }
}

?>