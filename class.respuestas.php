<?
require_once('coneccion.php');
class Respuestas extends Coneccion
{

	private $id;
	private $idpregunta;
	private $texto;
	private $idtipo;
	private $orden;
	private $estado;
	private $name;
	private $idpadre;
	private $con;
	
	function Respuestas($id="")
	{
		$con = new Coneccion();
		if($id!="")
		{
			$select_respuestas = "select * from respuestaspreg where id=".$id;
			$resultados_respuestas = $this->query($select_respuestas);
		
			foreach($resultados_respuestas as $resu)
			{
			
				//print_r($resu);
				
			
			}
		}
		
		
	
	}



	function RespuestasPreguntas($idpregunta)
	{
	
	
		$select_respuestas = "select * from respuestaspreg where idpregunta=".$idpregunta." order by orden asc";
		$resultados_respuestas = $this->query($select_respuestas);	
		return($resultados_respuestas);
		
		
	
	}


	function insertarRespuesta($texto,$id_pregunta,$tipo_respuesta,$parametro)
	{
		$this->traerTopOrden($id_pregunta);
		$orden_top=$this->orden;
		$orden_top=$orden_top+1;
		if($tipo_respuesta=="select")
		{
			//insert a la tabla de respuestaspreg
			if($parametro==0)
			{
			$insert_query="insert into respuestaspreg (texto,idtipo,orden,idpadre,idpregunta) select '".$texto."',4,".$orden_top.",".$id_pregunta.",".$id_pregunta;
			}
			else
			{
				
				$select_padre = "select 1 as valor from respuestaspreg where idpregunta=".$id_pregunta." and idpadre is null";
				echo $select_padre;
				$resultado = $this->query($select_padre);
				$valor = $resultado[0]['valor'];
				if($valor!=1)
				{
				
					$insert_query="insert into respuestaspreg (texto,idtipo,orden,idpregunta) select '".$texto."',4,".$orden_top.",".$id_pregunta;
				}
			}

			$this->query($insert_query);

			
		}
		
		if($tipo_respuesta=="check")
		{
			$orden=1;//A reemplazar por un "select orden from respuestaspreg where idpregunta..."
			if($parametro)
				$parametro='especificar';
			else
				$parametro='';

			$insert_query="insert into respuestaspreg (texto,idtipo,orden,idpregunta,estado) select '".$texto."',2,".$orden_top.",".$id_pregunta.",'".$parametro."'";
			echo $insert_query."<br>";
			$this->query($insert_query);
		}
		
		if($tipo_respuesta=="text")
		{
			$orden=1;//A reemplazar por un "select orden from respuestaspreg where idpregunta..."

			$insert_query="insert into respuestaspreg (texto,idtipo,orden,idpregunta) select '".$texto."',1,".$orden_top.",".$id_pregunta."";
			echo $insert_query."<br>";
			$this->query($insert_query);
		}
		if($tipo_respuesta=="area")
		{
			$orden=1;//A reemplazar por un "select orden from respuestaspreg where idpregunta..."

			$insert_query="insert into respuestaspreg (texto,idtipo,orden,idpregunta) select '".$texto."',6,".$orden_top.",".$id_pregunta."";
			echo $insert_query."<br>";
			$this->query($insert_query);
		}
		
		
	}




	function traerTopOrden($id_pregunta)
	{
		$top_orden= "select orden from respuestaspreg where idpregunta=".$id_pregunta." order by orden desc limit 1";
		$ordencito=$this->query($top_orden);
		
		$this->orden=$ordencito[0]['orden'];
		if(count($ordencito)==0) $this->orden=0;
	}


}
?>