<?php
class Coneccion
{
var $coneccion;
function Coneccion()
{
session_start();
$datos_configuracion = parse_ini_file("configuracion.ini","conexion");
$servidor = $datos_configuracion['conexion']['servidor'];
$usuario  = $datos_configuracion['conexion']['usuario'];
$pass     = $datos_configuracion['conexion']['pass'];
$port     = $datos_configuracion['conexion']['port'];
$base     = $datos_configuracion['conexion']['base']."_".$_SESSION['nombre_base'];

/*

[conexion]

servidor="127.0.0.1"
usuario="postgres"
clave="1111"
port="5432"
base="formularios_tutorias"
pass="1111"


*/



$coneccion = pg_connect("host=$servidor port=$port user=$usuario password=$pass dbname=$base");
}
function query($consultasql)
{

  ///////// - Hace un log
/*
$archivo= "log.txt"; // el nombre de tu archivo
$fecha = getdate();
$datos = $fecha['mday']."/".$fecha['mon']."/".$fecha['year']." - ".$fecha['hours'].":".$fecha['minutes'].":".$fecha['seconds'];
$contenido= $datos." - ".$_SESSION['id']." - ".$consultasql."\r\n"; // Recibez el formulario
$fch= fopen($archivo, "a"); // Abres el archivo para escribir en él
fwrite($fch, $contenido); // Grabas
fclose($fch); // Cierras el archivo.
*/

  ////////////////

$resultado = pg_query($consultasql);

//session_start();
//$id = $_SESSION['id'];

//$consulta_log = "insert into logs (valor,fecha,id_usuario) select '".str_replace("'","*",$consultasql)."',now(),".$id;
//pg_query($consulta_log);

while($res = pg_fetch_array($resultado))
{
	
	$resultado_devolver[]=$res;
	
}
return $resultado_devolver;	
}

function Close()
	{

//$valor=pg_Close("host=$servidor port=$port user=$usuario password=$pass dbname=$base");

	}

}
?>
