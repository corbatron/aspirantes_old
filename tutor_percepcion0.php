<?php
include('ver_login.php');
require_once('coneccion.php');
include('class.form.php');
require_once("class.tutores.php");
$tutor = new Tutores();

if($_REQUEST['origen']=="modal_percepcion")
{
	try {
		
		$tutor->grabar_percepcion($_REQUEST['tutor'],$_REQUEST['dni_percepcion'],$_REQUEST['nro'],$_REQUEST['fecha'],$_REQUEST['detalle'],$_REQUEST['percepcion'],$_REQUEST['entrevista'],$_REQUEST['acuerdos'],$_REQUEST['espontanea']);
		echo '<script>alert("Los datos han sido guardados exitosamente");</script>';
		
		exit();
	} catch (Exception $e) {
		echo "<script>alert('Ha ocurrido un error en el sistema, los datos no han sido guardados.')</script>";
		exit();
	} 
}
if($_REQUEST['origen']=="modal_problematica")
{
	try {
		$tutor->borrar_problematica_alumno($_REQUEST['dni_problematica']);
		$cont=0;
		foreach($_REQUEST as $clave=>$valor){
			if(is_numeric($clave)){
				$cont++;
				if($cont==1){
					$tutor->problematica_alumno($_REQUEST['dni_problematica'],$clave,$_REQUEST['fecha_problematica'],1);
				}else{
					$tutor->problematica_alumno($_REQUEST['dni_problematica'],$clave,$_REQUEST['fecha_problematica'],2);
				}
			}
		}
		echo '<script>alert("Los datos han sido guardados exitosamente");</script>';
		exit();	
	} catch (Exception $e) {
		echo "<script>alert('Ha ocurrido un error en el sistema, los datos no han sido guardados.')</script>";
		exit();
	} 	
		
}
if($_REQUEST['origen']=="modal_seguimiento"){
	
	header('Location: seguimiento.php?dni='.$_RESQUEST['dni_seguimiento']);
	exit();
}
if($_REQUEST['accion']=="borrar_problematica"){
	$tutor->borrar_problematica_alumno($_REQUEST['documento']);
	exit();
}
if($_REQUEST['accion']=="problematica"){
	$tutor->problematica_alumno($_REQUEST['documento'],$_REQUEST['id_prob'],$_REQUEST['fecha'],$_REQUEST['vez']);
	exit();
}
if($_REQUEST['accion']=="traer_problematica"){
	$array = $tutor->traer_problematica($_REQUEST['documento']);
    $var= "[";
    foreach ($array as $key => $value) {
		$var .= '{"clave":'.$key.',"valor":'.$value[0]."},";
    }
    $var = substr($var,0,strlen($var)-1);
    $var.="]";
    echo $var;        
	exit();
}
if($_REQUEST['accion']=="traer_problematica_fecha")
{
	$array = $tutor->traer_problematica($_REQUEST['documento']);
    echo $array[0]['fecha_baja'];    
	exit();
}

