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
	
		
		var colors = ['#FF3300', '#FF00FF','#F8F933','#22FF00'];
		var myChart = new JSChart(div_id, 'pie');
		myChart.setDataArray(myData);
		myChart.colorizePie(colors);
		myChart.setTitle('Riesgo');
		myChart.setTitleColor('#857D7D');
		myChart.setPieUnitsColor('#9B9B9B');
		myChart.setPieValuesColor('#6A0000');
		myChart.draw();
		
		
	}

</script>
<?
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



echo "<H1><i>TABLA: Tiempo 1 Riesgo en Condicionantes personales y contextuales</i></H1>";
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
				echo "<td bgcolor='#CCCCCD'>Riesgo</td>";
				echo "<td bgcolor='#CCCCCD'>Tipo de orientaci&oacute;n a la carrera</td>";			
				echo "<td bgcolor='#CCCCCD'>Posicionamiento personal</td>";			
				echo "<td bgcolor='#CCCCCD'>Org. Del tiempo</td>";			
				echo "<td bgcolor='#CCCCCD' width='20%'>Autovaloraci&oacute;n personal</td>";
				echo "<td bgcolor='#CCCCCD' width='20%'>Tutor</td>";
				echo "<td bgcolor='#CCCCCD' width='20%'>Discontinuidad</td>";
				echo "<td bgcolor='#CCCCCD' width='20%'>Causa</td>";
			echo "</tr>";

			$conexion = new Coneccion();
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
							if($mutar['ingreso']==1) echo "<img src='images/dentro.png' id='img_1_".trim($mutar['dni'])."'/>";
							else echo "<img src='images/fuera.png' id='img_1_".trim($mutar['dni'])."'/>";
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



					$mutar['dni'] = trim($mutar['dni']);
				

					
//riesgo					
					echo "<td align='center' bgcolor='".$color_fondo."' >";
						$riesgo = $conexion->query("select riesgo from alumnos where trim(dni) like trim('".$mutar['dni']."')");
						//colores ['#FF3300', '#FF00FF','#F8F933','#22FF00'];
						switch($riesgo[0][0]){
							case "ALTO":
								$color= "#FF3300";
								break;
							case "MEDIO":
								$color= "#FF00FF";
								break;
							case "BAJO":
								$color= "#F8F933";
								break;
							case "NULO":
								$color= "#22FF00";
								break;				
						}
						
						echo '<font style="background-color: '.$color.';">'.$riesgo[0][0].'</font>';	
						$array_riesgo[$mutar['idcarrera']][$riesgo[0][0]]++;
					echo "</td>";
					
					
//	Tipo de orientaci&oacute;n a la carrera	
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
						}

						
						echo '<font style="background-color: '.$color.';">'.$orientacion1.'</font>';	
						$array_orientacion[$mutar['idcarrera']][$orientacion1]+=1;
						
						
					echo "</td>";
					


/*
				echo "<td bgcolor='#CCCCCD'>Posicionamiento personal</td>";			
				echo "<td bgcolor='#CCCCCD'>Org. Del tiempo</td>";			
				echo "<td bgcolor='#CCCCCD' width='20%'>Autovaloraci&oacute;n personal</td>";

*/
							
				echo "<td align='center' bgcolor='".$color_fondo."'>";
						$posicionamiento_personal= $conexion->query("select campo_magico from alumnoform where idform=18 and trim(idalumno) like trim('".$mutar['dni']."')");
					switch(trim($posicionamiento_personal[0][0])){
						case "-":
							$color= "RED";
							$posicionamiento_personal[0][0] = "NEGATIVO";
							break;
						case "NEUTRO":
							$color= "YELLOW";
							break;
						case "+":
							$color= "GREEN";
							$posicionamiento_personal[0][0] = "POSITIVO";
							break;		
					}
				echo '<font style="background-color: '.$color.';">'.$posicionamiento_personal[0][0].'</font>';	
				echo "</td>";
				
				echo "<td align='center' bgcolor='".$color_fondo."'>";
					$tiempo_agenda1 = $conexion->query("select campo_magico from alumnoform where idform=22 and trim(idalumno) like trim('".$mutar['dni']."')");

					switch($tiempo_agenda1[0][0]){
						case "-":
							$color= "RED";
							$tiempo_agenda1[0][0] = "NEGATIVO";
							break;
						case "NEUTRO":
							$color= "YELLOW";
							break;
						case "+":
							$color= "GREEN";
							$tiempo_agenda1[0][0] = "POSITIVO";
							break;		
					}
						
					echo '<font style="background-color: '.$color.';">'.$tiempo_agenda1[0][0].'</font>';	

				echo "</td>";
