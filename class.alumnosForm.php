<?
error_reporting(0);
include("coneccion.php");
class alumnosForm extends Coneccion{
	private $formulario;
	private $alumnos;
	
	
	function alumnosForm(){
		$this->Coneccion();
	}
	function alumnosSinForm($id_form,$carrera){
	//alumnos que no estan asignados al formulario pasado por parametro
		$alumnos_query = "select dni,apellido,nombre,ingreso,cuatrimestre from alumnos where dni not in (select idalumno from alumnoform where idform = ".$id_form.") and idcarrera =".$carrera." order by dni asc";
		return ($this->query($alumnos_query));

	}
	
	function alumnosConForm($id_form,$carrera){
	//alumnos que estan asignados al formulario del paramtro
		$alumnos_query = "select dni,apellido,nombre,ingreso,cuatrimestre from alumnos where dni in (select idalumno from alumnoform where idform = ".$id_form.") and idcarrera =".$carrera." order by dni asc";
		return ($this->query($alumnos_query));
	}
		
	function asignarAlumnoForm($id_form,$id_alumno){
	//asignar el alumno al formulario 
		$alumno_asignar = "insert into alumnoform (idform,idalumno) values (".$id_form.",'".$id_alumno."')";
		$this->query($alumno_asignar);
	}
	
	function desasignarAlumnoForm($id_form,$id_alumno,$forzar){
	if($forzar=="true"){
		$this->forzarDesasignacion($id_form,$id_alumno);
	}else{
		//desasignar el alumno (solo si el form esta incompleto)
		$alumno_desasignar = "delete from alumnoform where idalumno like '".$id_alumno."%' and idform=".$id_form." and fecha_realizacion is null";
		$this->query($alumno_desasignar);
		}
	}
	
	function forzarDesasignacion($id_form,$id_alumno){
	//borra el form del alumno incluso si fue completado (tambien borra las respuestas)
		$alumno_desasignar = "delete from alumnoform where idalumno like '".$id_alumno."%' and idform=".$id_form;
		$result = $this->query($alumno_desasignar);	
    //borra las respuestas que existen para ese form
		$alumno_borarrespuestas = "delete from respuestasagenda where dni like '".trim($id_alumno)."%' and id_formulario=".$id_form;
		$result = $this->query($alumno_borarrespuestas);
		$alumno_borarrespuestas = "delete from ppc where idalumno=".$id_alumno." and idformulario=".$id_form;
		$result = $this->query($alumno_borarrespuestas);
		$alumno_borarrespuestas = "delete from respuestaalumno where idalumno like '".trim($id_alumno)."%' and codform='".$id_form."'";
		$result = $this->query($alumno_borarrespuestas);		
	}
}
?>