if($_REQUEST['accion']=="guardar_percepcion")
{
	$tutor->grabar_percepcion($_REQUEST['tutor'],$_REQUEST['documento'],$_REQUEST['numero'],$_REQUEST['fecha'],$_REQUEST['descripcion'],$_REQUEST['percepcion'],$_REQUEST['tipo'],$_REQUEST['descripcion_2'],$_REQUEST['entrevista']);
	exit();
}
if($_REQUEST['accion']=="fecha")
{
    $resultado_tutor = $tutor->percepcion_alumno($_REQUEST['documento'],$_REQUEST['percepcion']);
	echo $resultado_tutor[0]['fecha'];
	exit();
}
if($_REQUEST['accion']=="descripcion")
{
	$resultado_tutor = $tutor->percepcion_alumno($_REQUEST['documento'],$_REQUEST['percepcion']);
	echo $resultado_tutor[0]['texto'];
	exit();
}
if($_REQUEST['accion']=="tutor")
{
	$resultado_tutor = $tutor->percepcion_alumno($_REQUEST['documento'],$_REQUEST['percepcion']);
	echo $resultado_tutor[0]['id_tutor'];
	exit();
}
if($_REQUEST['accion']=="percepcion")
{
	$resultado_tutor = $tutor->percepcion_alumno($_REQUEST['documento'],$_REQUEST['percepcion']);
	echo $resultado_tutor[0]['percepcion'];
	exit();
}
if($_REQUEST['accion']=="descripcion2")
{
	$resultado_tutor = $tutor->percepcion_alumno($_REQUEST['documento'],$_REQUEST['percepcion']);
	echo $resultado_tutor[0]['texto2'];
	exit();
}
if($_REQUEST['accion']=="tipo")
{
	$resultado_tutor = $tutor->percepcion_alumno($_REQUEST['documento'],$_REQUEST['percepcion']);
	echo $resultado_tutor[0]['tipo'];
	exit();
}
if($_REQUEST['accion']=="entrevista")
{
	$resultado_tutor = $tutor->percepcion_alumno($_REQUEST['documento'],$_REQUEST['percepcion']);
	if($resultado_tutor[0]['espontanea']==1)
	{
		echo "true";
	}
	else
	{
		echo "false";
	}
	exit();
}


$formularios = new Form(0);
include('class.alumnos.php');
include('class.carreras.php');
//require_once("cabecera_ajax.php");

?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<!-- Bootstrap core CSS -->
		<? if($_REQUEST['salida']!='Excel') { ?> 
			<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
			<style>
				body { padding-top: 50px; }
			</style>
		<? } ?>
	</head>
	<body>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
<form class="form-horizontal" role="form"  name='form_alumnos' id='form_alumnos'>

<?php

$tutor = new Tutores();
$tutores = $tutor->obtener_tutores();
$alumno   = new Alumno(0);
$carreras = new Carreras();


$array_carreras_listado = $carreras->traer_carreras();
foreach($array_carreras_listado as $array_carrera)
{
	$arra_carreras.= "<option value='".$array_carrera['carr_id']."'>".$array_carrera['carr_descripcion']."</option>";
}
?>


				<div class="form-group">				 
					<label for="id_carrera_sele" class="col-sm-2 control-label">				
						Carrera
					</label>
					<div class="col-sm-5">
					<select name='carrera_seleccionada' id='id_carrera_sele' class='form-control'>
						<option value='0'>Todas</option>
						<? echo $arra_carreras; ?>
					</select>
					</div>
				</div>
				<div class="form-group"> 
					<label for="numero_docu" class="col-sm-2 control-label">
						Documento
					</label>
					<div class="col-sm-5">
						<input type='number'  class='form-control' maxlength='9' name='numero_docu' id='numero_docu' value='<? echo $_REQUEST['numero_docu']; ?>' />
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						 
						<button type="submit" class="btn btn-primary">
							Buscar
						</button>
					</div>
				</div>
				<input type='hidden' name='guardar' value='guardar'/>
			</form>

<?

$id_instancia = $_REQUEST['instancia'];
$id_carrera   = $_REQUEST['carrera_seleccionada'];
$documento    = $_REQUEST['numero_docu'];

foreach($array_carreras_listado as $array_carreras){
	$array_carrera_indexado[$array_carreras['carr_id']]=$array_carreras['carr_descripcion'];
}

foreach($array_tutores as $array_tutor){
	$array_tutor_indexado[$array_tutor['carr_id']]=$array_tutor['carr_descripcion'];
}


