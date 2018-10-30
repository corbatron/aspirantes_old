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

        $unserial = unserialize($res["mat_cursar"]);
        $materias = $con2->obtenerMaterias($res["idalumno"]);
        $array_promedios["d"]+=count($unserial);
        $array_promedios["r"]+=count($materias);
    }

    
  

    //echo "<br>";
    //echo round($array_promedios["d"] / count($resultados));
    //echo " ";
    //echo round($array_promedios["r"] / count($resultados));
    //echo "<br>";
    
        if($esp['carr_descripcion']!="TEC. SUP. PROGRAMACION J.C.PAZ " && $esp['carr_descripcion']!="TECNICO SUPERIOR EN ADMINISTRACION " && 
                !strstr($esp['carr_descripcion'],"CICLO")&& !strstr($esp['carr_descripcion'],"SAN MARTIN") && !strstr($esp['carr_descripcion'],"SISTEMAS") && !strstr($esp['carr_descripcion'],"SITEMAS")){
            $array_salida[$esp['carr_descripcion']][$i]["d"]=round($array_promedios["d"] / count($resultados));
            $array_salida[$esp['carr_descripcion']][$i]["r"]=round($array_promedios["r"] / count($resultados));
        }   
    }
    
    
}

$tabla.="<tr><th></th>";
for ($i = 2012; $i <= 2016; $i++){
	$tabla.="<th colspan='2'>".$i."</th>";
}
$tabla.="<tr>";
foreach($array_salida as $carrera=>$array_tabla){
	$tabla.="<tr><th>".$carrera;
	foreach($array_tabla as $anio=>$body_tabla){
		$tabla.="<td>".$body_tabla['d']."</td><td>".$body_tabla['r']."</td>";
	}	

	$tabla.="</th></tr>";


}
echo "<table>";
echo $tabla;
echo "</table>";

echo "<pre>";
print_r($array_salida);
echo "</pre>";







?>
