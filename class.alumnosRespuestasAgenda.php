<?php
require_once('coneccion.php');
class alumnosRespuestasAgenda extends Coneccion
{
	function alumnosRespuestasAgenda(){
		$this->Coneccion();
	}
	
	function traerFormularios(){
		$select_formularios="select id, codigo, descripcion from formularios where id in (select distinct id_formulario from respuestasagenda)";
		return ($this->query($select_formularios));
	}
	
	function traerAlumnos($id_form){
		$select_alumnos ="select distinct idalumno from alumnoform where idform=".$id_form." and fecha_realizacion is not null";
		return ($this->query($select_alumnos));
	}
	
	function traerRespuestas($id_form,$id_alumno){
		//$select_respuestas="select distinct dni,(select count(*) as valor1 from respuestasagenda where dni like '".$id_alumno."%' and id_valor=0) as ESTUDIO,(select count(*) as valor1 from respuestasagenda where dni like '".$id_alumno."%' and id_valor=1) as ACTIVIDADES,(select count(*) as valor1 from respuestasagenda where dni like '".$id_alumno."%' and id_valor=2) as FACULTAD,(select count(*) as valor1 from respuestasagenda where dni like '".$id_alumno."%' and id_valor=3) as TRABAJO from respuestasagenda where dni like '".$id_alumno."%' and id_formulario=".$id_form;
		//echo $select_respuestas;

		$select_respuestas="select distinct dni,(select count(*) as valor1 from respuestasagenda where dni like '".$id_alumno."%' and id_valor=0  and id_formulario=".$id_form.") as ESTUDIO,(select count(*) as valor1 from respuestasagenda where dni like '".$id_alumno."%' and id_valor=1  and id_formulario=".$id_form.") as ACTIVIDADES,(select count(*) as valor1 from respuestasagenda where dni like '".$id_alumno."%' and id_valor=2  and id_formulario=".$id_form.") as FACULTAD,(select count(*) as valor1 from respuestasagenda where dni like '".$id_alumno."%' and id_valor=3 and id_formulario=".$id_form.") as TRABAJO from respuestasagenda where dni like '".$id_alumno."%' and id_formulario=".$id_form;

		return ($this->query($select_respuestas));
	}
	
	function traerAgendaCompleta($id_form,$id_alumno)
	{
	
		$select_respuestas="select * from respuestasagenda where dni like '".$id_alumno."%' and id_formulario=".$id_form;
		return ($this->query($select_respuestas));	
	
	}


	function traerMaxAgenda($id_alumno)
	{
	
		return ($this->query("select max(id_formulario) from respuestasagenda where dni like '".$id_alumno."%'  "));	
	
	}



}
?>
