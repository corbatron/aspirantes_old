<link href='http://fonts.googleapis.com/css?family=Rosarivo:400italic' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="js/jscharts.js"></script>

<style>
	 h1{
        font-family: 'Rosarivo', serif;
        font-size: 48px;
      }
	  	 h3 {
        font-family: 'Rosarivo', serif;
        font-size: 18px;
      }
</style>
<?
include('class.form.php');
include('class.alumnos.php');
$formulario = $_REQUEST['id_formulario'];
$dni		= $_REQUEST['id_alumno'];

$vclassform 	= new Form($formulario);
$vclassalumno 	= new Alumno($dni);
$respuestas_alumno = $vclassalumno->traerRespuestas($formulario);



/*
echo "<pre>";
print_r($respuestas_alumno);
echo "</pre>";
foreach($respuestas_alumno as $ralf){

$arespuesta[$ralf['id']]['valor'] = $ralf['valor']; 

$arespuesta[$ralf['id']]['idrespuesta'] = $ralf['idrespuesta'];

}
ksort($arespuesta);
echo "<pre>";
print_r($arespuesta);
echo "</pre>";
*/


$texto = $vclassform->get_descripcion();

echo "<H1><i>".utf8_decode($texto)."</i></H1>";
echo "<h2>".$vclassalumno->apellido.", ".$vclassalumno->nombre." (".$vclassalumno->id.")"."</h2>";
echo "<hr align='left' width='80%'>";

