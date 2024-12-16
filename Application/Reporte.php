<?php
require '../Config/Database.php';
class Reporte extends Database{

    function examenesPorPeriodo($periodo){
        $query = "select distinct ep.cve_examen, ex.descripcion from texamenesempleados ep inner join texamen ex on ep.cve_examen = ex.cve_examen where ep.cve_periodo = :periodo";
        $sql = $this->connect()->prepare($query);
        $sql->bindParam(':periodo',$periodo);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function poblacionSexo($cve_periodo, $cve_sucursal){
        $query = "select emp.sexo, count(emp.cve_empleado) as cantidad from templeado emp
        inner join tsucursal s on emp.cve_sucursal = s.cve_sucursal
        inner join tempresa e on e.cve_empresa = s.cve_empresa
        inner join tperiodo p on e.cve_empresa = e.cve_empresa
        where p.cve_periodo = :periodo";
        if($cve_sucursal == '0' || $cve_sucursal == NULL){
            $query = $query . ' group by emp.sexo';
            $sql = $this->connect()->prepare($query);
            $sql->bindParam(':periodo',$cve_periodo);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }else{
            $query = $query . ' and s.cve_sucursal = :sucursal group by emp.sexo';
            $sql = $this->connect()->prepare($query);
            $sql->bindParam(':periodo',$cve_periodo);
            $sql->bindParam(':sucursal',$cve_sucursal);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }

    function poblacionPuesto($cve_periodo, $cve_sucursal){
        $query = "select pu.descripcion as puesto, count(emp.cve_puesto) as cantidad from templeado emp
        inner join tsucursal s on emp.cve_sucursal = s.cve_sucursal
        inner join tempresa e on e.cve_empresa = s.cve_empresa
        inner join tperiodo p on e.cve_empresa = e.cve_empresa
        left join tpuesto pu on pu.cve_puesto = emp.cve_puesto
        where p.cve_periodo = :periodo";
        if($cve_sucursal == '0' || $cve_sucursal == NULL){
            $query = $query . ' group by pu.descripcion';
            $sql = $this->connect()->prepare($query);
            $sql->bindParam(':periodo',$cve_periodo);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }else{
            $query = $query . ' and s.cve_sucursal = :sucursal group by pu.descripcion';
            $sql = $this->connect()->prepare($query);
            $sql->bindParam(':periodo',$cve_periodo);
            $sql->bindParam(':sucursal',$cve_sucursal);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }

    function poblacionEdad($cve_periodo, $cve_sucursal){
        $query = "select pu.edad as puesto, count(emp.cve_puesto) as cantidad from templeado emp
        inner join tsucursal s on emp.cve_sucursal = s.cve_sucursal
        inner join tempresa e on e.cve_empresa = s.cve_empresa
        inner join tperiodo p on e.cve_empresa = e.cve_empresa
        left join tpuesto pu on pu.cve_puesto = emp.cve_puesto
        where p.cve_periodo = :periodo";
        if($cve_sucursal == '0' || $cve_sucursal == NULL){
            $query = $query . ' group by pu.edad';
            $sql = $this->connect()->prepare($query);
            $sql->bindParam(':periodo',$cve_periodo);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }else{
            $query = $query . ' and s.cve_sucursal = :sucursal group by pu.edad';
            $sql = $this->connect()->prepare($query);
            $sql->bindParam(':periodo',$cve_periodo);
            $sql->bindParam(':sucursal',$cve_sucursal);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }

    function datosEmpresa($cve_empresa, $cve_periodo){

        $query = "select emp.nombre, emp.actividad_principal, emp.denominacion,
        emp.objetivo,emp.domicilio, (select count(x.cve_empleado) from templeado x inner join tsucursal s on s.cve_sucursal = x.cve_sucursal
        where s.cve_empresa = emp.cve_empresa) as noempleados, p.fecha_inicio, p.fecha_fin
        from tempresa emp inner join tperiodo p on p.cve_empresa = emp.cve_empresa where emp.cve_empresa = :empresa and p.cve_periodo = :periodo ";
        $sql = $this->connect()->prepare($query);
        $sql->bindParam(':empresa',$cve_empresa);
        $sql->bindParam(':periodo',$cve_periodo);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
      //  echo var_dump($result);
        return $result;
    }

    function ats($periodo){
        $query = "select resultado from texamenesempleados where cve_periodo = :periodo and cve_examen = 1";
        $sql = $this->connect()->prepare($query);
        $sql->bindParam(':periodo',$periodo);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        $requiere = 0;
        $norequiere = 0;
        foreach($result as $resultado){
            $jsonraw= json_encode($resultado,true);
            $json =  json_decode($jsonraw);
            $result = json_decode($json->resultado);
            $result = $result->resultado;
            if($result == "No requiere valoración clinica"){
                $norequiere = $norequiere +1;
            }else{
                $requiere = $requiere +1;
            }
        }

        $negativo = new stdClass;
        $negativo->name = "No atención";
        $negativo->value = $norequiere;


        $positivo = new stdClass;
        $positivo->name = "Atención";
        $positivo->value = $requiere;

        $response = array($negativo, $positivo);
        return json_encode($response);
    }

    function violencia($periodo){
        $query = "select resultado from texamenesempleados where cve_periodo = :periodo and cve_examen = 4";
        $sql = $this->connect()->prepare($query);
        $sql->bindParam(':periodo',$periodo);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_OBJ);
        $bajos = 0;
        $altos = 0;
        $graves = 0;
        $valor = 0;
        foreach($result as $obj){
            $jsonraw = json_encode($obj);
            $json = json_decode($jsonraw);
            $value = json_decode($json->resultado);
            $valorRedondo = round($value->calificacion);
            $decimales = $value->calificacion - $valorRedondo;
            if($decimales < 0.5){
                $valor = round($value->calificacion);
            }else{
                $valor = ceil($value->calificacion);
            }

            if($valor<=2){
                $bajos = $bajos +1;
            }

            if($valor>2 && $valor<=4){
                $altos = $altos +1;
            }

            if($valor > 4){
                $graves = $graves +1;
            }
        }

        $leve = new stdClass;
        $leve->name = "Leve o inexistente";
        $leve->value = $bajos;


        $medio = new stdClass;
        $medio->name = "Medio";
        $medio->value = $altos;

        $grave = new stdClass;
        $grave->name = "Grave";
        $grave->value = $altos;

        $response = array($leve, $medio,$grave);

        return json_encode($response);
    }

    function ref3($periodo){
        //valores totales
        $EvaluacionTotal = new stdClass;
        $EvaluacionTotal->nulos = 0;
        $EvaluacionTotal->bajo = 0;
        $EvaluacionTotal->medio = 0;
        $EvaluacionTotal->alto = 0;
        $EvaluacionTotal->muyalto = 0;
        //ambiente de trabajo
        $ambiente = new stdClass;
        $ambiente->nulos = 0;
        $ambiente->bajo = 0;
        $ambiente->medio = 0;
        $ambiente->alto = 0;
        $ambiente->muyalto = 0;
        //factores
        $factores = new stdClass;
        $factores->nulos = 0;
        $factores->bajo = 0;
        $factores->medio = 0;
        $factores->alto = 0;
        $factores->muyalto = 0;
        //organizacion
        $organizacion = new stdClass;
        $organizacion->nulos = 0;
        $organizacion->bajo = 0;
        $organizacion->medio = 0;
        $organizacion->alto = 0;
        $organizacion->muyalto = 0;
        //liderazgo
        $liderazgo = new stdClass;
        $liderazgo->nulos = 0;
        $liderazgo->bajo = 0;
        $liderazgo->medio = 0;
        $liderazgo->alto = 0;
        $liderazgo->muyalto = 0;
        //entorno
        $entorno = new stdClass;
        $entorno->nulos = 0;
        $entorno->bajo = 0;
        $entorno->medio = 0;
        $entorno->alto = 0;
        $entorno->muyalto = 0;

        $query = "select resultado from texamenesempleados where cve_periodo= :periodo and cve_examen = 2";
        $sql = $this->connect()->prepare($query);
        $sql->bindParam(':periodo',$periodo);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        for($i = 0; $i < count($result); $i++){
            $partial = json_encode($result[$i]);
            $aux =  json_decode($partial);
            $valores =  $aux->resultado;
            $valus = json_decode($valores);
            $sumaTotal = 0;
            $co = 0;

            foreach($valus as $doms){
                $co = $co + 1;
                $sumaTotal = $sumaTotal + $doms->items;
            
                if($doms->id == 1){
                    $val = $doms->items;
                    if($val < 5){
                        $ambiente->nulos = $ambiente->nulos +1;
                        
                    }
                    if($val >=5 && $val < 9){
                        $ambiente->bajo = $ambiente->bajo +1;
                    }
                    if($val >=9 && $val < 11){
                        $ambiente->medio = $ambiente->medio +1;
                    }
                    if($val >=11 && $val < 14){
                        $ambiente->alto = $ambiente->alto +1;
                    }
                    if($val >= 14){
                        $ambiente->muyalto = $ambiente->muyalto +1;
                    }
                }

                if($doms->id == 2){

                    $val = $doms->items;
                    if($val < 15){
                        $factores->nulos = $factores->nulos +1;
                    }
                    if($val >=15 && $val < 30){
                        $factores->bajo = $factores->bajo +1;
                    }
                    if($val >=30 && $val < 45){
                        $factores->medio = $factores->medio +1;
                    }
                    if($val >=45 && $val < 60){
                        $factores->alto = $factores->alto +1;
                    }
                    if($val >= 60){
                        $factores->muyalto = $factores->muyalto +1;
                    }
                }

                if($doms->id == 3){
                    $val = $doms->items;
                    if($val < 5){
                        $organizacion->nulos = $organizacion->nulos +1;
                    }
                    if($val >=5 && $val < 7){
                        $organizacion->bajo = $organizacion->bajo +1;
                    }
                    if($val >=7 && $val < 10){
                        $organizacion->medio = $organizacion->medio +1;
                    }
                    if($val >=10 && $val < 13){
                        $organizacion->alto = $organizacion->alto +1;
                    }
                    if($val >= 13){
                        $organizacion->muyalto = $organizacion->muyalto +1;
                    }
                }

                if($doms->id == 4){
                    $val = $doms->items;
                    if($val < 14){
                        $liderazgo->nulos = $liderazgo->nulos +1;
                    }
                    if($val >= 14 && $val <29){
                        $liderazgo->bajo = $liderazgo->bajo +1;
                    }
                    if($val >=29&& $val < 42){
                        $liderazgo->medio = $liderazgo->medio +1;
                    }
                    if($val >=42 && $val < 58){
                        $liderazgo->alto = $liderazgo->alto +1;
                    }
                    if($val >= 58){
                        $liderazgo->muyalto = $liderazgo->muyalto +1;
                    }
                }

                if($doms->id == 5){
                    $val = $doms->items;
                    if($val < 10){
                        $entorno->nulos = $entorno->nulos +1;
                    }
                    if($val >= 10 && $val <14){
                        $entorno->bajo = $entorno->bajo +1;
                    }
                    if($val >=14&& $val < 18){
                        $entorno->medio = $entorno->medio +1;
                    }
                    if($val >=18 && $val < 23){
                        $entorno->alto = $entorno->alto +1;
                    }
                    if($val >= 23){
                        $entorno->muyalto = $entorno->muyalto +1;
                    }
                }


            }

            if($sumaTotal < 50){
                $EvaluacionTotal->nulos = $EvaluacionTotal->nulos +1;
            }
            if($sumaTotal >=50 && $sumaTotal < 75){
                $EvaluacionTotal->bajo = $EvaluacionTotal->bajo +1;
            }
            if($sumaTotal >=75 && $sumaTotal < 99){
                $EvaluacionTotal->medio = $EvaluacionTotal->medio +1;
            }
            if($sumaTotal >=99 && $sumaTotal < 140){
                $EvaluacionTotal->alto = $EvaluacionTotal->alto +1;
            }
            if($sumaTotal >= 140){
                $EvaluacionTotal->muyalto = $EvaluacionTotal->muyalto +1;
            }
        }

        $ans = array($EvaluacionTotal, $ambiente, $factores, $organizacion, $liderazgo, $entorno);
        return json_encode($ans);
    }

    function ref2($periodo){
        //valores totales
        $EvaluacionTotal = new stdClass;
        $EvaluacionTotal->nulos = 0;
        $EvaluacionTotal->bajo = 0;
        $EvaluacionTotal->medio = 0;
        $EvaluacionTotal->alto = 0;
        $EvaluacionTotal->muyalto = 0;
        //ambiente de trabajo
        $ambiente = new stdClass;
        $ambiente->nulos = 0;
        $ambiente->bajo = 0;
        $ambiente->medio = 0;
        $ambiente->alto = 0;
        $ambiente->muyalto = 0;
        //factores
        $factores = new stdClass;
        $factores->nulos = 0;
        $factores->bajo = 0;
        $factores->medio = 0;
        $factores->alto = 0;
        $factores->muyalto = 0;
        //organizacion
        $organizacion = new stdClass;
        $organizacion->nulos = 0;
        $organizacion->bajo = 0;
        $organizacion->medio = 0;
        $organizacion->alto = 0;
        $organizacion->muyalto = 0;
        //liderazgo
        $liderazgo = new stdClass;
        $liderazgo->nulos = 0;
        $liderazgo->bajo = 0;
        $liderazgo->medio = 0;
        $liderazgo->alto = 0;
        $liderazgo->muyalto = 0;
        $query = "SELECT resultado,nombre FROM texamenesempleados tex inner join templeado te on te.cve_empleado = tex.cve_empleado WHERE cve_periodo = :periodo and cve_examen = 3";
        $sql = $this->connect()->prepare($query);
        $sql->bindParam(':periodo',$periodo);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        // return json_encode($result) ;
        $cont = 0;
        for($i = 0; $i < count($result); $i++){
            $partial = json_encode($result[$i]);
            $aux =  json_decode($partial);
            $valores =  $aux->resultado;
            $valus = json_decode($valores);
            $sumaTotal = 0;
            $co = 0;
         
         
        // echo $aux->nombre."\n";
         $cont = 0;
            foreach($valus as $doms){
               // echo $cont++."\n";
                $co = $co + 1;
                $sumaTotal = $sumaTotal + $doms->items;
                
                //echo $sumaTotal."---------".$doms->items."\n";

                if($doms->id == 1){
                    $val = $doms->items;
                    if($val < 3){
                        $ambiente->nulos = $ambiente->nulos +1;
                    }
                    if($val >=3 && $val < 5){
                        $ambiente->bajo = $ambiente->bajo +1;
                    }
                    if($val >=5 && $val < 7){
                        $ambiente->medio = $ambiente->medio +1;
                    }
                    if($val >=7 && $val < 9){
                        $ambiente->alto = $ambiente->alto +1;
                    }
                    if($val >= 9){
                        $ambiente->muyalto = $ambiente->muyalto +1;
                    }
                }

                if($doms->id == 2){

                    $val = $doms->items;
                    if($val < 10){
                        $factores->nulos = $factores->nulos +1;
                    }
                    if($val >=10 && $val < 20){
                        $factores->bajo = $factores->bajo +1;
                    }
                    if($val >=20 && $val < 30){
                        $factores->medio = $factores->medio +1;
                    }
                    if($val >=30 && $val < 40){
                        $factores->alto = $factores->alto +1;
                    }
                    if($val >= 40){
                        $factores->muyalto = $factores->muyalto +1;
                    }
                }

                if($doms->id == 3){
                    $val = $doms->items;
                    if($val < 4){
                        $organizacion->nulos = $organizacion->nulos +1;
                    }
                    if($val >=4 && $val < 6){
                        $organizacion->bajo = $organizacion->bajo +1;
                    }
                    if($val >=6 && $val < 9){
                        $organizacion->medio = $organizacion->medio +1;
                    }
                    if($val >=9 && $val < 12){
                        $organizacion->alto = $organizacion->alto +1;
                    }
                    if($val >= 12){
                        $organizacion->muyalto = $organizacion->muyalto +1;
                    }
                }

                if($doms->id == 4){
                    $val = $doms->items;
                    if($val < 10){
                     //   echo "nulo\n";
                        $liderazgo->nulos = $liderazgo->nulos +1;
                    }
                    if($val >= 10 && $val <18){
                     //   echo "bajo\n";

                        $liderazgo->bajo = $liderazgo->bajo +1;
                    }
                    if($val >=18 && $val < 28){
                     //   echo "medio\n";

                        $liderazgo->medio = $liderazgo->medio +1;
                    }
                    if($val >=28 && $val < 38){
                     //   echo "alto\n";

                        $liderazgo->alto = $liderazgo->alto +1;
                    }
                    if($val >= 38){
                     //   echo "muy alto\n";

                        $liderazgo->muyalto = $liderazgo->muyalto +1;
                    }
                }
 
            }

            if($sumaTotal < 20){
                $EvaluacionTotal->nulos = $EvaluacionTotal->nulos +1;
            }
            if($sumaTotal >=20 && $sumaTotal < 45){

                $EvaluacionTotal->bajo = $EvaluacionTotal->bajo +1;
            }
            if($sumaTotal >=45 && $sumaTotal < 70){

                $EvaluacionTotal->medio = $EvaluacionTotal->medio +1;
            }
            if($sumaTotal >=70 && $sumaTotal < 90){

                $EvaluacionTotal->alto = $EvaluacionTotal->alto +1;
            }
            if($sumaTotal >= 90){ 

                $EvaluacionTotal->muyalto = $EvaluacionTotal->muyalto +1;
            }
        }

        $ans = array($EvaluacionTotal, $ambiente, $factores, $organizacion, $liderazgo);
        return json_encode($ans);
    }
}

?>