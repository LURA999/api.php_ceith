<?php

include_once '../Application/Usuario.php';

class UsuarioController
{
    private $dbcontext;

    function __construct() {
        $this->dbcontext = new Usuario();
    } 

    function getUsuarios()
    {
        try{
            $response = $this->dbcontext->listaUsuarios();
            if($response == ""){
                return  json_encode(array('estatus'=>"not found",
                'info'=>"Sin resultados",
                'contenido'=>null));
            }else{
                return  json_encode(array('estatus'=>"ok",
                'info'=>"Usuarios encontrados",
                'contenido'=>$response));
            }
        }catch(Exception $e){
            return  json_encode(array('estatus'=>"error",
            'info'=>$e->getMessage(),
            'contenido'=>$response));
        }
    }

    function getUsuariobyid($id_usuario)
    {
        try{
            $response = $this->dbcontext->usuarioById($id_usuario);
            if($response == ""){
                return  json_encode(array('estatus'=>"not found",
                'info'=>"Sin resultados",
                'contenido'=>null));
            }else{
                return  json_encode(array('estatus'=>"ok",
                'info'=>"Usuario encontrado",
                'contenido'=>$response));
            }
        }catch(Exception $e){
            return  json_encode(array('estatus'=>"error",
            'info'=>$e->getMessage(),
            'contenido'=>$response));
        }
    }

    function agregarUsuario($params){
        try{
            $this->dbcontext->insertarUsuario($params);
            return  json_encode(array('estatus'=>"ok",
            'info'=>"Usuario agregado",
            'contenido'=>null));
        }catch(Exception $e){
            return  json_encode(array('estatus'=>"error",
            'info'=>$e->getMessage(),
            'contenido'=>null));
        }
    }

    function actualizarUsuario($params){
        try{
            $this->dbcontext->actualizarUsuario($params);
            return  json_encode(array('estatus'=>"ok",
            'info'=>"Usuario actualizado",
            'contenido'=>null));
        }catch(Exception $e){
            return  json_encode(array('estatus'=>"error",
            'info'=>$e->getMessage(),
            'contenido'=>null));
        }
    }
}

?>