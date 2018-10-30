<?

?>

<link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>

<?
include("class.carreras.php");
$materias = new Carreras();

$id_carrera = $_SESSION['id_carrera'];

$resultado_carrera_sysacad = $materias->traer_carreras($id_carrera);

$id_materia_sysacad = $resultado_carrera_sysacad[0]['id_materia_sysacad'];


$resultado_materias = $materias->devolverMaterias($id_materia_sysacad);


if($id_carrera=="33887"){
    $titulo2="<h3><b><font color='red'>Atenci&oacute;n</font></b>, en este plan de carrera deber&aacute;s completarlo cargando los finales que planific&aacute;s rendir en tu primer a&ntilde;o de cursada.<br> Si ya has rendido finales de tu 1er Cuatrimestre, por favor incluilos en este plan.</h3>";
}


echo "<h1><u>Materias a cursar / homologadas</u></h1>";

$array_valores = "<option value='1'>Prueba</option><option value='2'>Prueba 2</option>";

foreach($resultado_materias as $materia)
{
	$array_materias.="<option value='".$materia['id']."'>".$materia['nombre']."</option>";
}

$array_calificaciones = "<option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option>";

$anio = date('Y');


for($i=$anio;$i>=1995;$i--)
{
	$array_anios.= "<option value='".$i."'>".$i."</option>";
}

?>

   <link rel="stylesheet" type="text/css" href="codebase/dhtmlxcalendar.css"></link>
	<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxcalendar_dhx_skyblue.css"></link>
	<script src="codebase/dhtmlxcalendar.js"></script>
	<script>
		var myCalendar;
		function doOnLoad() {
			<?
			for($i=0;$i<1000;$i++)
			{
				$calendarios = $calendarios.'"calendar'.$i.'",';
			}
			$calendarios = substr($calendarios,0,strlen($calendarios)-1);
			$calendarios ="[".$calendarios."]";
			?>
			myCalendar = new dhtmlXCalendarObject(<?echo $calendarios?>);
                        document.getElementById('titulo2').innerHTML="<? echo $titulo2; ?>";
		}
	</script>
	
