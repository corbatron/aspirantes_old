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
	
		
		var colors = ['#22FF00', '#F8F933','#FFA500','#FF3300'];
		var myChart = new JSChart(div_id, 'pie');
		myChart.setDataArray(myData);
		myChart.colorizePie(colors);
		myChart.setTitle('Percepci&oacute;n');
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



echo "<H1><i>Tabla: TIEMPO 3- 2º Percepci&oacute;n de autorregulaci&oacute;n (Supervisi&oacute;n de metas y rendimiento acad&eacute;mico)</i></H1>";
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
				echo "<td bgcolor='#CCCCCD'>2º Percepci&oacute;n</td>";
				echo "<td bgcolor='#CCCCCD'>1º Percepci&oacute;n</td>";		
				echo "<td bgcolor='#CCCCCD'>Fecha de 2º entrevista</td>";					
				echo "<td bgcolor='#CCCCCD' width='20%'>Acuerdos logrados (2º entrevista)</td>";
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
				



							

				
				$percepcion1 = $conexion->query("select percepcion from percepcion where numero_percepcion=1 and id_alumno=".$mutar['dni']);
				
				$percepcion2 = $conexion->query("select texto2,fecha, percepcion from percepcion where numero_percepcion=2 and id_alumno=".$mutar['dni']);
/*
echo "<option value='1'>Alta</option>";
echo "<option value='2'>Media</option>";
echo "<option value='3'>Baja</option>";
echo "<option value='4'>Nula</option>";
*/				
//percepcion 2
				echo "<td align='center' bgcolor='".$color_fondo."' >";
					$color="";
					$texto="";
					switch($percepcion2[0]['percepcion']){
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
						case "5":
							$color= "";
							$texto="SIN PERCEPCION";
							break;						
					}
					echo '<font style="background-color: '.$color.';">'.$texto.'</font>';
					$array_percepcion[$mutar['idcarrera']][$percepcion2[0]['percepcion']]++;
				echo "</td>";	
//percepcion1
				echo "<td align='center' bgcolor='".$color_fondo."' >";
					$color="";
					$texto="";
					switch($percepcion1[0]['percepcion']){
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
						case "5":
							$color= "";
							$texto="SIN PERCEPCION";
							break;				
					}
					echo '<font style="background-color: '.$color.';">'.$texto.'</font>';
				echo "</td>";				
				
				
///fecha 2da entrevista
				echo "<td align='center' bgcolor='".$color_fondo."' >";
					echo $percepcion2[0]['fecha'];
				echo "</td>";
								
				
				
				
//Acuerdos logrados				
				echo "<td align='center' bgcolor='".$color_fondo."'>";
					
					echo utf8_decode($percepcion2[0]['texto2']);
				echo "</td>";	
	
//tutor
					echo "<td bgcolor='".$color_fondo."'>";
						$tutor = $conexion->query("select nombre||', '||apellido as tutor from alumnos where id = (select id_tutor from alumnos  where trim(dni) like trim('".$mutar['dni']."') and id_tutor is not null limit 1)");
						echo utf8_decode($tutor[0][0]);
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
echo "<option value='1'>Alta</option>";
echo "<option value='2'>Media</option>";
echo "<option value='3'>Baja</option>";
echo "<option value='4'>Nula</option>";
*/

	foreach($array_percepcion as $carrera=>$percepcion)
	{
		$valor1 ="";
		if($percepcion['1']==""){$percepcion['1']=0;}
		if($percepcion['2']==""){$percepcion['2']=0;}
		if($percepcion['3']==""){$percepcion['3']=0;}
		if($percepcion['4']==""){$percepcion['4']=0;}
		$valor1="['ALTO', ".$percepcion['1']."], ['MEDIO', ".$percepcion['2']."], ['BAJO', ".$percepcion['3']."], ['NULO', ".$percepcion['4']."]";
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
	<td bgcolor='CCCCCE'>Percepci&oacute;n
	</td>
	<td bgcolor='CCCCCE'>Cantidad
	</td>
	<td bgcolor='CCCCCE'>Porcentaje
	</td>
	</tr>
	<tr>
		<td bgcolor='#22FF00'>ALTO
		</td>
		<td>
		<?echo $percepcion['1'];?>
		</td>
		<td>
		<?
// ['#FF3300', '#FF00FF','#F8F933','#22FF00'];
			$total = $percepcion['1'] + $percepcion['2'] + $percepcion['3']  + $percepcion['4'];
			$calculo = ($percepcion['1'] * 100) / $total;
			echo $calculo."%";
		?>
		</td>
	</tr>
	<tr>
		<td bgcolor='#F8F933'>MEDIO
		</td>
		<td>
		<?
		echo $percepcion['2'];
		?>
		</td>
		<td>
		<?
			$calculo = ($percepcion['2'] * 100) / $total;
			echo $calculo."%";

		?>
		</td>
	</tr>
	<tr>
		<td bgcolor='#FFA500'>BAJO
		</td>
		<td>
		<? echo $percepcion['3'];?>
		</td>
		<td>
		<?
			$calculo = ($percepcion['3'] * 100) / $total;
			echo $calculo."%";
		?>
		</td>
	</tr>
	<tr>
		<td bgcolor='#FF3300'>NULO
		</td>
		<td>
		<? echo $percepcion['4'];?>
		</td>
		<td>
		<?
			$calculo = ($percepcion['4'] * 100) / $total;
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
	</script>;
	<?
	
	}