if($_REQUEST['guardar']!=""){
	$alumnos_mutantes = $alumno->traer_alumnos($id_instancia,$id_carrera,$documento);
?>
	<table class='table table-bordered table-striped' width='100%' id='tabla_reporte'>
	<tr>
		<th>Nombre</th><th>Apellido</th><th>Documento</th><th>E-mail</th><th>Telefono</th><th>Carrera</th><th>Percepci&oacute;n</th><th>Seguimiento</th><th>Problem&aacute;tica de discontinuidad o no contactado</th>
	</tr>
<?

	foreach($alumnos_mutantes as $mutar){
		$mutar['dni'] = trim($mutar['dni']);
		?>
		<tr>
			<td><? echo $mutar['nombre']; ?></td>
			<td><? echo $mutar['apellido']; ?></td>
			<td><? echo $mutar['dni']; ?></td>
			<td><? echo $mutar['mail']; ?></td>
			<td><? echo $mutar['tel_linea']; ?></td>
			<td><? echo $array_carrera_indexado[$mutar['idcarrera']]; ?></td>
			<!--td> echo $array_tutor_indexado[$mutar['idcarrera']]['carr_descripcion']; </td-->
			<td>
			<button type="button" class="btn btn-default btn-lg" data-backdrop="static" data-keyboard="false" onclick='mostrar("<? echo $mutar['dni']; ?>",1);'/>
				1
				</button>
			<button type="button" class="btn btn-default btn-lg" data-backdrop="static" data-keyboard="false" onclick='mostrar("<? echo $mutar['dni']; ?>",2);'/>
				2
				</button>
			<!--img src='../aspirantes/images/1350079381_green01.png'  onclick='mostrar("<? echo $mutar['dni']; ?>",1);'/>
			<img src='../aspirantes/images/1350079427_green02.png'  onclick='mostrar("<? echo $mutar['dni']; ?>",2);'/-->
			</td>

			<td>
				
				<button type="button" class="btn btn-default btn-lg" onclick='seguimiento("<? echo $mutar['dni']; ?>")'>
					<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
				</button>
			</td>
			<td >
				<button type="button" class="btn btn-danger btn-lg" onclick='motivos("<? echo $mutar['dni']; ?>")'>
				<span class="glyphicon glyphicon-ban-circle" aria-hidden="true" ></span>
				</button>
			</td>
			<?
		//           echo "<a href='seguimiento.php?dni=".$mutar['dni']."'>Seguimiento</a>";
			?>
		</tr>
				
			
<?
		$documento = $mutar['dni'];
		$con = new Coneccion();
		$problematicas = $con->query("select * from problematicas order by prioridad");
		$string = "";

		$string = "<br>";
		$copia = $problematicas;


		}




	echo "</table>";

}















include('modal_percepcion.php');
include('modal_problematica.php');
include('modal_seguimiento.php');

?>
			<iframe style="border: none; width:0; height:0;" id="iframesubmission" name="iframesubmission"></iframe>

		</div>
	</div>
</div>
	

        <script src="bootstrap/js/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="bootstrap/js/jquery.min.js"><\/script>')</script> 
        <script src="bootstrap/dist/js/bootstrap.min.js"></script> 
