<?php
require_once('coneccion.php');
class Alumno extends Coneccion{
	var $id;
	var $nombre;
	var $apellido;
    //se agregaron estos datos para que puedan ser actualizados por los alumnos
	var $mail;
	var $fecha_nac;
	var $tel_linea;
	var $tel_cel;
	var $password;
	var $perfil;
	var $idcarrera;
	

	function Alumno($id){
		$this->Coneccion();
		$select_alumno = "select * from alumnos where dni='".$id."' limit 1";
		$datos_alumno = $this->query($select_alumno);
		

		
		$this->id        = $datos_alumno[0]['dni'];
		$this->nombre    = $datos_alumno[0]['nombre'];
		$this->apellido  = $datos_alumno[0]['apellido'];
  		$this->mail      = $datos_alumno[0]['mail'];
		$this->fecha_nac = $datos_alumno[0]['fecha_nac'];
		$this->tel_linea = $datos_alumno[0]['tel_linea'];
                $this->tel_cel   = $datos_alumno[0]['tel_cel'];
		$this->password  = $datos_alumno[0]['password'];
		$this->perfil	 = $datos_alumno[0]['perfil'];
		$this->idcarrera = $datos_alumno[0]['idcarrera'];

		
	

	}
	
	function get_id()      { return $this->id;         }
	function get_nombre()  { return $this->nombre;     }
	function get_apellido(){ return $this->apellido;   }
	function get_mail()    { return $this->mail;       }
	function get_fechaNac(){ return $this->fecha_nac;  }
	function get_telLinea(){ return $this->tel_linea;  }
	function get_telCel()  { return $this->tel_cel;    }
	function get_pass()    { return $this->password;   }
	function get_carrera()    { return $this->idcarrera;   }
  
    
	function enviar_mensaje($correo,$mensaje)
	{
		

		$mensaje = nl2br($mensaje);
		$mensaje = trim($mensaje);

		$query_insert = "insert into mensajesalumnos (id,correo,descripcion,usuario) select 1,'".$correo."'".","."'".$mensaje."'".","."'".$this->id."'";

		
		$resultados_insert = $this->query($query_insert);
		
	}

	function enviar_mensaje_dni($dni,$correo,$mensaje)
	{
		

		$mensaje = nl2br($mensaje);
		$mensaje = trim($mensaje);

		$query_insert = "insert into mensajes (correo,descripcion,usuario,fecha,estado) values('".$correo."','".$mensaje."','".$dni."',now(),'Nuevo')";

		
		$resultados_insert = $this->query($query_insert);
		
	}
	
	
	function traer_alumnos($instancia,$carrera,$documento,$ingreso,$fecha_desde="",$fecha_hasta="",$id_tutor=0)
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
		if($ingreso!="")
		{
			$where_ingreso=" and (ingreso=".$ingreso;
		}
		
		if($id_tutor!="0")
		{
			$query_select="select id from alumnos where trim(dni)='".trim($id_tutor)."'";
			$id_tutor = $this->query($query_select);

			
			$where_tutor=" and id_tutor=".$id_tutor[0]['id'];
		}
		
		$query_alumnos = "select * from alumnos where 1 = 1 and perfil=1 ".$where_instancia."".$where_carrera."".$where_documento." ".$where_ingreso;


 		if($fecha_desde !="" && $fecha_hasta !="")
			$query_alumnos.=" and dni in (select dni from alumnos, alumnoform where dni=idalumno and (fecha_realizacion >='$fecha_desde'  and fecha_realizacion <= '$fecha_hasta') and idform in(1,2,25,28))"; 


		$resultado_alumnos = $this->query($query_alumnos.$where_tutor."--  hola $fecha_desde $fecha_hasta") ;
		
