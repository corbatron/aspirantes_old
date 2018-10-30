<?php
error_reporting(0);
require_once('coneccion.php');
class Form extends Coneccion
{
var $id=null;
var $codigo=null;
var $estado= 0;
var $descripcion="";
var $fecha_desde="";
var $fecha_hasta="";
var $descripcion_larga="";


function Form($id_in)
	{

		$this->Coneccion();
		if($id_in!="")
		{
			$select_formulario = "select * from formularios where id=".$id_in;
			
			$resultado_formularios = $this->query($select_formulario);

			$this->id = $resultado_formularios[0]['id'];
			$this->codigo = $resultado_formularios[0]['codigo'];
			$this->estado = $resultado_formularios[0]['estado'];
			$this->fecha_desde = $resultado_formularios[0]['fecha_desde'];
			$this->fecha_hasta = $resultado_formularios[0]['fecha_hasta'];
			$this->descripcion = $resultado_formularios[0]['descripcion'];
			$this->descripcion_larga = $resultado_formularios[0]['descripcion_larga'];


		}
	}


function get_codigo(){return $this->codigo;}
function get_estado (){return $this->estado;}
function get_descripcion (){return $this->descripcion;}
function get_fecha_desde(){return $this->fecha_desde;}
function get_fecha_hasta(){return $this->fecha_hasta;}
function get_id(){return $this->id;}
function get_descripcionLarga(){return $this->descripcion_larga;}

function set_id($valor_id)
	{
		$this->id = $valor_id;
	}

function set_codigo($valor_codigo)
	{
		$this->codigo = $valor_codigo;
	}

function set_estado($valor_estado=0)
	{
		$this->estado = $valor_estado;
	}

function set_descripcion($valor_descri)
	{
		$this->descripcion = $valor_descri;
	}

function set_fecha_inicio($fecha)
	{
		$this->fecha_desde = $fecha;
	}

function set_fecha_fin($fecha)
	{
		$this->fecha_hasta = $fecha;
	}
function set_descripcionLarga($desc)
	{
		$this->descripcion_larga = $desc;
	}

function saveForm()
	{

		if($this->id!=0)
		{	
			$query_update = "update formularios set codigo='".$this->codigo."',estado=".$this->estado.",descripcion='".$this->descripcion."',fecha_desde='".$this->fecha_desde."',fecha_hasta='".$this->fecha_hasta."',descripcion_larga='".$this->descripcion_larga."' where id=".$this->id;
			$this->query($query_update);

			
		}
		else
		{
			$query_insert = "insert into formularios (codigo,estado,descripcion,fecha_desde,fecha_hasta,descripcion_larga) values('".$this->codigo."',".$this->estado.",'".$this->descripcion."','".$this->fecha_desde."','".$this->fecha_hasta."','".$this->descripcion_larga."')";
			$this->query($query_insert);
			//insertar boton de submit para todas por defecto
			$insert_boton = "insert into preguntas values (4,1,'Enviar')";
			$this->query($insert_boton);
			$insert_boton2 = "insert into preguntasform(id_pregunta,orden,id_formulario,estado) values ((select idpregunta from preguntas order by idpregunta desc limit 1),1,(select id from formularios order by id desc limit 1),1)"; 
			$this->query($insert_boton2);
			
		}
	}

function delForm()
	{
		$query_del = "update formularios set activo=0 where id=".$this->id;
		$this->query($query_del);
		return 1;
	}

function showForm()
	{
	
	$select_formularios= "select * from formularios where activo is null order by orden_form asc";			
	$formularios = $this->query($select_formularios);

	return $formularios;
		
	}

function traerPreguntas()
	{

	$select_preguntas = "select * from preguntasform inner join preguntas on id_pregunta = idpregunta
						where id_formulario = ".$this->id. " and preguntasform.estado = 1 and preguntas.estado = 1 order by orden asc";
	$preguntas = $this->query($select_preguntas);
	
	return $preguntas;

	}


function cambiarPosicion($id_pregunta,$accion,$orden)
	{

		if($accion=="subir")
		{
			$nuevo_orden = $orden -1;
			$query_update="update preguntasform set orden=".$orden." where orden=".$nuevo_orden." and id_formulario=".$this->id."; update preguntasform set orden=".$nuevo_orden." where id_pregunta=".$id_pregunta." and id_formulario=".$this->id;
		}
		else
		{
			$nuevo_orden = $orden +1;
			$query_update="update preguntasform set orden=".$orden." where orden=".$nuevo_orden." and id_formulario=".$this->id."; update preguntasform set orden=".$nuevo_orden." where id_pregunta=".$id_pregunta." and id_formulario=".$this->id;
		}
		
		
		
	$this->query($query_update);
	}

function eliminarPregunta($id_pregunta,$accion,$nada)
	{
		$eliminar = "update preguntasform set estado = 0 where id_pregunta=".$id_pregunta;
		$this->query($eliminar);
		$eliminar = "update preguntas set estado = 0 where idpregunta=".$id_pregunta;
		$this->query($eliminar);
	}

function agregarPregunta($texto_pregunta)
	{	
		$insertar = "insert into preguntas (idtipo,estado,texto) select 1,1,'".$texto_pregunta."'";
		$this->query($insertar);
		
		$id_pregunta = "select idpregunta from preguntas where texto like '".$texto_pregunta."'";
		$pregunta_nueva = $this->query($id_pregunta);
		
		
		
		
		$otro_insert = "insert into preguntasform(id_pregunta,orden,id_formulario,estado) select ".$pregunta_nueva[0]['idpregunta'].",
		COALESCE((select orden from preguntasform where id_formulario = ".$this->id." order by orden desc limit 1),0)+1,".$this->id.",1;";
		
	
		
		$this->query($otro_insert);
		

	}	



function editarPregunta($pregunta, $texto)
	{	
		
		
		$update = "update preguntas set texto='".$texto."' where idpregunta=".$pregunta;
		$this->query($update);
		

	}	

	
//RESPUESTAS
	function cambiarPosicionResp($id,$orden,$accion)
	{	
		
		$query="select max(orden) from respuestaspreg where idpregunta=(select idpregunta from respuestaspreg where id=".$id.")";
		$maximo=$this->query($query);			

		if($accion=="subir_respuesta" && $orden!=1)
		{
			$nuevo_orden = $orden -1;

			$query_update="update respuestaspreg set orden=".$nuevo_orden." where id=".$id.";update respuestaspreg set orden=".$orden." where idpregunta=(select idpregunta from respuestaspreg where id=".$id.") and orden=".$nuevo_orden." and id <>".$id.";";


		}
		elseif($accion=="bajar_respuesta" && $orden!=$maximo[0][0])
		{
			$nuevo_orden = $orden +1;
			$query_update="update respuestaspreg set orden=".$nuevo_orden." where id=".$id.";update respuestaspreg set orden=".$orden." where idpregunta=(select idpregunta from respuestaspreg where id=".$id.") and orden=".$nuevo_orden." and id <>".$id.";";

		}
		$this->query($query_update);	
	}
	

