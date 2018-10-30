<meta charset="utf-8">
<?php
include('ver_login.php');
include('class.form.php');
require_once('coneccion.php');
include('class.alumnos.php');
include('class.carreras.php');
include('class.alumnosFormularios.php');



$carreras = new Carreras();
$array_carreras_listado = $carreras->traer_carreras();
foreach($array_carreras_listado as $array_carrera)
{
	$seleccion = "";
	if($_REQUEST['carrera_seleccionada']==$array_carrera['carr_id']) $seleccion = "selected";		
	$arra_carreras.= "<option ".$seleccion." value='".$array_carrera['carr_id']."'>".$array_carrera['carr_descripcion']."</option>";
}

if($_REQUEST['salida']=="" or $_REQUEST['salida']=="Pantalla" )
{
	echo "<form name='form_alumnos' id='form_alumnos'>";

	echo "<table width='100%'><tr><td width='15%' bgcolor='#CCCCCD'>Carrera inscripto</td><td bgcolor='#CCCCCD'><select name='carrera_seleccionada' id='id_carrera_sele'><option value='0'>Todas</option>".$arra_carreras."</select></td></tr>";



	$arr_sel[$_REQUEST['tiempo']] = "selected"; 
	$opciones = "";
	$opciones .= "<option value='tiempo_0' ".$arr_sel['tiempo_0'].">TIEMPO 0 - Orientaci&oacute;n a la carrera</option>";
	$opciones .= "<option value='tiempo_1' ".$arr_sel['tiempo_1'].">TIEMPO 1 - Riesgo en Condicionantes personales y contextuales</option>";
	$opciones .= "<option value='tiempo_2' ".$arr_sel['tiempo_2'].">TIEMPO 2 - 1º Percepci&oacute;n de autorregulaci&oacute;n (Metas y planificaci&oacute;n)</option>";
	$opciones .= "<option value='tiempo_3' ".$arr_sel['tiempo_3'].">TIEMPO 3 - 2º Percepci&oacute;n de autorregulaci&oacute;n (Supervisi&oacute;n de metas y rendimiento acad&eacute;mico)</option>";
	$opciones .= "<option value='tiempo_4' ".$arr_sel['tiempo_4'].">TIEMPO 4 - Autoevaluaci&oacute;n y ajustes de planes personales de carrera</option>";
        $opciones .= "<option value='tiempo_4_plus' ".$arr_sel['tiempo_4_plus'].">TIEMPO 4 - Completo</option>";
	$opciones .= "<option value='tiempo_5' ".$arr_sel['tiempo_5'].">TIEMPO 5 - Autorregulaci&oacute;n </option>";
	$opciones .= "<option value='discontinuidad' ".$arr_sel['discontinuidad'].">REPORTE Discontinuidad</option>";

	echo "<tr><td bgcolor='#CCCCCD'>Tiempo</td><td bgcolor='#CCCCCD'><select name='tiempo' id='id_tiempo'>".$opciones."</select></td></tr>";

	echo "<tr><td colspan='2' bgcolor='#CCCCCC'><input type='radio' name='salida' checked value='Pantalla'>Pantalla</input><input type='radio' name='salida' value='Excel'>Excel</input></td></tr>";
	echo "<tr><td colspan='2'><input type='submit' value='buscar'></input></td></tr>";
	echo "<tr><td><input type='hidden' name='guardar' value='guardar'></input></td></tr>";
	echo "</table>";
	echo "</form>";	
	echo "<div id='div_guardar'></div>";
}elseif($_REQUEST['salida']=='Excel'){
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=reporte_instrumentos_".$_GET['tiempo']."_".date('Ymd').".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
}

$id_reporte = $_GET['tiempo'];	
$archivo_reporte = $id_reporte.".php";


include($archivo_reporte);


?>