<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS, PATCH, DELETE');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With');
    require "../../../Config/Database.php";
    require "../../../Models/Response.php";

    $validRequest = true;
    $response = new Response();


    if(!isset($_GET['periodo'])){
        $validRequest = false;
        $response->mensaje = "Parametro necesario.";
        echo json_encode($response);
    }

    if($validRequest){
        try{
            $bd = new Database();
            $periodo = $_GET['periodo'];
            //Consulta SQL
            //echo "SELECT valor, resultado FROM texamenesempleados WHERE cve_periodo = $periodo and cve_examen = 1";
            $query = "SELECT valor, resultado FROM texamenesempleados WHERE cve_periodo = :periodo and cve_examen = 1";
            $request = $bd->connect()->prepare($query);
            $request->bindParam(':periodo', $periodo);
            $request->execute();
            $result = $request->fetchAll(PDO::FETCH_ASSOC);
            //variables de resultados para grafica de atenciones
            $accidente = $asaltos = $actosViolentos = $secuestro = $amenazas =
            $cualquier = $recuerdos = $sueños = $evsentimientos = $actividades = 
            $recordar = $interes = $alejado = $sentimientos = $expresar = $vida = 0;
            $requiere = 0;
            $norequiere = 0;

            for($x = 0; $x < count($result); $x++){
                $respuestasRaw =  json_encode($result[$x]);
                $respuestasRaw = json_decode($respuestasRaw);
                $respuestas = json_decode($respuestasRaw->valor);
                $resultado = json_decode($respuestasRaw->resultado);
                $resultado = $resultado->resultado;

                if($resultado === "No requiere valoración clinica"){
                    $norequiere ++;
                }else{
                    $requiere++;
                }

                if($respuestas->p1 === 'Si'){
                    $accidente ++;
                }

                if($respuestas->p2 === 'Si'){
                    $asaltos ++;
                }

                if($respuestas->p3 === 'Si'){
                    $actosViolentos ++;
                }

                if($respuestas->p4 === 'Si'){
                    $secuestro ++;
                }

                if($respuestas->p5 === 'Si'){
                    $amenazas ++;
                }

                if($respuestas->p6 === 'Si'){
                    $cualquier ++;
                }

                if($respuestas->p7 === 'Si'){
                    $recuerdos ++;
                }
                
                if($respuestas->p8 === 'Si'){
                    $sueños ++;
                }

                if($respuestas->p9 === 'Si'){
                    $sueños ++;
                }

                if($respuestas->p10 === 'Si'){
                    $evsentimientos ++;
                }

                if($respuestas->p11 === 'Si'){
                    $actividades ++;
                }

                if($respuestas->p12 === 'Si'){
                    $recordar ++;
                }

                if($respuestas->p13 === 'Si'){
                    $interes ++;
                }

                if($respuestas->p14 === 'Si'){
                    $alejado ++;
                }

                if($respuestas->p15 === 'Si'){
                    $sentimientos ++;
                }

                
                if($respuestas->p16 === 'Si'){
                    $expresar ++;
                }

                
                if($respuestas->p17 === 'Si'){
                    $vida ++;
                }
            }

            $negativo = new stdClass;
            $negativo->name = "No atención";
            $negativo->value = $norequiere;
    
    
            $positivo = new stdClass;
            $positivo->name = "Atención";
            $positivo->value = $requiere;

            $generales = array(
                'accidente'=>$accidente,
                'asaltos'=>$asaltos,
                'actosViolentos'=>$actosViolentos,
                'secuestros'=>$secuestro,
                'amenazas'=>$amenazas,
                'cualquier'=>$cualquier,
                'evsentimientos'=>$evsentimientos,
                'evactividades'=>$actividades,
                'recordar'=>$recordar,
                'interes'=>$interes,
                'alejado'=>$alejado,
                'sentimientos'=>$sentimientos,
                'expresar'=>$expresar,
                'vida'=>$vida
            );
            $response->estatus = "ok";
            $response->mensaje = "Resultados procesados.";
            $response->contenido = array($negativo, $positivo,$generales);
            echo json_encode($response);



        }catch(Exception $e){
            $response->estatus = "error";
            $response->mensaje = $e;
            echo json_encode($response);
        }
    }




?>