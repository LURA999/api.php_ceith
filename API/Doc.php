<?php
include "../Config/Config.php";
include "../Controllers/DocController.php";

    try{

        $obj = new DocController();
        $input = json_decode(file_get_contents('php://input'), true);

        switch($_SERVER['REQUEST_METHOD']){
            case "GET":
                $response = $obj->controllerDocs($_GET["cveEmpleado"]);
                echo $response;
                break;
            case "POST":
                $response = $obj->controllerDocsPost($input);
                echo $response;
                break;
            case "PATCH":
                $response = $obj->controllerDocsPatch($input);
                break;
            case "DELETE":
                    $response = $obj->controllerDocsDelete($_GET["idTarchivo"]);
                    break;

        }
    }catch(Exception $e){
        $dbcon = null; 
        echo  json_encode(array('estatus'=>"error",
        'info'=>"error en servidor",
        'contenido'=>$e));
    }

