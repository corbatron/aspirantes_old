<link href='http://fonts.googleapis.com/css?family=Rosarivo:400italic' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="js/jscharts.js"></script>
<STYLE TYPE="text/css">

TD{font-family: Arial; font-size: 9pt;}
</STYLE>
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
<script>
	function crear_grafico(MyData,div_id,carrera)
	{
	
		
		var colors = ['#009933', '#F8F933','#FF3300'];
		var myChart = new JSChart(div_id, 'pie');
		myChart.setDataArray(myData);
		myChart.colorizePie(colors);
		myChart.setTitle('Orientaci&oacute;n');
		myChart.setTitleColor('#857D7D');
		myChart.setPieUnitsColor('#9B9B9B');
		myChart.setPieValuesColor('#6A0000');
		myChart.draw();
		
		
	}

</script>
<?php
$alumno = new Alumno(0);

$carreras = new Carreras();
$array_carreras_listado = $carreras->traer_carreras();

$arra_carreras = "";
foreach($array_carreras_listado as $array_carrera)
{		
	$arra_carreras[$array_carrera['carr_id']]=utf8_decode($array_carrera['carr_descripcion']);
}


echo "<div id='div_impresion'>";
$alumnos_mutantes = $alumno->traer_alumnos(0,$_REQUEST['carrera_seleccionada'],0,$ingreso,$_REQUEST["fecha_desde"],$_REQUEST["fecha_hasta"]);



echo "<H1><i>TABLA: Tiempo 0 Orientaci&oacute;n a la carrera</i></H1>";
echo "<hr align='left' width='80%'>";

