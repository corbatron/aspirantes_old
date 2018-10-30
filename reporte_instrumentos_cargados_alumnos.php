<?php
include('ver_login.php');
include('class.form.php');
$formularios = new Form(0);

require_once('coneccion.php');
include('class.alumnos.php');
include('class.carreras.php');
include('class.alumnosFormularios.php');
include('evaluaciones.php');

?>
<body onload="doOnLoad();">
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

if($_REQUEST['accion']=="habilitar")
{
	$dni = $_REQUEST['documento'];
	$alumno   = new Alumno($dni);
	$alumno->activar();
	echo "";
	exit();
}
if($_REQUEST['accion']=="deshabilitar")
{
	$dni = $_REQUEST['documento'];
	$alumno   = new Alumno($dni);
	$alumno->desactivar();
	
	echo "";
	exit();
}

echo "<h3>La tabla se encuentra en proceso de modificacion, puede acceder a los instrumentos para revisarlos.</h3>";




$array_carreras_listado = $carreras->traer_carreras();


foreach($array_carreras_listado as $array_carrera)
{
	if($_REQUEST['carrera_seleccionada']==$array_carrera['carr_id'])
	{
		$seleccion = "selected";
	}
	else
	{
		$seleccion = "";
	}
	
	$arra_carreras.= "<option ".$seleccion." value='".$array_carrera['carr_id']."'>".$array_carrera['carr_descripcion']."</option>";

}

if($_REQUEST['salida']=="" or $_REQUEST['salida']=="Pantalla" )
{
echo "<form name='form_alumnos' id='form_alumnos'>";
echo "<table width='100%'><tr><td width='15%' bgcolor='#CCCCCD'>Carrera inscripto</td><td bgcolor='#CCCCCD'><select name='carrera_seleccionada' id='id_carrera_sele'><option value='0'>Todas</option>".$arra_carreras."</select></td></tr>
<tr><td bgcolor='#CCCCCD'>Intancias</td><td bgcolor='#CCCCCD'><select name='instancia' id='id_insta'><option value='0'>Todas</option></select></td></tr><tr><td bgcolor='#CCCCCD'>Documento</td><td bgcolor='#CCCCCD'><input bgcolor='#CCCCCD' type='text' name='numero_docu' id='numero_docu' value='".$_REQUEST['numero_docu']."'></input></td></tr>";
}

$array_formularios = $formularios->showForm();
$cont=0;
foreach($array_formularios as $form_valor)
{
	$lol_form[$cont++]=$form_valor['orden_form'];
	//if($form_valor['id']=="1" || $form_valor['id']=="2" || $form_valor['id']=="18" || $form_valor['id']=="22" || $form_valor['id']=="21" )
	//{ 
		if(in_array($form_valor['id'],$_REQUEST['valor_instrumento']))
		{
			$checked_1="checked";
		}
		else
		{
			$checked_1="";
		}
//------MCO filtro por formularios			echo "<tr><td colspan='2' bgcolor='#CCCCCC'>".utf8_decode($form_valor['descripcion'])."<input type='checkbox'  ".$checked_1." name='valor_instrumento[]' value=".$form_valor['id']."></input></td><td></td></tr>";
		
	//}
}

if($_REQUEST['salida']=="" or $_REQUEST['salida']=="Pantalla" )
{

require_once("cabecera_ajax.php");

?>
<script>

function modificar_estado(documento)
{
	valor = document.getElementById('img_1_'+documento).src;
	if(valor=="http://sit.frgp.utn.edu.ar/aspirantes/images/fuera.png")
	{
		document.getElementById('img_1_'+documento).src = "http://sit.frgp.utn.edu.ar/aspirantes/images/dentro.png"; 
		ajax_loadContent('div_guardar',"reporte_instrumentos_cargados_alumnos.php?accion=habilitar&documento="+documento);
	}
	else
	{
		document.getElementById('img_1_'+documento).src = "http://sit.frgp.utn.edu.ar/aspirantes/images/fuera.png";
		ajax_loadContent('div_guardar',"reporte_instrumentos_cargados_alumnos.php?accion=deshabilitar&documento="+documento);
	}
	
	
}

</script>

<?php


echo "<tr><td colspan='1' bgcolor='#CCCCCC'>Fecha desde:</td><td bgcolor='#CCCCCC'>";
echo '<input type="text" class="input_text" name="fecha_desde" id="calendar1" value="'.$_REQUEST["fecha_desde"].'" ></input>';
echo "</td></tr>";
echo "<tr><td colspan='1' bgcolor='#CCCCCC'>Fecha hasta:</td><td bgcolor='#CCCCCC'>";
echo '<input type="text" class="input_text" name="fecha_hasta" id="calendar2" value="'.$_REQUEST["fecha_hasta"].'" ></input>';
echo "</td></tr>";

echo "<tr><td colspan='2' bgcolor='#CCCCCC'>Ingreso<input type='checkbox' name='ingreso' value='ingreso'></input> No ingreso<input type='checkbox' name='noingreso' value='noingreso'></input></td></tr>";
echo "<tr><td colspan='2' bgcolor='#CCCCCC'><input type='radio' name='salida' checked value='Pantalla'>Pantalla</input><input type='radio' name='salida' value='Excel'>Excel</input></td></tr>";
echo "<tr><td colspan='2' bgcolor='#CCCCCC'>Asignados a mi<input type='checkbox' name='tutor' value='".$_SESSION['id']."'></input></td></tr>";
echo "<tr><td colspan='2'><input type='submit' value='buscar'></input></td></tr>";
echo "<tr><td><input type='hidden' name='guardar' value='guardar'></input></td></tr>";
echo "</table>";
echo "</form>";
echo "<div id='div_guardar'></div>";

}elseif($_REQUEST['salida']=='Excel')
{
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=reporte_instrumentos.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
}

