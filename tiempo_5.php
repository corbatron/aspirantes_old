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



echo "<H1><i>Tabla: TIEMPO 5 Autorregulaci&oacute;n </i></H1>";
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
				echo "<td bgcolor='#CCCCCD'>PPC cumplido</td>";	
				echo "<td bgcolor='#CCCCCD'>Autorregulaci&oacute;n</td>";
				echo "<td bgcolor='#CCCCCD'>Riesgo</td>";
				//nuevo 04/08/2014
				echo "<td bgcolor='#CCCCCD'>Tipo de orientaci&oacute;n</td>";
				echo "<td bgcolor='#CCCCCD'>Posicionamiento</td>";
				echo "<td bgcolor='#CCCCCD'>Agenda</td>";
				echo "<td bgcolor='#CCCCCD'>Autovaloraci&oacute;n</td>";
				//_fin nuevo
				echo "<td bgcolor='#CCCCCD'>1� Percepci&oacute;n</td>";
				echo "<td bgcolor='#CCCCCD'>2� Percepci&oacute;n</td>";				
				echo "<td bgcolor='#CCCCCD' width='20%'>Autoevaluaci&oacute;n del estudiante acerca del Rend. Academ.</td>";
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


//Autorregulaci&oacute;n
					$mutar['dni'] = trim($mutar['dni']);
				
					echo "<td align='center' bgcolor='".$color_fondo."' >";
				    /*calcular porcentaje y dividir en categorias*/
					
									
						$id_alumno = trim($mutar['dni']);
						$alumno = new Alumno($id_alumno);
						$plan_carrera = $alumno->traer_plan_carrera();



						$array_materias_cursar = $plan_carrera[0]['mat_cursar'];

						$array_materias_cursar_deserializado = unserialize($array_materias_cursar);
                                                
                                            
                                                
                                                   $materias_cursar_filtro="";
                                                foreach($array_materias_cursar_deserializado as $mat){
						if($mat['llamado']!="APROBADA")
                                                    $materias_cursar_filtro[$mat['materias']] = $mat;
                                                }

  
                                                
						$cantidad= 0;
						foreach($materias_cursar_filtro as $clave=>$mate)
                                                {
                                                    if($mate['llamado']!="APROBADA"){
                                                    $materia = explode('-',$mate['materias']);
                                                    $query="select * from materias_carrera where materia=".$materia[0]." and plan=".$materia[2]." and carrera=".$materia[1]."";
                                                    $resultado = $conexion->query($query);
                                                    
                                                    if($resultado[0]['nombre'] != "") $cantidad++; 
                                                    }
						}

						$resultado = "";
						$query_select="select * from tutorias_materias_aprobadas where legajo=".$id_alumno."";

						$resultado = $conexion->query($query_select);



						$cantidad2 = 0;
						foreach($resultado as $mate)
						{
						$cantidad2 = $cantidad2 + 1;

						}

						//$cantidad2 = count($resultado);

				echo $cantidad2." de ".$cantidad;
echo "</td><td align='center' bgcolor='".$color_fondo."' >";



if($cantidad==0) $cantidad=1; /////// si no pone materias a cursar, entonces con que apruebe 1 ya tiene 100						




						$porcentaje = $cantidad2 * 100 / $cantidad + 0;
						if($porcentaje>100){$porcentaje=100;}
						$porcentaje = number_format($porcentaje,1,",","");
						$color = "";
						switch(true){
							case ($porcentaje<20):
								$color= $ROJO;
								break;
							case ($porcentaje<50):
								$color= $PURPURA;
								break;
							case ($porcentaje<85):
								$color= $AMARILLO;
								break;
							case ($porcentaje<=100):
								$color= $VERDE;
								break;				
						}
						echo '<font style="background-color: '.$color.';">'.$porcentaje.'%</font>';	
						$array_autorregulacion[$mutar['idcarrera']][$color]++;
					echo "</td>";
				
