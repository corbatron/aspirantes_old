<?
include('class.form.php');
include('class.alumnos.php');

$target_dir = "/var/www/html/aspirantes/photos/".trim($_REQUEST['alumnos']);
$target_file = $target_dir . basename($_FILES["photo"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

if($imageFileType !="" &&  $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {

	echo "&nbsp;<script>alert('Solo los siguientes formatos son soportados: JPG, JPEG, PNG & GIF.')</script>";

	return(0);

	
} 

if($imageFileType != ""){

unlink($target_dir.'.jpg');
unlink($target_dir.'.jpeg');
unlink($target_dir.'.png');
unlink($target_dir.'.gif');
move_uploaded_file($_FILES["photo"]["tmp_name"], $target_dir.".".$imageFileType );

}



$id_usuario = $_REQUEST['alumnos'];
$password = $_REQUEST['pass'];
$fecha_nacimiento = $_REQUEST['fecha_nac'];
$telefono_linea = $_REQUEST['telefono'];
$telefono_celular = $_REQUEST['celular'];
$email = $_REQUEST['email'];
$confirmar_password = $_REQUEST['pass2'];
$carrera = $_REQUEST['carrera_seleccionada'];

if($password!=$confirmar_password)
{
	echo "&nbsp;<script>alert('Las claves son diferentes');</script>";
	return(0); //exit();
}

if($telefono_linea == "")
{
	echo "&nbsp;<script>alert('El telefono de linea es necesario para contactarlo, por favor proporcione uno.')</script>";
	return(0); //exit();
}

if($fecha_nacimiento=="")
{
	echo "&nbsp;<script>alert('La fecha de nacimiento es requerida');</script>";
	return(0); //exit();
}


$alumno = new Alumno($id_usuario);

$array_datos['id']       = $id_usuario;
$array_datos['password']           = $password;
$array_datos['fecha_nacimiento']   = $fecha_nacimiento;
$array_datos['telefono_linea'] 	   = $telefono_linea;
$array_datos['telefono_celular']   = $telefono_celular;
$array_datos['correo_electronico'] = $email;
$array_datos['carrera_seleccionada'] =  $carrera;
$valor = $alumno->set_datos($array_datos); 

if($valor=="1")
{
	 echo "&nbsp;<script>top.location.href='main.php';</script>";
}


?>
