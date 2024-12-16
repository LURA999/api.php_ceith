<?php

include_once '../Application/Login.php';

class LoginController
{

    function login($user, $password)
    {
        $login = new Login();
        $response = $login->getUserData($user, $password);
        if($response == false){
            return "";
        }
        return $this->createToken($response);
    }

    function loginEmpleado($centro, $empleado, $numero)
    {
        $login = new Login();
        $result = $login->getEmpleado($centro, $empleado, $numero);
        if($result == ""){
            return  json_encode(array('estatus'=>"not found",
            'info'=>"Sin resultados",
            'contenido'=>null));
        }else{
            return  json_encode(array('estatus'=>"ok",
            'info'=>"Empleado encontrado",
            'contenido'=>$this->createTokenEmpleado($result)));
        }
    }


    function createToken($info)
    {
        $headers = ['alg' => 'HS256', 'typ' => 'JWT'];
        $headers_encoded = base64_encode(json_encode($headers));

        $payload = ['cve_usuario' => $info['cve_usuario'], 'nombre'=> $info['nombre'],'correo'=> $info['email'],'perfil' => 1, 'expire'=>microtime(true)];
        $payload_encoded = base64_encode(json_encode($payload));

        $key = 'secret';
        $signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $key, true);
        $signature_encoded = base64_encode($signature);

        $token = "$headers_encoded.$payload_encoded.$signature_encoded";
        return $token;
    }

    function createTokenEmpleado($info)
    {
        $headers = ['alg' => 'HS256', 'typ' => 'JWT'];
        $headers_encoded = base64_encode(json_encode($headers));

        $payload = ['cve_empleado' => $info['cve_empleado'], 
        'nombre'=> $info['nombre'],
        'empresa'=>$info['empresa'],
        'sucursal'=> $info['sucursal'],
        'cve_sucursal'=> $info['csucursal'],
        'cve_empresa'=> $info['cempresa'],
        'puesto'=> $info['puesto'],
        'departamento'=> $info['departamento'],
        'sucursal'=> $info['sucursal'],
        'administrador'=> $info['administrador'],
        'perfil'=> 0,
        'periodo'=> $info['periodo'],
        'expire'=>time()+(24*60*60)];
        $payload_encoded = base64_encode(json_encode($payload));

        $key = 'nom037red7ceith';
        $signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $key, true);
        $signature_encoded = base64_encode($signature);

        $token = "$headers_encoded.$payload_encoded.$signature_encoded";
        return $token;
    }

    function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}

?>