<?php
include('ver_login.php');
include('class.form.php');
if($_REQUEST['accion']=="borrar_problematica")
{

	require_once("class.tutores.php");
	$tutor = new Tutores();
	$tutor->borrar_problematica_alumno($_REQUEST['documento']);
	exit();
}
if($_REQUEST['accion']=="problematica")
{

	require_once("class.tutores.php");
	$tutor = new Tutores();
	$tutor->problematica_alumno($_REQUEST['documento'],$_REQUEST['id_prob'],$_REQUEST['fecha'],$_REQUEST['vez']);
	exit();
}
if($_REQUEST['accion']=="traer_problematica")
{

	require_once("class.tutores.php");
	$tutor = new Tutores();
	$array = $tutor->traer_problematica($_REQUEST['documento']);

        $var= "[";
        foreach ($array as $key => $value) {
          $var .= '{"clave":'.$key.',"valor":'.$value[0]."},";
	//	$var .= '{"clave":'.$key.',"valor":'.$value[0].',"fecha":'.$value[1]."},";
        }
        $var = substr($var,0,strlen($var)-1);
        $var.="]";
        echo $var;
        
	exit();
}
if($_REQUEST['accion']=="traer_problematica_fecha")
{

	require_once("class.tutores.php");
	$tutor = new Tutores();
	$array = $tutor->traer_problematica($_REQUEST['documento']);
        echo $array[0]['fecha_baja'];
        
	exit();
}


if($_REQUEST['accion']=="guardar_percepcion")
{
	//percepcion="+percepcion+"&tutor="+tutor+"&fecha="+fecha+"&descripcion="+descripcion+"&numero="+numero+"&documento="+documento
	require_once("class.tutores.php");

	$tutor = new Tutores();
//	print_R($_REQUEST);
	$tutor->grabar_percepcion($_REQUEST['tutor'],$_REQUEST['documento'],$_REQUEST['numero'],$_REQUEST['fecha'],$_REQUEST['descripcion'],$_REQUEST['percepcion'],$_REQUEST['tipo'],$_REQUEST['descripcion_2'],$_REQUEST['entrevista']);
	exit();
}
if($_REQUEST['accion']=="fecha")
{
	require_once("class.tutores.php");
	$tutor = new Tutores();
        $resultado_tutor = $tutor->percepcion_alumno($_REQUEST['documento'],$_REQUEST['percepcion']);
	echo $resultado_tutor[0]['fecha'];
exit();
}
if($_REQUEST['accion']=="descripcion")
{
	require_once("class.tutores.php");
	$tutor = new Tutores();
	$resultado_tutor = $tutor->percepcion_alumno($_REQUEST['documento'],$_REQUEST['percepcion']);
	echo $resultado_tutor[0]['texto'];

exit();
}
if($_REQUEST['accion']=="tutor")
{
	require_once("class.tutores.php");
	$tutor = new Tutores();
	$resultado_tutor = $tutor->percepcion_alumno($_REQUEST['documento'],$_REQUEST['percepcion']);
	echo $resultado_tutor[0]['id_tutor'];

exit();
}
if($_REQUEST['accion']=="percepcion")
{
	require_once("class.tutores.php");
	$tutor = new Tutores();
	$resultado_tutor = $tutor->percepcion_alumno($_REQUEST['documento'],$_REQUEST['percepcion']);
	echo $resultado_tutor[0]['percepcion'];

exit();
}
if($_REQUEST['accion']=="descripcion2")
{
	require_once("class.tutores.php");
	$tutor = new Tutores();
	$resultado_tutor = $tutor->percepcion_alumno($_REQUEST['documento'],$_REQUEST['percepcion']);
	echo $resultado_tutor[0]['texto2'];

exit();
}
if($_REQUEST['accion']=="tipo")
{
	require_once("class.tutores.php");
	$tutor = new Tutores();
	$resultado_tutor = $tutor->percepcion_alumno($_REQUEST['documento'],$_REQUEST['percepcion']);
	echo $resultado_tutor[0]['tipo'];

exit();
}
if($_REQUEST['accion']=="entrevista")
{
	require_once("class.tutores.php");
	$tutor = new Tutores();
	$resultado_tutor = $tutor->percepcion_alumno($_REQUEST['documento'],$_REQUEST['percepcion']);
	if($resultado_tutor[0]['espontanea']==1)
	{
		echo "true";
	}
	else
	{
		echo "false";
	}
	

exit();
}


$formularios = new Form(0);

