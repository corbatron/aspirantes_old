<?
//error_reporting(0);
include('ver_login.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<title>UTN</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link rel="stylesheet" type="text/css" href="estilo.css">
<link rel="stylesheet" type="text/css" href="estilo2.css">
</head>
<body bgcolor="#EFFFFE">
<?


include('class.form.php');
include('class.alumnos.php');
include('class.alumnosFormularios.php');
$id_alumno = $_SESSION['id']; 
$alumno = new Alumno($id_alumno);
$formularios = new alumnosFormularios($id_alumno);
session_start();
$formu=$formularios->traerForms();
$directorio = $_SERVER['HTTP_HOST']."/aspirantes";
//Encabezado con los datos personales 




if($_REQUEST['email']!="")
{

	$email = $_REQUEST['email'];

}
if($_REQUEST['texto']!="")
{

	$texto=$_REQUEST['texto'];

}

if($texto!="" && $email!="")
{

	$alumno->enviar_mensaje($email,$texto);

}

echo "<div id='div_contacto' name='contacto' style='width:500Px;height:200Px;background-color:#CCCCCD;position:absolute;left:550px;top:50px;border:1Px solid;display:none'>
<form>
<table><tr><td>
e-mail</td><td><input type='text' name='email' size='40'></input></td></tr>
<tr>
<td>
comentario
</td>
<td>
<textarea cols='50' rows='7' name='texto'>

</textarea>
</td>
</tr>
<tr>
<td>
<input type='submit' value='enviar'></input>
</td>
<td>
</td>
</tr>
</table></div>
</form>";
echo '<table width="100%"><tr><th style="text-align:left">';
echo 'Nombre y apellido:&nbsp;'.$alumno->get_nombre().',&nbsp;'.$alumno->get_apellido();
echo '</th><th style="text-align:right">';
echo 'DNI:&nbsp;'.$alumno->get_id();
echo '</th></tr></table>';
echo '<br>';
//Listado de formularios disponibles para completar y ya completados
echo '<table width="70%" align="center" cellpadding="2" cellspacing="2"><tr><th colspan="2" bgcolor="#CCCCCC">';
echo 'Formularios disponibles';
echo '</th></tr>';

foreach($formu as $form){
	if($form['campo_magico'] == "" && $form['fecha_realizacion'] != "") {
		session_start();
	//	exec("/usr/bin/php /var/www/html/aspirantes/batch.php ".trim($alumno->get_id())." ".trim($form['idform'])." ".trim($form['lugar_reporte'])." ".trim($_SESSION['nombre_base'])." ".trim($_SESSION['id_carrera'])." >/dev/null 2>/dev/null &");
		exec("/usr/bin/php /var/www/html/aspirantes/batch.php ".trim($alumno->get_id())." ".trim($form['idform'])." ".trim($form['lugar_reporte'])." ".trim($_SESSION['nombre_base'])." ".trim($_SESSION['id_carrera']));
	

	}
 }
$formu=$formularios->traerForms();





foreach($formu as $form){
	echo '<tr><td  width="50%" bgcolor="#CCCCCC">';
	echo $formularios->get_descripcion($form[0]);
	echo '</td><td bgcolor="#CCCCCC">';
	if( $form[2] == "0000-00-00" or $form[2] == ""){
		echo "<a href='#' onclick='ir_formulario(".$form[0].")'><u>Completar</u></a>";
	}else{
                if($form['campo_magico']=="OP") $form['campo_magico']="Orientaci&oacute;n Parcial";
                if($form['campo_magico']=="T") $form['campo_magico']="Orientaci&oacute;n Total";
                if($form['campo_magico']=="D") $form['campo_magico']="Desorientaci&oacute;n";

                
                
		echo 'Instrumento completado el d&iacute;a &nbsp;'.$form[2].' / resultado:&nbsp;'.$form['campo_magico'] ;
	}
}
echo '</td></tr></table>';
echo "<table width='100%' align='center'><tr><td width='100%' align='center'>&iquest;Tiene alg&uacute;n inconveniente? Rep&oacute;rtelo haciendo click <a href='#' onclick='mostrar_div_mensajes();'>aqui</a>!!</td></tr></table>";
?>
</body>
<script>
function ir_formulario(id)
{
	document.location="http://<?echo $_SERVER['HTTP_HOST']?>/aspirantes/index_pregunta.php?id_formulario="+id;
}

function mostrar_div_mensajes()
{
	if(document.getElementById('div_contacto').style.display=="block")
	{
		document.getElementById('div_contacto').style.display="none";
	}
	else
	if(document.getElementById('div_contacto').style.display=="none")
	{
		document.getElementById('div_contacto').style.display="block";
	}
}






</script>