<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script> 
<script>
function agregar_fila()
{
	if(parseInt(document.getElementById('contador').value) > 700)
	{
		alert("Llego al limite maximo de materias");
		return 1;
	}
	
	fila_valor=incremental();
	
	//valor ="<tr id='fila"+fila_valor+"'><td><input type='hidden' name='valor[]' value='"+document.getElementById('contador').value+"'></input><select name='tipo_cursada[]'> "+
	//" <option value='1'>A cursar</option><option value='2'>Homologada</option></select></td><td> "+
	//" <select name='anios[]'><?echo $array_anios;?></select></td><td> "+ 
	//" <select name='materias[]'><?echo $array_materias;?></select></td> "+
	//" <table><tbody><tr><td><select name='parcial_1[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_parcial_1[]' id='calendar"+incremental()+"'></td></tr><tr><td><u><b>Primer Parcial</b></u><br><select name='recu_1_1[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_1_1[]' id='calendar"+incremental()+"'><br></td></tr><tr><td><u><b>Segundo Parcial</b></u><br><select name='recu_1_2[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_1_2[]' id='calendar"+incremental()+"'><br></td></tr><tr><td><u><b>Tercer Parcial</b></u><br><select name='recu_1_3[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_1_3[]' id='calendar"+incremental()+"'></td></tr></tbody></table></td> "+ 
	//" <td><table><tbody><tr><td><select name='parcial_2[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_parcial_2[]' id='calendar"+incremental()+"'></td></tr><tr><td><u><b>Primer Parcial</b></u><br><select name='recu_2_1[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_2_1[]' id='calendar"+incremental()+"'><br></td></tr><tr><td><u><b>Segundo Parcial</b></u><br><select name='recu_2_2[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_2_2[]' id='calendar"+incremental()+"'><br></td></tr><tr><td><u><b>Tercer Parcial</b></u><br><select name='recu_2_3[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_2_3[]' id='calendar"+incremental()+"'></td></tr></tbody></table></td> "+
	//" <td><table><tbody><tr><td><select name='parcial_3[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_parcial_3[]' id='calendar"+incremental()+"'></td></tr><tr><td><u><b>Primer Parcial</b></u><br><select name='recu_3_1[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_3_1[]' id='calendar"+incremental()+"'><br></td></tr><tr><td><u><b>Segundo Parcial</b></u><br><select name='recu_3_2[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_3_2[]' id='calendar"+incremental()+"'><br></td></tr><tr><td><u><b>Tercer Parcial</b></u><br><select name='recu_3_3[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_3_3[]' id='calendar"+incremental()+"'></td></tr></tbody></table></td> "+
	//" <td><select name='primer_llamado[]'><option value='1'>NO</option><option value='2'>Diciembre</option><option value='3'>Feb / Mar</option><option value='4'>Mayo</option><option value='5'>Julio</option><option value='6'>Octubre</option></select></td> "+ 
	//"<td><a href='#' onclick='eliminar_fila("+fila_valor+");'>eliminar</a></td></tr> ";

	//alert(fila_valor);
	
	valor ="<tr id='fila"+fila_valor+"'><td><input type='hidden' name='valor[]' value='"+document.getElementById('contador').value+"'></input><select name='tipo_cursada[]' oculto='1' onchange='ocultar_campos(this);'> "+
	" <option value='1'>A cursar</option><option value='2'>Homologada</option></select></td><td> "+
	" <select name='anios[]'><?echo $array_anios;?></select></td><td> "+ 
	" <select name='materias[]'><?echo $array_materias;?></select></td>"+
	" <td><table><tbody><tr><td><select name='parcial_1[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_parcial_1[]' id='calendar"+incremental()+"'></td></tr><tr><td><u><b>1&deg; Rec. 1&deg; Parcial</b></u><br><select name='recu_1_1[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_1_1[]' id='calendar"+incremental()+"'><br></td></tr><tr><td><u><b>2&deg; Rec. 1&deg; Parcial</b></u><br><select name='recu_1_2[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_1_2[]' id='calendar"+incremental()+"'><br></td></tr></tbody></table></td>"+
	/*<tr><td><u><b>3&deg; Rec. 1&deg; Parcial</b></u><br><select name='recu_1_3[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_1_3[]' id='calendar"+incremental()+"'></td></tr>*/
	" <td><table><tbody><tr><td><select name='parcial_2[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_parcial_2[]' id='calendar"+incremental()+"'></td></tr><tr><td><u><b>1&deg; Rec. 2&deg; Parcial</b></u><br><select name='recu_2_1[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_2_1[]' id='calendar"+incremental()+"'><br></td></tr><tr><td><u><b>2&deg; Rec. 2&deg; Parcial</b></u><br><select name='recu_2_2[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_2_2[]' id='calendar"+incremental()+"'><br></td></tr></tbody></table></td>"+
	/*<tr><td><u><b>3&deg; Rec. 2&deg; Parcial</b></u><br><select name='recu_2_3[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_2_3[]' id='calendar"+incremental()+"'></td></tr>*/
	" <td><table><tbody><tr><td><select name='parcial_3[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_parcial_3[]' id='calendar"+incremental()+"'></td></tr><tr><td><u><b>1&deg; Rec. 3&deg; Parcial</b></u><br><select name='recu_3_1[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_3_1[]' id='calendar"+incremental()+"'><br></td></tr><tr><td><u><b>2&deg; Rec. 3&deg; Parcial</b></u><br><select name='recu_3_2[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_3_2[]' id='calendar"+incremental()+"'><br></td></tr></tbody></table></td>"+
	/*<tr><td><u><b>3&deg; Rec. 3&deg; Parcial</b></u><br><select name='recu_3_3[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_3_3[]' id='calendar"+incremental()+"'></td></tr>*/	
	" <td><table><tr><td><select name='primer_llamado[]'><option value='1'>NO</option><option value='2'>Diciembre</option><option value='3'>Feb / Mar</option><option value='4'>Mayo</option><option value='5'>Julio/Agosto</option><option value='6'>Octubre</option></select></td></tr></table></td> "+ 
	"<td><a href='#' onclick='eliminar_fila("+fila_valor+");'>eliminar</a></td></tr> ";
	
        if(<? echo $id_carrera;?> == "33887"){
        valor ="<tr id='fila"+fila_valor+"'><td><input type='hidden' name='valor[]' value='"+document.getElementById('contador').value+"'></input><select name='tipo_cursada[]' oculto='1' onchange='ocultar_campos(this);'> "+
	" <option value='1'>A cursar</option><option value='2'>Homologada</option></select></td><td> "+
	" <select name='anios[]'><?echo $array_anios;?></select></td><td> "+ 
	" <select name='materias[]'><?echo $array_materias;?></select></td>"+
	" <td><table><tbody><tr><td><select name='parcial_1[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_parcial_1[]' id='calendar"+incremental()+"'></td></tr><tr><td><u><b>1&deg; Rec. 1&deg; Parcial</b></u><br><select name='recu_1_1[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_1_1[]' id='calendar"+incremental()+"'><br></td></tr><tr><td><u><b>2&deg; Rec. 1&deg; Parcial</b></u><br><select name='recu_1_2[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_1_2[]' id='calendar"+incremental()+"'><br></td></tr></tbody></table></td>"+
	/*<tr><td><u><b>3&deg; Rec. 1&deg; Parcial</b></u><br><select name='recu_1_3[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_1_3[]' id='calendar"+incremental()+"'></td></tr>*/
	" <td><table><tbody><tr><td><select name='parcial_2[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_parcial_2[]' id='calendar"+incremental()+"'></td></tr><tr><td><u><b>1&deg; Rec. 2&deg; Parcial</b></u><br><select name='recu_2_1[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_2_1[]' id='calendar"+incremental()+"'><br></td></tr><tr><td><u><b>2&deg; Rec. 2&deg; Parcial</b></u><br><select name='recu_2_2[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_2_2[]' id='calendar"+incremental()+"'><br></td></tr></tbody></table></td>"+
	/*<tr><td><u><b>3&deg; Rec. 2&deg; Parcial</b></u><br><select name='recu_2_3[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_2_3[]' id='calendar"+incremental()+"'></td></tr>*/
	" <td><table><tbody><tr><td><select name='parcial_3[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_parcial_3[]' id='calendar"+incremental()+"'></td></tr><tr><td><u><b>1&deg; Rec. 3&deg; Parcial</b></u><br><select name='recu_3_1[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_3_1[]' id='calendar"+incremental()+"'><br></td></tr><tr><td><u><b>2&deg; Rec. 3&deg; Parcial</b></u><br><select name='recu_3_2[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_3_2[]' id='calendar"+incremental()+"'><br></td></tr></tbody></table></td>"+
	/*<tr><td><u><b>3&deg; Rec. 3&deg; Parcial</b></u><br><select name='recu_3_3[]'><option value='4'>N/D</option><option value='3'>AU</option><option value='2'>DA</option><option value='1'>AP</option></select><input width='10' type='text' size='10' name='fecha_anios_recu_3_3[]' id='calendar"+incremental()+"'></td></tr>*/	
	" <td><table><tr><td><select name='primer_llamado[]'><option value='1'>NO</option><option value='7'>Julio/Agosto 1er Cuat.</option><option value='2'>Diciembre</option><option value='3'>Febero/Marzo</option><option value='8'>Julio/Agosto 2do Cuat.</option></select></td></tr></table></td> "+ 
	"<td><a href='#' onclick='eliminar_fila("+fila_valor+");'>eliminar</a></td></tr> ";

        }

	$("#tabla").append(valor);
	doOnLoad();
	
}
function incremental()
{
	document.getElementById('contador').value  = parseInt(document.getElementById('contador').value)  + 1;
	return document.getElementById('contador').value;
}
function incremental_2()
{
	document.getElementById('contador2').value  = parseInt(document.getElementById('contador2').value)  + 1;
	return document.getElementById('contador2').value;
}


