<?php

$datos_configuracion = parse_ini_file("/var/www/restricted/configuracion.sit.ini","conexion");

$servidor = $datos_configuracion['conexion']['servidor'];
$usuario  = $datos_configuracion['conexion']['usuario'];
$pass     = $datos_configuracion['conexion']['pass'];
$port     = $datos_configuracion['conexion']['port'];
$base     = $datos_configuracion['conexion']['base']."_2017";

$coneccion = pg_connect("host=$servidor port=$port user=$usuario password=$pass dbname=$base");


$resultado = pg_query("select * from alumnoform where fecha_realizacion is not null and campo_magico is null");

while($res = pg_fetch_array($resultado))
{

    //$resultado_devolver[]=$res;
    print_r($res);
    $alumno = pg_query("SELECT * FROM alumnos WHERE dni=");
    echo "/var/www/html/aspirantes/batch.php ".trim($form['idform'])." ".trim($form['lugar_reporte'])." ".trim($_SESSION['nombre_base'])." ".trim($_SESSION['id_carrera']);
    exit();

}



?>
