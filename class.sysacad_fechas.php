<?php
require_once('coneccion.php');
class SysacadFechas extends Coneccion{
	
	function escribir_fechas($fecha_inicio,$fecha_fin){
		$query= "truncate sysacad_fechas";
		$this->query($query);
		$query= "INSERT INTO sysacad_fechas(fecha_inicio, fecha_fin) VALUES ('".$fecha_inicio."','".$fecha_fin."')";
		$this->query($query);


	}

	function obtener_fechas(){
		return $this->query("select * from sysacad_fechas");
	}


	
}       
?>