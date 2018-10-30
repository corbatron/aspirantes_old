<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />



<body onload="doOnLoad();">
<link rel="stylesheet" type="text/css" href="css/formularios.css"></link>
   <link rel="stylesheet" type="text/css" href="codebase/dhtmlxcalendar.css"></link>
	<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxcalendar_dhx_skyblue.css"></link>
	<script src="codebase/dhtmlxcalendar.js"></script>
	<script>
		var myCalendar;
		function doOnLoad() {
			myCalendar = new dhtmlXCalendarObject(["calendar1","calendar2"]);
		}
	</script>


<?

	include('class.form.php'); 
	$array_edit_form = $_REQUEST;
	$id_form=$array_edit_form['id'];

	
	if($_REQUEST['accion']=="guardar")
	{
		if($_REQUEST['id_form']=="")
		{
			$formulario_crear = new Form($_REQUEST['id_form']);
			$formulario_crear->set_id($_REQUEST['id_form']);

		}
		else
		{
			$formulario_crear = new Form($_REQUEST['id_form']);
		}
		
		$formulario_crear->set_codigo($_REQUEST['codigo']);
		if($_REQUEST['estado'] == "")
		{
			$_REQUEST['estado'] = 0;
		}
		$formulario_crear->set_estado($_REQUEST['estado']);
		$formulario_crear->set_descripcion($_REQUEST['descripcion']);
		$formulario_crear->set_fecha_inicio($_REQUEST['fecha_desde']);
		$formulario_crear->set_fecha_fin($_REQUEST['fecha_hasta']);
		$formulario_crear->set_descripcionLarga($_REQUEST['descripcion_larga']);
		if($formulario_crear->get_codigo() != "")
		{
			$formulario_crear->saveForm();
			echo "<script>location.href='http://".$_SERVER['HTTP_HOST']."/aspirantes/formularios.php'</script>";
			
		}


	}
	
	$formulario = new Form($id_form);
	if($formulario->get_fecha_desde() == "")
	{
		$formulario->set_fecha_inicio(date('Y-m-d'));
	}
	if($formulario->get_fecha_hasta() == "")
	{
		$formulario->set_fecha_fin(date('Y-m-d'));
	}
?>
	<form name="formu">
	<div class="box">
	
	<h1>Creaci&oacute;n/modificaci&oacute;n de formularios</h1>
	
	
	<label>
    <span>C&oacute;digo</span>
    <input type="text" class="input_text" name="codigo" id="codigo" value="<? echo $formulario->get_codigo(); ?>"/>
    </label>

	<label>
    <span>Descripci&oacute;n</span>
    <input type="text" class="input_text" name="descripcion" id="descripcion" value="<? echo $formulario->get_descripcion(); ?>"/>
    </label>
	
	<label>
    <span>Estado</span>
	<?
	if($formulario->get_estado() == 1) $var="checked";
	?>
    <input type="checkbox" class="input_text" name="estado" <?echo $var;?> id="codigo" value="1"/>
    </label>


	<label>
    <span>Fecha de inicio</span>
    <input type="text" class="input_text" name="fecha_desde" id="calendar1"  value="<? echo $formulario->get_fecha_desde();?>"/>dd/mm/aaaa
    </label>
	
	<label>
    <span>Fecha de fin</span>
    <input type="text" class="input_text" name="fecha_hasta" id="calendar2" value="<? echo $formulario->get_fecha_hasta();?>"/>dd/mm/aaaa
    </label>
	

	
	<label>
    <span>Descripcion</span>
    <textarea  style="overflow-y: scroll;" class="message"  rows="100" cols="100" name="descripcion_larga" id="descripcion_larga" wrap='virtual'><? echo $formulario->get_descripcionLarga();?></textarea>
    <input type="submit" class="button" value="Aceptar" />
    </label>
	<!--echo '<input type="submit" value="Aceptar">';-->
	
	<input type="hidden" name="id_form" value="<? echo $formulario->get_id(); ?>">
	<input type="hidden" name="accion" value="guardar">
	

	</div>
	</form>
	


</body>