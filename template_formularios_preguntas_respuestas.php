<?
include("ver_login.php");
?>
<head>
 <?

require_once("cabecera_ajax.php");
include('coneccion.php');
$conexion = new Coneccion();
 ?>

 <title>Pagina piola de Andr&eacute;s Tarrio</title>
	
	<script>
	
	function mostrar_div(id_div)
	{
		if(	document.getElementById(id_div).style.display == "block")
		{
			document.getElementById(id_div).style.display = "none";
		}
		else
		{
			document.getElementById(id_div).style.display = "block";
		}
	
	document.getElementById('nombre').value = "";
		
	}
	
	
	
	
	
	</script>


 </head>
<body>

<div id="div_flotante" style="display:none;background-color:#FFAA55;width:500Px;height:200Px;position:absolute; margin-top:200px;margin-left:400Px;">

<table align="center" width="98%">
<tr><td colspan="2" bgcolor="0000FF" align="center">
Preguntas
<img src="../common/imgs/close.gif" align="right" onclick="mostrar_div('div_flotante');"></img>
</td></tr>
<tr><td>
Ingrese la nueva pregunta:&nbsp; 
</td>
<td>
<input type="text" id="nombre" size="48"></input>
</td></tr>
<tr><td align="center">
<input type="hidden" value="" id="id_pregunta_oculto"></input>
<input type="button" value="Aceptar" onClick="agregarPregunta();"></input>
<input type="button" value="Cancelar" onClick="mostrar_div('div_flotante');cambio(document.getElementById('params').value);"></input>
</td></tr>
</table>
</div>

<div id="div_flotante_respuestas" style="background-color:#FFAA55;display:none;width:800Px;height:410Px;position:absolute; margin-top:200px;margin-left:400Px;">
<table width="99%">
<tr>
<td colspan="2" bgcolor="#0000FF" align="center">
Respuestas
<img src="../common/imgs/close.gif" align="right" onclick="mostrar_div('div_flotante_respuestas')"/>
</td>
</tr>
<tr>
<td>
Tipo:
</td>
<td>
<?



$query_select = "select * from tipospreguntas ";
$resultados_tipos = $conexion->query($query_select);

foreach($resultados_tipos as $resultados)
{

$array_opciones.="<option value='".$resultados['idtipo']."'>".$resultados['tipo_control']."</option>";

}

?>
<select id="tipos_respuesta" name="tipos_respuesta" onchange="cambiar_tipo_respuesta(this.value);">
<?
echo $array_opciones;
?>
</select>
</td>
</tr>
</table>
<div id="respuestas_modificar" style="background-color: #DFE0E6; width: 780Px;height:200Px;margin-left: 10Px;" >

</div>
</div>


<div  id="div_filtro_formulario" style="background-color:#FFCC11;width:100%;height:70Px;">
	<?

		$select_formularios = "select * from formularios where estado=1 and activo is null";//generico
		$formularios = $conexion->query($select_formularios);

		$formularios_mostrar='<OPTGROUP selected="selected" label="Formularios"><option vaue="0">Seleccione un formulario</option>';
		foreach($formularios as $formulario)
		{
			$formularios_mostrar.='<option value='.$formulario['id'].'>'.utf8_decode($formulario['descripcion']).'</option>';
		}
		$formularios_mostrar.='</OPTGROUP>';
	
		echo '<label>Seleccione un formulario de la lista:&nbsp;</label>';
		$input='<select id="params" onchange="cambio(this.value);">'.$formularios_mostrar.'</select>';		
		echo $input;

	?>



	
</div>
<div  id="div_cuerpo_preguntas" style="background-color:#FF3344;width:100%;height:650Px;">
	<table align="center" width="90%">
		<tr>
			<td width="50%">
				<div id="div_titulo_preg" style="background-color:#005522;width:100%;height:20px;">
				</div>
			</td>
			<td>
				<div id="div_titulo_resp" style="background-color:#005522;width:100%;height:20px;">
				</div>
			</td>
		</tr>
		<tr>
			<td width="50%">
				<div id="div_preguntas" style="background-color:#990011;width:100%;height:560px;overflow:auto">
				</div>
			</td>
			<td>
				<div id="div_respuestas" style="background-color:#550022;width:100%;height:560px;overflow:auto;">
				</div>
			</td>
		</tr>
	</table>
</div>
<script src="../codebase/md5-min.js"></script>
<script>
function cambio(id)
{
	if(id!=0)
	{
		ajax_loadContent('div_preguntas',"../ajax_preguntas.php?id_formulario="+id); 
	}
}

function subir(id_form, id_preg,orden)
{
ajax_loadContent('div_preguntas',"../ajax_preguntas.php?id_formulario="+id_form+"&id_pregunta="+id_preg+"&orden="+orden+"&accion=subir"); 
}

function bajar(id_form, id_preg,orden)
{
ajax_loadContent('div_preguntas',"../ajax_preguntas.php?id_formulario="+id_form+"&id_pregunta="+id_preg+"&orden="+orden+"&accion=bajar"); 
}

function eliminar(id_form, id_preg)
{
ajax_loadContent('div_preguntas',"../ajax_preguntas.php?id_formulario="+id_form+"&id_pregunta="+id_preg+"&accion=eliminar"); 
}

function agregarPregunta()
{
id_pregunta = document.getElementById("id_pregunta_oculto").value;
pregunta = document.getElementById("nombre").value;
id_form = document.getElementById("params").value;
if(id_pregunta =="")
	{
		ajax_loadContent('div_preguntas',"../ajax_preguntas.php?id_formulario="+id_form+"&texto="+pregunta+"&accion=agregarPregunta");
	}
	else
	{
		guardarPregunta(id_pregunta,pregunta,id_form);
	}
}

function editarPregunta(id_preg)
{
preguntaJr = "idpregunta_"+id_preg;
pregunta = document.getElementById(preguntaJr).innerHTML;
ajax_loadContent('div_preguntas',"../ajax_preguntas.php?id_pregunta="+id_preg+"&accion=editarPregunta&texto="+pregunta+"");
}

function guardarPregunta(id_pregunta,pregunta,id_form)
{
	ajax_loadContent('div_preguntas',"../ajax_preguntas.php?id_formulario="+id_form+"&id_pregunta="+id_pregunta+"&accion=guardarPregunta&texto="+pregunta+"");
}

function cargar_respuestas(id_pregunta)
{
	ajax_loadContent('div_respuestas',"../ajax_preguntas.php?pregunta="+id_pregunta+"&accion=respuestas");
}

function subir_resp(id_respuesta,orden)
{
	ajax_loadContent('div_respuestas',"../ajax_preguntas.php?&id_respuesta="+id_respuesta+"&orden="+orden+"&accion=subir_respuesta"); 
}

function bajar_resp(id_respuesta,orden)
{
	ajax_loadContent('div_respuestas',"../ajax_preguntas.php?&id_respuesta="+id_respuesta+'&orden='+orden+'&accion=bajar_respuesta'); 
}

function eliminar_resp(id_respuesta)
{
	ajax_loadContent('div_respuestas',"../ajax_preguntas.php?&id_respuesta="+id_respuesta+"&accion=eliminar_respuesta"); 
}

function cambiar_tipo_respuesta(id)
{
    
    ajax_loadContent("respuestas_modificar","../ajax_resp.php?respuesta_tipo="+id); 
    
}

function agregar_valores_select()
{
    alert("asd");
}




</script>
</body>