$id_instancia = $_REQUEST['instancia'];
$id_carrera   = $_REQUEST['carrera_seleccionada'];
$documento    = $_REQUEST['numero_docu'];

echo "<div style='width:99%;height:500Px;overflow:auto;align:center;'>";

if($_REQUEST['ingreso']!="")
{
	$ingreso="1)";
}


if($_REQUEST['noingreso']!="")
{
	$ingreso="0 or  ingreso is null)";
}


if($_REQUEST['guardar']!="")
{

if($_REQUEST['tutor']=="")
{
	$_REQUEST['tutor']=0;
}


$alumnos_mutantes = $alumno->traer_alumnos($id_instancia,$id_carrera,$documento,$ingreso,$_REQUEST["fecha_desde"],$_REQUEST["fecha_hasta"],$_REQUEST['tutor']);

echo "<table width='100%' id='tabla_reporte'>";
echo "<tr>";
echo "<td width='50%'>";
echo "<table cellspacing='2' cellpadding='2' width='100%'>";
echo "<tr>";
echo "<td bgcolor='#CCCCCD'>";
echo "Estado";
echo "</td>";
echo "<td bgcolor='#CCCCCD'>";
echo " Nombre";
echo "</td>";
echo "<td bgcolor='#CCCCCD'>";
echo " Apellido";
echo "</td>";
echo "<td bgcolor='#CCCCCD'>";
echo " Documento";
echo "</td>";
echo "<td bgcolor='#CCCCCD'>";
echo "E-mail";
echo "</td>";
echo "<td bgcolor='#CCCCCD'>";
echo "Telefono";
echo "</td>";
//print_r($array_formularios);
$cant_forms=0;
foreach($array_formularios as $form_valor){

	echo "<td bgcolor='#CCCCCD'>";
	echo utf8_decode($form_valor['descripcion']);
	echo "</td>";
	$cant_forms++;
	$array_idforms[$form_valor['id']]=$form_valor['lugar_reporte'];

}

echo "<td bgcolor='#CCCCCD'>";
echo "RIESGO";
echo "</td>";


echo "<td bgcolor='#CCCCCD'>";
echo "PER1";
echo "</td>";
echo "<td bgcolor='#CCCCCD'>";
echo "PER2";
echo "</td>";
echo "<td bgcolor='#CCCCCD'>";
echo "Tutor";
echo "</td>";
echo "</tr>";

$color_fondo = "#CCCCEE";

foreach($alumnos_mutantes as $mutar)
{

$aluform = new alumnosFormularios($mutar['dni']);


if($color_fondo == "#CCCCEE")
{
	$color_fondo = "#FFFFFF";
}
else
{
	$color_fondo = "#CCCCEE";
}

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
					if($mutar['ingreso']==1)
						echo "<img src='images/dentro.png' style='cursor:pointer;' alt='Deshabilitar' id='img_1_".trim($mutar['dni'])."' onclick='modificar_estado(".trim($mutar['dni']).")' />";
					else
						echo "<img src='images/fuera.png' style='cursor:pointer;' alt='Habilitar' id='img_1_".trim($mutar['dni'])."' onclick='modificar_estado(".trim($mutar['dni']).")'/>";
				}
				
				if($_REQUEST['salida']=="Excel")
				{
					if($mutar['ingreso']=="1")
					{
						echo "INGRES&oacute;";
					}
					else
					{
						echo "NO INGRES&oacute;";
					}
				}
				echo "</td>";

			
				echo "<td bgcolor='".$color_fondo."'>";
				echo utf8_decode($mutar['nombre']);
				echo "</td>";
			
		
				echo "<td bgcolor='".$color_fondo."'>";
				echo utf8_decode($mutar['apellido']);
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
							//$valorcete = load($url);
							//echo $url;
							//echo "<br>";
							//$stream = fopen($url, 'r');
							//stream_set_timeout($stream, 1,500);
							//$page = stream_get_contents($stream);
							//fclose($stream);
							echo "<script>window.open('".$url."','popup".$mutar['dni']."','width=300,height=400')</script>";
							
							
														//$valx = load("reporteform.php?id_alumno=".$mutar['dni']."&id_formulario=".$form1['idform']."&formulario=encuesta_inicial");
							/*$url = "http://sit.frgp.utn.edu.ar/academica/reporteform.php?id_alumno=".$mutar['dni']."&id_formulario=".$form1['idform']."&formulario=encuesta_inicial";
							$stream = fopen($url, 'r');
							stream_set_timeout($stream, 1);
							$page = stream_get_contents($stream);
							fclose($stream);*/
							
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




			/*foreach($array_formularios as $form1)
				{
					echo "<td bgcolor='".$color_fondo."'>";
					$cant_forms_alumno--;
						if($form1['fecha_realizacion']!="")
						{
							//$url = "http://sit.frgp.utn.edu.ar/academica/reporteform.php?id_alumno=".$mutar['dni']."&id_formulario=".$form1['idform']."&formulario=encuesta";
							//$stream = fopen($url, 'r');
							//stream_set_timeout($stream, 1);
							//$page = stream_get_contents($stream);
							//fclose($stream);
							
							echo "<a target='_blank' href='reporteform.php?id_alumno=".$mutar['dni']."&id_formulario=".$form1['idform']."&formulario=".$form1['lugar_reporte']."'>REALIZADO [".$form1['campo_magico']."]</a>";
							
						}
						else
						{
							
							echo "ASIGNADO ";
							
						}
					echo "</td>";	
				}

			while($cant_forms_alumno)
			{
				
				echo "<td bgcolor='".$color_fondo."'>";
				echo "lol nada - $cant_forms_alumno</td>";
				$cant_forms_alumno--;
			}*/


echo "<td bgcolor='".$color_fondo."'>";

$Riesg01 = new Riesgo();
$rie1 = $Riesg01->riesgo_foda(trim($mutar['dni']));

if($cantidad_riesgo>=3 || $rie1==1)
{
	echo "<font color='RED'>ALTO</font>";
	$Riesg01->guardar_riesgo($mutar['dni'],"ALTO");
}
elseif($cantidad_riesgo==2)
{
	echo "<font color='BLUE'>MEDIO</font>";
	$Riesg01->guardar_riesgo($mutar['dni'],"MEDIO");
}
elseif($cantidad_riesgo==1)
{
	echo "<font color='YELLOW'>BAJO</font>";
	$Riesg01->guardar_riesgo($mutar['dni'],"BAJO");
}
elseif($cantidad_riesgo==0)
{
	echo "<font>NULO</font>";
	$Riesg01->guardar_riesgo($mutar['dni'],"NULO");
}elseif($cantidad_riesgo=="-1")
{
	echo "INCOMPLETO";
}

echo "</td>";	
///percepcion 1
require_once("class.tutores.php");
$tutor = new Tutores();
$array_de_cosas[1]="ALTA";
$array_de_cosas[2]="MEDIA";
$array_de_cosas[3]="BAJA";
$array_de_cosas[4]="NULA";
echo "<td bgcolor='".$color_fondo."'>";
	$var=$tutor->percepcion_alumno($mutar['dni'],1);
	echo $array_de_cosas[$var[0]['percepcion']];
	
echo "</td>";
///percepcion 2
echo "<td bgcolor='".$color_fondo."'>";
	$var=$tutor->percepcion_alumno($mutar['dni'],2);
	echo $array_de_cosas[$var[0]['percepcion']];
echo "</td>";
echo "<td bgcolor='".$color_fondo."'>";
$tutor1 = new Tutores();
$id_tutor = $tutor1->devolver_tutor($mutar['dni']);
$resultados_tutor = $tutor1->obtener_tutores();

foreach($resultados_tutor as $res_tut)
{
	if(trim($res_tut['id'])==$id_tutor[0]['id_tutor'])
	{
		echo $res_tut['nombre']." ".$res_tut['apellido'];
	}	
}


echo "</td>";
echo "</tr>";
}

echo "</div>";
}
?>