<?php
session_start();

$_SESSION['id']="RESUMEN";
$code = explode("_", $_REQUEST['code']);

if($code[1]=="") return;
if($code[0]=="") return;

$_SESSION['nombre_base']=$code[1];


$_REQUEST['id_alumno'] = $code[0];


//$_SESSION['nombre_base']=2015;


//$_REQUEST['id_alumno'] = 987654321;



$_REQUEST['id_formulario'] = 21;//21 es el foda

include('class.form.php');
include('class.alumnos.php');
include('class.alumnosFormularios.php');

$formulario = $_REQUEST['id_formulario'];
$dni		= $_REQUEST['id_alumno'];

$vclassform 	= new Form($formulario);
$vclassalumno 	= new Alumno($dni);
$respuestas_alumno = $vclassalumno->traerRespuestas($formulario);

include('class.alumnosRespuestasAgenda.php');
$respagenda = new alumnosRespuestasAgenda();


$formularios = new alumnosFormularios($dni);
$formu=$formularios->traerForms();

$Fortalezas = array();
$Debilidades = array();
$Oportunidades = array();
$Amenazas = array();


foreach($respuestas_alumno as $resp)
{
	$tipo = $vclassform->obtenerTipo($resp['valor']);
	$id_pregunta = $vclassform->obtenerPregunta($resp['idrespuesta']);
	$array_valores_respuestas = $vclassform->traerRespuestas($resp['idrespuesta']);


	if($id_pregunta_anterior != $id_pregunta)
	{
		$array_datos_pregunta = $vclassform->traerPreguntasTexto($id_pregunta);
		$texto_preguntas = $array_datos_pregunta[0]['texto'];	
		$variable=utf8_decode($texto_preguntas);		
		$id_pregunta_anterior = $id_pregunta;
	}	
	
	
	if($array_valores_respuestas[0]['idtipo']=="2")
	{
		if(($array_valores_respuestas[0]['texto']=="Otra (Especificar)") || ($array_valores_respuestas[0]['texto']=="Otra"))
		{
			$var = $vclassform->traerValor($id_pregunta, $dni);
			if(($var[0][0]!="Otra (Especificar)") && ($var[0][0]!="Otra")  )
			{	
				array_push($$variable,utf8_decode($var[0]['valor']));

			}
		}
		else
		{
			array_push($$variable,utf8_decode($array_valores_respuestas[0]['texto']));
			//echo "<li>".utf8_decode($array_valores_respuestas[0]['texto'])."</li>";;
		}
	}
	
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Bootstrap 3, from LayoutIt!</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">



<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
<script type="text/javascript" src="bootstrap/dist/js/bootstrap.min.js"></script>
<script src="highcharts/highcharts.js"></script>
<script src="highcharts/modules/exporting.js"></script>

</head>

<body >
<div class="container_div">
<br><br>
	<div class="row clearfix">
		<div class="col-md-6 column">
<br>
<br>
<?
$default_image="images/profile.png";
if (file_exists("photos/".$_REQUEST['id_alumno'].".jpg")) {
 $default_image="photos/".$_REQUEST['id_alumno'].".jpg";
}
if (file_exists("photos/".$_REQUEST['id_alumno'].".jpeg")) {
 $default_image="photos/".$_REQUEST['id_alumno'].".jpeg";
}
if (file_exists("photos/".$_REQUEST['id_alumno'].".png")) {
 $default_image="photos/".$_REQUEST['id_alumno'].".png";
}
if (file_exists("photos/".$_REQUEST['id_alumno'].".gif")) {
 $default_image="photos/".$_REQUEST['id_alumno'].".gif";
}
  

?>
			<img height="140" width="140" src="<? echo $default_image; ?>" /> <address> 
<br>

<strong>Datos de contacto</strong><br /> 


<span class="glyphicon glyphicon-envelope"></span>&nbsp; <? echo "Mail: ".$vclassalumno->get_mail()."<br>"; ?>



<span class="glyphicon glyphicon-phone-alt"></span>&nbsp; <? 
echo "Tel&eacute;fono: ".$vclassalumno->get_telLinea()."<br>"; ?>


<span class="glyphicon glyphicon-phone"></span>&nbsp;
<?


echo "Celular: ".$vclassalumno->get_telCel()."<br>";



?>

</address>
		</div>
		<div class="col-md-6 column">
			<h3>
				<? echo $vclassalumno->get_nombre()." ".$vclassalumno->get_apellido()." - ".$vclassalumno->get_id();  ?>
			</h3>
<div id="container_graph" style="height: 300px;" ></div>
		</div>
	</div>
	<div class="row clearfix">
		<div class="col-md-6 column" style="word-break: break-all; word-wrap: break-word;">
		<h3>Textos clave.</h3>

 
<?
$respuestas = $vclassalumno->traerTextoLibre();
foreach($respuestas as $dato){
	if($dato[0]!="Otra (Especificar)" && $dato[0]!="Otro" && $dato[0]!="Otra")
		echo '<br><span class="glyphicon glyphicon-pencil"></span><span class="label label-default">'.$dato[0].'</span><br>';

}

?>


			 
		</div>
		<div class="col-md-6 column">
			<h3>
				Instrumentos cargados.
			</h3>












<?
foreach($formu as $form){
	
	echo "<br><span class='glyphicon glyphicon-ok' ></span>&nbsp;".$formularios->get_descripcion($form[0]).": ";





	if(strpos($formularios->get_descripcion($form[0]),"genda")) 
{
$id_agenda=$form['id'];
}


	if( $form[2] == "0000-00-00" or $form[2] == ""){
		echo "Asignado";
	}else{
                if($form['campo_magico']=="OP") $form['campo_magico']="Orientaci&oacute;n Parcial";
                if($form['campo_magico']=="T") $form['campo_magico']="Orientaci&oacute;n Total";
                if($form['campo_magico']=="D") $form['campo_magico']="Desorientaci&oacute;n";

                
		echo 'Completado el d&iacute;a &nbsp;'.utf8_decode($form[2]).' / resultado:&nbsp;'.$form['campo_magico'] ;
		echo "";
	}
}


if($id_agenda!=""){
	$respuesta_general = $respagenda->traerRespuestas($id_agenda,$dni);
//echo "<pre>";
//	print_r($respuesta_general);
//echo "</pre>";
}
?>














		</div>
	</div>
<br>
<br>
	<div class="row clearfix">
		<div class="col-md-12 column">
			<table class="table table-bordered table-condensed table-hover">
				<thead>
					<tr>
						<th width="50%">
							Fortalezas
						</th>
						<th>
							Oportunidades
						</th>

					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<? foreach($Fortalezas as $valor) echo $valor."<br>"; ?>
						</td>
						<td>
							<? foreach($Oportunidades as $valor) echo $valor."<br>"; ?>
						</td>

					
				</tbody>
				<thead>
					<tr>
						<th>
							Debilidades
						</th>
						<th>
							Amenazas
						</th>

					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<? foreach($Debilidades as $valor) echo $valor."<br>"; ?>
						</td>
						<td>
							<? foreach($Amenazas as $valor) echo $valor."<br>"; ?>
						</td>

					
				</tbody>
			</table>
		</div>
	</div>
</div>

<?
$idFormMaxAgenda = $respagenda->traerMaxAgenda($dni);

$agenda = $respagenda->traerRespuestas($idFormMaxAgenda[0][0],$dni);

$respagenda = $agenda;

$total = $respagenda[0][1]+$respagenda[0][2]+$respagenda[0][3]+$respagenda[0][4];




$estudio = $respagenda[0]['estudio'] / $total * 100;
$actividades = $respagenda[0]['actividades'] / $total * 100;
$facultad = $respagenda[0]['facultad'] / $total * 100;
$trabajo = $respagenda[0]['trabajo'] / $total * 100;


?>



<script>


$(function () {
    $('#container_graph').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 0,
            plotShadow: false
        },
        credits:{
            enabled:false
        },
        title: {
            text: 'Agenda<br>semanal',
            align: 'center',
            verticalAlign: 'middle',
            y: 60
        },
        plotOptions: {
            pie: {
                dataLabels: {
                    enabled: true,
                    distance: 20,
                    style: {
                        fontWeight: 'bold',
                        color: 'red',
                    }
                },
                startAngle: -90,
                endAngle: 90,
                center: ['50%', '70%']
            },
	    series: {
 	    	animation: false
	    }
        },
        exporting:{enabled:false},
        series: [{
            type: 'pie',
            innerSize: '100%',
            data: [
                ['Trabajo <? echo  round($trabajo,2); ?>%',  <? echo $trabajo; ?>],
                ['Estudio <? echo  round($estudio,2); ?>%',       <? echo $estudio; ?>],
                ['Facultad <? echo  round($facultad,2); ?>%', <? echo $facultad; ?>],
                ['T. libre <? echo  round($actividades,2); ?>%',    <? echo $actividades; ?>]

            ]
        }]
    });
});


