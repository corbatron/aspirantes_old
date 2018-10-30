<?php
require_once('coneccionCommon.php');
class Mensaje extends Coneccion{


	function enviar_mensaje_dni($dni,$correo,$mensaje)
	{
		

		$mensaje = nl2br($mensaje);
		$mensaje = trim($mensaje);

		$query_insert = "insert into mensajes (correo,descripcion,usuario,fecha,estado) values('".$correo."','".$mensaje."','".$dni."',now(),'Nuevo')";

		
		$resultados_insert = $this->query($query_insert);
		
	}
	
	
	
	function obtenerMensajes()
	{
		


		
		return $this->query("select * from mensajes order by id");
		
	}

	function resolverMensaje($id){
		$this->query("update mensajes set estado='Resuelto' where id=".$id);	
	}
	
}       
?>