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



echo "<H1><i>Tabla: Discontinuidad </i></H1>";
echo "<hr align='left' width='80%'>";

echo "<table id='tabla_reporte' align='center' width='80%'>"; 
		echo "<tr>";
		echo "<td >";

		echo "<table cellspacing='2' cellpadding='2'>";//width='100%' 
			echo "<tr>";		
				echo "<td bgcolor='#CCCCCD'>Estado</td>";
				echo "<td bgcolor='#CCCCCD'>Cuatrimestre</td>";
				echo "<td bgcolor='#CCCCCD'>Nombre</td>";
				echo "<td bgcolor='#CCCCCD'>Apellido</td>";
				echo "<td bgcolor='#CCCCCD'>Documento</td>";
				echo "<td bgcolor='#CCCCCD'>Riesgo</td>";
				echo "<td bgcolor='#CCCCCD'>1º Percepci&oacute;n</td>";
				echo "<td bgcolor='#CCCCCD'>Causa abandono</td>";	
				echo "<td bgcolor='#CCCCCD' width='20%'>Observaciones</td>";
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
					echo "</td>";


							
				$percepcion = $conexion->query("select (select percepcion as percepcion1 from percepcion where numero_percepcion=1 and id_alumno=".$mutar['dni']." limit 1),(select percepcion as percepcion2 from percepcion where numero_percepcion=2 and id_alumno=".$mutar['dni']." limit 1)");
				
				$percepcion1 = $percepcion[0]['percepcion1'] ;//$conexion->query("select percepcion from percepcion where numero_percepcion=1 and id_alumno=".$mutar['dni']);
				
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
					}
					echo '<font style="background-color: '.$color.';">'.$texto.'</font>';
				echo "</td>";		

		
				
	






	
//causa abandono
			


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
//tutor
					echo "<td bgcolor='".$color_fondo."'>";
						$tutor = $conexion->query("select nombre||', '||apellido as tutor from alumnos where id = (select id_tutor from alumnos  where trim(dni) like trim('".$mutar['dni']."') and id_tutor is not null)");
						echo utf8_decode($tutor[0][0]);
					echo "</td>";					
					
					
					
					



				echo "</tr>";
			}
		
	echo "</table>";
	echo "</td></tr></table>";







?>
<font color="white">


REPORTE Discontinuidad ( fecha)
Siempre por carrera y cohorte
Contactados:
No contactados: 


								cantidad	porcentaje
Se pasan a otra carrera (especificar)
		
Abandonadores (tipificaci&oacute;n de causas)
		
Retoman el año pr&oacute;ximo
		
		



Como anexo a este documento se puede incorporar un listado de abandonadores y discontinuadores con la siguiente informaci&oacute;n:

	Apellido y nombre	DNI	Riesgo		Tipo de entrevista	1º Percepci&oacute;n	Tutor	Tipo Deserci&oacute;n	Causa abandono	Observaciones

					Alto(red)	Intervencion(red)	nulo(rojo)		 Abandonador/discontinuador

					Medio(naranja) Asesoramiento(amarillo) baja(naranja)				trabajo, orientacion, economico etc


					Bajo(amarillo) recomendacion(verde) media(amarilllo
		

					Nulo(verde)				alta(verde)	 



Asesoramiento: 

Recomendaci&oacute;n	Nula

Baja


Media


Alta
		Abandonador/Discontinuador	Trabajo
Orientaci&oacute;n
Econ&oacute;mico
Salud
Familia
ETC	
</font>
