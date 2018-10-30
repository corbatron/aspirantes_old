<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<!-- Bootstrap core CSS -->
		<? if($_REQUEST['salida']!='Excel') { ?> 
			<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
			<style>
				body { padding-top: 50px; }
			</style>
		<? } ?>
	</head>
	<body>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
<form class="form-horizontal" role="form"  name='form_alumnos' id='form_alumnos'>
		
	
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
	
//	echo "<table width='100%'><tr><td width='15%' bgcolor='#CCCCCD'>Carrera inscripto</td><td bgcolor='#CCCCCD'><select name='carrera_seleccionada' id='id_carrera_sele' class='form-control'><option value='0'>Todas</option>".$arra_carreras."</select></td></tr>";

	$arr_sel[$_REQUEST['tiempo']] = "selected"; 
	$opciones = "";
	$opciones .= "<option value='tiempo_0' ".$arr_sel['tiempo_0'].">TIEMPO 0 - Orientaci&oacute;n a la carrera</option>";
	$opciones .= "<option value='tiempo_1' ".$arr_sel['tiempo_1'].">TIEMPO 1 - Riesgo en Condicionantes personales y contextuales</option>";
	$opciones .= "<option value='tiempo_2' ".$arr_sel['tiempo_2'].">TIEMPO 2 - 1ra Percepci&oacute;n de autorregulaci&oacute;n (Metas y planificaci&oacute;n)</option>";
	$opciones .= "<option value='tiempo_3' ".$arr_sel['tiempo_3'].">TIEMPO 3 - 2da Percepci&oacute;n de autorregulaci&oacute;n (Supervisi&oacute;n de metas y rendimiento acad&eacute;mico)</option>";
	$opciones .= "<option value='tiempo_4' ".$arr_sel['tiempo_4'].">TIEMPO 4 - Autoevaluaci&oacute;n y ajustes de planes personales de carrera</option>";
        $opciones .= "<option value='tiempo_4_plus' ".$arr_sel['tiempo_4_plus'].">TIEMPO 4 - Completo</option>";
	$opciones .= "<option value='tiempo_5' ".$arr_sel['tiempo_5'].">TIEMPO 5 - Autorregulaci&oacute;n </option>";
	$opciones .= "<option value='discontinuidad' ".$arr_sel['discontinuidad'].">REPORTE Discontinuidad</option>";
?>
<div class="form-group">				 
					<label for="id_carrera_sele" class="col-sm-2 control-label">			
						Carrera
					</label>
					<div class="col-sm-5">

					<select name='carrera_seleccionada' id='id_carrera_sele' class='form-control'>
						<option value='0'>Todas</option>
						<? echo $arra_carreras; ?>
					</select>



					</div>
				</div>
				
				
				
				
				<div class="form-group">
					 
					<label for="id_tiempo" class="col-sm-2 control-label">
						Tiempo
					</label>
					<div class="col-sm-5">

					<select name='tiempo' id='id_tiempo' class='form-control'><?echo $opciones; ?></select>


					</div>
				</div>
				
				
				
				
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
					<div class="checkbox">


  <input type="radio" name='salida' checked value='Pantalla'> Pantalla

  <input type="radio" name='salida' value='Excel'> Excel


					


						</div>
					</div>
				</div>








				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						 
						<button type="submit" class="btn btn-primary">
							Buscar
						</button>
					</div>
				</div>
				<input type='hidden' name='guardar' value='guardar'/>
			</form>
<div id='div_guardar'></div>
<hr/>
<?



//	echo "<tr><td bgcolor='#CCCCCD'>Tiempo</td><td bgcolor='#CCCCCD'><select name='tiempo' id='id_tiempo' class='form-control'>".$opciones."</select></td></tr>";

//	echo "<tr><td colspan='2' bgcolor='#CCCCCC'><input type='radio' name='salida' checked value='Pantalla'>Pantalla</input><input type='radio' name='salida' value='Excel'>Excel</input></td></tr>";

}elseif($_REQUEST['salida']=='Excel'){
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=reporte_instrumentos_".$_GET['tiempo']."_".date('Ymd').".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
}


$id_reporte = $_GET['tiempo'];	
$archivo_reporte = $id_reporte."0.php";
include($archivo_reporte);


?>

		</div>
	</div>
</div>
	

        <script src="bootstrap/js/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="bootstrap/js/jquery.min.js"><\/script>')</script> 
        <script src="bootstrap/dist/js/bootstrap.min.js"></script> 
	</body>
</html>