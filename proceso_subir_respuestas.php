<?
include('class.respuestas.php');
$id_pregunta=$_REQUEST['pregunta_tito'];
$tipo_respuesta=$_REQUEST['tito_respuesta'];
$contenidos=$_REQUEST['valores'];
$chekeados=$_REQUEST['checkeados'];

if($tipo_respuesta=='select')
{
	$respuestas = new Respuestas();
	$orden=0;
	foreach($contenidos as $cont)
	{
		$orden++;
	
		$respuestas->insertarRespuesta($cont,$id_pregunta,$tipo_respuesta,0);
	}
	
	$respuestas->insertarRespuesta($cont,$id_pregunta,$tipo_respuesta,1);
}
if($tipo_respuesta=='check')
{

	$respuestas = new Respuestas();
	foreach($contenidos as $cont)
	{
		$respuestas->insertarRespuesta($cont,$id_pregunta,$tipo_respuesta,in_array($cont,$chekeados));
	}
}

if($tipo_respuesta=='text')
{

	$respuestas = new Respuestas();
	foreach($contenidos as $cont)
	{
		$respuestas->insertarRespuesta($cont,$id_pregunta,$tipo_respuesta,0);
	}
}

if($tipo_respuesta=='area')
{

	$respuestas = new Respuestas();
	foreach($contenidos as $cont)
	{
		$respuestas->insertarRespuesta($cont,$id_pregunta,$tipo_respuesta,0);
	}
}




?>