		return $resultado_alumnos;
		
	}

	function traer_alumnos_nuevo($instancia,$carrera,$documento,$ingreso,$fecha_desde,$fecha_hasta)
	{

		if($instancia ==0){}	else {$where_instancia = " and id_instancia=".$instancia;}
		
		if($carrera == 0){} else {$where_carrera = " and idcarrera=".$carrera."";}
		
		if($documento==""){}	else {$where_documento = " and dni ilike '".$documento."%'";}
		
		if($ingreso!=""){$where_ingreso=" and (ingreso=".$ingreso;}
		
		$query_alumnos = "select * from alumnos where 1 = 1 and perfil=1 ".$where_instancia."".$where_carrera."".$where_documento." ".$where_ingreso;

		if($fecha_desde !="" && $fecha_hasta !="")
			$query_alumnos.=" and dni in (select dni from alumnos, alumnosform where dni=idalumno and (fecha_realizacion >=$fecha_desde  & fecha_realizacion <= $fecha_hasta) and idform in(1,2,25,28))"; 

 

		$resultado_alumnos = $this->query($query_alumnos."-- $fecha_desde $fecha_hasta");
		
		return $resultado_alumnos;




	}



	


	function insertar_alumno($nombre,$apellido,$dni,$mail,$telefono,$id_carrera)
	{


		$nombre = str_replace("'","",$nombre);
		$apellido = str_replace("'","",$apellido);

		$query_insert="insert into alumnos (apellido,nombre,dni,perfil,mail,tel_linea,idcarrera,password) select '".$apellido."','".$nombre."','".$dni."',1,'".$mail."','".$telefono."',".$id_carrera.",'".$dni."'";
		


		$this->id = $dni;
		
		$resultado_insert = $this->query($query_insert);
		
	}


	function insertar_alumno_cuatrimestre($nombre,$apellido,$dni,$mail,$telefono,$id_carrera,$cuatrimestre)
	{


		$nombre = str_replace("'","",$nombre);
		$apellido = str_replace("'","",$apellido);

		if($cuatrimestre=="") $cuatrimestre="0";
		$query_insert="insert into alumnos (apellido,nombre,dni,perfil,mail,tel_linea,idcarrera,password,cuatrimestre) select '".$apellido."','".$nombre."','".$dni."',1,'".$mail."','".$telefono."',".$id_carrera.",'".$dni."','".$cuatrimestre."'";
		


		$this->id = $dni;
		
		$resultado_insert = $this->query($query_insert);
		
	}


	function agregar_formulario($id_formulario)
	{
		$query_insert=" insert into alumnoform (idform,idalumno) select ".$id_formulario.",'".$this->id."'";
		
		$this->query($query_insert);
	}
	
	function set_datos($array_datos)
	{
		 $this->id 		  =  $array_datos['id'];        
		 $this->mail 	  = $array_datos['correo_electronico'];     
		 $this->fecha_nac = $array_datos['fecha_nacimiento'];
		 $this->tel_linea = $array_datos['telefono_linea'];
		 $this->tel_cel   = $array_datos['telefono_celular'];
		 $this->password  = $array_datos['password']; 
                 $this->idcarrera  = $array_datos['carrera_seleccionada'];

		
		if (strpos($this->fecha_nac, '/') !== false) {
			$array_fecha_nacimiento = split("/",$this->fecha_nac);
			$this->fecha_nac=$array_fecha_nacimiento[2]."-".$array_fecha_nacimiento[1]."-".$array_fecha_nacimiento[0]; 
		  
		}

		
	  
		  

		 $query_actualizar_alumnos="update alumnos set idcarrera=".$this->idcarrera.", fecha_nac='".$this->fecha_nac."',tel_linea='".$this->tel_linea."',"."tel_cel='".$this->tel_cel."',"."password='".$this->password."',mail='".$this->mail."' where trim(dni)='".trim($this->id)."'";
		 $this->query($query_actualizar_alumnos);
			
		return "1";	
	}     

	function traerRespuestas($idform)
	{
		$query_respuestas	="select idrespuesta,valor,id from respuestaalumno where codform like '".$idform."' and idalumno like '".trim($this->id)."%' order by id asc";
		return($this->query($query_respuestas));

	}

	function modificar_carrera($carrera)
	{
		$query_modificar="update alumnos set idcarrera=".$carrera." where dni='".$this->id."'";
		$this->query($query_modificar);
	}

	function modificar_tutor($tutor)
	{
		$query_modificar="update alumnos set id_tutor=".$tutor." where dni='".$this->id."'";
		$this->query($query_modificar);
	}

	function activar($tutor)
	{
		$query_modificar="update alumnos set ingreso=1 where dni='".$this->id."'";
		$this->query($query_modificar);
	}
	
	function desactivar($tutor)
	{
		$query_modificar="update alumnos set ingreso=0 where dni='".$this->id."'";
		$this->query($query_modificar);
	}
	
	function modificar_clave()
	{
		$query_modificar="update alumnos set password=trim(dni) where trim(dni)='".trim($this->id)."'";
		$this->query($query_modificar);
	}
	
	function modificar_telefono($telefono)
	{
		$query_modificar = "update alumnos set tel_linea = '".$telefono."' where trim(dni)='".trim($this->id)."'";
		$this->query($query_modificar);
	
	}

	function modificar_cuatrimestre($cuat)
	{
		$query_modificar = "update alumnos set cuatrimestre = '".$cuat."' where trim(dni)='".trim($this->id)."'";
		$this->query($query_modificar);
	
	}
	
	function modificar_celular($telefono)
	{
		$query_modificar = "update alumnos set tel_cel = '".$telefono."' where trim(dni)='".trim($this->id)."'";
		$this->query($query_modificar);
	
	}
	
	
	function traer_plan_carrera()
	{
		$query_select= "select * from ppc where idalumno=".$this->id." order by id desc limit 1 ";
		$resultado_select = $this->query($query_select);
		return $resultado_select;
	}


	function traerTextoLibre(){
		return $this->query("select distinct valor from respuestaalumno WHERE CHAR_LENGTH(valor) > 3 and trim(idalumno) like trim('".$this->id."')");
	}
	
}       
?>
