<?php
include "../Config/Config.php";
include "../Controllers/EmpleadosController.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try{  
    $controlador = new EmpleadoController();
    $params = json_decode(file_get_contents('php://input'), true);
        foreach($params as $obj){
            $empleado = 
            [
                'cve_puesto'=> $obj["cve_puesto"],
                'cve_departamento'=>$obj["cve_departamento"],
                'cve_sucursal' =>$obj["cve_sucursal"],
                'seccion_area' =>$obj["seccion_area"],
                'tipo_puesto ' =>$obj["tipo_puesto"],
                'nombre'=>$obj["nombre"],
                'edad'=>$obj["edad"],
                'no_dependientes'=>$obj["no_dependientes"],
                'experiencia_actual'=>$obj["experiencia_actual"],
                'experiencia_laboral'=>$obj["experiencia_laboral"],
                'tipo_contratacion'=>$obj["tipo_contratacion"],
                'cantidad_de_trabajos'=>$obj["cantidad_de_trabajos"],
                'sexo'=>$obj["sexo"],
                'estado_civil'=>$obj["estado_civil"],
                'escolaridad'=>$obj["escolaridad"],
                'no_personas_acargo'=>$obj["no_personas_acargo"],
                'horas_diarias_laboradas'=>$obj["horas_diarias_laboradas"],
                'numero_empleado'=>$obj["numero_empleado"],
                'tipo_personal'=>$obj["tipo_personal"],
                'rota_turnos'=>$obj["rota_turnos"],
                'tipo_jornada'=>$obj["tipo_jornada"],
                'otros'=>$obj["otros"],
                'administrador'=>$obj["administrador"],
                'password'=>generateRandomString(),
            ] ;
            $controlador->agregarEmpleado($empleado);
        }
        echo json_encode(array('estatus'=>"ok",
            'info'=>"Carga exitosa",
            'contenido'=>null));
        
    }catch(Exception $e){
        json_encode(array('estatus'=>"error",
        'info'=>"Error en servidor",
        'contenido'=>$e));
    }
}

function generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


