<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<title>UTN</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link rel="stylesheet" type="text/css" href="estilo.css">
<link rel="stylesheet" type="text/css" href="estilo2.css">
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="shortcut icon" href="bootstrap/img/new_ppc.png">
<script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
<script type="text/javascript" src="bootstrap/dist/js/bootstrap.min.js"></script>

</head>

<body>
<?
include('class.drawingform.php');

$objeto= new DrawingForm();

echo "<table align='center'><tr><td>";
echo "Para volver a la pantalla principal haga click <a href='javascript:redirect();'>aqu&iacute;</a>";
echo "</td></tr></table>";

echo '<div class="form-container">';
//$objeto->DrawFieldsetOpen("asdasd");
$objeto->DrawFormQuestions("","",$_REQUEST['id_formulario'],$_REQUEST['id_materia']); 
//$objeto->DrawFieldsetClose();
echo "</div>";
echo "<iframe style='display:none' width='100%' height='40%'  name='iframeproceso'>";
echo "</iframe>";


?>
<script>

function validar()
{
	var valor;

	valor = confirm("\u00BFDesea enviar sus datos?");

	return valor;
}

function redirect()
{
	top.location.href="http://<?echo $_SERVER['HTTP_HOST']?>/aspirantes/main.php";
}


setInterval(function() { alert("Atencion: Su sesion esta por vencenrse, esto puede ocasionar perdida de datos"); }, 1000*60*20); // call on interval

</script>
