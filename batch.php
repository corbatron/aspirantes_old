<?php
session_start();


 
$_REQUEST['id_alumno']=$argv[1];
$_REQUEST['id_formulario']=$argv[2];
$_REQUEST['formulario']=$argv[3];



$_SESSION['nombre_base']=$argv[4];

$_SESSION['id']=$argv[1];
$_SESSION['id_carrera']=$argv[5];
$_SESSION['usuario']=$argv[1];


print_r($_SESSION);
include("reporteform.php");

//print_r($_SESSION);




?>