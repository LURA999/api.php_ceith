<?php
include "../Config/Config.php";
include "../Controllers/UsuarioController.php";


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $controlador = new UsuarioController();
    if(isset($_GET['idusuario'])){
        echo $controlador->getUsuariobyid($_GET['idusuario']);
    }else{
        echo $controlador->getUsuarios();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controlador = new UsuarioController();
    $params = json_decode(file_get_contents('php://input'), true);
    echo $resultado = $controlador->agregarUsuario($params);
}

if ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    $controlador = new UsuarioController();
    $params = json_decode(file_get_contents('php://input'), true);
   echo  $resultado = $controlador->actualizarUsuario($params);
}
