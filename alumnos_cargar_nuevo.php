<?php
include('ver_login.php');
include('class.form.php');
$formularios = new Form(0);

require_once('coneccion.php');
include('class.alumnos.php');
include('class.carreras.php');
require_once("cabecera_ajax.php");

require_once("class.tutores.php");
$tutor = new Tutores();



$alumno   = new Alumno(0);
$carreras = new Carreras();

if($_REQUEST['accion']=="guardar")
{
$id_alumno = $_REQUEST['documento'];
$carrera = $_REQUEST['carrera'];
$tutor = $_REQUEST['tutor'];
$telefono = $_REQUEST['telefono'];
$al = new Alumno($id_alumno);
$al->modificar_carrera($carrera);
$al->modificar_tutor($tutor);
$al->modificar_telefono($telefono);
echo "Se modifico la carrera con exito";
exit();
	

}

if($_REQUEST['accion']=="clave")
{

$id_alumno = $_REQUEST['documento'];
$carrera = $_REQUEST['carrera'];
$tutor = $_REQUEST['tutor'];
$al = new Alumno($id_alumno);
$al->modificar_clave();
echo "Se modifico la carrera con exito";
exit();


}

echo "<div id='div_guardar_alumno'></div>";
?>
<script>
function cambiar_carrera(documento)
{	
	carrera_seleccionada = document.getElementById('select_carrera_'+documento).value;
	telefono = document.getElementById('tel_'+documento).value;
	tutor = document.getElementById('select_tutor_'+documento).value;
	ajax_loadContent('div_guardar_alumno',"alumnos_cargar_nuevo.php?accion=guardar&documento="+documento+"&carrera="+carrera_seleccionada+"&tutor="+tutor+"&telefono="+telefono); 
}

function cambiar_clave(documento)
{	
	carrera_seleccionada = document.getElementById('select_carrera_'+documento).value;
	tutor = document.getElementById('select_tutor_'+documento).value;
	ajax_loadContent('div_guardar_alumno',"alumnos_cargar_nuevo.php?accion=clave&documento="+documento); 
}

</script>
<?

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

echo "<table width='85%'>";
echo "<tr>";
echo "<td width='50%'>";
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
echo "<td bgcolor='#CCCCCD' width='10%'>";
echo "Email / <br> Telefono";
echo "</td>";
//echo "<td bgcolor='#CCCCCD'>";
//echo "Telefono";
//echo "</td>";
echo "<td bgcolor='#CCCCCD'>";
echo "Carrera";
echo "</td>";
echo "<td bgcolor='#CCCCCD'>";
echo "Tutor";
echo "</td>";
echo "<td bgcolor='#CCCCCD'>";
echo "Guardar";
echo "</td>";
echo "<td bgcolor='#CCCCCD'>";
echo "Clave";
echo "</td>";
echo "</tr>";

$color_fondo = "#CCCCEE";

foreach($alumnos_mutantes as $mutar)
{

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
				
				echo "<div style='background-color:#FEEC80;border-radius: 15px;'>";
				echo "<a href='mailto:".$mutar['mail']."&subject=Tutorias'>".$mutar['mail']."</a>";
				echo "<br>";
				
				echo "<textarea cols='40' rows='2' id='tel_".trim($mutar['dni'])."'>";
				echo $mutar['tel_linea'];
				echo "</textarea>";
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
				
				$array_tutores = $tutor->obtener_tutores("");//id
				
				$arra_tutores="";
				
				foreach($array_tutores as $array_tutor)
				{
					if($mutar['id_tutor'] == $array_tutor['id'])
					{
						$seleccionado="selected='selected'";
					}
					else
					{
						$seleccionado="";
					}
					
					
					$arra_tutores.= "<option value='".$array_tutor['id']."' ".$seleccionado.">".$array_tutor['nombre'].", ".$array_tutor['apellido']."</option>";

				}
				
				echo "<select name='select_carrera' id='select_carrera_".trim($mutar['dni'])."'>";
				echo $arra_carreras;
				echo "</select>";
				echo "</td>";
				echo "<td bgcolor='".$color_fondo."'>";
				echo "<select name='select_tutor' id='select_tutor_".trim($mutar['dni'])."'>";
				echo $arra_tutores;
				echo "</select>";
				echo "</td>";
				echo "<td>";
				echo "<input type='button' value='Guardar' onClick='cambiar_carrera(".trim($mutar['dni']).")'></input>";
				echo "</td>";
				echo "<td>";
				echo "<input type='button' value='Reiniciar' onClick='cambiar_clave(".trim($mutar['dni']).")'></input>";
				echo "</td>";
				
			

echo "</tr>";
}
echo "</table>";
echo "</td>";
echo "<td align='left' valign='top'>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<h2><u>Nuevo Alumno</u></h2>";
echo "<table>";
echo "<form name='form_nuevoalumno' id='form_nuevoalumno'>";
	echo "<table border='1'>";
		echo "<tr>";
		echo "<td>";
			echo "Nombre";
		echo "</td>";
		echo "<td>";
		echo "<input type='text' name='nombre_guardar'></input>";
		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>";
		echo "Apellido";
		echo "</td>";
		echo "<td>";
		echo "<input type='text' name='apellido_guardar'></input>";
		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>";
		echo "E-Mail";
		echo "</td>";
		echo "<td>";
		echo "<input type='text' name='mail_guardar'></input>";
		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>";
		echo "Tel&eacute;fono";
		echo "</td>";
		echo "<td>";
		echo "<input type='text' name='telefono_guardar'></input>";
		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>";
		echo "Documento";
		echo "</td>";
		echo "<td>";
		echo "<input type='text' name='documento_cargar' id='documento_cargar'></input>";
		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>";
		echo "Carrera";
		echo "</td>";
		echo "<td>";
		
		$carreras_mostrar = $arra_carreras;
		
		echo "<select name='carrera_guardar' id='carrera_guardar'>".$carreras_mostrar."</select>";
		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>";
		echo "</td>";
		echo "<td>";
		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>";
		echo "Formularios";
		echo "</td>";
		$arr_form_mostrar = $formularios->showForm();
		echo "<td>";
		foreach($arr_form_mostrar as $formulario)
		{
		
		if($formulario['estado']==1)
			{
			
			
				echo "<input type='checkbox' id='check_".$formulario['id']."' name='checkal1[]' value='".$formulario['id']."' >".$formulario['codigo']." - ".utf8_decode($formulario['descripcion'])."</input>";
				echo "<br>";
			}
		}
		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>";
		echo "<input type='submit' name='guar' value='Guardar'></input>";
		echo "</td>";
		echo "<td>";
		echo "</td>";
		echo "</tr>";
	echo "</table>";
	echo "</form>";
echo "</table>";

}

















?>