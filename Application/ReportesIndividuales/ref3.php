<?php
require '../../Config/Database.php';
class Ref3 extends Database{

    function getReporte($periodo,$sucursal,$opc){
        $select = "";
        $orderby = " e.nombre ";
        $innerjoin = " ";
        $where = " ";

        //con podemos cambiar de enfoque en la consulta que se requiera, de acuerdo al filtro
        switch ($opc) {
            case 1:
                //el case when, es un  if else
                $select = ", (CASE WHEN (edad =0 ) THEN 'N/A' ELSE edad  END) edad";  
                $orderby = " edad ";  
                break;
            case 2:
                //de la opcion dos para abajo, los nombramos como x, para no usar mucho codigo, en otros codigos
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
        //nomas aplica cuando se selecciona una sucrusal
        if($sucursal != 0){
            $where = " and e.cve_sucursal = ".$sucursal; 
        }

        
        $query = "select exem.resultado,e.nombre, s.nombre as sucursal ,concat(LPAD(s.cve_sucursal, 6, 0),LPAD(e.cve_empleado, 6, 0)) as clave   ".$select." from texamenesempleados exem 
        inner join templeado e on e.cve_empleado = exem.cve_empleado 
        inner join tsucursal s on s.cve_sucursal = e.cve_sucursal 
        ".$innerjoin."
        where cve_periodo = :periodo  and cve_examen  = 2 ".$where." order by ".$orderby." asc";
       

        $sql = $this->connect()->prepare($query);
        $sql->bindParam(':periodo',$periodo);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        $response = [];

        for($i = 0; $i < count($result); $i++){
            //empezamos a crear variables con el array asociativo
            $partial = json_encode($result[$i]);
            $aux =  json_decode($partial);
            //creamos variables directamente, para incluirlo en el json que se enviara
            
            $valores =  $aux->resultado;
            $nombre = $aux->nombre;
            $sucursal = $aux->sucursal;
            $clave = $aux->clave;

            //verificamos que opcion (consulta) es la que se esta pidiendo
            if($opc ==1){
                $edad = $aux -> edad;
            } else if($opc >=2 && $opc <7){
                $x = $aux -> x;
            }

            //recorremos el json que esta en el mysql
            $valus = json_decode($valores);
            for($k = 0; $k <count($valus);$k++){
                //identificamos los dominios y lo recorremos
                $rawDominios =  $valus[$k]->dominios;

                for($y=0;$y< count($rawDominios);$y++){
                    //guardamos los datos del dominio
                    $dominio =  $rawDominios[$y]->nombre;
                    $id =  $rawDominios[$y]->id;
                    $valor =  $rawDominios[$y]->items;
                    $nivel = $this->evaluaDominio($valor,$id);

                    //despues los empujamos al array, con los datos de la consulta principal y los datos del dominio.
                    if($opc ==1){
                        array_push($response,array("nombre"=>$nombre,"clave"=>$clave, "dominio"=>$dominio,"calificacion"=>$valor,"afectacion"=>$nivel,"edad"=>$edad));
                    } else if($opc >=2 && $opc <7){
                        array_push($response,array("nombre"=>$nombre,"clave"=>$clave,"dominio"=>$dominio,"calificacion"=>$valor,"afectacion"=>$nivel,"x"=>$x));
                    }else{
                        array_push($response,array("nombre"=>$nombre,"clave"=>$clave,"dominio"=>$dominio,"calificacion"=>$valor,"afectacion"=>$nivel));
                    }
                }
            }
        }

        return $response;
    }

    function evaluaDominio($item,$id){
        switch($id){
          case 1:
             if($item <5)
             return 'Nulo';
             if($item <= 5 || $item<9)
             return 'Bajo';
             if($item <= 9 || $item<11)
             return 'Medio';
             if($item <= 11 || $item<14)
             return 'Alto';
             if($item>=14)
             return 'Muy Alto';
            break;
            case 2:
              if($item <15)
              return 'Nulo';
              if($item <= 15 || $item<21)
              return 'Bajo';
              if($item <= 21 || $item<27)
              return 'Medio';
              if($item <= 27 || $item<37)
              return 'Alto';
              if($item>=37)
              return 'Muy Alto';
             break;
             case 3:
              if($item <11)
              return 'Nulo';
              if($item <=11 || $item<16)
              return 'Bajo';
              if($item <= 16|| $item<21)
              return 'Medio';
              if($item <= 21 || $item<25)
              return 'Alto';
              if($item>=25)
              return 'Muy Alto';
             break;
             case 4:
              if($item <1)
              return 'Nulo';
              if($item <=1 || $item<2)
              return 'Bajo';
              if($item <= 2|| $item<4)
              return 'Medio';
              if($item <= 4 || $item<6)
              return 'Alto';
              if($item>=6)
              return 'Muy Alto';
             break;
             case 5:
              if($item <4)
              return 'Nulo';
              if($item <=4 || $item<6)
              return 'Bajo';
              if($item <= 6|| $item<8)
              return 'Medio';
              if($item <= 8 || $item<10)
              return 'Alto';
              if($item>=10)
              return 'Muy Alto';
             break;
             case 6:
              if($item <9)
              return 'Nulo';
              if($item <=9 || $item<12)
              return 'Bajo';
              if($item <= 12|| $item<16)
              return 'Medio';
              if($item <= 16 || $item<20)
              return 'Alto';
              if($item>=20)
              return 'Muy Alto';
             break;
             case 7:
              if($item <10)
              return 'Nulo';
              if($item <=10 || $item<13)
              return 'Bajo';
              if($item <= 13|| $item<17)
              return 'Medio';
              if($item <= 17 || $item<21)
              return 'Alto';
              if($item>=21)
              return 'Muy Alto';
             break;
             case 8:
              if($item <7)
              return 'Nulo';
              if($item <=7 || $item<10)
              return 'Bajo';
              if($item <= 10|| $item<13)
              return 'Medio';
              if($item <= 13 || $item<16)
              return 'Alto';
              if($item>=16)
              return 'Muy Alto';
             break;
             case 9:
              if($item <6)
              return 'Nulo';
              if($item <=6 || $item<10)
              return 'Bajo';
              if($item <= 10|| $item<14)
              return 'Medio';
              if($item <= 14 || $item<18)
              return 'Alto';
              if($item>=18)
              return 'Muy Alto';
             break;
             case 10:
              if($item <4)
              return 'Nulo';
              if($item <=4 || $item<6)
              return 'Bajo';
              if($item <= 6|| $item<8)
              return 'Medio';
              if($item <= 8 || $item<10)
              return 'Alto';
              if($item>=10)
              return 'Muy Alto';
             break;
        }
        return "";
      }

}

?>