//riesgo					
					echo "<td align='center' bgcolor='".$color_fondo."' >";
						$riesgo = $conexion->query("select riesgo from alumnos where trim(dni) like trim('".$mutar['dni']."')");
						switch($riesgo[0][0]){
							case "ALTO":
								$color= $ROJO;
								break;
							case "MEDIO":
								$color= $PURPURA;
								break;
							case "BAJO":
								$color= $AMARILLO;
								break;
							case "NULO":
								$color= $VERDE;
								break;				
						}
						
						echo '<font style="background-color: '.$color.';">'.$riesgo[0][0].'</font>';	
						$array_riesgo[$mutar['idcarrera']][$riesgo[0][0]]++;
					echo "</td>";
//nuevo 04/08/2014
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
//posicionamiento
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
//agenda 
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




//_fin nuevo 04/08/2014					
					
							
				$percepcion = $conexion->query("select (select percepcion from percepcion where numero_percepcion=1 and id_alumno=".$mutar['dni']." limit 1) as percepcion1,	(select percepcion from percepcion where numero_percepcion=2 and id_alumno=".$mutar['dni']." limit 1)  as percepcion2");

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
						case "5":
							$color= "";
							$texto="SIN PERCEPCION";
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
						case "5":
							$color= "";
							$texto="SIN PERCEPCION";
							break;			
					}
					echo '<font style="background-color: '.$color.';">'.$texto.'</font>';
				echo "</td>";	
		
				
	






	
//Autoevaluaci&oacute;n del estudiante acerca del Rend. Academ
				echo "<td bgcolor='".$color_fondo."'>";
					//echo "TODO";
					$autoevaluacion = $conexion->query("select texto from respuestaspreg where id = cast((select valor from respuestaalumno where codform = '29' and idrespuesta=157  and trim(idalumno) = trim('".$mutar['dni']."')) as integer)");
					echo $autoevaluacion[0][0];


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

	foreach($array_autorregulacion as $carrera=>$autorregulacion)
	{
		$valor1 ="";
		if($autorregulacion[$ROJO]==""){$autorregulacion[$ROJO]=0;}
		if($autorregulacion[$PURPURA]==""){$autorregulacion[$PURPURA]=0;}
		if($autorregulacion[$AMARILLO]==""){$autorregulacion[$AMARILLO]=0;}
		if($autorregulacion[$VERDE]==""){$autorregulacion[$VERDE]=0;}
		$valor1="['ALTA', ".$autorregulacion[$VERDE]."], ['PARCIAL', ".$autorregulacion[$AMARILLO]."], ['PARCIAL', ".$autorregulacion[$PURPURA]."], ['NULA', ".$autorregulacion[$ROJO]."]";
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
	<td bgcolor='CCCCCE'>Autorregulaci&oacute;n
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
		<?echo $autorregulacion[$VERDE];?>
		</td>
		<td>
		<?
// ['#FF3300', '#FF00FF','#F8F933','#22FF00'];
			$total = $autorregulacion[$ROJO] + $autorregulacion[$VERDE] + $autorregulacion[$AMARILLO]  + $autorregulacion[$PURPURA];
			$calculo = ($autorregulacion[$VERDE] * 100) / $total;
			echo $calculo."%";
		?>
		</td>
	</tr>
	<tr>
		<td bgcolor='#F8F933'>PARCIAL
		</td>
		<td>
		<?
		echo $autorregulacion[$AMARILLO];
		?>
		</td>
		<td>
		<?
			$calculo = ($autorregulacion[$AMARILLO] * 100) / $total;
			echo $calculo."%";

		?>
		</td>
	</tr>
	<tr>
		<td bgcolor='#FFA500'>PARCIAL
		</td>
		<td>
		<? echo $autorregulacion[$PURPURA];?>
		</td>
		<td>
		<?
			$calculo = ($autorregulacion[$PURPURA] * 100) / $total;
			echo $calculo."%";
		?>
		</td>
	</tr>
	<tr>
		<td bgcolor='#FF3300'>NULO
		</td>
		<td>
		<? echo $autorregulacion[$ROJO];?>
		</td>
		<td>
		<?
			$calculo = ($autorregulacion[$ROJO] * 100) / $total;
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
