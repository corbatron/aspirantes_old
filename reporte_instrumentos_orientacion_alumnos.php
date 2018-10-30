<?php
include('ver_login.php');
include('class.form.php');
$formularios = new Form(0);
require_once('coneccion.php');
include('class.alumnos.php');
include('class.carreras.php');
include('class.alumnosFormularios.php');
?>
<body onload="doOnLoad();">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
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
	$alumno   = new Alumno(0);
	$carreras = new Carreras();
	$array_carreras_listado = $carreras->traer_carreras();
	foreach($array_carreras_listado as $array_carrera)
	{
		$seleccion = "";
		if($_REQUEST['carrera_seleccionada']==$array_carrera['carr_id']) $seleccion = "selected";		
		$arra_carreras.= "<option ".$seleccion." value='".$array_carrera['carr_id']."'>".$array_carrera['carr_descripcion']."</option>";
	}

	echo "<h3><font color='RED'>Aviso:</font> El siguiente reporte solo se encuentra funcional para el 2013</h3>";
	echo "<h3>Se recomienda exportar el reporte a excel para una mejor visualizacion de los datos</h3>";
	if($_REQUEST['salida']=="" or $_REQUEST['salida']=="Pantalla" )
	{
		echo "<form name='form_alumnos' id='form_alumnos'>";
		echo "<table width='100%'><tr><td width='15%' bgcolor='#CCCCCD'>Carrera inscripto</td><td bgcolor='#CCCCCD'><select name='carrera_seleccionada' id='id_carrera_sele'><option value='0'>Todas</option>".$arra_carreras."</select></td></tr>
		<tr><td bgcolor='#CCCCCD'>Intancias</td><td bgcolor='#CCCCCD'><select name='instancia' id='id_insta'><option value='0'>Todas</option></select></td></tr><tr><td bgcolor='#CCCCCD'>Documento</td><td bgcolor='#CCCCCD'><input bgcolor='#CCCCCD' type='text' name='numero_docu' id='numero_docu' value='".$_REQUEST['numero_docu']."'></input></td></tr>";
		echo "<tr><td colspan='1' bgcolor='#CCCCCC'>Fecha desde:</td><td bgcolor='#CCCCCC'>";
		echo '<input type="text" class="input_text" name="fecha_desde" id="calendar1" value="'.$_REQUEST["fecha_desde"].'" ></input>';
		echo "</td></tr>";
		echo "<tr><td colspan='1' bgcolor='#CCCCCC'>Fecha hasta:</td><td bgcolor='#CCCCCC'>";
		echo '<input type="text" class="input_text" name="fecha_hasta" id="calendar2" value="'.$_REQUEST["fecha_hasta"].'" ></input>';
		echo "</td></tr>";

		echo "<tr><td colspan='2' bgcolor='#CCCCCC'>Ingreso<input type='checkbox' name='ingreso' value='ingreso'></input> No ingreso<input type='checkbox' name='noingreso' value='noingreso'></input></td></tr>";
		echo "<tr><td colspan='2' bgcolor='#CCCCCC'><input type='radio' name='salida' checked value='Pantalla'>Pantalla</input><input type='radio' name='salida' value='Excel'>Excel</input></td></tr>";
		echo "<tr><td colspan='2'><input type='submit' value='buscar'></input></td></tr>";
		echo "<tr><td><input type='hidden' name='guardar' value='guardar'></input></td></tr>";
		echo "</table>";
		echo "</form>";	
		echo "<div id='div_guardar'></div>";
	}elseif($_REQUEST['salida']=='Excel'){
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=reporte_instrumentos.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
	
	
	$array_formularios = $formularios->showForm();
	$cont=0;

	$id_instancia = $_REQUEST['instancia'];
	$id_carrera   = $_REQUEST['carrera_seleccionada'];
	$documento    = $_REQUEST['numero_docu'];

	echo "<div style='height:500Px;overflow:auto;align:center;'>";//width:99%;

	if($_REQUEST['ingreso']!="") $ingreso="1)";
	if($_REQUEST['noingreso']!="")	$ingreso="0 or  ingreso is null)";
	
	if($_REQUEST['guardar']!="")
	{
		$alumnos_mutantes = $alumno->traer_alumnos($id_instancia,$id_carrera,$documento,$ingreso,$_REQUEST["fecha_desde"],$_REQUEST["fecha_hasta"]);
		echo "<table id='tabla_reporte'>";//width='100%' 
		echo "<tr>";
		echo "<td >";//width='50%'

			echo "<table cellspacing='2' cellpadding='2'>";//width='100%' 
			echo "<tr>";		
				echo "<td bgcolor='#CCCCCD'>Estado</td>";
				echo "<td bgcolor='#CCCCCD'>Nombre</td>";
				echo "<td bgcolor='#CCCCCD'>Apellido</td>";
				echo "<td bgcolor='#CCCCCD'>Documento</td>";
				echo "<td bgcolor='#CCCCCD'>E-mail</td>";
				echo "<td bgcolor='#CCCCCD'>Telefono</td>";			
				$cant_forms=0;
				foreach($array_formularios as $form_valor){
					// 1   2   25   28 - para 2013
					if($form_valor['id']==1 or $form_valor['id']==2 or $form_valor['id']==25 or $form_valor['id']==28){
						echo "<td bgcolor='#CCCCCD' width=>".$form_valor['descripcion']."</td>";
						$cant_forms++;
						$array_idforms[$form_valor['id']]=$form_valor['lugar_reporte'];
					}
				}
				$conexion = new Coneccion();
				echo "<td bgcolor='#CCCCCD' >RAZON</td>";
				echo "<td bgcolor='#CCCCCD'>Tutor</td>";
			echo "</tr>";

			$color_fondo = "#CCCCEE";
			foreach($alumnos_mutantes as $mutar)
			{
				
				$aluform = new alumnosFormularios($mutar['dni']);
				if($color_fondo == "#CCCCEE") $color_fondo = "#FFFFFF";
				else $color_fondo = "#CCCCEE";
			
				$esta_todo_bien="0";
				$array_formularios = $aluform->traerIdForms();



				foreach($_REQUEST['valor_instrumento'] as $valor_int)
				{	
					$res_1 = null;
					$res_1 = $aluform->compararID($valor_int);
					if($res_1[0]['verifica']!="1")
					{
						continue 2;
					}
				}

				$cantidad_riesgo = 0;
				echo "<tr>";
					echo "<td bgcolor='".$color_fondo."'>";
					if($_REQUEST['salida']!="Excel")
						{
							if($mutar['ingreso']==1) echo "<img src='images/dentro.png' id='img_1_".trim($mutar['dni'])."'/>";
							else echo "<img src='images/fuera.png' id='img_1_".trim($mutar['dni'])."'/>";
						}elseif($_REQUEST['salida']=="Excel"){
							if($mutar['ingreso']=="1") echo "INGRESO";
							else echo "NO INGRESO";
						}
					echo "</td>";
					echo "<td bgcolor='".$color_fondo."'>";
						echo $mutar['nombre'];
					echo "</td>";
					echo "<td bgcolor='".$color_fondo."'>";
						echo $mutar['apellido'];
					echo "</td>";
					echo "<td bgcolor='".$color_fondo."'>";
						echo $mutar['dni'];
					echo "</td>";
					echo "<td bgcolor='".$color_fondo."'>";
						echo "<a target='_blank' href='mailto:".$mutar['mail']."&subject=Tutorias'>".$mutar['mail']."</a>";
					echo "</td>";
					echo "<td bgcolor='".$color_fondo."'>";
						echo $mutar['tel_linea'];
					echo "</td>";
					
					$mutar['dni'] = trim($mutar['dni']);
					$cant_forms_alumno=$cant_forms;

					foreach($array_idforms as $form_valor=>$sx){
						echo "<td bgcolor='".$color_fondo."'>";
							$vNota 	= $aluform->wasDone($mutar['dni'],$form_valor);
							$vFechaReali= $vNota[0][2];
							$vExiste 	= $vNota[0][1];
							$vNota		= $vNota[0][0];
							if($vNota=="D" or $vNota=="-")
							{
								$cantidad_riesgo = $cantidad_riesgo + 1;
							}
							if($vNota != "" and $vExiste == 1 and $vFechaReali != ""){
								echo "<a target='_blank' href='reporteform.php?id_alumno=".$mutar['dni']."&id_formulario=".$form_valor."&formulario=".$sx."'>VERIFIQUE[".$vNota."]</a>";
							}
							elseif($vExiste == 1 and $vNota == "" and $vFechaReali != ""){
								$url = "reporteform.php?id_alumno=".$mutar['dni']."&id_formulario=".$form_valor."&formulario=".$sx."";
								echo "<script>window.open('".$url."','popup".$mutar['dni']."','width=300,height=400')</script>";
								echo "<a target='_blank' href='reporteform.php?id_alumno=".$mutar['dni']."&id_formulario=".$form_valor."&formulario=".$sx."'>CALCULAR</a>";
							}
							elseif($vExiste == 1 and $vFechaReali == ""){
								echo "ASIGNADO";
								if($sx!="plan_personal_carrera")
								{
									$cantidad_riesgo = -1;
								}
							}
							else{
								echo "N/A";
							}
						echo "</td>";
					}
			
					echo "<td bgcolor='".$color_fondo."' >";
					//MCO modificado
						$respuestas = $conexion->query("select id, trim(upper(texto)) as texto from respuestaspreg where idpregunta in  
						(5, 67 , 137, 144) and id in (select idrespuesta from respuestaalumno where  trim(idalumno) like trim('".$mutar['dni']."'))");
						echo "<ol>";
						foreach($respuestas as $singleresponse)
							if($singleresponse['texto']!="OTRA (ESPECIFICAR)") echo "<li type='circle'>".$singleresponse['texto']."</li>";
						echo "</ol>";

					echo "</td>";	

					echo "<td bgcolor='".$color_fondo."'>";
					echo "</td>";
			
			}
				echo "</tr>";
			echo "</table>";
		echo "</td></tr></table>";
	echo "</div>";
}
?>