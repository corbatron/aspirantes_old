<?php
session_start();

if ($_POST['firstname'] == "" || $_POST['lastname'] == "")
	{

	if ($_POST['indicator'] == "true")
		{
		echo "KO";
		exit();
		}
	session_destroy();

	Header("Location: /aspirantes/index.php?error=KO");

	}
  else
	{
	$anio_ingreso = $_REQUEST['anio_ingreso'];
	session_start();
	$_SESSION['id'] = $_POST['firstname'];
	$_SESSION['nombre_base'] = $_POST['anio_ingreso'];
	require ("coneccion.php");

	$conn = new Coneccion();
	$usuario = $_POST['firstname'];
	$password = $_POST['lastname'];
	$usuario = str_replace('UPDATE', '', $usuario);
	$usuario = str_replace('INSERT', '', $usuario);
	$usuario = str_replace('DELETE', '', $usuario);
	$usuario = str_replace('SELECT', '', $usuario);
	$usuario = str_replace('update', '', $usuario);
	$usuario = str_replace('insert', '', $usuario);
	$usuario = str_replace('delete', '', $usuario);
	$usuario = str_replace('select', '', $usuario);
	$_SESSION['usuario'] = $_POST['firstname'];
	$_SESSION['perfil'] = $_POST['lastname'];
	$resultado = $conn->query("select * from alumnos where (dni='" . $usuario . "' OR usuario='" . $usuario . "') and password='" . $password . "'");
	$_SESSION['id'] = "";
	if (count($resultado) > 0)
		{
		$_SESSION['id'] = $resultado[0]['dni'];
		$_SESSION['nombre'] = $resultado[0]['nombre'];
		$_SESSION['apellido'] = $resultado[0]['apellido'];
		$_SESSION['perfil'] = $resultado[0]['perfil'];
		$_SESSION['id_carrera'] = $resultado[0]['idcarrera'];


		$resultado = $conn->query("select * from sysacad_fechas");
		$_SESSION['fecha_ini']= $resultado[0]['fecha_inicio']; 
		$_SESSION['fecha_fin']= $resultado[0]['fecha_fin'];


		$query = "insert into masterlog (fecha,id) values (now(),'" . trim($_SESSION['id']) . "')";
		$resultado = $conn->query($query);

		if ($_POST['indicator'] == "true")
			{
			echo "OK";
			exit();
			}
		session_destroy();

		header("Location: /aspirantes/main.php");
		}
	  else
		{
		if ($_POST['indicator'] == "true")
			{
			echo "KO";
			exit();
			}

		Header("Location: /aspirantes/index.php?error=KO");
		}
	}

?>
