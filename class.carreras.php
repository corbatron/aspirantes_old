<?php
require_once('coneccion.php');
class Carreras extends Coneccion
{
	var $id;
	var $nombre;
	

	function Carreras(){
		$this->Coneccion();
	}

	function traer_carreras($id=null)
	{
		if($id!=null)
		{
			 $where=" where carr_id='".$id."'";
		}
		$query_select = "select * from carreras ".$where." order by carr_descripcion asc";
		$resultados_carreras = $this->query($query_select);
		return $resultados_carreras;
	}


	function devolverMaterias($id=0){
		$query_select = "select materia||'-'||carrera||'-'||plan as id,nombre from materias_carrera where (carrera=".$id." OR ".$id."=0) order by nombre asc";
		$resultados_carreras = $this->query($query_select);
		return $resultados_carreras;

	}
	
	
	function grabarPPC($idformulario,$idalumno,$mat1,$mat2)
	{
		$query_insert="INSERT INTO ppc(idformulario, idalumno, mat_cursar, mat_cursar_prox) VALUES ($idformulario, $idalumno, '$mat1', '$mat2')";
		$this->query($query_insert);
	
	}
	
	function recuperarPPC($id_formulario,$id_alumno)
	{
		$query="select * from ppc where idformulario=".$id_formulario." and idalumno=".$id_alumno."";
		$resultado_select=$this->query($query);
		return $resultado_select;
	}
        
        function transco($carr_id)
	{

		$query_select = "select id_materia_sysacad from carreras where carr_id='$carr_id'";
		$resultado = $this->query($query_select);
		return $resultado[0][0];
	}


}
?>