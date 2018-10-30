<script type="text/javascript">
function altRows(id){
	if(document.getElementsByTagName){  
		
		var table = document.getElementById(id);  
		var rows = table.getElementsByTagName("tr"); 
		 
		for(i = 0; i < rows.length; i++){          
			if(i % 2 == 0){
				rows[i].className = "evenrowcolor";
			}else{
				rows[i].className = "oddrowcolor";
			}      
		}
	}
}
window.onload=function(){
	altRows('alternatecolor');
}
</script>

<!-- CSS goes in the document HEAD or added to your external stylesheet -->
<style type="text/css">
table.altrowstable {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	color:#333333;
	border-width: 1px;
	border-color: #a9c6c9;
	border-collapse: collapse;
}
table.altrowstable th {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #a9c6c9;
}
table.altrowstable td {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #a9c6c9;
}
.oddrowcolor{
	background-color:#d4e3e5;
}
.evenrowcolor{
	background-color:#c3dde0;
}
</style>
<?
exit();
require("coneccion.php");

session_start();
$_SESSION['nombre_base'] = 2012;
$base = new Coneccion();

$query1="SELECT al.dni,al.nombre as nombre_alumno,al.apellido as apellido_alumno,al.id_tutor,al2.nombre,al2.apellido
 FROM alumnos al inner join alumnos al2 on al.id_tutor=al2.id where al.idcarrera='33887' and al.ingreso=1 order by al.dni asc";

$resultado = $base->Query($query1);

echo '<table class="altrowstable" id="alternatecolor">';
echo "<tr><th>Alumno</th><th>Dni</th><th>Primer PPC</th><th>Segundo PPC</th><th>Finales</th><th>Tutor</th></tr>";
foreach($resultado as $res){
echo "<tr>";
echo "<td>";

	//echo "<pre>";
	//print_r($res);
	//echo "</pre>";
	
	$query2="select * from ppc where  idalumno='".trim($res['dni'])."' and (idformulario=24 or idformulario=26)";
	$resultado_materias = $base->Query($query2);
	echo utf8_decode($res['apellido_alumno']." ".$res['nombre_alumno']); 	
	
	foreach($resultado_materias as $materia){
			$materias_programadas[$res['dni']][$materia['idformulario']] = $materia;
	}


echo "</td>";
echo "<td>";
echo $res['dni'];
echo "</td>";
echo "<td>";
$ppc = unserialize($materias_programadas[$res['dni']]['24']['mat_cursar']);
foreach($ppc as $ppc_mat)
{
	if($ppc_mat['tipo_cursada'] == 1 && $ppc_mat['llamado']!="APROBADA")
	{
		materias($ppc_mat['materias']);
		echo "<br>";
	}
	
}
echo "&nbsp;";
//print_r($ppc);
echo "</td>";
echo "<td>";
$ppc2 = unserialize($materias_programadas[$res['dni']]['26']['mat_cursar']);
foreach($ppc2 as $ppc2_mat){
	if($ppc2_mat['tipo_cursada']==1 && $ppc2_mat['llamado']!="APROBADA"){
		materias($ppc2_mat['materias']);
		echo "<br>";
	}
}
echo "&nbsp;";
//print_r($ppc2);
echo "</td>";
echo "<td>";
$query_aprobadas="select * from tutorias_materias_aprobadas where legajo=".$res['dni']."";
$resultado_aprobadas = $base->Query($query_aprobadas);
foreach($resultado_aprobadas as $aprobadas)
{
	$parametro = $aprobadas['materia']."-".$aprobadas['especialidad']."-".$aprobadas['plan'];
	materias($parametro);
	echo "<br>";
}
echo "&nbsp;";
echo "</td>";
echo "<td>";
echo $res['nombre'].", ".$res['apellido'];
echo "&nbsp;";
echo "</td>";
echo "</tr>";
}
echo "</table>";



function materias($mat){
global $base;
$mate = explode("-",$mat);
$query_materias = "SELECT * from materias_carrera where plan=".$mate[2]." and materia=".$mate[0]." and carrera=".$mate[1]."";
$resultado = $base->Query($query_materias);
echo utf8_decode($resultado[0]['nombre']);

}

?>
