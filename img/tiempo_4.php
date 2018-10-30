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
	
		
		//var colors = ['#22FF00', '#F8F933','#FFA500','#FF3300'];
		var colors = ['#FF3300', '#FFA500','#F8F933','#22FF00'];
		var myChart = new JSChart(div_id, 'pie');
		myChart.setDataArray(myData);
		myChart.colorizePie(colors);
		myChart.setTitle('Percepción');
		myChart.setTitleColor('#857D7D');
		myChart.setPieUnitsColor('#9B9B9B');
		myChart.setPieValuesColor('#6A0000');
		myChart.draw();
		
		
	}

</script>
<?
$AMARILLO = "#F8F933";
$ROJO = "#FF3300";
$PURPURA = "#FFA500";//purpura FF00FF
$VERDE = "#22FF00";


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



echo "<H1><i>Tabla: TIEMPO 4 Autoevaluación y ajustes de planes personales de carrera</i></H1>";
echo "<hr align='left' width='80%'>";

echo "<table id='tabla_reporte' align='center' width='80%'>";//width='100%' 
		echo "<tr>";
		echo "<td >";//width='50%'

			echo "<table cellspacing='2' cellpadding='2'>";//width='100%' 
			echo "<tr>";		
				echo "<td bgcolor='#CCCCCD'>Estado</td>";
				echo "<td bgcolor='#CCCCCD'>Nombre</td>";
				echo "<td bgcolor='#CCCCCD'>Apellido</td>";
				echo "<td bgcolor='#CCCCCD'>Documento</td>";
				echo "<td bgcolor='#CCCCCD'>Riesgo</td>";
				echo "<td bgcolor='#CCCCCD'>1º Percepción</td>";
				echo "<td bgcolor='#CCCCCD'>2º Percepción</td>";						
				echo "<td bgcolor='#CCCCCD'>PPC cumplido</td>";					
				echo "<td bgcolor='#CCCCCD' width='20%'>Autoevaluación del estudiante acerca del Rend. Academ.</td>";
				echo "<td bgcolor='#CCCCCD' width='20%'>Tutor</td>";				
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
							if($mutar['ingreso']==1) echo "<img src='img/dentro.png' id='img_1_".trim($mutar['dni'])."'/>";
							else echo "<img src='img/fuera.png' id='img_1_".trim($mutar['dni'])."'/>";
						}elseif($_REQUEST['salida']=="Excel"){
							if($mutar['ingreso']=="1") echo "INGRESO";
							else echo "NO INGRESO";
						}
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


							
				$percepcion = $conexion->query("select (select percepcion from percepcion where numero_percepcion=1 and id_alumno=".$mutar['dni']." limit 1) as percepcion1,
				(select percepcion from percepcion where numero_percepcion=2 and id_alumno=".$mutar['dni']." limit 1)  as percepcion2");
				
				
				$percepcion1 = $percepcion[0]['percepcion1'] ;//$conexion->query("select percepcion from percepcion where numero_percepcion=1 and id_alumno=".$mutar['dni']);
				
				$percepcion2 = $percepcion[0]['percepcion2'] ;//$conexion->query("select percepcion from percepcion where numero_percepcion=2 and id_alumno=".$mutar['dni']);
/*
echo "<option value='1'>Alta</option>";
echo "<option value='2'>Media</option>";
echo "<option value='3'>Baja</option>";
echo "<option value='4'>Nula</option>";
*/				
//percepcion1
				echo "<td align='center' bgcolor='".$color_fondo."' >";
					$color="";
					$texto="";
					switch($percepcion1){
						case "1":
							$color= $VERDE;
							$texto="ALTA";
							break;
						case "2":
							$color= $AMARILLO;
							$texto="MEDIA";	
							break;
						case "3":
							$color= $PURPURA;
							$texto="BAJA";
							break;
						case "4":
							$color= $ROJO;
							$texto="NULA";
							break;				
					}
					echo '<font style="background-color: '.$color.';">'.$texto.'</font>';
				echo "</td>";		

//percepcion 2
				echo "<td align='center' bgcolor='".$color_fondo."' >";
					$color="";
					$texto="";
					switch($percepcion2){
						case "1":
							$color= $VERDE;
							$texto="ALTA";
							break;
						case "2":
							$color= $AMARILLO;
							$texto="MEDIA";	
							break;
						case "3":
							$color= $PURPURA;
							$texto="BAJA";
							break;
						case "4":
							$color= $ROJO;
							$texto="NULA";
							break;				
					}
					echo '<font style="background-color: '.$color.';">'.$texto.'</font>';
				echo "</td>";	
		
				
	






	
///fecha 2da entrevista
		echo "<td align='center' bgcolor='".$color_fondo."' >";
				
		$id_alumno = trim($mutar['dni']);
		$alumno = new Alumno($id_alumno);
		$plan_carrera = $alumno->traer_plan_carrera();
		

		$array_materias_cursar=0;
		
		$array_materias_cursar = $plan_carrera[0]['mat_cursar'];
		
		$array_materias_cursar_deserializado = unserialize($array_materias_cursar);
                
                  $materias_cursar_filtro="";
                foreach($array_materias_cursar_deserializado as $mat){
                    $materias_cursar_filtro[$mat['materias']] = $mat;
                }
                
                
		$cantidad= 0;
                   
                echo "<pre>";
                print_r($materias_cursar_filtro);
                echo "</pre>";
      
                
		foreach($materias_cursar_filtro as $clave=>$mate)
		{
                    
			if($mate['tipo_cursada']=="1"){
			$materia = explode('-',$mate['materias']);
			$query="select * from materias_carrera where materia=".$materia[0]." and plan=".$materia[2]." and carrera=".$materia[1]."";
			$resultado = $conexion->query($query);

                            if($resultado[0]['nombre'] != "") $cantidad++; 
			}
		}
		
		$resultado = "";
		$query_select="select * from tutorias_materias_aprobadas where legajo=".$id_alumno."";

//		echo $query_select;

		$resultado = $conexion->query($query_select);
				
		$cantidad2 = 0;
		foreach($resultado as $mate)
		{
			$cantidad2 = $cantidad2 + 1;

		}

		//$cantidad2 = count($resultado);

		echo $cantidad2." de ".$cantidad;

		
			
		echo "</td>";
								
				
				
				
//autoevaluacion 			
				echo "<td align='center' bgcolor='".$color_fondo."'>";
					
					$autoevaluacion = $conexion->query("select texto from respuestaspreg where id = cast((select valor from respuestaalumno where codform = '29' and idrespuesta=157  and trim(idalumno) = trim('".$mutar['dni']."')) as integer)");
					echo $autoevaluacion[0][0];
					$array_autoevaluacion[$mutar['idcarrera']][strtoupper($autoevaluacion[0][0])]++;
				echo "</td>";	
	
//tutor
					echo "<td bgcolor='".$color_fondo."'>";
						$tutor = $conexion->query("select nombre||', '||apellido as tutor from alumnos where id = (select id_tutor from alumnos  where trim(dni) like trim('".$mutar['dni']."') and id_tutor is not null limit 1)");
						echo utf8_decode($tutor[0][0]);
					echo "</td>";
					
					
					
					
					



				echo "</tr>";
			}
		
	echo "</table>";
	echo "</td></tr></table>";

