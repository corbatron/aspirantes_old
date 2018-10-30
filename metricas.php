<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
</head>
<?php

session_start();

require_once("coneccion.php");
require_once("class.sysacadMateriasAprobadas.php");
require_once("class.sysacad_fechas.php");

for ($i = 2012; $i <= 2016; $i++) {
    $_SESSION['nombre_base'] = $i;
    $_SESSION['id'] = $i;


    $con = new Coneccion();


    $especialidades = $con->query("SELECT * FROM carreras");
    
 
    //echo "<h1>".$i."</h1>";
 
    foreach ($especialidades as $esp){
    
    $fecha = new SysacadFechas();
    $fechas = $fecha->obtener_fechas();

    $_SESSION['fecha_ini'] = $fechas[0]['fecha_inicio'];
    $_SESSION['fecha_fin'] = $fechas[0]['fecha_fin'];
    
    //echo "<b>".$esp['carr_descripcion']."</b>";
   

    $resultados = $con->query("select * from ppc where idformulario=26 and idalumno in (select cast(dni as integer) from alumnos where trim(dni)!='' and idcarrera=".$esp['carr_id'].")");

    //$resultados_aprobadas  = $con->query("");

    $con2 = new Sysacad();

    $array_promedios["d"] = 0;
    $array_promedios["r"] = 0;


    foreach ($resultados as $res) {
if($esp['carr_descripcion']!="TEC. SUP. PROGRAMACION J.C.PAZ " && $esp['carr_descripcion']!="TECNICO SUPERIOR EN ADMINISTRACION " && 
                !strstr($esp['carr_descripcion'],"CICLO")&& !strstr($esp['carr_descripcion'],"SAN MARTIN") && !strstr($esp['carr_descripcion'],"SISTEMAS") && !strstr($esp['carr_descripcion'],"SITEMAS")){

        $unserial = unserialize($res["mat_cursar"]);
        $materias = $con2->obtenerMaterias($res["idalumno"]);


	foreach($unserial as $ppc){
		$clave = explode('-',$ppc['materias'])[0]."-".explode('-',$ppc['materias'])[1];

		//print_r($ppc); echo "<br>".explode('-',$ppc['materias'])[0]."<br>";
		if($conteo_materias[$i][$esp['carr_descripcion']][$clave]['PPC']==="") $conteo_materias[$i][$esp['carr_descripcion']][$clave]['PPC']=0;
		$conteo_materias[$i][$esp['carr_descripcion']][$clave]['PPC']++;

	}



	foreach($materias as $sysacad){
		$clave=$sysacad['materia']."-".$sysacad['especialidad']."-".$sysacad['plan'];
		$clave=$sysacad['materia']."-".$sysacad['especialidad'];

		if($conteo_materias[$i][$esp['carr_descripcion']][$clave]['SYSACAD']==="") $conteo_materias[$i][$esp['carr_descripcion']][$clave]['SYSACAD']=0;

		$conteo_materias[$i][$esp['carr_descripcion']][$clave]['SYSACAD']++;
	}

    }
 }


    }
    
    
}



   $con2 = new Sysacad();
$todas_materias = $con2->query("SELECT materia||'-'||especialid as clave, nombre  FROM materias");
foreach($todas_materias as $materia){
	$nombre_materias[$materia['clave']]=$materia['nombre'];
}

$con = new Coneccion();
$materias_sit = $con->query("SELECT materia||'-'||carrera as clave, nombre  FROM materias_carrera");

foreach($materias_sit as $materia){
    $nombre_materias[$materia['clave']]=$materia['nombre'];



}


$resultados="";
$estadisticas=$conteo_materias;
foreach($estadisticas as $anio=>$carrera){
	foreach($carrera as $carr_id=>$conteo_materias){



foreach($conteo_materias as $id_materia=>$array_materias){

if($resultados[$anio][$carr_id][$nombre_materias[$id_materia]]['SYSACAD']==="") $resultados[$anio][$carr_id][$nombre_materias[$id_materia]]['SYSACAD']=0;
if($resultados[$anio][$carr_id][$nombre_materias[$id_materia]]['PPC']==="") $resultados[$anio][$carr_id][$nombre_materias[$id_materia]]['PPC']=0;

	$resultados[$anio][$carr_id][$nombre_materias[$id_materia]]['SYSACAD']+=$array_materias['SYSACAD'];
	$resultados[$anio][$carr_id][$nombre_materias[$id_materia]]['PPC']+=$array_materias['PPC'];

}
}
}



/*
    echo "<pre>";
print_r($resultados);
echo "</pre>";


$tabla.="<tr><th></th>";
for ($i = 2012; $i <= 2016; $i++){
	$tabla.="<th colspan='2'>".$i."</th>";
}
$tabla.="<tr>";
foreach($resultados as $anio=>$array_tabla){
	foreach($array_tabla as $carrera=>$body_tabla){
		$tabla.="<tr><th>".$carrera."</th>";
		foreach($body_tabla as $materia=>$valores){
			$tabla.="<td>".$materia."</td><td>".$valores['SYSACAD']."</td><td>".$valores['PPC']."</td>";
		}	
		$tabla.="</tr>";
	}
}
*/

$tablita="";
foreach($resultados as $anio=>$array_tabla){
	foreach($array_tabla as $carrera=>$body_tabla){
		foreach($body_tabla as $materia=>$valores){
			$tablita[$carrera][trim($materia)][$anio]['SYSACAD']=$valores['SYSACAD'];
			$tablita[$carrera][trim($materia)][$anio]['PPC']=$valores['PPC'];
		}
	}
}



foreach($tablita as $carrera=>$array_tabla){
	
	foreach($array_tabla as $materia=>$body_tabla){

		
		echo "<table>";
		$tablaContenido="";
		$header="<tr><th>".$carrera."</th>";

		$header.="<th colspan='2'>".$materia."</th>";

		$texto="";
		$tabla="";

		foreach($body_tabla as $anio=>$valores){
			$tabla.="<tr><td>".$anio."</td>";
			//$texto=$anio;
			
			$tabla.="<td>".$valores['SYSACAD']."</td><td>".$valores['PPC']."</td>";			

			
			$tabla.="</tr>";


		}
		//$tablaContenido= "<tr><td>".$texto."</td>".$tabla."</tr>";

		$header.="</tr>";
		echo $header;
		echo $tabla;

		echo "</table>";

	}
}

echo "<pre>";
print_r($tablita);
echo "</pre>";



echo json_encode($tablita);

?>
