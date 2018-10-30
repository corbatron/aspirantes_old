<?
include("ver_login.php");
?>
<head>
<?
require_once("cabecera_ajax.php");
?>
</head>
<body>
<div  id="div_filtros" style="background-color:#FFCC11;width:100%;height:70Px;">
<?	
	include('class.carreras.php');
	$carr = new Carreras();
	$array_carreras_listado = $carr->traer_carreras();
	foreach($array_carreras_listado as $array_carrera)
	{
		$carreras_mostrar.= "<option value='".$array_carrera['carr_id']."'>".utf8_decode($array_carrera['carr_descripcion'])."</option>";
	}
	echo "<label>Seleccione una carrera de la lista:&nbsp;</label> <select id='carrera' onchange='resetFormularios();' >".$carreras_mostrar."</select>";
		
	include('class.form.php');
	$form = new Form();
	$formularios = $form->showForm();
	$formularios_mostrar='<OPTGROUP selected="selected" label="Formularios"><option value="0">Selecciones un formulario</option>';
	foreach($formularios as $formulario)
	{
		$formularios_mostrar.='<option value='.$formulario['id'].'>'.utf8_decode($formulario['descripcion']).'</option>';
	}
	$formularios_mostrar.='</OPTGROUP>';

	echo '<br><label>Seleccione un formulario de la lista:&nbsp;</label>';
	$input='<select id="params" onchange="cambio(this.value);">'.$formularios_mostrar.'</select>';		
	echo $input;
?>
</div>
<div  id="div_cuerpo" style="background-color:#FF3344;width:100%;height:500Px;">
	<table align="center" width="90%">
		<tr>
			<td>Alumnos no asignados</td>
			<td></td>
			<td>Alumnos asignados</td>
		</tr>
		<tr>
			<td width="40%">
				<div id="div_alumnos" style="background-color:#990011;width:100%;height:400px;overflow:auto"></div>
			</td>
			
			<td width="20%">
				<div id="div_botones" style="background-color:#990011;width:100%;height:400px;overflow:auto">
					<input type="button" style="width: 100%;height: 50px;" onclick="asignarSeleccionados();" value="Asignar seleccionados >>"/>	
					<input type="button" style="width: 100%;height: 50px;" onclick="asignarTodos();" value="Asignar todos >>"/>
					<input type="button" id="botonmagico" style="width: 100%;height: 50px;" onclick="desasignar();" value="<< Desasignar seleccionados"/>
					<input type="button" hidden style="width: 100%;height: 50px;" onclick="desasignarTodos();" value="<< Desasignar todos"/>
					<input type="checkbox" id="forzar" onclick="alertaPiola(this.checked);"/> Forzar(experimental)
				</div>
			</td>
			<td><div id="div_alumnos_asignados" style="background-color:#990011;width:100%;height:400px;"></div></td>
		</tr>
	</table>
</div>
<script>
function resetFormularios(){
	document.getElementById("params").selectedIndex = 0;
	document.getElementById("div_alumnos").innerHTML = "";
	document.getElementById("div_alumnos_asignados").innerHTML = "";
}

function cambio(id)
{
	if(id!=0)
	{
		//cargar  los NO asignados en div_alumnos y los asignados en div_alumnos_asignados
		carr = document.getElementById("carrera").value;
		ajax_loadContent('div_alumnos',"ajax_alumnosform.php?id_formulario="+id+"&id_carrera="+carr+"&accion=noasignados"); 
		ajax_loadContent('div_alumnos_asignados',"ajax_alumnosform.php?id_formulario="+id+"&id_carrera="+carr+"&accion=asignados"); 
	}else{//si vale 0, entonces es la 1er opcion y hay que poner los divs vacios
		resetFormularios();
	}
}

function reload() //recarga los divs
{
	cambio(document.getElementById("params").value);
}

function formVacio(id_alumnos)//funcion de validacion
{
	if(id_alumnos == null) 
	{
		alert("Usted no ha seleccionado ning&uacute;n formulario");
		return(1);
	}
	return(0);
}

function alumnos(selected)//funcion de validacion de alumnos seleccionados
{
	if(selected=="")
	{
		alert("Usted no ha seleccionado ning&uacute;n alumno");
		return(1);
	}
	return(0);
}

function asignarSeleccionados()
{
	var dnies=new Array();
	cont=0;
	id_form = document.getElementById("params").value;
	id_alumnos= document.getElementById("sinform");
	if(formVacio(id_alumnos)) return(0);
	
	//alert(id_alumnos.length);
	for(i=0;i<id_alumnos.options.length;i++){
		if(id_alumnos.options[i].selected==true)
			dnies[cont++]=id_alumnos.options[i].value;
	}		
	//for(i=0;i<dnies.length;i++) alert(dnies[i]);
	if(alumnos(dnies)) return(0);
	//funcion del boton "asignar", asocia los DNI de los alumnos seleccionados con el form
	ajax_loadContent('div_alumnos',"ajax_alumnosform.php?id_formulario="+id_form+"&id_alumnos="+dnies+"&accion=asignar"); 
	reload();
	
}

function desasignar()
{
	var dnies=new Array();
	cont=0;
	id_form = document.getElementById("params").value;
	id_alumnos= document.getElementById("conform");
	if(formVacio(id_alumnos)) return(0);
	forzar=document.getElementById("forzar").checked;
	if(forzar) 
		if(!confirm('Usted ha seleccionado la opci&oacute;n de "Forzar", se proceder&aacute; a borrar las respuestas de los usuarios a desasignar \n ¿Desea continuar?'))
			return(0);
	for(i=0;i<id_alumnos.options.length;i++){
		if(id_alumnos.options[i].selected==true)
			dnies[cont++]=id_alumnos.options[i].value;
	}	
	if(alumnos(dnies)) return(0);
	ajax_loadContent('div_alumnos_asignados',"ajax_alumnosform.php?id_formulario="+id_form+"&id_alumnos="+dnies+"&forzar="+forzar+"&accion=desasignar"); 
	reload();
}

function asignarTodos(id_form)
{
	carr = document.getElementById("carrera").value
	id_form = document.getElementById("params").value;
	if(formVacio(document.getElementById("sinform"))) return(0);
	ajax_loadContent('div_alumnos',"ajax_alumnosform.php?id_formulario="+id_form+"&id_carrera="+carr+"&accion=asignartodos"); 
	reload();
}

function desasignarTodos(id_form)
{
	carr = document.getElementById("carrera").value
	id_form = document.getElementById("params").value;
	if(formVacio(document.getElementById("conform"))) return(0);
	ajax_loadContent('div_alumnos_asignados',"ajax_alumnosform.php?id_formulario="+id_form+"&id_carrera="+carr+"&accion=desasignartodos"); 
	reload();
}

function alertaPiola(valor)
{
	if(valor==true) alert('Atenci&oacute;n: La opci&oacute;n de "Forzar" solo se aplica a la desasignaci&oacute;n de formularios y puede ocasionar perdida de datos irreversible');
}
</script>
</body>