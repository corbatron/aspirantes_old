<?
require_once('class.conexion.php');
class Sysacad extends Conexion{

	function Sysacad(){
		$this->Conexion();
	}
	
	
	function obtenerMaterias($dni){		
		session_start();
		$fecha_inicio=$_SESSION['fecha_ini'];
		$fecha_fin=$_SESSION['fecha_fin'];
		$resultado = $this->query("select especialidad,plan,materia,legajo,fecha from tutorias_materias_aprobadas where legajo=".$dni." and (fecha>='".$fecha_inicio."' and fecha<='".$fecha_fin."');");
		return $resultado;
	}
	
}

?>