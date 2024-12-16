<?php
require '../Application/Setups.php';
class SetupsController{

    private $dbcontext;

    function __construct() {
        $this->dbcontext = new Setups();
    } 

    function getPoblaciones(){
        $content = $this->dbcontext->listaPoblaciones();
        return  json_encode(array('estatus'=>"ok",
        'info'=>"Poblaciones encontradas",
        'contenido'=>$content));
    }

    function getExamenesSucursal($idsucursal){
        $content = $this->dbcontext->getExamenesSucursal($idsucursal);
        if($content == ""){
            return json_encode(array('estatus'=>"not found",
            'info'=>"Sin resultados",
            'contenido'=>null));
        }else{
            return json_encode(array('estatus'=>"ok",
            'info'=>"Examenes encontrados",
            'contenido'=>$content));
        }
    }

    function getExamenesPoblacion($idPoblacion){
        $content = $this->dbcontext->getExamenesPoblacion($idPoblacion);
        if($content == ""){
            return json_encode(array('estatus'=>"not found",
            'info'=>"Sin resultados",
            'contenido'=>null));
        }else{
            return json_encode(array('estatus'=>"ok",
            'info'=>"Examenes encontrados",
            'contenido'=>$content));
        }
    }

    function crearExamenSucursal($idsucursal,$idexamen){
        $content = $this->dbcontext->insertExamenesSucursal($idsucursal,$idexamen);
        return json_encode(array('estatus'=>"ok",
        'info'=>"Examen creado para la sucursal",
        'contenido'=>null));
    }
}


?>