function eliminar_fila(id)
{
	$("#fila"+id).remove();
	//document.getElementById('fila'+id).style.display="none";
	//document.getElementById('fila'+id).innerHTML="";
}

function eliminar_fila2(id)
{
	$("#fila_1_"+id).remove();
	//document.getElementById('fila_1_'+id).style.display="none";
	//document.getElementById('fila_1_'+id).innerHTML="";
}

</script>
<script>

function agregar_materias_prox()
{

valor_incremental = incremental_2();
tabla_tr = "<tr id='fila_1_"+valor_incremental+"'><td><select name='materias_prox_"+valor_incremental+"' width='200' style='width:300 px;'><?echo $array_materias;?></select></td><td><input type='radio' name='dia_materia_"+valor_incremental+"' value='1'></input></td><td><input type='radio'name='dia_materia_"+valor_incremental+"' value='2'></input></td>"+
  "<td><input type='radio' name='dia_materia_"+valor_incremental+"' value='3'></input></td><td><input type='radio' name='dia_materia_"+valor_incremental+"' value='4'></input></td><td><input type='radio' name='dia_materia_"+valor_incremental+"' value='5'></input></td><td><input type='radio' name='dia_materia_"+valor_incremental+"' value='6'></input></td>"+
  "<td><a href='#' onclick='eliminar_fila2("+valor_incremental+");'>eliminar</a></td></tr>";

	$("#tabla_materias").append(tabla_tr);
  
}

