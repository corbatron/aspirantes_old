<?php
if($_GET['accion']=="getTutores"){
        require_once("class.tutores.php");
        $tutores = new Tutores();
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header("Content-type: application/json; charset=utf-8");


	$arrayTutores=$tutores->obtener_tutores();
	$cont=0;
	$nuevoArray= array();


	foreach($arrayTutores as $tutor){

		$nuevoArray[] = array('id' => $tutor["id"], 'name' => $tutor["nombre"]." ".$tutor["apellido"]);

		
		//array_push($nuevoArray, $arrayJson);
	
	}


	echo json_encode($nuevoArray);
	exit();
}

if($_POST['accion']=="setTutores"){
        require_once("class.tutores.php");
        $tutores = new Tutores();

       
	$arrayTutores=$tutores->actualizar_tutores($_POST['idTutor'],$_POST['idAlumno']);

	exit();
}
if($_POST['accion']=="resolverTicket"){
	require_once('class.mensajes.php');
	$mensajes = new Mensaje();
	$mensajes->resolverMensaje($_POST['id']);
	exit();
}

?>
