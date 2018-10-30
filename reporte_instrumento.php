<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<title>SIT - Reporte</title>
		<meta charset="utf-8">
		<!-- Bootstrap core CSS -->
			<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
			<style type="text/css">
				@media print { body { display:none } }
				body { padding-top: 7px; }
			</style>
	</head>
	<body>
<?php
include('class.form.php');
include('class.alumnos.php');
$formulario = $_REQUEST['id_formulario'];
$dni		= $_REQUEST['id_alumno'];

$vclassform 	= new Form($formulario);
$vclassalumno 	= new Alumno($dni);
require_once('class.sysacadMateriasAprobadas.php');


$respuestas_alumno = $vclassalumno->traerRespuestas($formulario);
$texto = $vclassform->get_descripcion();
?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">	
				<div style='background-color:#556;
background-image: linear-gradient(30deg, #445 12%, transparent 12.5%, transparent 87%, #445 87.5%, #445),
linear-gradient(150deg, #445 12%, transparent 12.5%, transparent 87%, #445 87.5%, #445),
linear-gradient(30deg, #445 12%, transparent 12.5%, transparent 87%, #445 87.5%, #445),
linear-gradient(150deg, #445 12%, transparent 12.5%, transparent 87%, #445 87.5%, #445),
linear-gradient(60deg, #99a 25%, transparent 25.5%, transparent 75%, #99a 75%, #99a), 
linear-gradient(60deg, #99a 25%, transparent 25.5%, transparent 75%, #99a 75%, #99a);
background-size:80px 140px;
background-position: 0 0, 0 0, 40px 70px, 40px 70px, 0 0, 40px 70px;'>
					<br/>

					<div class="container">
						<div class="row-fluid">
							<div class="span-6">
								<div class="form-container">

			
									<div class="well well-large">
										<div class="panel-group" >
											<div class="panel panel-default">
												<div class="panel-heading">
													<h1>
														<? echo $texto; ?>
													</h1>
												</div>
												<div class="panel-collapse">
													<div class="panel-body">
														<h2>
															<? echo $vclassalumno->apellido.", ".$vclassalumno->nombre." (".$vclassalumno->id.")"; ?>
														</h2>
													</div>
												</div>
											</div>
										</div>
									</div>

		
									<div class="well well-small">


									
		
		
<?php		
if($_REQUEST['formulario']=="autoevaluacion"){
	include('class.evaluacion.formularios.php');
	$formularios_evaluacion = new evaluacionFormularios();
	$formularios_evaluacion->actualizar_alumnoform($formulario,$dni,"OK");
}elseif($_REQUEST['formulario']=="agenda_semanal"){
	
	include('agendaDrawer.php');


}
elseif($_REQUEST['formulario']=="encuesta"){
	include('class.evaluacion.formularios.php');
	$formularios_evaluacion = new evaluacionFormularios();
	$valor_de_las_cosas 	= $formularios_evaluacion->calcular_valores_orientacion($formulario,$dni);
	$valor_regular =  $valor_de_las_cosas;
	$formularios_evaluacion->actualizar_alumnoform($formulario,$dni,$valor_regular);
}
elseif($_REQUEST['formulario']=="encuesta_inicial"){
	include('class.evaluacion.formularios.php');
	$formularios_evaluacion = new evaluacionFormularios();
	$array_loco = $formularios_evaluacion->calcular_encuesta_inicial($formulario,$dni);
	$cont1=0;
	$cont2=0;
	foreach($array_loco as $crazy)
	{
		if($crazy=="+") 
		{
			$cont1++;
		}
		elseif($crazy=="-")
		{
			$cont2++;
		}
	}
	if($cont1>$cont2)
	{
		$valor_regular="+";
	}elseif($cont1<$cont2){
		$valor_regular="-";
	}else{
		$valor_regular="NEUTRO";
		}
	$formularios_evaluacion->actualizar_alumnoform($formulario,$dni,$valor_regular);
}
elseif($_REQUEST['formulario']=="foda"){
	include('class.evaluacion.formularios.php');
	$formularios_evaluacion = new evaluacionFormularios();
	$val1foda = $formularios_evaluacion->calcular_foda($formulario,$dni);
	$valor_regular = $val1foda;
	$formularios_evaluacion->actualizar_alumnoform($formulario,$dni,$valor_regular);

}
elseif($_REQUEST['formulario']=="plan_personal_carrera_2"){

	include('class.carreras.php');
	include('class.evaluacion.formularios.php');
	$carrera = new Carreras();
	$id_alumno = $_REQUEST['id_alumno'];
	$id_formulario = $_REQUEST['id_formulario'];
	$resultados_ppc = $carrera->recuperarPPC($id_formulario, $id_alumno);
	$formularios_evaluacion = new evaluacionFormularios();
	$valor_regular = "COMPLETO";
	$formularios_evaluacion->actualizar_alumnoform($formulario,$dni,$valor_regular);

	$materias_cursar   = $resultados_ppc[0]['mat_cursar'];
	$materias_proximas = $resultados_ppc[0]['mat_cursar_prox'];
	$materias_cursar = unserialize($materias_cursar);
	$materias_proximas = unserialize($materias_proximas);
	foreach($materias_cursar as $mat){
        $materias_cursar_filtro[$mat['materias']] = $mat;
    }
       
	echo "<br>";
	
	echo '<div class="panel panel-primary"><div class="panel-heading"><h3 class="panel-title">Materias a cursar</h3></div><div class="panel-footer">';

	echo "</br>";
	
	
	$materias = $carrera->devolverMaterias();
	
	foreach($materias as $mate){
		$arr_materias[$mate[0]] = $mate[1];
	}
	
	$cantidad = 0;
	$cantidad2 =0; 
        
    
	echo '<table class="table table-bordered table-striped" width="100%">';
  
    echo "<thead><tr class='success'><th>Materia</th><th>Parcial1</th><th>Parcial2</th><th>Parcial3</th><th>Finales</th></tr></thead>";
        
    echo "<tbody>";    
        
	foreach($materias_cursar_filtro as $clave=>$curso){
          
            
            echo "<tr>";
            
            if(($cantidad2%2)==0) $backcolor="#CCCCCC";
            else $backcolor="#CECECE";
                
            $cantidad=0;
            foreach($curso as $campo){
                
                if($cantidad==0){
                   echo "<th class='success'>".$arr_materias[$campo]."</th>";
                }  else {
                    echo "<td>".$campo."</td>";
                }
                $cantidad=1;
            }
            echo "</tr>";
        }
        echo "</tbody>";    
        
        echo "</table>";
                

	
	echo "<br>";
	echo '</div></div><div class="panel panel-primary"><div class="panel-heading"><h3 class="panel-title">Pr&oacute;ximo A&ntilde;o</h3></div><div class="panel-footer">';

	echo "<br>";
	
	$cantidad = 0;
	$cantidad2=0;
	echo '<table class="table table-bordered table-striped" width="100%">';
    echo "<thead><tr class='success'><th>Materia</th><th>D&iacute;a</th></tr></thead><tbody>";
	foreach($materias_proximas as $proximas)
	{
		echo "<tr>";
		foreach($proximas as $campo)
		{

			echo "<td>";
			switch($cantidad)
			{
				case 0:
				
					echo $arr_materias[$campo];
				
				break;
				case 1:
			
					$array_dias[1]="Lunes";
					$array_dias[2]="Martes";
					$array_dias[3]="Miercoles";
					$array_dias[4]="Jueves";
					$array_dias[5]="Viernes";
					$array_dias[6]="Sabado";
					echo $array_dias[$campo];
						
				
				break;
			}
			echo "</td>";
		$cantidad = $cantidad + 1;
		}
		
		$cantidad  = 0;
		$cantidad2=$cantidad2 + 1;
		echo "</tr>";
		
	}
	echo "</tbody>";    

	echo "</table>";

	
}



$id_pregunta_anterior = "";

foreach($respuestas_alumno as $resp){
	$tipo = $vclassform->obtenerTipo($resp['valor']);

	if(trim($tipo) == "4")
	{
		$id_pregunta = $vclassform->obtenerPregunta($resp['valor']);
		$array_valores_respuestas = $vclassform->traerRespuestas($resp['valor']);
	}else{
		$id_pregunta = $vclassform->obtenerPregunta($resp['idrespuesta']);
		$array_valores_respuestas = $vclassform->traerRespuestas($resp['idrespuesta']);
	}

	if($resp[idrespuesta]==155){
		$array_datos_pregunta = $vclassform->traerPreguntasTexto($resp[idrespuesta]);
		$texto_preguntas = $array_datos_pregunta[0]['texto'];
	
		echo '</div></div><div  id="'.$id_pregunta.'" class="panel panel-primary"><div class="panel-heading"><h3 class="panel-title">' . $texto_preguntas . '</h3></div><div class="panel-footer">';




		$plan_carrera = $vclassalumno->traer_plan_carrera();
		

		$array_materias_cursar = $plan_carrera[0]['mat_cursar'];
		
		$array_materias_cursar_deserializado = unserialize($array_materias_cursar);
		
		  foreach($array_materias_cursar_deserializado as $mat){
	    if($mat['llamado']!="APROBADA")
            $materias_cursar_filtro[$mat['materias']] = $mat;


        }

		require_once('coneccion.php');

		$con = new Coneccion();

		echo "Programadas:";
		//echo "<br>";
		echo "<ul>";
		$cantidad= 0;
		foreach($materias_cursar_filtro as $key=>$mate)
		{

			$materia = explode('-',$mate['materias']);
			$query="select * from materias_carrera where materia=".$materia[0]." and plan=".$materia[2]." and carrera=".$materia[1]."";
			$resultado = $con ->query($query);
			echo "<li>";	
			echo $resultado[0]['nombre'];
			if($resultado[0]['nombre'] != "") $cantidad++; 
			echo "</li>";
		}
		echo "</ul>";
		
		

$sysacad = new Sysacad();
$resultado = $sysacad->obtenerMaterias($dni);
$con = new Coneccion();
//print_r($resultado );



		echo "Aprobadas:";
		//echo "<br>";
		echo "<ul>";
		foreach($resultado as $mate)
		{



			$query="select * from materias_carrera where materia=".$mate['materia']." and plan=".$mate['plan']." and carrera=".$mate['especialidad']."";
			//echo $query;
			$resultado2 = $con ->query($query);
			echo "<li>";	
			echo $resultado2[0]['nombre'];
			echo "</li>";
		}
		echo "</ul>";
		
		//$cantidad = count($array_materias_cursar_deserializado);
		$cantidad2 = count($resultado);
		
		//echo "<br>";
		echo "Efectividad: ".$cantidad2." / ".$cantidad;
		
		$valor_regular="OK";

		continue 1;


	}
		


















	if($id_pregunta_anterior != $id_pregunta){
		$array_datos_pregunta = $vclassform->traerPreguntasTexto($id_pregunta);
		$texto_preguntas = $array_datos_pregunta[0]['texto'];
		
		if($id_pregunta_anterior != "") echo "</div></div>";										
		echo '<div class="panel panel-primary"><div class="panel-heading"><h3 class="panel-title">' . $texto_preguntas . '</h3></div><div class="panel-footer">';		
		$id_pregunta_anterior = $id_pregunta;
	}	
	
	if($array_valores_respuestas[0]['idtipo']=="2"){
		if(($array_valores_respuestas[0]['texto']=="Otra (Especificar)") || ($array_valores_respuestas[0]['texto']=="Otra"))
		{
			$var = $vclassform->traerValor($id_pregunta, $dni);
			if(($var[0][0]!="Otra (Especificar)") && ($var[0][0]!="Otra")     )
			{	
				echo "<span class='glyphicon glyphicon-edit' aria-hidden='true'></span>&nbsp;".$var[0]['valor'];

				echo "<br>";
			}
		}
		else
		{
			echo "<span class='glyphicon glyphicon-check' aria-hidden='true'></span>&nbsp;".$array_valores_respuestas[0]['texto'];

			echo "<br>";
		}
	}elseif(trim($tipo)=="4"){
	
		echo "<span class='glyphicon glyphicon-sort-by-attributes-alt' aria-hidden='true'></span>&nbsp;".$array_valores_respuestas[0]['texto'];
		echo "<br>";
	}elseif($array_valores_respuestas[0]['idtipo']=="6"){
		if($resp['valor']!="")
		{
			echo "<span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>&nbsp;".$resp['valor'];
			echo "<br>";

		}
	}elseif($array_valores_respuestas[0]['idtipo']=="8")	{
		echo "asdasda";
	}
	



	
	

}

	echo "</div></div>";
	echo '<div class="panel panel-primary"><div class="panel-heading"><h3 class="panel-title"></h3></div><div class="panel-footer">';
	echo '<h2><font color="RED">Resultado: '.$valor_regular.'</font></h2>';
	echo "</div></div>";


?>
								
								</div>			
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	

        <script src="bootstrap/js/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="bootstrap/js/jquery.min.js"><\/script>')</script> 
        <script src="bootstrap/dist/js/bootstrap.min.js"></script> 
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script>
if($("#container").length >0){
$(graficar());
}
</script>
</body>
</html>
