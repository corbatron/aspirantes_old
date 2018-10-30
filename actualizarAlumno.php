<?php
session_start();
include('coneccion.php');
include('class.alumnos.php');	
$alumno=new Alumno($_SESSION['id']);
$id_alumno = $_SESSION['id'];
?>
<form method="post" action="modificar_alumno.php" target='iframe_modificar' enctype="multipart/form-data">
<input type='hidden' name='alumnos' id='alumnos' value='<? echo $_SESSION['id']; ?>'></input>
<div class="box">
	<h1>Por favor verifique sus datos personales :</h1>
	<label>
    <span>Foto de perfil (opcional)</span>
    <input type="file" name="photo" id="photo">
    </label>
    <label>

    <span>Fecha de nacimiento</span>
    <input type="text" class="input_text" name="fecha_nac" id="calendar1" id="email" value="<? echo $alumno->get_fechaNac();?>"/>dd/mm/aaaa
    </label>
    <label>
    <span>Tel&eacute;fono de l&iacute;nea</span>
    <input type="text" maxlength="15" class="input_text" name="telefono" id="telefono" value="<? echo $alumno->get_telLinea();?>" />
    </label>
    <label>
    <span>Tel&eacute;fono celular</span>
    <input type="text" maxlength="15" class="input_text" name="celular" id="celular" value="<? echo $alumno->get_telCel();?>" />
    </label>
    <label>
    <span>Email</span>
    <input type="text" maxlength="100" class="input_text" name="email" id="email" value="<? echo $alumno->get_mail();?>" />
    </label>
    <label>
    <span>Password</span>
    <input type="password" maxlength="15" class="input_text" name="pass" id="pass" value="<? echo $alumno->get_pass();?>" />
    </label> 
    <label>
    <span>Password</span>
    <input type="password" maxlength="15" class="input_text" name="pass2" id="pass2" value="<? echo $alumno->get_pass();?>" />
    </label>
	<label>
    <input type="submit" class="button" value="Aceptar" />
    </label>
</form>
<iframe style='display:none' width='300' height='100' name='iframe_modificar' id='iframe_modificar'></iframe>
</div>