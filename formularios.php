<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<title>UTN</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link rel="stylesheet" type="text/css" href="estilo.css">
<link rel="stylesheet" type="text/css" href="estilo2.css">

</head>

<body>
<?php
include('class.form.php');	


	$conexion = new Coneccion();
	
	
	if($_REQUEST['accion']=="eliminar")
	{
		$id_formulario_borrar = $_REQUEST['id_form'];
		$form_borrar = new Form($id_formulario_borrar);
		$form_borrar->delForm();

	}
	
	$formulario_1 = new Form("");

	$formularios = $formulario_1->showForm();
		
	echo '<table border="0" cellpadding="3" cellspacing="3" width="100%" style="font-family:arial;"><tr><th>Codigo</th><th>Descripcion</th><th>Estado</th><th>Duracion</th><th>Modificar</th><th>Eliminar</th></tr>';
	$color2="#D4D5ED";
	$color1="#9496ED";
	$color=color1;
	
	$directorio = $_SERVER['HTTP_HOST']."/aspirantes";
	
	foreach($formularios as $formu)
	{
		if($color==$color1)
		{
			$color=$color2;
		}
		else
		{
			$color=$color1;
		}
		if($formu['estado'] == 1)
		{
			$formu['estado'] = "Activo";
		}
		else
		{
			$formu['estado'] = "No activo";
		}
		
		
		
		echo '<tr><td bgcolor="'.$color.'">'.$formu['codigo'].'</td><td bgcolor="'.$color.'">'.$formu['descripcion'].'</td><td align="center" bgcolor="'.$color.'">'.$formu['estado'].'</td>';
		echo '<td bgcolor="'.$color.'">Desde '.$formu['fecha_desde'].' <br>Hasta '.$formu['fecha_hasta'].'</td>';
		echo '<td align="center" bgcolor="'.$color.'"><a href="http://'.$directorio.'/editform.php?id='.$formu['id'].'" ><img src="common/imgs/page_setup.gif"></a></td>';
		echo '<td align="center" bgcolor="'.$color.'"><a href="http://'.$directorio.'/formularios.php?id_form='.$formu['id'].'&accion=eliminar" ><img src="common/imgs/close.gif"></a></td></tr>';
	}
	
	echo '<tr><td colspan=6 bgcolor="#333333" align="right"><a href="http://'.$directorio.'/editform.php" style="color:#ffffff">A g r e g a r</input></a></td></tr>';
	echo '<table>';
	
?>

</body>