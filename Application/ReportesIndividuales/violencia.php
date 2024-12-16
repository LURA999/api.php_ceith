<?php
require '../../Config/Database.php';
class Violencia extends Database{
        //cuando se hace la consulta  principal de la variable $query, las instrucciones se pueden ver en el archivo ref3.php
        function getReporte($periodo,$sucursal,$opc){
        $select = "";
        $orderby = " e.nombre ";
        $innerjoin = " ";
        $where = " ";
        switch ($opc) {
            case 1:
                $select = ", (CASE WHEN (edad =0 ) THEN 'N/A' ELSE edad  END) edad";  
                $orderby = " edad ";  
                break;
            case 2:
                $select = ",  (CASE WHEN (escolaridad = '' )  THEN 'N/A' when (escolaridad is  null ) then 'N/A' ELSE escolaridad  END) x  ";    
                $orderby = " escolaridad ";
                break;
            case 3:
                $select = ", (CASE WHEN (estado_civil = '' )  THEN 'N/A' when (estado_civil is  null ) then 'N/A' ELSE estado_civil  END) x  ";    
                $orderby = " estado_civil ";
                break;
            case 4:
                $select = ",  (CASE WHEN (tp.descripcion = '' )  THEN 'N/A' when (tp.descripcion is  null ) then 'N/A' ELSE tp.descripcion  END) x ";    
                $orderby = " tp.descripcion ";
                $innerjoin = " inner join tpuesto tp on tp.cve_puesto = e.cve_puesto ";
                break;
            case 5:
                $select = ", (CASE WHEN (sexo = '' )  THEN 'N/A' when (sexo is  null ) then 'N/A' ELSE sexo  END) x ";    
                $orderby = " sexo ";
                break;  
            case 6:
                $select = ", (CASE WHEN (tipo_jornada = '' )  THEN 'N/A' when (tipo_jornada is  null ) then 'N/A' ELSE tipo_jornada  END) x  ";   
                $orderby = " tipo_jornada "; 
                break;  
        }

        if($sucursal != 0){
            $where = " and e.cve_sucursal = ".$sucursal; 
        }

        $query = "select exem.resultado,e.nombre, s.nombre as sucursal ".$select.",concat(LPAD(s.cve_sucursal, 6, 0),LPAD(e.cve_empleado, 6, 0)) as clave from texamenesempleados exem 
        inner join templeado e on e.cve_empleado = exem.cve_empleado 
        inner join tsucursal s on s.cve_sucursal = e.cve_sucursal 
        ".$innerjoin."
        where cve_periodo = :periodo  and cve_examen  = 4 ".$where." order by ".$orderby." asc";
       
        $sql = $this->connect()->prepare($query);
        $sql->bindParam(':periodo',$periodo);
        $sql->execute();
        //esta ves se usa PDO::FETCH_OBJ
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        $response = array();
        $response = [];

        foreach($result as $resultado){
            $valor = 0;
            $jsonraw = json_encode($resultado);
            $json = json_decode($jsonraw);
            $value = json_decode($json->resultado);
            $nombre = $json->nombre;
            $clave = $json->clave;
            $valorRedondo = round($value->calificacion);
            $decimales = $value->calificacion - $valorRedondo;
            $objAux = new stdClass;

           /*en este if identificamos las variables que queremos, de acuerdo a la consulta del filtro
           seleccionado en el select del fronted */
            if($opc ==1){
                $edad = $json -> edad;
                $objAux->edad = $edad;
            } else if($opc >=2 && $opc <7){
                $x = $json -> x;
                $objAux->x = $x;            
            }
            //redondeamos el decimales y detectamos el nivel de aferctacion.
            if($decimales < 0.5){
                $valor = round($value->calificacion);
            }else{
                $valor = ceil($value->calificacion);
            }
            
            
            if($valor<=2){
                $objAux->afectacion = "Leve o inexistente";
            }

            if($valor>2 && $valor<=4){
                $objAux->afectacion = "Medio";
            }

            if($valor > 4){
               $objAux->afectacion = "Grave";
            }
            //las variables reunidas se juntaran para usarlas en el typescript
            $objAux->nombre = $nombre;
            $objAux->clave = $clave;
            $objAux->calificacion = $valor;
            array_push($response,$objAux);
        }

        return json_encode($response);
    }

}

?>