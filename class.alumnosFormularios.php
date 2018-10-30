<?
class alumnosFormularios extends Coneccion{
	var $idAlumno;
	var $idForm;
	var $fecha;

	function alumnosFormularios($id_alumno){
		$this->Coneccion();
		$this->idAlumno = $id_alumno;
	}
	
	function traerForms(){
		$select_forms = "select * from alumnoform inner join formularios on alumnoform.idform=formularios.id where idalumno='".trim($this->idAlumno)."' order by idalumno,formularios.orden_form asc ";
		$datos_alumno_form = $this->query($select_forms);
		return $datos_alumno_form;
	}
	
	function get_descripcion($id){
		$select_form = "select descripcion from formularios where id=".$id;
		$descripcion = $this->query($select_form);
		return $descripcion[0]['descripcion'];
	}

	function insertarRespuestas($id_resp,$valor_respuesta,$codigo_formulario)
	{
		$query_insert="insert into respuestaalumno (idrespuesta,codform,valor,fecha,idalumno) values (".$id_resp.",'".$codigo_formulario."','".$valor_respuesta."',now(),'".trim($this->idAlumno)."')";
        
        
		$this->query($query_insert);
	}

	function formularioCerrar($id_formu)
	{
		$query_update_formulario = "update alumnoform set fecha_realizacion=now() where idalumno='".trim($this->idAlumno)."' and idform=".$id_formu."";
		$this->query($query_update_formulario);

	}

	function insertarAgenda($dia,$hora,$valor,$id_form)
	{
		$query_insert="INSERT INTO respuestasagenda(dni, id_dia, id_hora, id_formulario, fecha, id_valor)  VALUES ('".$this->idAlumno."',".$dia." ,".$hora.", ".$id_form.", now() ,".$valor.")";
		$this->query($query_insert);
	}

	
	function traerIdForms(){
		$select_forms = "select * from alumnoform where idalumno='".trim($this->idAlumno)."'";
		$datos_alumno_form = $this->query($select_forms);
		return $datos_alumno_form;
	}
	
	function wasDone($dni,$id_form){
		$select_q = "select campo_magico,1,fecha_realizacion from alumnoform where idalumno like '".trim($dni)."%' and idform=".$id_form;
		$datos = $this->query($select_q);
		return $datos;
	}
	
	function compararId($id){
		$select_forms = "select  1 as verifica from alumnoform where idalumno='".trim($this->idAlumno)."' and idform=".$id;
		$datos_alumno_form = $this->query($select_forms);
		return $datos_alumno_form;
	}
}
?>