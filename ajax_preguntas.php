<?
//error_reporting(0);
include('class.form.php');
include('class.respuestas.php');

$id_formulario = $_GET["id_formulario"];
$preguntas = new Form($id_formulario);

if($_REQUEST['accion']=="respuestas")
{
	$respuesta = new Respuestas();
	$array_respuestas = $respuesta->RespuestasPreguntas($_REQUEST['pregunta']);
	echo "<table width:100%>";
	if(count($array_respuestas)>0)
	{
		foreach($array_respuestas as $resp)
		{
			if($resp['idpadre']!="" && $resp['idtipo']==4)
			{
				echo '<tr><td width="80%"><div style="border-bottom:solid; 1Px;"><label name="idrespuesta_'.$resp['id'].'" id="idrespuesta_'.$resp['id'].'"  >'.$resp['texto'].'</label></div></td>
					<td><img src="../common/imgs/flecha_up.png" onclick="subir_resp('.$resp['id'].','.$resp['orden'].');"></img></td>
					<td><img src="../common/imgs/flecha_down.png" onclick="bajar_resp('.$resp['id'].','.$resp['orden'].');"></img></td>
					<td><img src="../common/imgs/eliminar.png"
					onclick="eliminar_resp('.$resp['id'].')"></img></td>
					</tr>';
			}
			
		if($resp['idtipo']!=4)
		{
			echo '<tr><td width="80%"><div style="border-bottom:solid; 1Px;"><label name="idrespuesta_'.$resp['id'].'" id="idrespuesta_'.$resp['id'].'"  >'.$resp['texto'].'</label></div></td>
				<td><img src="../common/imgs/flecha_up.png" onclick="subir_resp('.$resp['id'].','.$resp['orden'].')"></img></td>
				<td><img src="../common/imgs/flecha_down.png" onclick="bajar_resp('.$resp['id'].','.$resp['orden'].')"></img></td>
				<td><img src="../common/imgs/eliminar.png"
				onclick="eliminar_resp('.$resp['id'].')"></img></td>
				</tr>';
		}
	}
}

echo '<input type="hidden" id="id_pregunta_tito" name="id_pregunta_tito" value="'.$_REQUEST['pregunta'].'" ></input>';
echo '<tr><td colspan="5" align="center"><input type="button" value="Agregar respuesta" onClick="mostrar_div(\'div_flotante_respuestas\');"></input></td></tr>';
echo "</table>";

exit();


}
if($_REQUEST["accion"]=="agregarPregunta" )
{
	$preguntas->agregarPregunta($_GET["texto"]);
	echo "&nbsp;<script>mostrar_div('div_flotante');</script>";
}
elseif($_REQUEST["accion"]=="guardarPregunta")
{
	$preguntas->editarPregunta($_GET["id_pregunta"],$_GET["texto"]);
	echo "&nbsp:<script>document.getElementById('nombre').value='';</script>";
	echo "&nbsp:<script>document.getElementById('id_pregunta_oculto').value='';</script>";
	echo "&nbsp;<script>cambio(".$_REQUEST['id_formulario'].")</script>";
	echo "&nbsp;<script>mostrar_div('div_flotante');</script>";	
}
elseif($_REQUEST["accion"]=="editarPregunta")
{
	echo "&nbsp;<script>mostrar_div('div_flotante');</script>";
	echo "&nbsp:<script>document.getElementById('nombre').value='".$_REQUEST['texto']."';</script>";
	echo "&nbsp:<script>document.getElementById('id_pregunta_oculto').value='".$_REQUEST['id_pregunta']."';</script>";
	
}
elseif($_REQUEST["accion"] == "subir" or $_REQUEST["accion"] == "bajar" )
{
	$preguntas->cambiarPosicion($_GET['id_pregunta'],$_GET['accion'],$_GET['orden']);

}
elseif($_REQUEST["accion"] == "eliminar")
{
	$preguntas->eliminarPregunta($_GET['id_pregunta'],$_GET['accion'],$_GET['orden']);
}

if($id_formulario != "")
{

    $array_preguntas = $preguntas->traerPreguntas();
    
    echo "<table width:100%>";
    if(count($array_preguntas)>0)
    {
    	foreach($array_preguntas as $preg)
    	{
    	
    		echo '<tr><td width="80%"><div style="border-bottom:solid; 1Px;"><label name="idpregunta_'.$preg['idpregunta'].'" id="idpregunta_'.$preg['idpregunta'].'" >'.$preg['texto'].'</label></div></td>
    		<td><img src="../common/imgs/flecha_up.png" onclick="subir('.$id_formulario.','.$preg["idpregunta"].','.$preg['orden'].');"></img></td>
    		<td><img src="../common/imgs/flecha_down.png" onclick="bajar('.$id_formulario.','.$preg["idpregunta"].','.$preg['orden'].');"></img></td>
    		<td><img src="../common/imgs/eliminar.png"
    		onclick="eliminar('.$id_formulario.','.$preg["idpregunta"].');"></img></td>
    		<td><img src="../common/imgs/lapicito.png" onclick="editarPregunta('.$preg["idpregunta"].');"></img></td>
    		<td><img src="../common/imgs/flecha.png" onclick="cargar_respuestas('.$preg["idpregunta"].');"></img></td>
    		</tr>';
    
    	}
    }
    echo '<tr><td colspan="5" align="center"><input type="button" value="Agregar pregunta" onClick="mostrar_div(\'div_flotante\');"></input></td></tr>';
    echo "</table>";


    
}

if($_REQUEST['accion']=="subir_respuesta" or $_REQUEST['accion']=="bajar_respuesta")
{
	$preguntas->cambiarPosicionResp($_GET['id_respuesta'],$_GET['orden'],$_GET['accion']);
}
if($_REQUEST['accion']=="eliminar_respuesta")
{
   
	$preguntas-> eliminarRespuesta($_GET['id_respuesta']);
}

?>