<script>
function mostrar(documento,numero)
{
	$.get('tutor_percepcion.php?accion=fecha&percepcion='+numero+'&documento='+documento, function(result) {
	$("#fecha").val(result);
	});
	
	$.get('tutor_percepcion.php?accion=descripcion&percepcion='+numero+'&documento='+documento, function(result) {
	$("#detalle").val(result);
	});
	
	$.get('tutor_percepcion.php?accion=tutor&percepcion='+numero+'&documento='+documento, function(result) {
	$("#tutor").val(result);
	});
	
	$.get('tutor_percepcion.php?accion=percepcion&percepcion='+numero+'&documento='+documento, function(result) {
	$("#percepcion").val(result);
	});
	
	$.get('tutor_percepcion.php?accion=tipo&percepcion='+numero+'&documento='+documento, function(result) {
	$("#entrevista").val(result);
	});
	
	$.get('tutor_percepcion.php?accion=descripcion2&percepcion='+numero+'&documento='+documento, function(result) {
	$("#acuerdos").val(result);
	});
	
	$.get('tutor_percepcion.php?accion=entrevista&percepcion='+numero+'&documento='+documento, function(result) {
		if(result=="true"){	$("#check_espontanea_"+documento).attr('checked', result);}
	});
	$("#dni_percepcion").val(documento);
	tiempo=numero+1;
	$("#nroPercepcion")[0].innerText=" "+numero+" - Entrevista en tiempo "+tiempo;
	$("#nro").val(numero);

	$("#modal-container-727445").modal({backdrop: 'static', keyboard: false});

	
	
	return;
	
	
	
	estado = document.getElementById("div_documento_"+documento).style.display;
	

	
	if(estado=="none")
	{
		document.getElementById("div_documento_"+documento).style.display="table-row";
	}
	else
	{
		document.getElementById("div_documento_"+documento).style.display="none";
	}
		
		
		if(numero=="1")
		{ 
			texto="Entrevista en tiempo 2";
		}
		else
		{
			texto="Entrevista en tiempo 3";
		}
		
		document.getElementById("div_"+documento).innerHTML=texto;
		document.getElementById('percepcion_'+documento).value=numero;
		
	$.get('tutor_percepcion.php?accion=fecha&percepcion='+numero+'&documento='+documento, function(result) {
	$("#fecha_"+documento).val(result);
	});
	
	$.get('tutor_percepcion.php?accion=descripcion&percepcion='+numero+'&documento='+documento, function(result) {
	$("#descripcion_"+documento).val(result);
	});
	
	$.get('tutor_percepcion.php?accion=tutor&percepcion='+numero+'&documento='+documento, function(result) {
	$("#tutor_"+documento).val(result);
	});
	
	$.get('tutor_percepcion.php?accion=percepcion&percepcion='+numero+'&documento='+documento, function(result) {
	$("#select_per_"+documento).val(result);
	});
	
	$.get('tutor_percepcion.php?accion=tipo&percepcion='+numero+'&documento='+documento, function(result) {
	$("#select_tipo_"+documento).val(result);
	});
	
	$.get('tutor_percepcion.php?accion=descripcion2&percepcion='+numero+'&documento='+documento, function(result) {
	$("#descripcion_2_"+documento).val(result);
	});
	
	$.get('tutor_percepcion.php?accion=entrevista&percepcion='+numero+'&documento='+documento, function(result) {
	if(result=="true"){	$("#check_espontanea_"+documento).attr('checked', result);}
	});

	
}
function motivos(documento){

	$.get('tutor_percepcion.php?accion=traer_problematica&documento='+documento, function(result) {
        result = $.parseJSON(result)
        $.each(result, function(clave, valor){
			document.getElementById(valor.valor).checked = true;
        });
    }) 


    $.get('tutor_percepcion.php?accion=traer_problematica_fecha&documento='+documento, function(result) {	
		document.getElementById("fecha_problematica").value = result;
    } ) 
	
		$("#dni_problematica").val(documento);


	$("#modal-container-727987").modal();
	return;


    estado = document.getElementById("div_abandono_"+documento).style.display;
	

	if(estado=="none")
	{
		document.getElementById("div_abandono_"+documento).style.display="table-row";
	}
	else
	{
		document.getElementById("div_abandono_"+documento).style.display="none";
	}
        
    	$.get('tutor_percepcion.php?accion=traer_problematica&documento='+documento, function(result) {

            result = $.parseJSON(result)
            $.each(result, function(clave, valor){
               // alert(clave + "-" + valor.valor);
               //prob_".$value['id']."_".$mutar['dni']."
               document.getElementById("prob_"+valor.valor+"_"+documento).checked = true;
            });
               
            } ) 


    	$.get('tutor_percepcion.php?accion=traer_problematica_fecha&documento='+documento, function(result) {	
		 document.getElementById("fechabaja_"+documento).value = result;
            } ) 


            
}
        
        
    
    
    


