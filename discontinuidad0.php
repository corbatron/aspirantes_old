<script type="text/javascript" src="js/jscharts.js"></script>
<STYLE TYPE="text/css">

TD{font-family: Arial; font-size: 9pt;}
br {mso-data-placement:same-cell;}
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

$AMARILLO = "warning";
$ROJO = "danger";
$PURPURA = "info";//purpura FF00FF
$VERDE = "success";

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



echo "<H1><i>Reporte: Discontinuidad </i></H1>";
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
				echo "<th>1ra Percepci&oacute;n</th>";
				echo "<th>Causa abandono</th>";	
				echo "<th>Observaciones</th>";
				echo "<th>Tutor</th>";
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
$color="";
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
										echo "<td align='center' class='".$color."' >";
	
						echo $riesgo[0][0];	
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
								echo "<td align='center' class='".$color."' >";

					echo $texto;
				echo "</td>";		

		
				
	






	
//causa abandono
			


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
		
		
		



Como anexo a este documento se puede incorporar un listado de abandonadores y discontinuadores con la siguiente informaci&oacute;n:


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