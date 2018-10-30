<?
error_reporting(0);
define(color1,"#9496ED");
define(color2,"#D4D5ED");

include('class.alumnosRespuestasAgenda.php');
//traer alumnos que completaron la agenda
$alures=new alumnosRespuestasAgenda();
$formularios = $alures->traerFormularios();
$valor=0;
if(isset($_REQUEST['formularios'])) $valor=$_REQUEST['formularios'];//selected="selected"

$formularios_mostrar.='<option value="0">nada</option>';
foreach($formularios as $formulario){
	if($formulario['id'] == $valor) $seleccionado='selected="selected"';
	else $seleccionado= "";
	$formularios_mostrar.='<option '.$seleccionado.' value='.$formulario['id'].'>'.$formulario['codigo'].' - '.utf8_decode($formulario['descripcion']).'</option>';
}
	
echo '<form action="reporte_agenda.php">';
echo '<br><label>Seleccione un formulario de la lista:&nbsp;</label>';
echo '<select id="formularios" name="formularios" onchange="">'.$formularios_mostrar.'</select>';


//una vez seleccionado el formulario, traer los alumnos
if($_REQUEST['formularios']!=0){

	$alumnos = $alures->traerAlumnos($_REQUEST['formularios']);
	$alumnos_mostrar='<option value="0">Todos</option>';
	foreach($alumnos as $alumno)
		$alumnos_mostrar.='<option value='.$alumno['idalumno'].'>'.$alumno['idalumno'].'</option>';
	
	
	echo '<br><label>Seleccione un alumno:&nbsp;</label>';
	echo '<select id="alumno" name="alumno"  onchange="">'.$alumnos_mostrar.'</select>';
	echo '<br>';
}

echo '<input type="submit" value="Rechercher">';
echo '</form>';

if(isset($_REQUEST['alumno'])){
	echo '<table cellspacing="3" cellpadding="3" width="50%"><tr><th>DNI</th><th>1</th><th>2</th><th>3</th><th>4</th></tr>';
	if($_REQUEST['alumno']==0){
		foreach($alumnos as $alumno){
			imprimir_tabla($alures->traerRespuestas($_REQUEST['formularios'],$alumno['idalumno']));
		}
	}else{
		imprimir_tabla($alures->traerRespuestas($_REQUEST['formularios'],$_REQUEST['alumno']));
	}
	echo '</table>';
}


//contar la cantidad de elementos seleccionados en la agenda
function imprimir_tabla($muchos_datos){
	global $color;
	if($color==color1) $color=color2;
	else $color=color1;
error_reporting(0);
	foreach($muchos_datos as $datos)
		echo '<tr><td bgcolor="'.$color.'">'.$datos["dni"].'</td><td bgcolor="'.$color.'">'.$datos["valor0"].'</td><td bgcolor="'.$color.'">'.$datos["valor1"].'</td><td bgcolor="'.$color.'">'.$datos["valor2"].'</td><td bgcolor="'.$color.'">'.$datos["valor3"].'</td></tr>';
	
}

?>