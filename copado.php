<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<link rel="stylesheet" type="text/css" href="estilo.css">
<link rel="stylesheet" type="text/css" href="estilo2.css">
</head>

<body>
<?php
include('class.alumnos.php');	
$alumno=new Alumno($_REQUEST['$id']);

if($alumno->get_fechaNac() == "")	{


echo '<table><tr>
	<td>Tel&eacute;fono de l&iacute;nea</td>
	<td><input type="text" size="15" maxlength="15" name="telefono" id="telefono" value="'.$alumno->get_telLinea().'" /></td>
</tr>
<tr>
	<td>Tel&eacute;fono celular</td>
	<td><input type="text" size="15" maxlength="15" name="celular" id="celular" value="'.$alumno->get_telCel().'" /></td>
</tr>
<tr>
	<td>Mail</td>
	<td><input type="text" size="50" maxlength="100" name="mail" id="mail" value="'.$alumno->get_mail().'" /></td>
</tr>
<tr>
	<td>Password</td>
	<td><input type="password" size="15" maxlength="15" name="pass" id="pass" value="'.$alumno->get_pass().'" /></td>
</tr>
<tr>
	<td>Confirmar password</td>
	<td><input type="password" size="15" maxlength="15" name="pass2" id="pass2" value="'.$alumno->get_pass().'" /></td>
</tr>
</table>';
        
}
    


	
?>

</body>