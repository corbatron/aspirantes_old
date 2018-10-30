<?
class Alumno extends Coneccion{
	var $id;
	var $nombre;
	var $apellido;
	

	function Alumno($id){
		$this->Coneccion();
		$select_alumno = "select * from alumnos where dni='".$id."'";
		$datos_alumno = $this->query($select_alumno);
		

		
		$this->id = $datos_alumno[0]['dni'];
		$this->nombre = $datos_alumno[0]['nombre'];
		$this->apellido = $datos_alumno[0]['apellido'];
	}
	
	function get_id(){ return $this->id; }
	function get_nombre(){ return $this->nombre; }
	function get_apellido(){ return $this->apellido; }

	function enviar_mensaje($correo,$mensaje)
	{
		

		$mensaje = nl2br($mensaje);
		$mensaje = trim($mensaje);

		$query_insert = "insert into mensajesalumnos (id,correo,descripcion,usuario) select 1,'".$correo."'".","."'".$mensaje."'".","."'".$this->id."'";

		
		$resultados_insert = $this->query($query_insert);
		
	}
	
	function traer_alumnos($instancia,$carrera,$documento)
	{
	
		if($instancia ==0)
		{
		
		}
		else
		{
			$where_instancia = " and id_instancia=".$instancia;
		}
		
		if($carrera == 0)
		{
			
		}
		else
		{
			$where_carrera = " and idcarrera=".$carrera."";
		}
		
		if($documento=="")
		{
		
		}
		else
		{
			$where_documento = " and dni ilike '".$documento."%'";
		}
		
		$query_alumnos = "select * from alumnos where 1 = 1 ".$where_instancia."".$where_carrera."".$where_documento;
		
		
		$resultado_alumnos = $this->query($query_alumnos);
		
		return $resultado_alumnos;
		
	}

	function insertar_alumno($nombre,$apellido,$dni,$id_carrera)
	{

		$query_insert="insert into alumnos (apellido,nombre,dni,perfil,idcarrera,password) select '".$apellido."','".$nombre."','".$dni."',".$id_carrera.",'".$dni."'";
		$this->id = $dni;
		echo $query_insert;
		$resultado_insert = $this->query($query_insert);
		
	}

	function agregar_formulario($id_formulario)
	{
		$query_insert=" insert into alumnoform (idform,idalumno) select ".$id_formulario.",'".$this->id."'";
		echo $query_insert;
		$this->query($query_insert);
	}
}
?>