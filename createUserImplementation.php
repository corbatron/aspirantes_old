<?
session_start();
$_SESSION['nombre_base']=date("Y");
$_SESSION['id']="register";
include("class.alumnos.php");

$dni=$_POST['documento'];
$nombre=$_POST['nombre'];
$apellido=$_POST['apellido'];
$carrera=$_POST['carrera'];

$alumnoObj = new Alumno($dni);


if($alumnoObj->get_id()!=""){
	session_destroy();
	echo "KO";
	return;
}else{
	$alumnoObj->insertar_alumno($nombre,$apellido,$dni,"","",$carrera);
	echo "OK";
	session_destroy();
	return;
}
?>