function ocultar_campos(id)
{
	if($(id).attr('oculto')==1)
	{
		$('td table',$(id).parent().parent()).hide();
		$('td table input',$(id).parent().parent()).val('');
		$(id).attr('oculto','0');
		
	}
	else
	{
		$('td table',$(id).parent().parent()).show();
		$(id).attr('oculto','1');
	}
}

</script>
<?

?>
<table id='tabla' cellspacing='2' border='1' width='99%' class='table1'> 
 <tr>
  <th><div class='color_fondo' width="100%;"><b>Materias a cursar <br>/ aprobadas anteriormente (homologadas)</b></div></th>
  <th ><b>A&ntilde;o de cursada</b></th>
  <th ><b>Materias a cursar</b></th>
  <th ><b>1&deg; Parcial</b></th>
  <th ><b>2&deg; Parcial</b></th>
  <th ><b>3&deg; Parcial</b></th>
  <th ><b>Plani.De Finales</b></th>
  <th >Eliminar</th>
 </tr>
	<tr>
	<td><input type='hidden' name='valor[]' value='0'></input><select name='tipo_cursada[]' oculto='1' onchange='ocultar_campos(this);'><option value='1'>A cursar</option><option value='2'>Homologada</option></select></td>
	<td><select name='anios[]'><?echo $array_anios;?></select></td>
	<td><select name='materias[]'><?echo $array_materias;?></select></input></td>
	<td>
	<table>
	<tr>
		<td>
		<select name='parcial_1[]'><?echo $array_calificaciones;?><input type='text' id='calendar1' name='fecha_anios_parcial_1[]' size='10' width='10' value=''></input>
		</td>
	</tr>
	<tr>
	<td>
		<u><b>1&deg; Rec. 1&deg; Parcial</b></u><br>
		<select name='recu_1_1[]'><?echo $array_calificaciones;?></select><input id='calendar2' type='text' name='fecha_anios_recu_1_1[]' size='10' width='10' value=''></input><br>
	</td>
	</tr>
	<tr>
		<td>
		<u><b>2&deg;Rec. 1&deg; Parcial</b></u><br>
		<select name='recu_1_2[]'><?echo $array_calificaciones;?></select><input id='calendar3' type='text' name='fecha_anios_recu_1_2[]' size='10' width='10' value=''></input><br>
		</td>
	</tr>
<!--	<tr>	
	<td>
		<u><b>3&deg; Rec. 1&deg; Parcial.</b></u><br>
		<select name='recu_1_3[]'><?//echo $array_calificaciones;?></select><input id='calendar4' type='text' name='fecha_anios_recu_1_3[]' size='10' width='10' value=''></input>
	</td>
	</tr>-->
	</table>
	</td>
  <td>
	<table>
	<tr>
		<td>
		<select name='parcial_2[]'><?echo $array_calificaciones;?><input type='text' id='calendar5' name='fecha_anios_parcial_2[]' size='10' width='10' value=''></input>
		</td>
	</tr>
	<tr>
	<td>
		<u><b>1&deg;Rec. 2&deg; Parcial </b></u><br>
		<select name='recu_2_1[]'><?echo $array_calificaciones;?></select><input id='calendar6' type='text' name='fecha_anios_recu_2_1[]' size='10' width='10' value=''></input><br>
	</td>
	</tr>
	<tr>
		<td>
		<u><b>2&deg;Rec. 2&deg; Parcial</b></u><br>
		<select name='recu_2_2[]'><?echo $array_calificaciones;?></select><input id='calendar7' type='text' name='fecha_anios_recu_2_2[]' size='10' width='10' value=''></input><br>
		</td>
	</tr>