</script>

<style>
.container_div {
    width: 800px;
}
.container_div {
    margin-left: auto;
    margin-right: auto;
    padding-left: 15px;
    padding-right: 15px;
}

.col-md-6{
float: left;
}

 .avoid {
    page-break-inside: avoid !important;
    margin: 4px 0 4px 0;  /* to keep the page break from cutting too close to the text in the div */
  }
</style>


<h1 class="project-name">Hist&oacute;rico</h1>
<table style="width:850px;table-layout:fixed;border:1Px solid;overflow: visible !important;page-break-inside: avoid;" >       
<?php

   $con = new Mongo(); // Connect to Mongo Server
   $db = $con->selectDB("seguimiento"); // Connect to Database
   $collection = new MongoCollection($db, "seguimiento".$_SESSION['nombre_base']);
   $busqueda = "";
   $busqueda = array('user' => $_REQUEST['id_alumno']);  

   $cursor = $collection->find($busqueda);
   $array_solicitud = iterator_to_array($cursor);



ksort($array_solicitud);
echo "<tr style='border:1Px solid;'>";
echo "<th style='border: 1px solid;'>";
echo "Descripcion";
echo "</th>";
echo "<th style='border: 1px solid;'>";
echo "Origen";
echo "</th>";
echo "<th style='border: 1px solid;'>";
echo "Fecha";
echo "</th>";
echo "<th style='border: 1px solid; width:70px;'>";
echo "Archivo";
echo "</th>";
echo "</tr>";
foreach ($array_solicitud as $solicitud) {
echo "<tr style='height:1em;page-break-inside: avoid;'>";
echo "<td style='overflow:hidden;white-space:normal;border: 1px solid;'>";
//echo "<div class='avoid'>";
echo $solicitud['description'];
//echo "</div>";
echo "</td>";
echo "<td style='border: 1px solid;'>";
echo "<div class='avoid'>";
echo $solicitud['origin'];
echo "</div>";
echo "</td>";
echo "<td style='border: 1px solid;'>";
echo "<div class='avoid'>";
echo $solicitud['date_user'];
echo "</div>";
echo "</td>";
echo "<td style='border: 1px solid;width:5PX;'>";
echo "<div class='avoid'>";
if($solicitud['filename']!=""){
echo "<img src='images/clip.svg'>";
}
echo "</div>";
echo "</td>";
echo "</tr>";

    
  
}

?>
            </table>

</body>
</html>