if($_REQUEST['formulario']=="autoevaluacion")
{
	include('class.evaluacion.formularios.php');
	$formularios_evaluacion = new evaluacionFormularios();
//	$valor_de_las_cosas 	= $formularios_evaluacion->calcular_valores_orientacion($formulario,$dni);
//	$valor_regular =  $valor_de_las_cosas;
	$formularios_evaluacion->actualizar_alumnoform($formulario,$dni,"OK");
	
	echo "<br>";

}elseif($_REQUEST['formulario']=="agenda_semanal")
{
	include('class.alumnosRespuestasAgenda.php');
	$respagenda = new alumnosRespuestasAgenda();
	
	include('class.evaluacion.formularios.php');
	$formularios_evaluacion = new evaluacionFormularios();
	

	
	$respuesta_general = $respagenda->traerRespuestas($formulario,$dni);
	
	$valor1="['ESTUDIO',".$respuesta_general[0]['estudio']."],['ACTIVIDADES',".$respuesta_general[0]['actividades']."],['FACULTAD',".$respuesta_general[0]['facultad']."],['TRABAJO',".$respuesta_general[0]['trabajo']."]";
	
	
	?>
	<div id="graph">Generando grafico</div>
		<script>
	function crear_grafico(cadena1)
	{

		var myChart = new JSChart('graph', 'pie');
	    myChart.setDataArray([<?echo $valor1?>]);
	    myChart.colorize(['#99CDFB','#3366FB','#F89900','#F76600']);
		myChart.setSize(600, 300);
		myChart.setTitle('Referencias');
		myChart.setTitleFontFamily('Times New Roman');
		myChart.setTitleFontSize(14);
		myChart.setTitleColor('#0F0F0F');
		myChart.setPieRadius(95);
		myChart.setPieValuesColor('#FFFFFF');
		myChart.setPieValuesFontSize(9);
		myChart.setPiePosition(180, 165);
		myChart.setShowXValues(false);
     	myChart.setLegend('#99CDFB', 'ESTUDIO');
		myChart.setLegend('#3366FB', 'ACTIVIDADES');
		myChart.setLegend('#F89900', 'FACULTAD');
		myChart.setLegend('#F76600', 'TRABAJO');
		myChart.setLegendShow(true);
		myChart.setLegendFontFamily('Times New Roman');
		myChart.setLegendFontSize(10);
		myChart.setLegendPosition(350, 120);
		myChart.setPieAngle(30);
		myChart.set3D(true);
		myChart.draw();
		
		
	}
	</script>
	<?
	
	echo "&nbsp;<script>crear_grafico('".$cadena1."');</script>";
	
	$array_resultados_agenda = $respagenda->traerAgendaCompleta($formulario,$dni);

	echo "<br>";

	foreach($array_resultados_agenda as $resp_res_agenda)
	{
		$array_resp[$resp_res_agenda['id_dia']][$resp_res_agenda['id_hora']] = $resp_res_agenda['id_valor'];
	}

	$array_dia[1]="Lunes";
	$array_dia[2]="Martes";
	$array_dia[3]="Miercoles";
	$array_dia[4]="Jueves";
	$array_dia[5]="Viernes";
	$array_dia[6]="Sabado";
	$array_dia[7]="Domingo";

	echo "<table bgcolor='#CCCCCC' cellspacing='2' cellpadding='2'>";
	echo "<tr>";
	echo "<td>";
	echo "</td>";
	echo "<td>";
	echo "6";
	echo "</td>";
	echo "<td>";
	echo "7";
	echo "</td>";
	echo "<td>";
	echo "8";
	echo "</td>";
	echo "<td>";
	echo "9";
	echo "</td>";
	echo "<td>";
	echo "10";
	echo "</td>";
	echo "<td>";
	echo "11";
	echo "</td>";
	echo "<td>";
	echo "12";
	echo "</td>";
	echo "<td>";
	echo "13";
	echo "</td>";
	echo "<td>";
	echo "14";
	echo "</td>";
	echo "<td>";
	echo "15";
	echo "</td>";
	echo "<td>";
	echo "16";
	echo "</td>";
	echo "<td>";
	echo "17";
	echo "</td>";
	echo "<td>";
	echo "18";
	echo "</td>";
	echo "<td>";
	echo "19";
	echo "</td>";
	echo "<td>";
	echo "20";
	echo "</td>";
	echo "<td>";
	echo "21";
	echo "</td>";
	echo "<td>";
	echo "22";
	echo "</td>";
	echo "<td>";
	echo "23";
	echo "</td>";
	echo "<td>";
	echo "24";
	echo "</td>";


	echo "</tr>";
	for($dia = 1;$dia<8;$dia++)
	{	
		echo "<tr>";
		echo "<td>";
		echo $array_dia[$dia];
		echo "</td>";

		for($hora = 0;$hora<19;$hora++)
		{
			echo "<td>";
			$cantidades[$array_resp[$dia][$hora]] = $cantidades[$array_resp[$dia][$hora]] + 1;
			switch ($array_resp[$dia][$hora])
			{
				case "0":
					echo "<img width='20' height='20' src='common/img/estudio.png'/>";
				break;
				case "1":
					echo "<img width='20' height='20' src='common/img/tiempo_libre.png'/>";
				break;
				case "2":
					echo "<img width='20' height='20' src='common/img/cursada.png'/>";
				break;
				case "3":
					echo "<img width='20' height='20' src='common/img/trabajo.png'/>";
				break;
			}
			
			echo "&nbsp;";
			echo "</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
	
		$valores_evaluacion = $formularios_evaluacion->calcular_valores_agenda($cantidades[3],$cantidades[1],$cantidades[0],$cantidades[2]);
		
		$X1 = $valores_evaluacion['general'];
		$Y1 = $valores_evaluacion['equilibrio_estudio'];
	
		$RESULTADO = $X1 + $Y1;
		if($RESULTADO>="1.30")
		{
			$valor_regular = "+";
		}
		
		if($RESULTADO>"0.85" && $RESULTADO<"1.30")
		{
			$valor_regular = "NEUTRO";
		}
		
		if($RESULTADO<="0.85")
		{
			$valor_regular = "-";
		}
		
		$formularios_evaluacion->actualizar_alumnoform($formulario,$dni,$valor_regular);
		
		if($valores_evaluacion['general']>="0.50" )
		{
			$texto1="<H2>(E+C / L+O) OK</H2>".$valores_evaluacion['general'];
			$color1="#33DD22;";
		}
		elseif($valores_evaluacion['general']<"0.50" && $valores_evaluacion['general']>"0.35")
		{
			$texto1="<H2>(E+C / L+O) MODERADO</H2>".$valores_evaluacion['general'];
			$color1="#FFAA00";
		}
		elseif($valores_evaluacion['general']<="0.35")
		{
			$texto1="<H2>(E+C / L+O) NO</H2>".$valores_evaluacion['general'];
			$color1="#FF4433";
		}
		
		if($valores_evaluacion['equilibrio_estudio']>"0.8")
		{
			$texto2="<H2>(E / C) OK</H2>".$valores_evaluacion['equilibrio_estudio'];
			$color2="#33DD22;";
		}
		elseif($valores_evaluacion['equilibrio_estudio']>="0.5" && $valores_evaluacion['equilibrio_estudio']<="0.8")
		{
			$texto2="<H2>(E / C) MODERADO</H2>".$valores_evaluacion['equilibrio_estudio'];
			$color2="#FFAA00;";
		
		}
		elseif($valores_evaluacion['equilibrio_estudio']<"0.5")
		{
			$texto2="<H2>(E / C) NO</H2>".$valores_evaluacion['equilibrio_estudio'];
			$color2="#FF4433;";
		
		}
		
		if($valores_evaluacion['equilibrio_personal']<1)
		{
			$texto3="<H2>(T / O) OK</H2>".$valores_evaluacion['equilibrio_personal'];
			$color3="#33DD22;";
		}
		else
		{
			$texto3="<H2>(T / O) NO</H2>".$valores_evaluacion['equilibrio_personal'];
			$color3="#ff4433;";
		}
		
		
		echo "<table border='0'><tr><td><div style='width:200Px;height:150Px;background-color:".$color1."'>".$texto1."</div></td><td><div style='width:200Px;height:150Px;background-color:".$color2."'>".$texto2."</div></td><td><div style='width:200Px;height:150Px;background-color:".$color3."'>".$texto3."</div></td></tr></table>";
	
	?>
	



<?



}
elseif($_REQUEST['formulario']=="encuesta")
{
	include('class.evaluacion.formularios.php');
	$formularios_evaluacion = new evaluacionFormularios();
	$valor_de_las_cosas 	= $formularios_evaluacion->calcular_valores_orientacion($formulario,$dni);
	$valor_regular =  $valor_de_las_cosas;
	$formularios_evaluacion->actualizar_alumnoform($formulario,$dni,$valor_regular);
	
	echo "<br>";

}
elseif($_REQUEST['formulario']=="encuesta_inicial")
{
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
elseif($_REQUEST['formulario']=="foda")
{
	include('class.evaluacion.formularios.php');
	$formularios_evaluacion = new evaluacionFormularios();
	$val1foda = $formularios_evaluacion->calcular_foda($formulario,$dni);
	$valor_regular = $val1foda;
	$formularios_evaluacion->actualizar_alumnoform($formulario,$dni,$valor_regular);

}
elseif($_REQUEST['formulario']=="plan_personal_carrera")
{

	include('class.carreras.php');
	include('class.evaluacion.formularios.php');
	$carrera = new Carreras();
	$id_alumno = $_REQUEST['id_alumno'];
	$id_formulario = $_REQUEST['id_formulario'];
	$resultados_ppc = $carrera->recuperarPPC($id_formulario, $id_alumno);
	$formularios_evaluacion = new evaluacionFormularios();
	$valor_regular = "COMPLETO";
	$formularios_evaluacion->actualizar_alumnoform($formulario,$dni,$valor_regular);


	//print_r($resultados_ppc);
	

	$materias_cursar   = $resultados_ppc[0]['mat_cursar'];

	$materias_proximas = $resultados_ppc[0]['mat_cursar_prox'];

	$materias_cursar = unserialize($materias_cursar);
	
	$materias_proximas = unserialize($materias_proximas);
	
	//echo "<pre>";
	//print_r($materias_proximas);
	//echo "</pre>";
	
        
        foreach($materias_cursar as $mat){
            $materias_cursar_filtro[$mat['materias']] = $mat;
        }
	
	echo "<br>";
	echo "<h2>Materias a cursar</h2>";
	echo "</br>";
	
	
	$materias = $carrera->devolverMaterias();
	
	foreach($materias as $mate)
	{
		$arr_materias[$mate[0]] = $mate[1];
	}
	
	
	$cantidad = 0;
	$cantidad2 =0; 
	echo "<table cellpadding='2' cellspacing='2'>";
	echo utf8_decode("<tr><td bgcolor='#CECECE'>Tipo</td><td bgcolor='#CECECE'>Año</td><td bgcolor='#CECECE'>Materia</td><td bgcolor='#CECECE' colspan='2'>1ºPar</td><td bgcolor='#CECECE' colspan='2'>2ºPar</td><td bgcolor='#CECECE' colspan='2'>3ºPar</td>
	<td bgcolor='#CECECE'>Finales</td></tr>");
//<td bgcolor='#CECECE'>Feb / Mar</td><td bgcolor='#CECECE'>Mayo</td><td bgcolor='#CECECE'>Julio</td><td bgcolor='#CECECE'>Octubre</td></tr>";
	foreach($materias_cursar_filtro as $clave=>$curso)
	{

		$salida_pantalla.= "<tr>";
		if(($cantidad2%2)==0)
		{
		$backcolor="#CCCCCC";
		}
		else
		{
		$backcolor="#CECECE";
		}
		foreach($curso as $campo)
		{
			$contador ++;
			$contador_valores++;
	$min=9;//9	
	$max=27;//26 --- es la posicion de los finales
	
		
			if($cantidad<$min or $cantidad==$max  ) $salida_pantalla.= "<td bgcolor='".$backcolor."'>";

			switch($cantidad)
			{
				case 0:
					if($campo=="1")
						$salida_pantalla.= "A CURSAR";
					else
						$salida_pantalla.= "HOMOLOGADA";
					break;
				
				case 1;
					$salida_pantalla.= $campo;
					break;
				case 2:
					$salida_pantalla.= utf8_decode($arr_materias[$campo]);
					break;
				//04/10/2012   default:
				case 3:
				case 5:
				case 7:
			
				case 9:
				case 11:
				case 13:
		
					if($contador_valores == "4" or $contador_valores == "6" or $contador_valores == "8")
					{
						if($campo=="1")
						{			
							$salida_pantalla.= "<li>AP</li>";
						}
						if($campo=="2")
						{
						
							$salida_pantalla.= "<li>DE</li>";
						}
						if($campo=="3")
						{
						
							$salida_pantalla.=  "<li>AU</li>";
						}
						$salida_pantalla.= "@".$contador_valores."@";
					 }
					else
					{
					
						if($campo=="1")
						{			
							$primer_parcial.= "<li>AP</li>";
						}
						if($campo=="2")
						{
					
							$primer_parcial.= "<li>DE</li>";
						}
						if($campo=="3")
						{
						
							$primer_parcial.=  "<li>AU</li>";
						}


					}
				
					
					break;

				
				case 15:
				case 17:
				case 19:
				

					if($contador_valores == "4" or $contador_valores == "6" or $contador_valores == "8")
					{
						if($campo=="1")
						{			
							$salida_pantalla.= "<li>AP</li>";
						}
						if($campo=="2")
						{
						
							$salida_pantalla.= "<li>DE</li>";
						}
						if($campo=="3")
						{
						
							$salida_pantalla.=  "<li>AU</li>";
						}



						$salida_pantalla.= "@".$contador_valores."@";
					 }
					 else
					 {
					
						if($campo=="1")
						{
					
							$segundo_parcial.= "<li>AP</li>";
						}
						if($campo=="2")
						{
						
							$segundo_parcial.= "<li>DE</li>";
						}
						if($campo=="3")
						{
						
							$segundo_parcial.=  "<li>AU</li>";
						}



				
					}
					break;

				
				
				case 21:
				case 23:
				case 25:
					if($contador_valores == "4" or $contador_valores == "6" or $contador_valores == "8")
					{
						if($campo=="1")
						{			
							$salida_pantalla.= "<li>AP</li>";
						}
						if($campo=="2")
						{
						
							$salida_pantalla.= "<li>DE</li>";
						}
						if($campo=="3")
						{
						
							$salida_pantalla.=  "<li>AU</li>";
						}

						$salida_pantalla.= "@".$contador_valores."@";
					 }
					 else
					 {
					
					
						if($campo=="1")
						{
							
							$tercer_parcial.= "<li>AP</li>";
						}
						if($campo=="2")
						{
					
							$tercer_parcial.= "<li>DE</li>";
						}
						if($campo=="3")
						{
						
							$tercer_parcial.=  "<li>AU</li>";
						}
		
					}
					break;

				case 10:
				case 12:
				case 14:
					$array_fecha=split("-",$campo);
					$var_fecha =  $array_fecha[2]."-".$array_fecha[1]."-".$array_fecha[0];
					$valor_fecha_1.="<li>".$var_fecha."</li>";
					break;
				case 16:
				case 18:
				case 20:
					$array_fecha=split("-",$campo);
					$var_fecha =  $array_fecha[2]."-".$array_fecha[1]."-".$array_fecha[0];
					$valor_fecha_2.="<li>".$var_fecha."</li>";
					break;
				case 22:
				case 24:
				case 26:
					$valor_fecha_3.="<li>".$campo."</li>";
					break;
				
				
				case 27:
				
				if($campo == 2) $salida_pantalla.= "Diciembre";
				if($campo == 3) $salida_pantalla.= "Febrero/Marzo";
				if($campo == 4) $salida_pantalla.= "Mayo";
				if($campo == 5) $salida_pantalla.= "Julio";
				if($campo == 6) $salida_pantalla.= "Octubre";
                                if($campo == 7) $salida_pantalla.= "Julio/Agosto 1er Cuat.";
                                if($campo == 8) $salida_pantalla.= "Julio/Agosto 2do Cuat.";
				break;
				
				/*case 28:
				
				
				if($campo == 3)
				$salida_pantalla.= "SI3";
				break;
				
				case 29:
				
				
				if($campo == 4)
				$salida_pantalla.= "SI4";
				break;
				
				case 30:
				
				
				if($campo == 5)
				$salida_pantalla.= "SI5";
				break;
				
				case 31:
						
				if($campo == 6)
				$salida_pantalla.= "SI6";

				break;*/
				
				
				default:
				$array_fecha=split("-",$campo);
				$var_fecha =  $array_fecha[2]."-".$array_fecha[1]."-".$array_fecha[0];
				
				if($var_fecha!="--")
				{
					$salida_pantalla.= "<li>".$var_fecha."</li>";
					
					if($cantidad=="4")
					{
						$canti = "1";
					}
					elseif($cantidad=="6")
					{
						$canti = "2";
					}
					elseif($cantidad=="8")
					{
					$canti="3";
					}
					$salida_pantalla.= "@@CORBI".$canti."@@";
			
				}
				break;
			}
			
			if($campo=="")
			{
				$salida_pantalla.= "&nbsp;";
			}

			if($cantidad<$min or $cantidad==$max)  $salida_pantalla.= "</td>";
			
			$cantidad = $cantidad + 1;



		
		}

		$cantidad2 = $cantidad2 + 1;
		$salida_pantalla.= "</tr>";
//break;///fsdafasdfa
		$cantidad = 0;
		
		$salida_pantalla = str_replace("@@CORBI1@@",$valor_fecha_1,$salida_pantalla);
		$salida_pantalla = str_replace("@@CORBI2@@",$valor_fecha_2,$salida_pantalla);
		$salida_pantalla = str_replace("@@CORBI3@@",$valor_fecha_3,$salida_pantalla);
		
		
		
		$salida_pantalla = str_replace("@4@",$primer_parcial,$salida_pantalla);
		$salida_pantalla = str_replace("@6@",$segundo_parcial,$salida_pantalla);
		$salida_pantalla = str_replace("@8@",$tercer_parcial,$salida_pantalla);
		
		
		$valor_fecha_1 = "";
		$valor_fecha_2 = "";
		$valor_fecha_3 = "";
		$primer_parcial = "";
		$segundo_parcial = "";
		$tercer_parcial = "";

$contador_valores=0;/////MARIANO 04/10/2012
		
	}
	$salida_pantalla.= "</table>";
	
	echo $salida_pantalla;
	
	
	echo "<br>";
	echo "<h2>Proximo A&ntilde;o</h2>";
	echo "<br>";
	
	$cantidad = 0;
	$cantidad2=0;
	echo "<table cellpaddin='2' cellspacing='2'>";
	echo "<tr><td bgcolor='#CECECE'>Materia</td><td bgcolor='#CECECE'>Dia</td></tr>";
	foreach($materias_proximas as $proximas)
	{
		echo "<tr>";
		foreach($proximas as $campo)
		{
			if(($cantidad2%2)==0)
			{
				$backcolor="#CCCCCC";
			}
			else
			{
				$backcolor="#CECECE";
			}
			echo "<td bgcolor='".$backcolor."'>";
			switch($cantidad)
			{
				case 0:
				
					echo utf8_decode($arr_materias[$campo]);
				
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
	echo "</table>";

	
}





$id_pregunta_anterior = "";

foreach($respuestas_alumno as $resp)
{
	$tipo = $vclassform->obtenerTipo($resp['valor']);

//print_r($resp);
//echo $tipo;

	if(trim($tipo) == "4")
	{
		$id_pregunta = $vclassform->obtenerPregunta($resp['valor']);
		$array_valores_respuestas = $vclassform->traerRespuestas($resp['valor']);
	}else{
		$id_pregunta = $vclassform->obtenerPregunta($resp['idrespuesta']);
		$array_valores_respuestas = $vclassform->traerRespuestas($resp['idrespuesta']);
	}
//echo $id_pregunta."<br>";


	if($id_pregunta_anterior != $id_pregunta)
	{
		$array_datos_pregunta = $vclassform->traerPreguntasTexto($id_pregunta);

		$texto_preguntas = $array_datos_pregunta[0]['texto'];
		echo "<H3>".utf8_decode($texto_preguntas)."</H3>";
		
		$id_pregunta_anterior = $id_pregunta;
		echo "<br>";
	}	
	
	
	if($array_valores_respuestas[0]['idtipo']=="2")
	{
		if(($array_valores_respuestas[0]['texto']=="Otra (Especificar)") || ($array_valores_respuestas[0]['texto']=="Otra"))
		{
			$var = $vclassform->traerValor($id_pregunta, $dni);
			if(($var[0][0]!="Otra (Especificar)") && ($var[0][0]!="Otra")     )
			{	
				echo "<li>".utf8_decode($var[0]['valor'])."</li>";;
				echo "<br>";
			}
		}
		else
		{
			echo "<li>".utf8_decode($array_valores_respuestas[0]['texto'])."</li>";;
			echo "<br>";
		}
	}elseif(trim($tipo)=="4"){
	
		echo "<li>".utf8_decode($array_valores_respuestas[0]['texto'])."</li>";
		echo "<BR>";
	}elseif($array_valores_respuestas[0]['idtipo']=="6")
	{
		if($resp['valor']!="")
		{
			echo "<li>".utf8_decode($resp['valor'])."</li>";
		}
		echo "<br>";
	}elseif($array_valores_respuestas[0]['idtipo']=="8")
	{
		echo "asdasda";
	}
	


	

	
	

}
	echo "<font color='RED'>RESULTADO: ".$valor_regular."</font>";


?>