</script>
<script>


function guardar_percepcion(documento)
{	
	percepcion  = document.getElementById('select_per_'+documento).value;
	tutor      	= document.getElementById('tutor_'+documento).value;
	fecha      	= document.getElementById('fecha_'+documento).value;
	descripcion = document.getElementById('descripcion_'+documento).value;
	numero = document.getElementById('percepcion_'+documento).value;
	tipo = document.getElementById('select_tipo_'+documento).value;
	descripcion_2 = document.getElementById('descripcion_2_'+documento).value;
	entrevista = document.getElementById('check_espontanea_'+documento).checked;
	
	
	//descripcion = Base64.encode(descripcion);
	
	
	if(fecha=="")
	{
		 alert("debe completar el campo de fecha");
		 $('#fecha_'+documento).focus();
		 $('#fecha_'+documento).css({'border-color':'FF0000'});
		 return;
	}
	else
	{
		$('#fecha_'+documento).css({'border-color':'EEEEEE'});
	}
	
	if(descripcion=="")
	{
		 alert("debe completar la percepcion");
		 $('#descripcion_'+documento).focus();
		 $('#descripcion_'+documento).css({'border-color':'FF0000'});
		 return;
	}
	else
	{
		$('#descripcion_'+documento).css({'border-color':'EEEEEE'});
	}
	
	if(descripcion_2=="")
	{
		 alert("debe los acuerdos");
		 $('#descripcion_2_'+documento).focus();
		 $('#descripcion_2_'+documento).css({'border-color':'FF0000'});
		 return;
	}
	else
	{
		$('#descripcion_2_'+documento).css({'border-color':'EEEEEE'});
	}
	
	if(tipo=="0")
	{
		 alert("debe completar el tipo de entrevista");
		 $('#select_tipo_'+documento).focus();
		 $('#select_tipo_'+documento).css({'border-color':'FF0000'});
		 return;
	}
	else
	{
		$('#select_tipo_'+documento).css({'border-color':'EEEEEE'});
	}
	
	
	//descripcion=escape(descripcion);
	//alert(descripcion);
	
	$.post("tutor_percepcion.php?accion=guardar_percepcion", { percepcion: percepcion, tutor: tutor, fecha: fecha,descripcion: descripcion, numero:numero, documento: documento, tipo: tipo, descripcion_2: descripcion_2,entrevista: entrevista } );
	
	//ajax_loadContent('div_guardar_percepcion',"tutor_percepcion.php?accion=guardar_percepcion&percepcion="+percepcion+"&tutor="+tutor+"&fecha="+fecha+"&descripcion="+descripcion+"&numero="+numero+"&documento="+documento); 
	//alert("Los datos se guardaron satisfactoriamente");
	//alert("La percepcion se guardo satisfactoriamente");

}


function guardar_problematica(documento)
{	

	$.post("tutor_percepcion.php?accion=borrar_problematica", { documento: documento} );


	fecha = document.getElementById('fechabaja_'+documento).value;

	var array_probl = new Array();
	<?
		foreach ($problematicas as $value)
			echo "array_probl[".$value['id']."] = ".$value['id'].";\n";
	?>
	
	var array_selecccionados = new Array();
	contador = 1;
	for(id_prob=1; id_prob<array_probl.length ;id_prob++)	
		if(document.getElementById('prob_'+array_probl[id_prob]+"_"+documento).checked ){
			$.post("tutor_percepcion.php?accion=problematica", { id_prob: id_prob, documento: documento, fecha: fecha, vez: contador} );
			contador=2;
		}

	//alert("La/s problematicas se guardo/aron satisfactoriamente");

}

function seguimiento(documento){

	$("#iframeseguimiento").attr('src', "seguimiento.php?dni="+documento );
			$("#dni_seguimiento").val(documento);

		$("#modal-container-727546").modal();

	
}




</script>

	</body>
</html>
