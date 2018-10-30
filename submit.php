<?
session_start();
if($_POST['from']=='bugModal'){
	include("class.mensajes.php");
	$mensaje = new Mensaje();

	$detalle = base64_decode($_POST['detalle']);
	$detalle = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($detalle));
	$detalle = html_entity_decode($detalle ,null,'UTF-8');;

	$mensaje->enviar_mensaje_dni($_POST['dni'], base64_decode($_POST['mail']),$_SESSION['nombre_base']."-".$_POST['asunto']."-".$detalle );
	return 0;
}

if($_POST['from']=='crearFormulario'){

	include('class.form.php'); 

	
	$formulario_crear = new Form();
	$formulario_crear->set_codigo($_REQUEST['codigo']);
	
	$formulario_crear->set_estado(1);
	$formulario_crear->set_descripcion($_REQUEST['descripcion']);

	$formulario_crear->set_fecha_inicio("1999-01-01");
	$formulario_crear->set_fecha_fin("2099-01-01");

	$formulario_crear->set_descripcionLarga($_REQUEST['encabezado']);

	$formulario_crear->saveForm();

	return 0;
}
if($_POST['from']=='editarFormulario'){

	include('class.form.php'); 

	
	$formulario_crear = new Form($_REQUEST['formulario']);
	$formulario_crear->set_codigo($_REQUEST['codigo']);
	
	$formulario_crear->set_estado(1);
	$formulario_crear->set_descripcion($_REQUEST['descripcion']);

	$formulario_crear->set_fecha_inicio("1999-01-01");
	$formulario_crear->set_fecha_fin("2099-01-01");

	$formulario_crear->set_descripcionLarga($_REQUEST['encabezado']);

	$formulario_crear->saveForm();

	return 0;
}
if($_POST['from']=='deleteFormulario'){


	include('class.form.php');	
	$id_formulario_borrar = $_REQUEST['formulario'];
	$form_borrar = new Form($id_formulario_borrar);
	$form_borrar->delForm();
	return 0;



}
if($_POST['from']=='datosPersonales'){
	include("modificar_alumnos.php");
	return 0;
}
if($_REQUEST['from']=='cambiarUsuarioModal'){


	include('class.alumnos.php');	


	$alumno = new Alumno($_REQUEST['dni']);


	$_SESSION['id']=$_REQUEST['dni'];
	$_SESSION['usuario']=$_REQUEST['dni'];

	$_SESSION['nombre'] = $alumno->get_nombre();
	$_SESSION['apellido'] = $alumno->get_apellido();
	$_SESSION['id_carrera'] = $alumno->get_carrera();

	$_SESSION['perfil'] = 1;



	return 0;
}
if($_REQUEST['from']=='crearTutorModal'){
	include('class.tutores.php');	
	$tutor = new Tutores();
	$tutor->insertar_tutor($_REQUEST['nombre'],$_REQUEST['apellido'],$_REQUEST['dni']);

	return 0;
}

if($_REQUEST['from']=='setFechas'){
	session_start();
	$_SESSION['fecha_ini']=$_REQUEST['fechaInicio'];
	$_SESSION['fecha_fin']=$_REQUEST['fechafin'];	


	include('class.sysacad_fechas.php');	
	$sysfechas = new SysacadFechas();
	$sysfechas->escribir_fechas($_REQUEST['fechaInicio'],$_REQUEST['fechafin']);

	return 0;
}







?>