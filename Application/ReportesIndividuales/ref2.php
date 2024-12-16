<?php
require '../../Config/Database.php';
class Ref2 extends Database{
    //las instrucciones son las mismas que las de ref3.php
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
        $query = "select exem.resultado,e.nombre, s.nombre as sucursal , concat(LPAD(s.cve_sucursal, 6, 0),LPAD(e.cve_empleado, 6, 0)) as clave ".$select." from texamenesempleados exem 
        inner join templeado e on e.cve_empleado = exem.cve_empleado 
        inner join tsucursal s on s.cve_sucursal = e.cve_sucursal 
        ".$innerjoin."
        where cve_periodo = :periodo  and cve_examen  = 3 ".$where." order by ".$orderby." asc";
        
       
        $sql = $this->connect()->prepare($query);
        $sql->bindParam(':periodo',$periodo);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        $response = [];
        for($z = 0; $z < count($result); $z++){
            $partial = json_encode($result[$z]);
            $aux =  json_decode($partial);
            $valores =  $aux->resultado;
            $nombre = $aux->nombre;
            $sucursal = $aux->sucursal;
            $clave = $aux->clave;

            if($opc ==1){
                $edad = $aux -> edad;
            } else if($opc >=2 && $opc <7){
                $x = $aux -> x;
            }
            $valus = json_decode($valores);
            for($i = 0; $i <count($valus);$i++){
                $rawDominios =  $valus[$i]->dominios;
                for($y=0;$y< count($rawDominios);$y++){
                    $dominio =  $rawDominios[$y]->nombre;
                    $id =  $rawDominios[$y]->id;
                    $valor =  $rawDominios[$y]->items;
                    
                    $nivel = $this->evaluaDominio($valor,$id);

                    if($opc ==1){
                        array_push($response,array("nombre"=>$nombre,"clave"=>$clave, "dominio"=>$dominio,"calificacion"=>$valor,"afectacion"=>$nivel,"edad"=>$edad));
                    } else if($opc >=2 && $opc <7){
                        array_push($response,array("nombre"=>$nombre,"clave"=>$clave, "dominio"=>$dominio,"calificacion"=>$valor,"afectacion"=>$nivel,"x"=>$x));
                    }else{
                        array_push($response,array("nombre"=>$nombre,"clave"=>$clave, "dominio"=>$dominio,"calificacion"=>$valor,"afectacion"=>$nivel));
                    }
                   
                }
            }
        }

        return $response;
    }

    function evaluaDominio($item,$id):string{
        switch($id){
          case 1:
             if($item <3)
             return 'Nulo';
             if($item <= 3 || $item<5)
             return 'Bajo';
             if($item <= 5 || $item<7)
             return 'Medio';
             if($item <= 7 || $item<9)
             return 'Alto';
             if($item>=9)
             return 'Muy Alto';
            break;
            case 2:
              if($item <12)
              return 'Nulo';
              if($item <= 12 || $item<16)
              return 'Bajo';
              if($item <= 5 || $item<7)
              return 'Medio';
              if($item <= 7 || $item<9)
              return 'Alto';
              if($item>=9)
              return 'Muy Alto';
             break;
             case 3:
              if($item <5)
              return 'Nulo';
              if($item <=5 || $item<8)
              return 'Bajo';
              if($item <= 8|| $item<11)
              return 'Medio';
              if($item <= 11 || $item<14)
              return 'Alto';
              if($item>=14)
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
             case 6:
              if($item <3)
              return 'Nulo';
              if($item <=3 || $item<5)
              return 'Bajo';
              if($item <= 5|| $item<8)
              return 'Medio';
              if($item <= 8 || $item<11)
              return 'Alto';
              if($item>=11)
              return 'Muy Alto';
             break;
             case 7:
              if($item <5)
              return 'Nulo';
              if($item <=5 || $item<8)
              return 'Bajo';
              if($item <= 8|| $item<11)
              return 'Medio';
              if($item <= 11 || $item<14)
              return 'Alto';
              if($item>=14)
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
             
        }
        return "";
      }

}

?>