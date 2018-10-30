<?
include("ver_login.php");
include("coneccion.php");

session_start();
$coneccion = new Coneccion();


$documento=$_REQUEST['documento'];

$select_alumno="select * from alumnos where dni like '%".$documento."%'";
$resultado = $coneccion->query($select_alumno);

$documento_alumno = $resultado[0]['dni'];
$carrera = $resultado[0]['idcarrera'];

$_SESSION['usuario_anterior']  = $_SESSION['usuario'];
$_SESSION['id'] = $documento_alumno;
$_SESSION['id_carrera'] = $carrera;
$_SESSION['perfil'] = $resultado[0]['perfil'];
$_SESSION['nombre'] = "UTN FRGP";
$_SESSION['apellido'] = "UTN FRGP";

///MARIANO 06/09/2012 --- redireccion para no tener que apretar F5
echo "&nbsp;<script>location.replace('http://sit.frgp.utn.edu.ar/aspirantes/index_forms.php');</script>";

//echo "&nbsp;<script>location.reload();</script>";



?>