<head>
 <?
error_reporting(0);
require_once("cabecera_ajax.php");

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

<div id="div_flotante" style="display:none;background-color:#FFAA55;width:400Px;height:200Px;position:absolute; margin-top:200px;margin-left:400Px;">
<table align="center" width="90%">
<tr><td align="center">
Ingrese la nueva pregunta:&nbsp; 
<input type="text" id="nombre" size="20"></input>
</td></tr>
<tr><td align="center">
<input type="hidden" value="" id="id_pregunta_oculto"></input>
<input type="button" value="Aceptar" onClick="agregarPregunta();"></input>
<input type="button" value="Cancelar" onClick="mostrar_div('div_flotante');cambio(document.getElementById('params').value);"></input>
</td></tr>
</table>
</div>

<div  id="div_filtro__carrera" style="background-color:#FFCC11;width:100%;height:70Px;">
	<?
		
		include('class.carreras.php');
		
		
		$carr = new Carreras();
		$array_carreras_listado = $carr->traer_carreras();
print_r(array_carreras_listado);
	foreach($array_carreras_listado as $array_carrera)
	{

		$carreras_mostrar.= "<option value='".$array_carrera['carr_id']."'>".$array_carrera['carr_descripcion']."</option>";

	}
	echo "<select name='carrera_guardar' id='carrera_guardar'>".$carreras_mostrar."</select>";
		
	?>
</div>

<div  id="div_filtro_formulario" style="background-color:#FFCC11;width:100%;height:70Px;">
	<?
	
		include('class.form.php');
		$form = new Form();
		$formularios = $form->showForm();


		$formularios_mostrar='<OPTGROUP selected="selected" label="Formularios"><option vaue="0">Selecciones un formulario</option>';
		foreach($formularios as $formulario)
		{
			$formularios_mostrar.='<option value='.$formulario['id'].'>'.$formulario['descripcion'].'</option>';
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
				<div id="div_respuestas" style="background-color:#550022;width:100%;height:560px;">
				</div>
			</td>
		</tr>
		<tr>
		<td colspan=2>
				<div id="div_edit_pregunta" style="background-color:#225500;width:100%;height:80px;">
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

</script>
</body>