<!--	<tr>	
	<td>
		<u><b>3&deg; Rec. 2&deg; Parcial.</b></u><br>
		<select name='recu_2_3[]'><?//echo $array_calificaciones;?></select><input id='calendar8' type='text' name='fecha_anios_recu_2_3[]' size='10' width='10' value=''></input>
	</td>
	</tr>-->
	</table>
  </td>
	<td>
	<table>
	<tr>
		<td>
		<select name='parcial_3[]'><?echo $array_calificaciones;?><input type='text' id='calendar9' name='fecha_anios_parcial_3[]' size='10' width='10' value=''></input>
		</td>
	</tr>
	<tr>
	<td>
		<u><b>1&deg;Rec. 3&deg;Parcial</b></u><br>
		<select name='recu_3_1[]'><?echo $array_calificaciones;?></select><input id='calendar10' type='text' name='fecha_anios_recu_3_1[]' size='10' width='10' value=''></input><br>
	</td>
	</tr>
	<tr>
		<td>
		<u><b>2&deg;Rec. 3&deg; Parcial</b></u><br>
		<select name='recu_3_2[]'><?echo $array_calificaciones;?></select><input id='calendar11' type='text' name='fecha_anios_recu_3_2[]' size='10' width='10' value=''></input><br>
		</td>
	</tr>
<!--	<tr>	
	<td>
		<u><b>3&deg; Rec. 3&deg; Pracial.</b></u><br>
		<select name='recu_3_3[]'><?//echo $array_calificaciones;?></select><input id='calendar12' type='text' name='fecha_anios_recu_3_3[]' size='10' width='10' value=''></input>
	</td>
	</tr>-->
	</table>
	</td>
	<td>
	<table>
	<tr>
	<td>
	<select name='primer_llamado[]' >
        <?
        if($id_carrera!="33887"){
        ?>  
	<option value='1'>NO</option>
	  <option value='2'>Diciembre</option>
	  <option value='3'>Feb / Mar</option>
	  <option value='4'>Mayo</option>
	  <option value='5'>Julio/Agosto</option>
	  <option value='6'>Octubre</option>
         <? }else{
            ?>
            <option value='1'>NO</option><option value='7'>Julio/Agosto 1er Cuat.</option><option value='2'>Diciembre</option><option value='3'>Febero/Marzo</option><option value='8'>Julio/Agosto 2do Cuat.</option>
            <?
            }
         ?>
	</select>
	</td>
	</tr>
	</table>
	</td>
	<td>
	&nbsp;
	</td>
 </tr>
</table>
<table>
<tr>
<td>
<input type='button' value='Agregar' onclick='agregar_fila();'></input>
</td>
</tr> 
</table>
<table width='100%'>
<tr>
<td width='100%'>
<?

if($id_carrera== 24117 or $id_carrera==24118 or $id_carrera==24119 or $id_carrera==34835 or $id_carrera==24120)
{	$titulin = "a&ntilde;o";	}else{ $titulin = "cuatrimestre";  }
// a&ntilde;o
?>
<h1><u>Materias a cursar el proximo <? echo $titulin;?>  </u></h1>

</td>
</tr>
</table>

<table border='1' width='99%' id='tabla_materias' class='table1'>
<tr>
  <th><b>Materias</b></th>
  <th><b>Lunes</b></th>
  <th><b>Martes</b></th>
  <th><b>Miercoles</b></th>
  <th><b>Jueves</b></th>
  <th><b>Viernes</b></th>
  <th><b>Sabado</b></th>
  <th>Eliminar</th>
</tr>
<tr>
  <td><select name='materias_prox_0' width='200' style='width:300 px;'><?echo $array_materias;?></select></td>
  <td><input type='radio' name='dia_materia_0' value='1'></input></td>
  <td><input type='radio'name='dia_materia_0' value='2'></input></td>
  <td><input type='radio' name='dia_materia_0' value='3'></input></td>
  <td><input type='radio' name='dia_materia_0' value='4'></input></td>
  <td><input type='radio' name='dia_materia_0' value='5'></input></td>
  <td><input type='radio' name='dia_materia_0' value='6'></input></td>
  <td>&nbsp;</td>
</tr>
</table>
<input type='button' value='Agregar' onclick='agregar_materias_prox();'></input>
<?
//echo "<input type='submit' value='Enviar'></input>";
?>
<input type='hidden' name='contador' value='25' id='contador'></input>
<input type='hidden' value='0' name='contador2' id='contador2'></input>
<input type='hidden' name='plan_de_carrera' id='plan_de_carrera' value='plan_de_carrera'></input>
<input type='hidden' name='id_formulario' id='id_formulario' value='<? echo $_REQUEST['id_formulario'];?>'></input>
<?
//echo $_SESSION['id_carrera'];
?>

<script>doOnLoad();</script>

