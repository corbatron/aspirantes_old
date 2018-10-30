<script type="text/javascript" src="js/jscharts.js"></script>
<STYLE TYPE="text/css">

TD{font-family: Arial; font-size: 9pt;}

br {mso-data-placement:same-cell;}</STYLE>
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


echo "<div id='div_impresion' align='center'>";
$alumnos_mutantes = $alumno->traer_alumnos(0,$_REQUEST['carrera_seleccionada'],0,$ingreso,$_REQUEST["fecha_desde"],$_REQUEST["fecha_hasta"]);



echo "<H1><i>Reporte: Tiempo 1 - Riesgo en Condicionantes personales y contextuales</i></H1>";

echo "<table id='tabla_reporte' align='center' width='100%'>";//width='100%' 
		echo "<tr>";
		echo "<td >";//width='50%'

			echo "<table class='table table-bordered table-striped'  cellspacing='2' cellpadding='2'>";//width='100%' 
			
			echo "<thead><tr>";		
				echo "<th>Estado</th>";
				echo "<th>Cuatrimestre</th>";
				echo "<th>Nombre</th>";
				echo "<th>Apellido</th>";
				echo "<th>Documento</th>";
				echo "<th>Riesgo</th>";
				echo "<th>Tipo de orientaci&oacute;n a la carrera</th>";			
				echo "<th>Posicionamiento personal</th>";			
				echo "<th>Org. Del tiempo</th>";			
				echo "<th>Autovaloraci&oacute;n personal</th>";
				echo "<th>Tutor</th>";
				echo "<th>Discontinuidad</th>";
				echo "<th>Causa</th>";
			echo "</tr></thead><tbody>";


			$conexion = new Coneccion();
			$color_fondo = "#CCCCEE";
			foreach($alumnos_mutantes as $mutar)
			{
				
				$aluform = new alumnosFormularios($mutar['dni']);
				if($color_fondo == "#CCCCEE") $color_fondo = "#FFFFFF";
				else $color_fondo = "#CCCCEE";
			$color_fondo = "";
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
						echo $mutar['cuatrimestre'];
					echo "</td>";
					echo "<td bgcolor='".$color_fondo."'>";
						echo $mutar['nombre'];
					echo "</td>";
					echo "<td bgcolor='".$color_fondo."'>";
						echo $mutar['apellido'];
					echo "</td>";
					echo "<td bgcolor='".$color_fondo."'>";
						echo $mutar['dni'];
					echo "</td>";



					$mutar['dni'] = trim($mutar['dni']);
				

					
//riesgo					
					
						$riesgo = $conexion->query("select riesgo from alumnos where trim(dni) like trim('".$mutar['dni']."')");
						//colores ['#FF3300', '#FF00FF','#F8F933','#22FF00'];
						$color="";
						switch($riesgo[0][0]){
							case "ALTO":
								$color= "danger";
								break;
							case "MEDIO":
								$color= "warning";
								break;
							case "BAJO":
								$color= "info";
								break;
							case "NULO":
								$color= "success";
								break;				
						}
					echo "<td align='center' class='".$color."' >";	
						echo $riesgo[0][0];	
						$array_riesgo[$mutar['idcarrera']][$riesgo[0][0]]++;
					echo "</td>";
					
					
//	Tipo de orientaci&oacute;n a la carrera	
						$orientacion = $conexion->query("select campo_magico from alumnoform where idform in (select id from formularios where lugar_reporte = 'encuesta') and trim(idalumno) like trim('".$mutar['dni']."')");
						
						$orientacion1="N/A";
						$color="";
						
						if($orientacion[0][0]=="T"){
						$orientacion1 = "TOTAL";
						$color="success";
						}
						elseif($orientacion[0][0]=="OP"){
						$orientacion1 = "PARCIAL";
						$color="warning";
						}elseif($orientacion[0][0]=="D"){
						$orientacion1 = "DESORIENTADO";
						$color="danger";
						}

				echo "<td align='center'  class='".$color."' >";
	
						echo $orientacion1;	
						$array_orientacion[$mutar['idcarrera']][$orientacion1]+=1;
						
						
					echo "</td>";
					


/*
				echo "<td bgcolor='#CCCCCD'>Posicionamiento personal</td>";			
				echo "<td bgcolor='#CCCCCD'>Org. Del tiempo</td>";			
				echo "<td bgcolor='#CCCCCD' width='20%'>Autovaloraci&oacute;n personal</td>";

*/
				$color="";
				$posicionamiento_personal= $conexion->query("select campo_magico from alumnoform where idform=18 and trim(idalumno) like trim('".$mutar['dni']."')");
					switch(trim($posicionamiento_personal[0][0])){
						case "-":
							$color= "danger";
							$posicionamiento_personal[0][0] = "NEGATIVO";
							break;
						case "NEUTRO":
							$color= "warning";
							break;
						case "+":
							$color= "success";
							$posicionamiento_personal[0][0] = "POSITIVO";
							break;		
					}
				echo "<td align='center' class='".$color."'>";
$color="";
				echo $posicionamiento_personal[0][0];	
				echo "</td>";
				
					$tiempo_agenda1 = $conexion->query("select campo_magico from alumnoform where idform=22 and trim(idalumno) like trim('".$mutar['dni']."')");

					switch($tiempo_agenda1[0][0]){
						case "-":
							$color= "danger";
							$tiempo_agenda1[0][0] = "NEGATIVO";
							break;
						case "NEUTRO":
							$color= "warning";
							break;
						case "+":
							$color= "success";
							$tiempo_agenda1[0][0] = "POSITIVO";
							break;		
					}
				echo "<td align='center' class='".$color."'>";
		
					echo $tiempo_agenda1[0][0];	

				echo "</td>";
//autovaloracion				
				$color="";
					$autovaloracion = $conexion->query("select campo_magico from alumnoform where idform=21 and trim(idalumno) like trim('".$mutar['dni']."')");
					switch($autovaloracion[0][0]){
						case "-":
							$color= "danger";
							$autovaloracion[0][0] = "NEGATIVO";
							break;
						case "NEUTRO":
							$color= "warning";
							break;
						case "+":
							$color= "success";
							$autovaloracion[0][0] = "POSITIVO";
							break;		
					}
				echo "<td align='center' class='".$color."'>";
					
					echo $autovaloracion[0][0];	

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
					if($_REQUEST['salida']=="Excel"){
						foreach($observaciones  as $causa_simple){
							echo "<br>".utf8_decode($causa_simple[0]);
						}	
					}else{
						echo "<ol>";
						foreach($observaciones  as $causa_simple){
							echo "<li type='circle'>".utf8_decode($causa_simple[0])."</li>";
						}	
						echo "</ol>";
					}
				echo "</td>";	
					
					
					
$color="";


				echo "</tr>";
			}
		
			echo "</tbody></table>";
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
	<table class="table" width='80%' cellpadding='2' cellspacing='2'>
	<tr>
	<td bgcolor='CCCCCE'>Riesgo
	</td>
	<td bgcolor='CCCCCE'>Cantidad
	</td>
	<td bgcolor='CCCCCE'>Porcentaje
	</td>
	</tr>
	<tr>
		<td class="danger">ALTO
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
		<td class="warning">MEDIO
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
		<td class="info">BAJO
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
		<td class="success">NULO
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