require_once('coneccion.php');
include('class.alumnos.php');
include('class.carreras.php');
require_once("cabecera_ajax.php");
require_once("class.tutores.php");

?>
<script src='../aspirantes/js/jquery-1.6.1.min.js'></script>
<?php




$tutor = new Tutores();


$tutores = $tutor->obtener_tutores();




?>
 

<style type="text/css">

html, body, h1, form, fieldset, legend, ol, li {
	margin: 0;
	padding: 0;
}
body {
	background: #ffffff;
	color: #111111;
	font-family: Helvetica;
	padding: 20px;
	font-size: 12px
}

input:not([type=checkbox]), textarea {
	width: 250px;
	padding: 5px;
	border: 1px solid #ccc;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
}



form fieldset {
	padding: 26px;
	border: 1px solid #b4b4b4;
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
}

form legend {
	padding: 5px 20px 5px 20px;
	color: #030303;
	-moz-border-radius: 6px;
	-webkit-border-radius: 6px;
	border: 1px solid #b4b4b4;
}


form ol {
	list-style: none;
	margin-bottom: 20px;
	border: 1px solid #b4b4b4;
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
	padding: 10px;
}

form ol, form legend, form fieldset {
	background-image: -moz-linear-gradient(top, #f7f7f7, #e5e5e5); /* FF3.6 */
	background-image: -webkit-gradient(linear,left bottom,left top,color-stop(0, #e5e5e5),color-stop(1, #f7f7f7)); /* Saf4+, Chrome */
}

form ol.buttons {
	overflow: auto;
}

form ol li label {
	float: left;
	width: 160px;
	font-weight: bold;
	
}

/*
form ol.radio-buttons li {
	float:left;
margin-bottom:0;
width:8px;
}

form ol.radio-buttons li label {
	line-height:20px;
padding-right:20px;
width:80px;
}

form ol.radio-buttons li input {
padding:0;
width:20px;
}
*/

.settings {
	/* width: 400px; */
	list-style: none;
	position: relative;
}

.settings p {
	display: block;
	margin-bottom: 20px;
	background: -moz-linear-gradient(50% 50% 180deg,#C91A1A, #DB2E2E, #0C990C 0%); 
	background: -webkit-gradient(linear, 50% 50%, 0% 50%, from(#C90202), to(#009C05), color-stop(0,#00AB00));
	border-radius: 8px;
	-moz-border-radius: 6px;
	border: 1px solid #555555;
	width: 36px;
	position: relative;
	height: 15px;
}

/*
.settings p:before {
	content: "ON";
	padding-left: 9px;
	line-height: 15px;
	color: #fff;
	font-size: 14px;
	text-shadow: #093B5C 0px -1px 1px;

}

.settings p:after {
	content: "OFF";
	padding-left: 12px;
	line-height: 15px;
	color: #fff;
	font-size: 14px;
	text-shadow: #093B5C 0px -1px 1px;
}
*/

.check { 
	display: block;
	width: 20px;
	height: 13px;
	border-radius: 8px;
	-moz-border-radius: 6px;
	background: -moz-linear-gradient(19% 75% 90deg,#FFFFFF, #A1A1A1);
	background: #fff -webkit-gradient(linear, 0% 0%, 0% 100%, from(#A1A1A1), to(#FFFFFF));
	border: 1px solid #e5e5e5;
	position: absolute;
	top: 0px;
	left: 0px;
}



input[type=checkbox] {
	/*display: none;*/
}

@-webkit-keyframes labelON {
	0% {
		top: 0px;
    	left: 0px;
	}
	
	100% { 
		top: 0px;
    	left: 14px;
	}
}

input[type=checkbox]:checked + label.check {
	top: 0px;
	left: 14px;
	-webkit-animation-name: labelON; 
  	-webkit-animation-duration: .2s; 
  	-webkit-animation-iteration-count: 1;
  	-webkit-animation-timing-function: ease-in;
  	-webkit-box-shadow: #244766 -1px 0px 3px;
  	-moz-box-shadow: #244766 -1px 0px 3px;
}

@-webkit-keyframes labelOFF {
	0% {
		top: 0px;
    	left: 16px;
	}
	
	100% { 
		top: 0px;
    	left: 0px;
	}
}

input[type=checkbox] + label.check {
	top: 0px;
	left: 0px;
	-webkit-animation-name: labelOFF; 
  	-webkit-animation-duration: .2s; 
  	-webkit-animation-iteration-count: 1;
  	-webkit-animation-timing-function: ease-in;
  	-webkit-box-shadow: #244766 1px 0px 3px;
  	-moz-box-shadow: #244766 1px 0px 3px;
}

label.info {
	position: absolute;
	color: #000;
	top:0px;
	left: 50px;
	line-height: 15px;
	width: 200px;
}


form ol.buttons li {
	float: left;
	width: 200px;
}

input[type=submit] {
	width: 80px;
	color: #f3f3f3;
	-moz-border-radius: 6px;
	-webkit-border-radius: 6px;
	background-image: -moz-linear-gradient(top, #0cb114, #07580b); /* FF3.6 */
	background-image: -webkit-gradient(linear,left bottom,left top,color-stop(0, #07580b),color-stop(1, #0cb114)); /* Saf4+, Chrome */
	-webkit-box-shadow: #4b4b4b 0px 2px 5px;
	-moz-box-shadow: #4e4e4e 0px 2px 5px;
	box-shadow: #e3e3e3 0px 2px 5px;
	border: none;
}
input[type=reset] {
	width: 80px;
	color: #f3f3f3;
	-moz-border-radius: 6px;
	-webkit-border-radius: 6px;
	background-image: -moz-linear-gradient(top, #d01111, #7e0c0c); /* FF3.6 */
	background-image: -webkit-gradient(linear,left bottom,left top,color-stop(0, #7e0c0c),color-stop(1, #d01111)); /* Saf4+, Chrome */
	-webkit-box-shadow: #4b4b4b 0px 2px 5px;
	-moz-box-shadow: #4e4e4e 0px 2px 5px;
	box-shadow: #e3e3e3 0px 2px 5px;
	border: none;

}

input[type=file] {
	width: 80px;
}


</style>






<?php



$alumno   = new Alumno(0);
$carreras = new Carreras();

if($_REQUEST['accion']=="guardar")
{
$id_alumno = $_REQUEST['documento'];
$carrera = $_REQUEST['carrera'];
$al = new Alumno($id_alumno);
$al->modificar_carrera($carrera);
echo "Se modifico la carrera con exito";
exit();
	

}

echo "<div id='div_guardar_alumno'></div>";
?>
<script>
function cambiar_carrera(documento)
{	
	carrera_seleccionada = document.getElementById('select_carrera_'+documento).value;
	ajax_loadContent('div_guardar_alumno',"alumnos_cargar_nuevo.php?accion=guardar&documento="+documento+"&carrera="+carrera_seleccionada); 
}

</script>
<?php

if($_REQUEST['guar'])
{
	$nombre_alumno = $_REQUEST['nombre_guardar'];
	$apellido = $_REQUEST['apellido_guardar'];
	$documento = $_REQUEST['documento_cargar'];
	$mail = $_REQUEST['mail_guardar'];
	$telefono = $_REQUEST['telefono_guardar'];
	$id_carrera = $_REQUEST['carrera_guardar'];
	
	$alumno->insertar_alumno($nombre_alumno,$apellido,$documento,$mail,$telefono,$id_carrera);
	
	$formularios_cargar = $_REQUEST['checkal1'];

	if(count($formularios_cargar)>0)
	{
		foreach($formularios_cargar as $form)
		{
			$alumno->agregar_formulario($form);
		}

	}

}

$array_carreras_listado = $carreras->traer_carreras();


foreach($array_carreras_listado as $array_carrera)
{

	$arra_carreras.= "<option value='".$array_carrera['carr_id']."'>".$array_carrera['carr_descripcion']."</option>";

}

echo "<form name='form_alumnos' id='form_alumnos'>";
echo "<table width='100%'><tr><td width='15%' bgcolor='#CCCCCD'>Carrera inscripto</td><td bgcolor='#CCCCCD'><select name='carrera_seleccionada' id='id_carrera_sele'><option value='0'>Todas</option>".$arra_carreras."</select></td></tr>
<tr><td bgcolor='#CCCCCD'>Intancias</td><td bgcolor='#CCCCCD'><select name='instancia' id='id_insta'><option value='0'>Todas</option></select></td></tr><tr><td bgcolor='#CCCCCD'>Documento</td><td bgcolor='#CCCCCD'><input bgcolor='#CCCCCD' type='text' name='numero_docu' id='numero_docu'></input></td></tr>
<tr><td colspan='2'><input type='submit' value='buscar'></input></td></tr>
<tr><td><input type='hidden' name='guardar' value='guardar'></input></td></tr>
</table>";
echo "</form>";



$id_instancia = $_REQUEST['instancia'];
$id_carrera   = $_REQUEST['carrera_seleccionada'];
$documento    = $_REQUEST['numero_docu'];


if($_REQUEST['guardar']!="")
{

$alumnos_mutantes = $alumno->traer_alumnos($id_instancia,$id_carrera,$documento);

echo "<table width='100%'>";
echo "<tr>";
echo "<td width='100%'>";
echo "<table cellspacing='2' cellpadding='2' width='90%'>";
echo "<tr>";
echo "<td bgcolor='#CCCCCD'>";
echo " Nombre";
echo "</td>";
echo "<td bgcolor='#CCCCCD'>";
echo " Apellido";
echo "</td>";
echo "<td bgcolor='#CCCCCD' width='10%'>";
echo " Documento";
echo "</td>";
echo "<td bgcolor='#CCCCCD' width='1%'>";
echo "Email / <br> Telefono";
echo "</td>";
//echo "<td bgcolor='#CCCCCD'>";
//echo "Telefono";
//echo "</td>";
echo "<td bgcolor='#CCCCCD'>";
echo "Carrera";
echo "</td>";
echo "<td bgcolor='#CCCCCD'>";
echo "Percepci&oacute;n";
echo "</td>";
echo "<td bgcolor='#CCCCCD'>";
echo "Problem&aacute;tica de discontinuidad <br> o no contactado";
echo "</td>";
echo "<td bgcolor='#CCCCCD'>";
echo "Seguimiento";
echo "</td>";

echo "</tr>";

$color_fondo = "#CCCCEE";

foreach($alumnos_mutantes as $mutar)
{

$mutar['dni'] = trim($mutar['dni']);

if($color_fondo == "#CCCCEE")
{
	$color_fondo = "#FFFFFF";
}
else
{
	$color_fondo = "#CCCCEE";
}


echo "<tr>";

			
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
				
				echo "<div style='background-color:#FEEC80;border-radius: 7px;padding-top: 4px;padding-right: 0px;padding-bottom: 0.25in;padding-left: 5em; width: 65%; '>";
				echo "<a href='mailto:".$mutar['mail']."&subject=Tutorias'>".substr($mutar['mail'],0,15)."...</a>";
				echo "<br>";
				echo $mutar['tel_linea'];
				echo "</div>";
				
				echo "</td>";
				
				//echo "<td bgcolor='".$color_fondo."'>";
				//echo $mutar['tel_linea'];
				//echo "</td>";
				echo "<td bgcolor='".$color_fondo."'>";
				
				$arra_carreras="";
				
				foreach($array_carreras_listado as $array_carrera)
				{
					if($mutar['idcarrera'] == $array_carrera['carr_id'])
					{
						$seleccionado="selected='selected'";
					}
					else
					{
						$seleccionado="";
					}
					
					
					$arra_carreras.= "<option value='".$array_carrera['carr_id']."' ".$seleccionado.">".$array_carrera['carr_descripcion']."</option>";

				}
				
				$arra_tutores="";
				
				foreach($array_tutores as $array_tutor)
				{
					if($mutar['idcarrera'] == $array_tutor['carr_id'])
					{
						$seleccionado="selected='selected'";
					}
					else
					{
						$seleccionado="";
					}
					
					
					$arra_carreras.= "<option value='".$array_tutor['carr_id']."' ".$seleccionado.">".$array_tutor['carr_descripcion']."</option>";

				}
				
				echo "<select name='select_carrera' disabled id='select_carrera_".trim($mutar['dni'])."'>";
				echo $arra_carreras;
				echo "</select>";
				echo "</td>";
				echo "<td>";
				echo "<img src='../aspirantes/images/1350079381_green01.png'  onclick='mostrar(".$mutar['dni'].",1);'/>";
				echo "<img src='../aspirantes/images/1350079427_green02.png' onclick='mostrar(".$mutar['dni'].",2);'/>";
                                echo "</td>";
                                echo "<td>";
                                echo "<img src='../aspirantes/images/close.gif' onclick='motivos(".$mutar['dni'].");'/>";
				echo "</td>";
                                echo "<td>";
                                echo "<a href='seguimiento.php?dni=".$mutar['dni']."'>Seguimiento</a>";
				echo "</td>";
				
			

echo "</tr>";
$documento = $mutar['dni'];

echo "<tr id='div_documento_".trim($mutar['dni'])."' style='display:none;'>";
echo "<td colspan='6'>";
echo "<fieldset style='width:100%;'>";
echo "<form id='form-".$mutar['dni']."'>";
echo "<table width='100%' style='width:100%;'>";

echo "<tr>";
echo "<td width='100%' bgcolor='#CECECE'>";
echo "<i><b>Percepci&oacute;n N°:</b></i>";
echo "<div id='div_".trim($mutar['dni'])."'></div>";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td width='100%' bgcolor='#CECECE'>";
echo "<ol>";
echo "<li>";
echo "<label for='select_tipo_".$mutar['dni']."'>"."Tipo de entrevista"."</label>";
echo "</li>";
echo "<li>";
echo "<select id='select_tipo_".$mutar['dni']."' name='select_tipo'>";
echo "<option value='0'></option>";
echo "<option value='1'>Intervenci&oacute;n</option>";
echo "<option value='2'>Asesoramiento</option>";
echo "<option value='3'>Recomendaci&oacute;n</option>";
echo "<option value='4'>No aplica</option>";
echo "</select>";
echo "</li>";
echo "</ol>";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td width='100%' bgcolor='#CECECE'>";
echo "<ol>";
echo "<li>";
echo "<label for='check_espontanea_".$mutar['dni']."'>"."Espont&aacute;nea"."</label>";
echo "</li>";
echo "<li>";
echo "<input type='checkbox' id='check_espontanea_".$mutar['dni']."' name='check_espontanea'>";
echo "</li>";
echo "</ol>";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td width='100%' bgcolor='#CECECE'>";
echo "<ol>";
echo "<li>";
echo "<label for='select_per_".$mutar['dni']."'>"."Percepci&oacute;n"."</label>";
echo "</li>";
echo "<li>";
echo "<select id='select_per_".$mutar['dni']."' name='select_per'>";
echo "<option value='1'>Alta</option>";
echo "<option value='2'>Media</option>";
echo "<option value='3'>Baja</option>";
echo "<option value='4'>Nula</option>";
echo "<option value='5'>Sin percepcion</option>";
echo "</select>";
echo "</li>";
echo "</ol>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td bgcolor='#CECECE'>";
echo "<ol>";
echo "<li>";
echo "<label for='tutor_".$mutar['dni']."'>"."Tutor"."</label>";
echo "</li>";
echo "<li>";

$tutores_array = "";
foreach($tutores as $val)
{
	$tutores_array.="<option value='".$val['id']."'>".$val['nombre']." ".$val['apellido']."</option>"; 
}


echo "<select id='tutor_".$mutar['dni']."' name='tutor'>";
echo $tutores_array;
echo "</select>";
echo "</li>";
echo "</ol>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td width='100%' bgcolor='#CECECE'>";
echo "<ol>";
echo "<li>";
echo "<label for='fecha_".$mutar['dni']."'>"."Fecha"."</label>";
echo "</li>";
echo "<li>";
echo "<input type='text' name='fecha' id='fecha_".$mutar['dni']."' width='10' length='10'>";
echo "</li>";
echo "</ol>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td width='100%' bgcolor='#CECECE'>";
echo "<ol>";
echo "<li>";
echo "<label for='descripcion".$mutar['dni']."'>"."Detalle de necesidades"."</label>";
echo "</li>";
echo "<li>";
echo "<textarea id='descripcion_".$mutar['dni']."'  name='descripcion' cols='100' rows='4'>";
echo "</textarea>";
echo "</li>";
echo "</ol>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td width='100%' bgcolor='#CECECE'>";
echo "<ol>";
echo "<li>";
echo "<label for='descripcion_2_".$mutar['dni']."'>"."Acuerdos logrados / Intervenciones"."</label>";
echo "</li>";
echo "<li>";
echo "<textarea id='descripcion_2_".$mutar['dni']."' name='descripcion_2' cols='100' rows='4'>";
echo "</textarea>";
echo "</li>";
echo "</ol>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td width='100%' bgcolor='#CECECE'>";
echo "<ol class='buttons'>";
echo "<li>";
echo "<input type='button' onClick='guardar_percepcion(".trim($mutar['dni']).")' class='button' value='Guardar'></input>";
echo "</li>";
echo "</ol>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<input type='hidden' name='percepcion_".trim($mutar['dni'])."' id='percepcion_".trim($mutar['dni'])."'></input>";
echo "</form>";
echo "</fieldset>";
echo "</td>";
echo "</tr>";






///////////MARIANO

echo "<tr id='div_abandono_".trim($mutar['dni'])."' style='display:none;'>";
echo "<td colspan='6'>";
echo "<fieldset style='width:100%;'>";
echo "<form id='form-".$mutar['dni']."'>";
echo "<table width='100%' style='width:100%;'>";

echo "<tr>";
echo "<td width='100%' bgcolor='#CECECE'>";
echo "<i><b></b></i>";
echo "<div id='div_".trim($mutar['dni'])."'></div>";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td width='100%' bgcolor='#CECECE'>";
echo "<ol>";
echo "<li>";
echo "<label for='fechabaja_".$mutar['dni']."'>"."Fecha"."</label>";
echo "</li>";
echo "<li>";
echo "<input type='text' name='fechabaja_".$mutar['dni']."' id='fechabaja_".$mutar['dni']."' width='10' length='10'>";
echo "</li>";
echo "</ol>";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td width='100%' bgcolor='#CECECE'>";
echo "<ol>";
echo "<li>";



echo "<label>Problem&aacute;tica</label>";
echo "</li>";
echo "<li>";



$con = new Coneccion();
$problematicas = $con->query("select * from problematicas order by prioridad");
$string = "";

$string = "<br>";
$copia = $problematicas;

foreach ($problematicas as $value) {
	if( $value['orden'] == 0){ 
		$string .= "<input type='CHECKBOX' id='prob_".$value['id']."_".$mutar['dni']."' name='prob_".$value['id']."_".$mutar['dni']."'></input>".utf8_decode($value['descripcion'])."<br>";
		if($value['campos_hijos'] != ""){
			foreach($problematicas as $campo){
				if( $campo['orden'] == 1){ 
					$string.="--- <input type='CHECKBOX' id='prob_".$campo['id']."_".$mutar['dni']."' name='prob_".$campo['id']."_".$mutar['dni']."'></input>".utf8_decode($campo['descripcion'])."<br>";
					if($campo['campos_hijos'] != ""){
						foreach($problematicas as $campojr){

							if( $campojr['orden'] == 2  ) 
							$string.="------ <input type='CHECKBOX' id='prob_".$campojr['id']."_".$mutar['dni']."' name='prob_".$campojr['id']."_".$mutar['dni']."'></input>".utf8_decode($campojr['descripcion'])."<br>";
			
						
						}

					}
				
				}
		}	

	
	}

	}
}




echo "<br>".$string;

echo "</li>";
echo "</ol>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td bgcolor='#CECECE'>";
echo "<ol>";
echo "<li>";

echo "</li>";
echo "</ol>";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td width='100%' bgcolor='#CECECE'>";
echo "<ol>";
echo "<li>";
//echo "<label for='descripcion".$mutar['dni']."'>"."Detalle"."</label>";
echo "</li>";
echo "<li>";
//echo "<textarea id='descripcion_".$mutar['dni']."' name='descripcion' cols='100' rows='4'>";
//echo "</textarea>";
echo "</li>";
echo "</ol>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td width='100%' bgcolor='#CECECE'>";
echo "<ol class='buttons'>";
echo "<li>";
echo "<input type='button' onClick='guardar_problematica(".trim($mutar['dni']).")' class='button' value='Guardar'></input>";
echo "</li>";
echo "</ol>";
echo "</td>";
echo "</tr>";
echo "</table>";
//echo "<input type='hidden' name='percepcion_".trim($mutar['dni'])."' id='percepcion_".trim($mutar['dni'])."'></input>";
echo "</form>";
echo "</fieldset>";
echo "</td>";
echo "</tr>";





}




echo "</table>";
echo "</td>";
echo "<td align='left' valign='top'>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<div id='div_guardar_percepcion'></div>";




}
















?>
<script>
function mostrar(documento,numero)
{

	estado = document.getElementById("div_documento_"+documento).style.display;
	

	
	if(estado=="none")
	{
		document.getElementById("div_documento_"+documento).style.display="table-row";
	}
	else
	{
		document.getElementById("div_documento_"+documento).style.display="none";
	}
		
		
		if(numero=="1")
		{ 
			texto="Entrevista en tiempo 2";
		}
		else
		{
			texto="Entrevista en tiempo 3";
		}
		
		document.getElementById("div_"+documento).innerHTML=texto;
		document.getElementById('percepcion_'+documento).value=numero;
		
	$.get('tutor_percepcion.php?accion=fecha&percepcion='+numero+'&documento='+documento, function(result) {
	$("#fecha_"+documento).val(result);
	});
	
	$.get('tutor_percepcion.php?accion=descripcion&percepcion='+numero+'&documento='+documento, function(result) {
	$("#descripcion_"+documento).val(result);
	});
	
	$.get('tutor_percepcion.php?accion=tutor&percepcion='+numero+'&documento='+documento, function(result) {
	$("#tutor_"+documento).val(result);
	});
	
	$.get('tutor_percepcion.php?accion=percepcion&percepcion='+numero+'&documento='+documento, function(result) {
	$("#select_per_"+documento).val(result);
	});
	
	$.get('tutor_percepcion.php?accion=tipo&percepcion='+numero+'&documento='+documento, function(result) {
	$("#select_tipo_"+documento).val(result);
	});
	
	$.get('tutor_percepcion.php?accion=descripcion2&percepcion='+numero+'&documento='+documento, function(result) {
	$("#descripcion_2_"+documento).val(result);
	});
	
	$.get('tutor_percepcion.php?accion=entrevista&percepcion='+numero+'&documento='+documento, function(result) {
	if(result=="true"){	$("#check_espontanea_"+documento).attr('checked', result);}
	});

	
}
function motivos(documento){
    estado = document.getElementById("div_abandono_"+documento).style.display;
	

	if(estado=="none")
	{
		document.getElementById("div_abandono_"+documento).style.display="table-row";
	}
	else
	{
		document.getElementById("div_abandono_"+documento).style.display="none";
	}
        
    	$.get('tutor_percepcion.php?accion=traer_problematica&documento='+documento, function(result) {

            result = $.parseJSON(result)
            $.each(result, function(clave, valor){
               // alert(clave + "-" + valor.valor);
               //prob_".$value['id']."_".$mutar['dni']."
               document.getElementById("prob_"+valor.valor+"_"+documento).checked = true;
            });
               
            } ) 


    	$.get('tutor_percepcion.php?accion=traer_problematica_fecha&documento='+documento, function(result) {	
		 document.getElementById("fechabaja_"+documento).value = result;
            } ) 


            
}
        
        
    
    
    


</script>
<script>

function guardar_percepcion(documento)
{	
	percepcion  = document.getElementById('select_per_'+documento).value;
	tutor      	= document.getElementById('tutor_'+documento).value;
	fecha      	= document.getElementById('fecha_'+documento).value;
	descripcion = document.getElementById('descripcion_'+documento).value;
	numero = document.getElementById('percepcion_'+documento).value;
	tipo = document.getElementById('select_tipo_'+documento).value;
	descripcion_2 = document.getElementById('descripcion_2_'+documento).value;
	entrevista = document.getElementById('check_espontanea_'+documento).checked;
	
	
	//descripcion = Base64.encode(descripcion);
	
	
	if(fecha=="")
	{
		 alert("debe completar el campo de fecha");
		 $('#fecha_'+documento).focus();
		 $('#fecha_'+documento).css({'border-color':'FF0000'});
		 return;
	}
	else
	{
		$('#fecha_'+documento).css({'border-color':'EEEEEE'});
	}
	
	if(descripcion=="")
	{
		 alert("debe completar la percepcion");
		 $('#descripcion_'+documento).focus();
		 $('#descripcion_'+documento).css({'border-color':'FF0000'});
		 return;
	}
	else
	{
		$('#descripcion_'+documento).css({'border-color':'EEEEEE'});
	}
	
	if(descripcion_2=="")
	{
		 alert("debe los acuerdos");
		 $('#descripcion_2_'+documento).focus();
		 $('#descripcion_2_'+documento).css({'border-color':'FF0000'});
		 return;
	}
	else
	{
		$('#descripcion_2_'+documento).css({'border-color':'EEEEEE'});
	}
	
	if(tipo=="0")
	{
		 alert("debe completar el tipo de entrevista");
		 $('#select_tipo_'+documento).focus();
		 $('#select_tipo_'+documento).css({'border-color':'FF0000'});
		 return;
	}
	else
	{
		$('#select_tipo_'+documento).css({'border-color':'EEEEEE'});
	}
	
	
	//descripcion=escape(descripcion);
	//alert(descripcion);
	
	$.post("tutor_percepcion.php?accion=guardar_percepcion", { percepcion: percepcion, tutor: tutor, fecha: fecha,descripcion: descripcion, numero:numero, documento: documento, tipo: tipo, descripcion_2: descripcion_2,entrevista: entrevista } );
	
	//ajax_loadContent('div_guardar_percepcion',"tutor_percepcion.php?accion=guardar_percepcion&percepcion="+percepcion+"&tutor="+tutor+"&fecha="+fecha+"&descripcion="+descripcion+"&numero="+numero+"&documento="+documento); 
	//alert("Los datos se guardaron satisfactoriamente");
	//alert("La percepcion se guardo satisfactoriamente");

}


function guardar_problematica(documento)
{	

	$.post("tutor_percepcion.php?accion=borrar_problematica", { documento: documento} );


	fecha = document.getElementById('fechabaja_'+documento).value;

	var array_probl = new Array();
	<?
		foreach ($problematicas as $value)
			echo "array_probl[".$value['id']."] = ".$value['id'].";\n";
	?>
	
	var array_selecccionados = new Array();
	contador = 1;
	for(id_prob=1; id_prob<array_probl.length ;id_prob++)	
		if(document.getElementById('prob_'+array_probl[id_prob]+"_"+documento).checked ){
			$.post("tutor_percepcion.php?accion=problematica", { id_prob: id_prob, documento: documento, fecha: fecha, vez: contador} );
			contador=2;
		}

	//alert("La/s problematicas se guardo/aron satisfactoriamente");

}
/**
*
*  Base64 encode / decode
*  http://www.webtoolkit.info/
*
**/
 
var Base64 = {
 
	// private property
	_keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
 
	// public method for encoding
	encode : function (input) {
		var output = "";
		var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
		var i = 0;
 
		input = Base64._utf8_encode(input);
 
		while (i < input.length) {
		
 
			chr1 = input.charCodeAt(i++);
			chr2 = input.charCodeAt(i++);
			chr3 = input.charCodeAt(i++);
 
			enc1 = chr1 >> 2;
			enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
			enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
			enc4 = chr3 & 63;
 
			if (isNaN(chr2)) {
				enc3 = enc4 = 64;
			} else if (isNaN(chr3)) {
				enc4 = 64;
			}
 
			output = output +
			this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
			this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);
 
		}
		
		return output;
	},
 
	// public method for decoding
	decode : function (input) {
		var output = "";
		var chr1, chr2, chr3;
		var enc1, enc2, enc3, enc4;
		var i = 0;
 
		input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
 
		while (i < input.length) {
 
			enc1 = this._keyStr.indexOf(input.charAt(i++));
			enc2 = this._keyStr.indexOf(input.charAt(i++));
			enc3 = this._keyStr.indexOf(input.charAt(i++));
			enc4 = this._keyStr.indexOf(input.charAt(i++));
 
			chr1 = (enc1 << 2) | (enc2 >> 4);
			chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
			chr3 = ((enc3 & 3) << 6) | enc4;
 
			output = output + String.fromCharCode(chr1);
 
			if (enc3 != 64) {
				output = output + String.fromCharCode(chr2);
			}
			if (enc4 != 64) {
				output = output + String.fromCharCode(chr3);
			}
 
		}
 
		output = Base64._utf8_decode(output);
 
		return output;
 
	},
 
	// private method for UTF-8 encoding
	_utf8_encode : function (string) {
		string = string.replace(/\r\n/g,"\n");
		var utftext = "";
 
		for (var n = 0; n < string.length; n++) {
 
			var c = string.charCodeAt(n);
 
			if (c < 128) {
				utftext += String.fromCharCode(c);
			}
			else if((c > 127) && (c < 2048)) {
				utftext += String.fromCharCode((c >> 6) | 192);
				utftext += String.fromCharCode((c & 63) | 128);
			}
			else {
				utftext += String.fromCharCode((c >> 12) | 224);
				utftext += String.fromCharCode(((c >> 6) & 63) | 128);
				utftext += String.fromCharCode((c & 63) | 128);
			}
 
		}
 
		return utftext;
	},
 
	// private method for UTF-8 decoding
	_utf8_decode : function (utftext) {
		var string = "";
		var i = 0;
		var c = c1 = c2 = 0;
 
		while ( i < utftext.length ) {
 
			c = utftext.charCodeAt(i);
 
			if (c < 128) {
				string += String.fromCharCode(c);
				i++;
			}
			else if((c > 191) && (c < 224)) {
				c2 = utftext.charCodeAt(i+1);
				string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
				i += 2;
			}
			else {
				c2 = utftext.charCodeAt(i+1);
				c3 = utftext.charCodeAt(i+2);
				string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
				i += 3;
			}
 
		}
 
		return string;
	}
 
}

setInterval(function() { alert("Atencion: Su sesion esta por vencenrse, esto puede ocasionar perdida de datos"); }, 1000*60*20); // call on interval



</script>