//autovaloracion				
				$color="";
				echo "<td align='center' bgcolor='".$color_fondo."'>";
					$autovaloracion = $conexion->query("select campo_magico from alumnoform where idform=21 and trim(idalumno) like trim('".$mutar['dni']."')");
					switch($autovaloracion[0][0]){
						case "-":
							$color= "RED";
							$autovaloracion[0][0] = "NEGATIVO";
							break;
						case "NEUTRO":
							$color= "YELLOW";
							break;
						case "+":
							$color= "GREEN";
							$autovaloracion[0][0] = "POSITIVO";
							break;		
					}
						
					echo '<font style="background-color: '.$color.';">'.$autovaloracion[0][0].'</font>';	

				echo "</td>";
				
				
//tutor
					echo "<td bgcolor='".$color_fondo."'>";
						$orientacion = $conexion->query("select nombre||', '||apellido as tutor from alumnos where id = (select id_tutor from alumnos  where trim(dni) like trim('".$mutar['dni']."') and id_tutor is not null limit 1)");
						echo $orientacion[0][0];
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
	/*
	Alto
	Medio 
	Bajo
	Nulo
	*/
	foreach($array_riesgo as $carrera=>$riesgo)
	{
		$valor1 ="";
		if($riesgo['ALTO']==""){$riesgo['ALTO']=0;}
		if($riesgo['MEDIO']==""){$riesgo['MEDIO']=0;}
		if($riesgo['BAJO']==""){$riesgo['BAJO']=0;}
		if($riesgo['NULO']==""){$riesgo['NULO']=0;}
		$valor1="['ALTO', ".$riesgo['ALTO']."], ['MEDIO', ".$riesgo['MEDIO']."], ['BAJO', ".$riesgo['BAJO']."], ['NULO', ".$riesgo['NULO']."]";
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
	<td bgcolor='CCCCCE'>Riesgo
	</td>
	<td bgcolor='CCCCCE'>Cantidad
	</td>
	<td bgcolor='CCCCCE'>Porcentaje
	</td>
	</tr>
	<tr>
		<td bgcolor='#FF3300'>ALTO
		</td>
		<td>
		<?echo $riesgo['ALTO'];?>
		</td>
		<td>
		<?
// ['#FF3300', '#FF00FF','#F8F933','#22FF00'];
			$total = $riesgo['ALTO'] + $riesgo['MEDIO'] + $riesgo['BAJO']  + $riesgo['NULO'];
			$calculo = ($riesgo['ALTO'] * 100) / $total;
			echo $calculo."%";
		?>
		</td>
	</tr>
	<tr>
		<td bgcolor='#FF00FF'>MEDIO
		</td>
		<td>
		<?
		echo $riesgo['MEDIO'];
		?>
		</td>
		<td>
		<?
			$calculo = ($riesgo['MEDIO'] * 100) / $total;
			echo $calculo."%";

		?>
		</td>
	</tr>
	<tr>
		<td bgcolor='#F8F933'>BAJO
		</td>
		<td>
		<? echo $riesgo['BAJO'];?>
		</td>
		<td>
		<?
			$calculo = ($riesgo['BAJO'] * 100) / $total;
			echo $calculo."%";
		?>
		</td>
	</tr>
	<tr>
		<td bgcolor='#22FF000'>NULO
		</td>
		<td>
		<? echo $riesgo['NULO'];?>
		</td>
		<td>
		<?
			$calculo = ($riesgo['NULO'] * 100) / $total;
			echo $calculo."%";
		?>
		</td>
	</tr>
	<tr>
		<td bgcolor='CCCCCE'>
		</td>
		<td bgcolor='CCCCCE'>
		<? echo $total;?>
		</td>
		<td bgcolor='CCCCCE'>
				<?
			//$total = $orientacion['PARCIAL'] + $orientacion['DESORIENTADO'] + $orientacion['TOTAL'];
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
	</script>
	<?
	
	}
