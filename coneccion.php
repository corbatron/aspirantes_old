<?php
class Coneccion
{
var $coneccion;
function Coneccion()
{
session_start();
//$datos_configuracion = parse_ini_file("../restricted/configuracion.sit.ini","conexion");
$datos_configuracion = parse_ini_file("/var/www/restricted/configuracion.sit.ini","conexion");

$servidor = $datos_configuracion['conexion']['servidor'];
$usuario  = $datos_configuracion['conexion']['usuario'];
$pass     = $datos_configuracion['conexion']['pass'];
$port     = $datos_configuracion['conexion']['port'];
$base     = $datos_configuracion['conexion']['base']."_".$_SESSION['nombre_base'];




$coneccion = pg_connect("host=$servidor port=$port user=$usuario password=$pass dbname=$base");

}
function query($consultasql)
{

//session_start();
if($_SESSION['id']=="" OR $_SESSION=="")
{
?>
<script>
alert("Su sesion se ha vencido y sera redireccionado a la pagina principal");
window.top.location.href = "http://aspirantes.frgp.utn.edu.ar/aspirantes/index.php";</script> 

<?php
die();
}


  ///////// - Hace un log
$path =  getcwd();
$path .= "/logs";
//opendir($path);

$archivo= trim($_SESSION['id'])."_".trim($_SESSION['nombre_base'])."log.txt"; // el nombre de tu archivo
$fecha = getdate();
$datos = $fecha['mday']."/".$fecha['mon']."/".$fecha['year']." - ".$fecha['hours'].":".$fecha['minutes'].":".$fecha['seconds'];
$contenido= $datos." - ".$_SESSION['id']." - ".$consultasql."\r\n"; // Recibez el formulario
$fch= fopen("/var/www/logs/".$archivo, "a+"); // Abres el archivo para escribir en &eacute;l
fwrite($fch, $contenido); // Grabas
fclose($fch); // Cierras el archivo.


  ////////////////

$resultado = pg_query($consultasql);


$resultado_devolver = null;
while($res = pg_fetch_array($resultado)){
	$resultado_devolver[]=$res;
	}
	return $resultado_devolver;
	}


}
?>