/*
echo "<option value='1'>Nulo</option>";
echo "<option value='2'>Regular</option>";
echo "<option value='3'>Bueno;
echo "<option value='4'>Muy bueno;
*/

//['#FF3300', '#FFA500','#F8F933','#22FF00];

	foreach($array_autoevaluacion as $carrera=>$autoevaluacion)
	{

		$valor1 ="";
		if($autoevaluacion['NULO']==""){$autoevaluacion['NULO']=0;}
		if($autoevaluacion['REGULAR']==""){$autoevaluacion['REGULAR']=0;}
		if($autoevaluacion['BUENO']==""){$autoevaluacion['BUENO']=0;}
		if($autoevaluacion['MUY BUENO']==""){$autoevaluacion['MUY BUENO']=0;}
		$valor1="['NULO', ".$autoevaluacion['NULO']."], ['REGULAR', ".$autoevaluacion['REGULAR']."], ['BUENO', ".$autoevaluacion['BUENO']."], ['MUY BUENO', ".$autoevaluacion['MUY BUENO']."]";

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
	<td bgcolor='CCCCCE'>Percepción
	</td>
	<td bgcolor='CCCCCE'>Cantidad
	</td>
	<td bgcolor='CCCCCE'>Porcentaje
	</td>
	</tr>
	<tr>
		<td bgcolor='#FF3300'>NULO
		</td>
		<td>
		<?echo $autoevaluacion['NULO'];?>
		</td>
		<td>
		<?
// ['#FF3300', '#FF00FF','#F8F933','#22FF00'];
			$total = $autoevaluacion['NULO'] + $autoevaluacion['REGULAR'] + $autoevaluacion['BUENO']  + $autoevaluacion['MUY BUENO'];
			$calculo = ($autoevaluacion['NULO'] * 100) / $total;
			echo $calculo."%";
		?>
		</td>
	</tr>
	<tr>
		<td bgcolor='#FF00FF'>REGULAR
		</td>
		<td>
		<?
		echo $autoevaluacion['REGULAR'];
		?>
		</td>
		<td>
		<?
			$calculo = ($autoevaluacion['REGULAR'] * 100) / $total;
			echo $calculo."%";

		?>
		</td>
	</tr>
	<tr>
		<td bgcolor='#F8F933'>BUENO
		</td>
		<td>
		<? echo $autoevaluacion['BUENO'];?>
		</td>
		<td>
		<?
			$calculo = ($autoevaluacion['BUENO'] * 100) / $total;
			echo $calculo."%";
		?>
		</td>
	</tr>
	<tr>
		<td bgcolor='#22FF00'>MUY BUENO
		</td>
		<td>
		<? echo $autoevaluacion['MUY BUENO'];?>
		</td>
		<td>
		<?
			$calculo = ($autoevaluacion['MUY BUENO'] * 100) / $total;
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
