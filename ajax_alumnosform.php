<?
error_reporting(0);
include("class.alumnosForm.php");
$id_formulario 	= $_GET["id_formulario"];
$id_alumnos 	= $_GET["id_alumnos"];
$accion			= $_GET["accion"];
$forzar			= $_GET["forzar"];
$carrera		= $_GET["id_carrera"];
$alumnosForm	= new alumnosForm();
 
if($accion=="noasignados"){
	$alumnosSinForm = $alumnosForm->alumnosSinForm($id_formulario,$carrera);
	echo '<select id="sinform" name="sinform[]" size="15" multiple="true" style="width: 100%">';
		foreach($alumnosSinForm as $alumno){
			$color = "WHITE";
			if($alumno['ingreso']==""){
			 $color = "RED";
			}
			echo '<option value="'.$alumno['dni'].'" style="background:'.$color.'">'.$alumno['dni'].' - '.$alumno['apellido'].', '.$alumno['nombre'].' ('.$alumno['cuatrimestre'].')'.'</option>';		
		}
	echo '</select>';
	}

if($accion=="asignados"){
	$alumnosConForm = $alumnosForm->alumnosConForm($id_formulario,$carrera);
	echo '<select id="conform" name="conform[]" size="15" multiple="true" style="width: 100%">';
		foreach($alumnosConForm as $alumno){
			$color = "WHITE";
			if($alumno['ingreso']==""){
			 $color = "RED";
			}
			echo '<option value="'.$alumno['dni'].'"  style="background:'.$color.'">'.$alumno['dni'].' - '.$alumno['apellido'].', '.$alumno['nombre'].' ('.$alumno['cuatrimestre'].')'.'</option>';		

		}
	echo '</select>';	
	}

	
if($accion=="asignar"){//form,array de dni
		$array_alumnos=explode(',',$id_alumnos);
		foreach($array_alumnos as $alumno){
			$alumnosForm->asignarAlumnoForm($id_formulario,$alumno);
		}
	}
		
if($accion=="desasignar"){//form,array de dni
		$array_alumnos=explode(',',$id_alumnos);
		foreach($array_alumnos as $alumno){
			$alumnosForm->desasignarAlumnoForm($id_formulario,$alumno,$forzar);
		}
	}
	
if($accion=="asignartodos"){
	$alumnosSinForm = $alumnosForm->alumnosSinForm($id_formulario,$carrera);
	foreach($alumnosSinForm as $alumno){
			$alumnosForm->asignarAlumnoForm($id_formulario,$alumno['dni']);
		}
	}	

if($accion=="desasignartodos"){
	$alumnosConForm = $alumnosForm->alumnosConForm($id_formulario,$carrera);
	foreach($alumnosConForm as $alumno){
			$alumnosForm->desasignarAlumnoForm($id_formulario,$alumno['dni'],$forzar);
		}
	}	










if($accion=="noasignados2"){
	$alumnosSinForm = $alumnosForm->alumnosSinForm($id_formulario,$carrera);
	$ingreso = $_GET["ingreso"];
	$noingreso = $_GET["noingreso"];
	echo '<select class="form-control" id="sinform" name="sinform[]" size="15" multiple="true" style="width: 100%">';
		foreach($alumnosSinForm as $alumno){
			if($alumno['ingreso']=="" && $noingreso=="true")
				echo '<option value="'.$alumno['dni'].'" class="label-danger">'.$alumno['dni'].' - '.$alumno['apellido'].', '.$alumno['nombre'].' ('.$alumno['cuatrimestre'].')'.'</option>';		
			if($alumno['ingreso']!="" && $ingreso=="true")
				echo '<option value="'.$alumno['dni'].'" >'.$alumno['dni'].' - '.$alumno['apellido'].', '.$alumno['nombre'].' ('.$alumno['cuatrimestre'].')'.'</option>';		
		}
	echo '</select>';
	}

if($accion=="asignados2"){
	$alumnosConForm = $alumnosForm->alumnosConForm($id_formulario,$carrera);
	$ingreso = $_GET["ingreso"];
	$noingreso = $_GET["noingreso"];
	echo '<select class="form-control" id="conform" name="conform[]" size="15" multiple="true" style="width: 100%">';
		foreach($alumnosConForm as $alumno){
			if($alumno['ingreso']=="" && $noingreso=="true")
				echo '<option value="'.$alumno['dni'].'" class="label-danger">'.$alumno['dni'].' - '.$alumno['apellido'].', '.$alumno['nombre'].' ('.$alumno['cuatrimestre'].')'.'</option>';		
			if($alumno['ingreso']!="" && $ingreso=="true")
				echo '<option value="'.$alumno['dni'].'" >'.$alumno['dni'].' - '.$alumno['apellido'].', '.$alumno['nombre'].' ('.$alumno['cuatrimestre'].')'.'</option>';		

		}
	echo '</select>';	
	}








?>