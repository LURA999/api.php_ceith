<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS, PATCH, DELETE');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With');
    require "../../../Config/Database.php";
    require "../../../Models/Response.php";

    $validRequest = true;
    $response = new Response();

    if(!isset($_GET['empresa']) && !isset($_GET['sucursal'])){
        $validRequest = false;
        $response->mensaje = "Parametro necesario.";
        echo json_encode($response);
    }



    if($validRequest){
        try{
            $bd = new Database();
            $sucursal = 0;
            $query = "";

            if(isset($_GET['sucursal'])){
                $sucursal = $_GET['sucursal'];
            }

            if(isset($_GET['empresa'])){
                $empresa = $_GET['empresa'];
            }
            
            //OBTENER SEXO
            $request = $bd->connect();
            if($sucursal > 0){
                $query = "SELECT (CASE WHEN (sexo = '' )  THEN 'N/A' when (sexo is  null ) then 'N/A' ELSE sexo  END) sexo,COUNT(IFNULL(sexo,'')) as total, 
                ((count(IFNULL(sexo,''))/
                    (SELECT COUNT(cve_empleado) from templeado emp INNER JOIN tsucursal s ON emp.cve_sucursal = s.cve_sucursal WHERE s.cve_sucursal = :sucursal))*100) as porcentaje
                    FROM templeado emp INNER JOIN tsucursal s ON emp.cve_sucursal = s.cve_sucursal WHERE s.cve_sucursal = :sucursal GROUP BY sexo;";
                    $request  = $request->prepare($query);
                    $request->bindParam(':sucursal', $sucursal);
            }else{
                $query = "SELECT (CASE WHEN (sexo = '' )  THEN 'N/A' when (sexo is  null ) then 'N/A' ELSE sexo  END) sexo ,COUNT(IFNULL(sexo,'')) as total, 
                ((count(IFNULL(sexo,''))/
                    (SELECT COUNT(cve_empleado) from templeado emp INNER JOIN tsucursal s ON emp.cve_sucursal = s.cve_sucursal INNER JOIN tempresa e ON s.cve_empresa=e.cve_empresa WHERE e.cve_empresa = :empresa))*100) as porcentaje
                    FROM templeado emp INNER JOIN tsucursal s ON emp.cve_sucursal = s.cve_sucursal INNER JOIN tempresa e ON s.cve_empresa=e.cve_empresa WHERE e.cve_empresa = :empresa GROUP BY sexo;";
                $request  = $request->prepare($query);
                $request->bindParam(':empresa', $empresa);
            }

            $request->execute();
            $sexo = $request->fetchAll(PDO::FETCH_ASSOC);

            //OBTENER POR ESTADO CIVIL
            $request = $bd->connect();
            if($sucursal > 0){
                $query = "SELECT (CASE WHEN (estado_civil = '' )  THEN 'N/A' when (estado_civil is  null ) then 'N/A' ELSE estado_civil  END) estado_civil ,COUNT(IFNULL(estado_civil,''))  as total, 
                ((count(IFNULL(estado_civil,''))/
                    (SELECT COUNT(cve_empleado) from templeado emp INNER JOIN tsucursal s ON emp.cve_sucursal = s.cve_sucursal WHERE s.cve_sucursal = :sucursal))*100) as porcentaje
                    FROM templeado emp INNER JOIN tsucursal s ON emp.cve_sucursal = s.cve_sucursal WHERE s.cve_sucursal = :sucursal GROUP BY estado_civil;";
                    $request  = $request->prepare($query);
                    $request->bindParam(':sucursal', $sucursal);
            }else{
                $query = "SELECT (CASE WHEN (estado_civil = '' )  THEN 'N/A' when (estado_civil is  null ) then 'N/A' ELSE estado_civil  END) estado_civil,COUNT(IFNULL(estado_civil,'')),COUNT(IFNULL(estado_civil,'')) as total, 
                ((count(IFNULL(estado_civil,''))/
                    (SELECT COUNT(cve_empleado) from templeado emp INNER JOIN tsucursal s ON emp.cve_sucursal = s.cve_sucursal INNER JOIN tempresa e ON s.cve_empresa=e.cve_empresa WHERE e.cve_empresa = :empresa))*100) as porcentaje
                    FROM templeado emp INNER JOIN tsucursal s ON emp.cve_sucursal = s.cve_sucursal INNER JOIN tempresa e ON s.cve_empresa=e.cve_empresa WHERE e.cve_empresa = :empresa GROUP BY estado_civil;";
                $request  = $request->prepare($query);
                $request->bindParam(':empresa', $empresa);
            }

            $request->execute();
            $estadoCivil = $request->fetchAll(PDO::FETCH_ASSOC);
            //Obtener escolaridad
            $request = $bd->connect();
            if($sucursal > 0){
                $query = "SELECT (CASE WHEN (escolaridad = '' )  THEN 'N/A' when (escolaridad is  null ) then 'N/A' ELSE escolaridad  END) escolaridad,COUNT(IFNULL(escolaridad,'')),COUNT(IFNULL(escolaridad,'')) as total, 
                ((count(IFNULL(escolaridad,''))/
                    (SELECT COUNT(IFNULL(escolaridad,'')) from templeado emp INNER JOIN tsucursal s ON emp.cve_sucursal = s.cve_sucursal WHERE s.cve_sucursal = :sucursal))*100) as porcentaje
                    FROM templeado emp INNER JOIN tsucursal s ON emp.cve_sucursal = s.cve_sucursal WHERE s.cve_sucursal = :sucursal GROUP BY escolaridad;";
                    $request  = $request->prepare($query);
                    $request->bindParam(':sucursal', $sucursal);
            }else{
                $query = "SELECT (CASE WHEN (escolaridad = '' )  THEN 'N/A' when (escolaridad is  null ) then 'N/A' ELSE escolaridad  END) escolaridad,COUNT(IFNULL(escolaridad,'')) as total, 
                ((count(IFNULL(escolaridad,''))/
                    (SELECT COUNT(cve_empleado) from templeado emp INNER JOIN tsucursal s ON emp.cve_sucursal = s.cve_sucursal INNER JOIN tempresa e ON s.cve_empresa=e.cve_empresa WHERE e.cve_empresa = :empresa))*100) as porcentaje
                    FROM templeado emp INNER JOIN tsucursal s ON emp.cve_sucursal = s.cve_sucursal INNER JOIN tempresa e ON s.cve_empresa=e.cve_empresa WHERE e.cve_empresa = :empresa GROUP BY escolaridad;";
                $request  = $request->prepare($query);
                $request->bindParam(':empresa', $empresa);
            }

            $request->execute();
            $escolaridad = $request->fetchAll(PDO::FETCH_ASSOC);
            $result = array($sexo,$estadoCivil,$escolaridad);
            echo json_encode($result);


        }catch(Exception $e){
            $response->estatus = "error";
            $response->mensaje = $e;
            echo json_encode($response);
        }
    }




?>