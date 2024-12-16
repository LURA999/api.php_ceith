<?php
include_once '../Application/Empresas.php';

class EmpresasController{

    function listaEmpresas(){
        $obj = new Empresas();
        $result = $obj->listEmpresas();
        if($result == ""){
            return  json_encode(array('estatus'=>"not found",
            'info'=>"Sin resultados",
            'contenido'=>null));
        }else{
            return  json_encode(array('estatus'=>"ok",
            'info'=>"Empresas encontradas",
            'contenido'=>$result));
        }
    }

    function empresabyid($id){
        $obj = new Empresas();
        $result = $obj->empresabyid($id);
        if($result == ""){
            return  json_encode(array('estatus'=>"not found",
            'info'=>"Empresa no encontrada",
            'contenido'=>null));
        }else{
            return  json_encode(array('estatus'=>"ok",
            'info'=>"Empresa encontrada",
            'contenido'=>$result));
        }
    }

    function agregarEmpresa($empresa){
        $obj = new Empresas();
        $obj->crearEmpresa($empresa);
        return json_encode(array('estatus'=>"ok",
        'info'=>"Empresa creada",
        'contenido'=>null));
    }

    function actualizarEmpresa($empresa){
        $obj = new Empresas();
        $obj->actualizarEmpresa($empresa);
        return json_encode(array('estatus'=>"ok",
        'info'=>"Empresa actualizada",
        'contenido'=>null));
    }

    function eliminarEmpresa($id){
        $obj = new Empresas();
        $obj->desactivarEmpresa($id);
        return json_encode(array('estatus'=>"ok",
        'info'=>"Empresa eliminada",
        'contenido'=>null));
    }
    
    function buscarEmpresaNombre($nombre){
        $obj = new Empresas();
        $result = $obj->empresapornombre($nombre);
        if($obj == ""){
            return  json_encode(array('estatus'=>"not found",
            'info'=>"Sin resultados",
            'contenido'=>null));
        }else{
            return  json_encode(array('estatus'=>"ok",
            'info'=>"Empresas coincidentes",
            'contenido'=>$result));
        }
    }

    function actualizarLink($params){
        $obj = new Empresas();
        $result = $obj->actualizarLink($params);
        return json_encode(array('estatus'=>"ok",
        'info'=>"Link actualizada",
        'contenido'=>null));
    }
}
