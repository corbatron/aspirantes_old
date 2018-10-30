<?
include('coneccion.php');
$coneccion =  new Coneccion();

echo "<form>";
echo "ID FORM";

echo "<input type='text' id='formulario' name='formulario' value='".$_REQUEST['formulario']."' ></input>";


echo "ID PREGUNTA";

$resultados_preguntas = $coneccion->query("select * from preguntas order by idpregunta");

foreach($resultados_preguntas as $preguntas)
{
	if($preguntas['idpregunta']==$_REQUEST['pregunta'])
		$sel="selected";
	else
		$sel="";
	$opciones_preguntas.= "<option $sel value='".$preguntas['idpregunta']."'>".$preguntas['idpregunta']."-".$preguntas['texto']."</option>";
}



echo "<select name='pregunta'>".$opciones_preguntas."</select>";

echo "ID RESPUESTA";


$resultados_respuesta = $coneccion->query("select * from respuestaspreg order by idpregunta");

foreach($resultados_respuesta as $respuestas)
{
	if($respuestas['id']==$_REQUEST['respuesta'])
		$sel="selected";
	else
		$sel="";
	
	$opciones_respuestas.= "<option $sel value='".$respuestas['id']."'>".$respuestas['idpregunta']."-".$respuestas['texto']."</option>";
}

echo "<select name='respuesta'>".$opciones_respuestas."</select>";

echo "CAUSA";

$resultados_causas = $coneccion->query("select * from causas");
foreach($resultados_causas as $causas)
{
	if($causas['id']==$_REQUEST['causas'])
		$sel="selected";
	else
		$sel="";
	
	$opciones_causas.= "<option $sel value='".$causas['id']."'>".$causas['id']."-".$causas['causa']."</option>";
}

echo "<select name='causas'>".$opciones_causas."</select>";
echo "<input type='submit' value='guardar'></input>";
echo "</form>";

print_R($_REQUEST);

$form=$_REQUEST['formulario'];
if($form!="")
{
	$respuesta=$_REQUEST['respuesta'];
	$pregunta=$_REQUEST['pregunta'];
	$causa=$_REQUEST['causas'];
	$var="select 1 from categoriasrespuestas where idformulario=".$form." and idrespuesta=$respuesta and idpregunta=$pregunta and causas=$causa" ; 
	$resultado_existe=$coneccion->query($var);
	if($resultado_existe[0][0]==1)
	{
		$asdf="update categoriasrespuestas set causas=".$causa." where idformulario=".$form." and idrespuesta=$respuesta and idpregunta=$pregunta";
			
	}
	else
	{
		$asdf="insert into categoriasrespuestas select $pregunta,$respuesta,$form,$causa";
	
	}
	$coneccion->query($asdf);
	
	

}





?>