	function eliminarRespuesta($id)
	{
		$eliminar = "update respuestaspreg set estado = 0 where id=".$id;
		$this->query($eliminar);
	}
	
	function obtenerPregunta($id)
	{
		$select = "select idpregunta from  respuestaspreg where id=".$id;
		$resultado = $this->query($select);
		$id_pregunta = $resultado[0]['idpregunta'];
		return $id_pregunta;
	}
	function obtenerTipo($id)
	{
		if(is_numeric($id)){
			$select = "select idtipo from  respuestaspreg where id=".$id;
			$resultado = $this->query($select);
			$id_pregunta = $resultado[0]['idtipo'];
			return $id_pregunta;
		}

	}
	
	
	function agregarRespuesta($idpregunta,$texto,$tipo)
	{
		if($tipo!=4)
		{
			$insert = "insert into preguntasform(idpregunta,texto,idtipo,orden) values (".$idpregunta.",'".$texto."',".$tipo.",select orden from preguntasform order by orden where idpregunta=".$idpregunta." order by desc limit 1)";
		}
		else // entra si es del tipo "select"
		{
			//averiguar si tiene padre
			$select = "";
			
			//insertar padre
			$insert_padre = "insert into preguntasform(idpregunta,texto,idtipo,orden) values (".$idpregunta.",'select_padre',4,select orden from preguntasform order by orden where idpregunta=".$idpregunta." order by desc limit 1)";
			$this->query($insert_padre);
			
			
			
			
			$insert = "insert into preguntasform(idpregunta,texto,idtipo,orden) values (".$idpregunta.",'select_padre',4,select orden from preguntasform order by orden where idpregunta=".$idpregunta." order by desc limit 1)";
		
		}
		
		
	}
	
	
	function traerPreguntasTexto($id_pregunta)
	{

	$select_preguntas = "select * from preguntasform inner join preguntas on id_pregunta = idpregunta
						where id_pregunta=".$id_pregunta." and preguntasform.estado = 1 and preguntas.estado = 1 order by orden asc";
	$preguntas = $this->query($select_preguntas);
	
	return $preguntas;

	}
	
	function traerRespuestas($id)
	{
		$select_respuesta = " select * from respuestaspreg where id=".$id;
		return $this->query($select_respuesta);
	
	}

	function traerValor($id_preg,$dni)
	{
		
		$select_valor="select valor from respuestaalumno where idrespuesta in (select id from respuestaspreg where idpregunta=".$id_preg." and estado like 'especificar') and idalumno like '".$dni."%'";
		return $this->query($select_valor);
	}
	
	
	
	
	
	
}

?>