echo "<table id='tabla_reporte' align='center' width='80%'>";//width='100%' 
		echo "<tr>";
		echo "<td >";//width='50%'

			echo "<table cellspacing='2' cellpadding='2'>";//width='100%' 
			echo "<tr>";		
				echo "<td bgcolor='#CCCCCD'>Estado</td>";
				echo "<td bgcolor='#CCCCCD'>Cuatrimestre</td>";
				echo "<td bgcolor='#CCCCCD'>Nombre</td>";
				echo "<td bgcolor='#CCCCCD'>Apellido</td>";
				echo "<td bgcolor='#CCCCCD'>Documento</td>";
				//echo "<td bgcolor='#CCCCCD'>E-mail</td>";
				//echo "<td bgcolor='#CCCCCD'>Telefono</td>";			
				$cant_forms=0;
				foreach($array_formularios as $form_valor){
					// 1   2   25   28 - para 2013
					if($form_valor['id']==1 or $form_valor['id']==2 or $form_valor['id']==25 or $form_valor['id']==28){
						echo "<td bgcolor='#CCCCCD' width=>".$form_valor['descripcion']."</td>";
						$cant_forms++;
						$array_idforms[$form_valor['id']]=$form_valor['lugar_reporte'];
					}
				}
				$conexion = new Coneccion();
				echo "<td bgcolor='#CCCCCD' >Tipo de orientaci&oacute;n</td>";
				
				echo "<td bgcolor='#CCCCCD' width='20%' >V&iacute;a en que se inform&oacute;</td>";
				echo "<td bgcolor='#CCCCCD' width='20%'>Motivo de elecci&oacute;n de la carrera</td>";
				echo "<td bgcolor='#CCCCCD' width='20%'>Motivo de elecci&oacute;n FRGP</td>";
				echo "<td bgcolor='#CCCCCD' width='20%'>Sabe que carrera va a estudiar</td>";
				echo "<td bgcolor='#CCCCCD' width='20%'>Descontinuidad</td>";
				echo "<td bgcolor='#CCCCCD' width='20%'>Causas</td>";
			echo "</tr>";

			$color_fondo = "#CCCCEE";
			foreach($alumnos_mutantes as $mutar)
			{
				
				$aluform = new alumnosFormularios($mutar['dni']);
				if($color_fondo == "#CCCCEE") $color_fondo = "#FFFFFF";
				else $color_fondo = "#CCCCEE";
			
				$esta_todo_bien="0";
				$array_formularios = $aluform->traerIdForms();



				foreach($_REQUEST['valor_instrumento'] as $valor_int)
				{	
					$res_1 = null;
					$res_1 = $aluform->compararID($valor_int);
					if($res_1[0]['verifica']!="1")
					{
						continue 2;
					}
				}

				$cantidad_riesgo = 0;
				echo "<tr>";
					echo "<td bgcolor='".$color_fondo."'>";
					if($_REQUEST['salida']!="Excel")
						{
							if($mutar['ingreso']==1) echo "<img src='img/dentro.png' id='img_1_".trim($mutar['dni'])."'/>";
							else echo "<img src='img/fuera.png' id='img_1_".trim($mutar['dni'])."'/>";
						}elseif($_REQUEST['salida']=="Excel"){
							if($mutar['ingreso']=="1") echo "INGRESO";
							else echo "NO INGRESO";
						}
					echo "</td>";
					echo "<td bgcolor='".$color_fondo."'>";
						echo utf8_decode($mutar['cuatrimestre']);
					echo "</td>";

					echo "<td bgcolor='".$color_fondo."'>";
						echo utf8_decode($mutar['nombre']);
					echo "</td>";
					echo "<td bgcolor='".$color_fondo."'>";
						echo utf8_decode($mutar['apellido']);
					echo "</td>";
					echo "<td bgcolor='".$color_fondo."'>";
						echo $mutar['dni'];
					echo "</td>";
					//echo "<td bgcolor='".$color_fondo."'>";
					//	echo "<a target='_blank' href='mailto:".$mutar['mail']."&subject=Tutorias'>".$mutar['mail']."</a>";
					//echo "</td>";
					//echo "<td bgcolor='".$color_fondo."'>";
						//echo $mutar['tel_linea'];
					//echo "</td>";
					
					$mutar['dni'] = trim($mutar['dni']);
					$cant_forms_alumno=$cant_forms;

					foreach($array_idforms as $form_valor=>$sx){
						echo "<td bgcolor='".$color_fondo."'>";
							$vNota 	= $aluform->wasDone($mutar['dni'],$form_valor);
							$vFechaReali= $vNota[0][2];
							$vExiste 	= $vNota[0][1];
							$vNota		= $vNota[0][0];
							if($vNota=="D" or $vNota=="-")
							{
								$cantidad_riesgo = $cantidad_riesgo + 1;
							}
							if($vNota != "" and $vExiste == 1 and $vFechaReali != ""){
								echo "<a target='_blank' href='reporteform.php?id_alumno=".$mutar['dni']."&id_formulario=".$form_valor."&formulario=".$sx."'>VERIFIQUE[".$vNota."]</a>";
							}
							elseif($vExiste == 1 and $vNota == "" and $vFechaReali != ""){
								$url = "reporteform.php?id_alumno=".$mutar['dni']."&id_formulario=".$form_valor."&formulario=".$sx."";
								echo "<script>window.open('".$url."','popup".$mutar['dni']."','width=300,height=400')</script>";
								echo "<a target='_blank' href='reporteform.php?id_alumno=".$mutar['dni']."&id_formulario=".$form_valor."&formulario=".$sx."'>CALCULAR</a>";
							}
							elseif($vExiste == 1 and $vFechaReali == ""){
								echo "ASIGNADO";
								if($sx!="plan_personal_carrera")
								{
									$cantidad_riesgo = -1;
								}
							}
							else{
								echo "N/A";
							}
						echo "</td>";
					}
					echo "<td align='center' bgcolor='".$color_fondo."' >";
						$orientacion = $conexion->query("select campo_magico from alumnoform where idform in (select id from formularios where lugar_reporte = 'encuesta') and trim(idalumno) like trim('".$mutar['dni']."')");
						
						$orientacion1="N/A";
						$color="WHITE";
						
						if($orientacion[0][0]=="T"){
						$orientacion1 = "TOTAL";
						$color="GREEN";
						}
						elseif($orientacion[0][0]=="OP"){
						$orientacion1 = "PARCIAL";
						$color="YELLOW";
						}elseif($orientacion[0][0]=="D"){
						$orientacion1 = "DESORIENTADO";
						$color="RED";
						}elseif($orientacion[0][0]=="PASE"){
						$orientacion1 = "PASE";
						$color="WHITE";
						}

						
						echo '<font style="background-color: '.$color.';">'.$orientacion1.'</font>';	
						$array_orientacion[$mutar['idcarrera']][$orientacion1]+=1;
						
						
					echo "</td>";
					echo "<td bgcolor='".$color_fondo."' >";
					//MCO modificado
						if($_REQUEST['salida']=='Excel')
						{$vineta = "* ";$vineta2="<br>";}else{$vineta="<li type='circle'>";$vineta2="</li>";}
					
						$respuestas = $conexion->query("select id, trim(upper(texto)) as texto from respuestaspreg where idpregunta in  
						(5, 67 , 137, 144) and id in (select idrespuesta from respuestaalumno where  trim(idalumno) like trim('".$mutar['dni']."'))");
						echo "<ol>";
						foreach($respuestas as $singleresponse)
							if($singleresponse['texto']!="OTRA (ESPECIFICAR)") echo $vineta.utf8_decode($singleresponse['texto']).$vineta2;
						echo "</ol>";
					echo "</td>";	

					echo "<td bgcolor='".$color_fondo."'>";
                                        //MCO agregar IF 27/05/2014
                                        if($orientacion1!="N/A"){
						$motivo_carrera = $conexion->query("select idrespuesta, trim(upper(valor)) as valor from respuestaalumno  where idrespuesta in (
								select id from respuestaspreg where idpregunta in (2,64,142,135)) and trim(idalumno) like trim('".$mutar['dni']."')");


						echo "<ol>";
						foreach($motivo_carrera as $singleresponse)
							if(is_numeric(trim($singleresponse['valor']))){ 
								$motivo = $conexion->query("select texto from respuestaspreg where id=".$singleresponse['idrespuesta']);
								if(strtoupper($motivo[0][0]) != "OTRA (ESPECIFICAR)" ) echo $vineta.utf8_decode($motivo[0][0]).$vineta2;
							} 
							else
								if($singleresponse['valor'] != "OTRA (ESPECIFICAR)") echo $vineta.utf8_decode($singleresponse['valor']).$vineta2;
					//2  64   142   135
						echo "</ol>";
                                        }//fin MCO
					echo "</td>";
					echo "<td bgcolor='".$color_fondo."'>";
						$motivo_carrera = $conexion->query("select idrespuesta, trim(upper(valor)) as valor from respuestaalumno  where idrespuesta in (
								select id from respuestaspreg where idpregunta in (3,65,143,136)) and trim(idalumno) like trim('".$mutar['dni']."')");
						echo "<ol>";
						foreach($motivo_carrera as $singleresponse)
							if(is_numeric(trim($singleresponse['valor']))){ 
								$motivo = $conexion->query("select texto from respuestaspreg where id=".$singleresponse['idrespuesta']);
								if(strtoupper($motivo[0][0]) != "OTRA (ESPECIFICAR)" ) echo $vineta.utf8_decode($motivo[0][0]).$vineta2;
							} 
							else
								if($singleresponse['valor'] != "OTRA (ESPECIFICAR)") echo $vineta.utf8_decode($singleresponse['valor']).$vineta2;

						echo "</ol>";
					
					echo "</td>";	
                                        
                                        
                                        
                                        
					echo "<td bgcolor='".$color_fondo."'>";
						$motivo_curso = $conexion->query("select trim(upper(valor)) as valor from respuestaalumno  where valor in (
						select cast(id as char(10)) from respuestaspreg where idpregunta in (select idpregunta from preguntas  where texto ilike '%UTN FRGP%')) and trim(idalumno) like trim('".$mutar['dni']."')");

						$motivo = $conexion->query("select texto from respuestaspreg where id=".$motivo_curso[0]['valor']);

						echo utf8_decode($motivo[0][0]);
					echo "</td>";
					
					echo "<td bgcolor='".$color_fondo."'>";
						$causa_abandono = $conexion->query("select descripcion from problematicas_alumno, problematicas where problematica = problematicas.id and orden=0 and  dni=".$mutar['dni']);	
						echo $causa_abandono[0][0];
					echo "</td>";								

				
					//observaciones
					echo "<td bgcolor='".$color_fondo."'>";
						$observaciones = $conexion->query("select descripcion from problematicas_alumno, problematicas where problematica = problematicas.id and orden!=0 and  dni=".$mutar['dni']);
						echo "<ol>";
							foreach($observaciones  as $causa_simple){
								echo "<li type='circle'>".utf8_decode($causa_simple[0])."</li>";
							}	
						echo "</ol>";
					echo "</td>";					
										
										
            
			echo "</tr>";	
			}
			
			echo "</table>";
		echo "</td></tr></table>";
		
	
	foreach($array_orientacion as $carrera=>$orientacion)
	{
		$valor1 ="";
		if($orientacion['TOTAL']==""){$orientacion['TOTAL']=0;}
		if($orientacion['PARCIAL']==""){$orientacion['PARCIAL']=0;}
		if($orientacion['DESORIENTADO']==""){$orientacion['DESORIENTADO']=0;}
		
		$valor1="['TOTAL', ".$orientacion['TOTAL']."], ['PARCIAL', ".$orientacion['PARCIAL']."], ['DESORIENTADO', ".$orientacion['DESORIENTADO']."]";
	?>
	<table width='50%' align='center' valign='top'>
	<tr>
	<td width='50%' align='center'>
	<?
	echo "<b>".$arra_carreras[$carrera]."</b>";
	?>
	<div id="graph_<? echo $carrera; ?>" style="border-radius: 15px;background: -moz-linear-gradient(top, #CCFFFF, #FFFFFF);">Generando grafico</div>
	</div>
	</td>
	<td align='center'>
	<table width='80%' cellpadding='2' cellspacing='2'>
	<tr>
	<td bgcolor='CCCCCE'>Orientaci&oacute;n
	</td>
	<td bgcolor='CCCCCE'>Cantidad
	</td>
	<td bgcolor='CCCCCE'>Porcentaje
	</td>
	</tr>
	<tr>
		<td bgcolor='#009933'>TOTAL
		</td>
		<td>
		<?echo $orientacion['TOTAL'];?>
		</td>
		<td>
		<?
			$total = $orientacion['PARCIAL'] + $orientacion['DESORIENTADO'] + $orientacion['TOTAL'];
			$calculo = ($orientacion['TOTAL'] * 100) / $total;
			echo $calculo."%";
		?>
		</td>
	</tr>
	<tr>
		<td bgcolor='#F8F933'>PARCIAL
		</td>
		<td>
		<?
		echo $orientacion['PARCIAL'];
		?>
		</td>
		<td>
		<?
			$total = $orientacion['PARCIAL'] + $orientacion['DESORIENTADO'] + $orientacion['TOTAL'];
			$calculo = ($orientacion['PARCIAL'] * 100) / $total;
			echo $calculo."%";
		?>
		</td>
	</tr>
	<tr>
		<td bgcolor='#FF3300'>DESORIENTADO
		</td>
		<td>
		<? echo $orientacion['DESORIENTADO'];?>
		</td>
		<td>
		<?
			$total = $orientacion['PARCIAL'] + $orientacion['DESORIENTADO'] + $orientacion['TOTAL'];
			$calculo = ($orientacion['DESORIENTADO'] * 100 ) / $total;
			echo $calculo."%";
		?>
		</td>
	</tr>
	<tr>
		<td bgcolor='CCCCCE'>
		</td>
		<td bgcolor='CCCCCE'>
		<? echo $orientacion['PARCIAL'] + $orientacion['DESORIENTADO'] + $orientacion['TOTAL'];?>
		</td>
		<td bgcolor='CCCCCE'>
				<?
			$total = $orientacion['PARCIAL'] + $orientacion['DESORIENTADO'] + $orientacion['TOTAL'];
			$calculo = ($total * 100 ) / $total;
			echo $calculo."%";
		?>
		</td>
	</tr>
	</table>
	</td>
	</tr>
	</table>
	&nbsp;
	<script>
	var myData = new Array(<?echo $valor1;?>);
	crear_grafico(myData,"graph_<?echo $carrera;?>","<? echo $arra_carreras[$carrera];?>");
	</script>;
	<?
	
	}
