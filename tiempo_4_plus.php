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



echo "<H1><i>Tabla: TIEMPO 4 Autoevaluaci&oacute;n y ajustes de planes personales de carrera</i></H1>";
echo "<hr align='left' width='80%'>";

echo "<table id='tabla_reporte' align='center' width='80%'>";//width='100%' 

		echo "<tr>";
		echo "<td >";//width='50%'

			echo "<table cellspacing='2' cellpadding='2'>";//width='100%' 
			echo "<tr>";		
				echo "<td bgcolor='#CCCCCD'>Nombre</td>";
				echo "<td bgcolor='#CCCCCD'>Apellido</td>";
				echo "<td bgcolor='#CCCCCD'>Documento</td>";					
				echo "<td bgcolor='#CCCCCD'>PPC cumplido</td>";	
                                echo "<td bgcolor='#CCCCCD'>PPC %</td>";		
				echo "<td bgcolor='#CCCCCD' width='20%'>Autoevaluaci&oacute;n del estudiante acerca del Rend. Academ.</td>";
                                echo "<td bgcolor='#CCCCCD'>Trabajaste</td>";
                                echo "<td bgcolor='#CCCCCD'>Conociste a tu tutor</td>";
                                echo "<td bgcolor='#CCCCCD'>Pregunta 5</td>";
                                echo "<td bgcolor='#CCCCCD'>Pregunta 6A</td>";
                                echo "<td bgcolor='#CCCCCD'>Pregunta 6B</td>";
                                echo "<td bgcolor='#CCCCCD'>Pregunta 6C</td>";
                                echo "<td bgcolor='#CCCCCD'>Pregunta 6D</td>";
                                echo "<td bgcolor='#CCCCCD'>Pregunta 7</td>";
                                echo "<td bgcolor='#CCCCCD'>Pregunta 8</td>";
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
                                if($mutar['ingreso']==0){
                                    continue;
                                }
                                	$autoevaluacion = $conexion->query("select texto from respuestaspreg where id = cast((select valor from respuestaalumno where codform = '29' and idrespuesta=157  and trim(idalumno) = trim('".$mutar['dni']."')) as integer)");
					if($autoevaluacion[0][0]=="")
                                        {
                                        continue;
                                        }
                                        $autoevaluacion = $conexion->query("select texto from respuestaspreg where id = cast((select valor from respuestaalumno where codform = '29' and idrespuesta=156  and trim(idalumno) = trim('".$mutar['dni']."')) as integer)");
                                        $cumplir = $autoevaluacion[0][0];
                                        $autoevaluacion = $conexion->query("select texto from respuestaspreg where id = cast((select valor from respuestaalumno where codform = '29' and idrespuesta=21  and trim(idalumno) = trim('".$mutar['dni']."')) as integer)");
                                        $cumplir_trabajaste = $autoevaluacion[0][0];
                                         $autoevaluacion = $conexion->query("select texto from respuestaspreg where id = cast((select valor from respuestaalumno where codform = '29' and idrespuesta=153  and trim(idalumno) = trim('".$mutar['dni']."')) as integer)");
                                        $cumplir_conociste = $autoevaluacion[0][0];
                                          $autoevaluacion = $conexion->query("select valor from respuestaalumno where codform = '29' and idrespuesta='622'  and trim(idalumno) = trim('".$mutar['dni']."')");
                                        $cumplir_6a = $autoevaluacion[0][0];
                                           $autoevaluacion = $conexion->query("select valor from respuestaalumno where codform = '29' and idrespuesta='624'  and trim(idalumno) = trim('".$mutar['dni']."')");
                                        $cumplir_6b = $autoevaluacion[0][0];
                                        $autoevaluacion = $conexion->query("select valor from respuestaalumno where codform = '29' and idrespuesta='623'  and trim(idalumno) = trim('".$mutar['dni']."')");
                                        $cumplir_6c = $autoevaluacion[0][0];
                                           $autoevaluacion = $conexion->query("select valor from respuestaalumno where codform = '29' and idrespuesta='626'  and trim(idalumno) = trim('".$mutar['dni']."')");
                                        $cumplir_6d = $autoevaluacion[0][0];
                                           $autoevaluacion = $conexion->query("select valor from respuestaalumno where codform = '29' and idrespuesta='627'  and trim(idalumno) = trim('".$mutar['dni']."')");
                                        $cumplir_7 = $autoevaluacion[0][0];
                                        $autoevaluacion = $conexion->query("select valor from respuestaalumno where codform = '29' and idrespuesta='628'  and trim(idalumno) = trim('".$mutar['dni']."')");
                                        $cumplir_8 = $autoevaluacion[0][0];
                                        echo "<tr>";
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
                    if($mat['llamado']!="APROBADA") 
                    $materias_cursar_filtro[$mat['materias']] = $mat;
                }
                
                
		$cantidad= 0;

                
		foreach($materias_cursar_filtro as $clave=>$mate)
		{
                    
			//if($mate['tipo_cursada']=="1"){
			$materia = explode('-',$mate['materias']);
			$query="select * from materias_carrera where materia=".$materia[0]." and plan=".$materia[2]." and carrera=".$materia[1]."";
			$resultado = $conexion->query($query);

                            if($resultado[0]['nombre'] != "") $cantidad++; 
			//}
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
		echo "<td align='center' bgcolor='".$color_fondo."' >";	
                echo round((($cantidad2 * 100)/$cantidad), 1, PHP_ROUND_HALF_ODD);
		echo "</td>";		
				
				
//autoevaluacion 			
				echo "<td align='center' bgcolor='".$color_fondo."'>";
					
					$autoevaluacion = $conexion->query("select texto from respuestaspreg where id = cast((select valor from respuestaalumno where codform = '29' and idrespuesta=157  and trim(idalumno) = trim('".$mutar['dni']."')) as integer)");
					echo $autoevaluacion[0][0];
					$array_autoevaluacion[$mutar['idcarrera']][strtoupper($autoevaluacion[0][0])]++;
				echo "</td>";	
	
//tutor

					

					
					
					
                                echo "<td align='center' bgcolor='".$color_fondo."'>";
                                echo  $cumplir_trabajaste;
                                echo "</td>";
                                echo "<td align='center' bgcolor='".$color_fondo."'>";
                                echo $cumplir_conociste;
                                echo "</td>";
                                echo "<td align='center' bgcolor='".$color_fondo."'>";
                                echo $cumplir;
                                echo "</td>";
                                echo "<td align='center' bgcolor='".$color_fondo."'>";
                                echo $cumplir_6a;
                                echo "</td>";
                                echo "<td align='center' bgcolor='".$color_fondo."'>";
                                echo $cumplir_6b;
                                echo "</td>";
                                echo "<td align='center' bgcolor='".$color_fondo."'>";
                                echo $cumplir_6c;
                                echo "</td>";
                                echo "<td align='center' bgcolor='".$color_fondo."'>";
                                echo $cumplir_6d;
                                echo "</td>";
                                echo "<td align='center' bgcolor='".$color_fondo."'>";
                                echo $cumplir_7;
                                echo "</td>";
                                echo "<td align='center' bgcolor='".$color_fondo."'>";
                                echo $cumplir_8;
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

