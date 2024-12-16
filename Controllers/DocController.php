<?php
require '../Application/Doc.php';
class DocController{

    private $dbcontext;

    function __construct() {
        $this->dbcontext = new Doc();
    } 

    function controllerDocs($cveEmpleado){
        $content = $this->dbcontext->getDocs($cveEmpleado);
        if($content == ""){
            return json_encode(array('estatus'=>"not found",
            'info'=>"not found",
            'contenido'=>null));
        }else{
            return json_encode(array('estatus'=>"ok",
            'info'=>"docs founds",
            'contenido'=>$content));
        }
    }


    function controllerDocsDelete($idTarchivo){
        $content = $this->dbcontext->DeleteDocs($idTarchivo);
        if($content == ""){
            return json_encode(array('estatus'=>"not found",
            'info'=>"not Remove",
            'contenido'=>null));
        }else{
            return json_encode(array('estatus'=>"ok",
            'info'=>"docs Remove",
            'contenido'=>$content));
        }
    }

    function controllerDocsPost($input){
        $content = $this->dbcontext->postDocs($input);
        return json_encode(array('estatus'=>"ok",
        'info'=>"Examen creado para la sucursal",
        'contenido'=>null));
    }

    function controllerDocsPatch($input){
        $content = $this->dbcontext->patchDocs($input);
        return json_encode(array('estatus'=>"ok",
        'info'=>"Examen creado para la sucursal",
        'contenido'=>null));
    }
}
