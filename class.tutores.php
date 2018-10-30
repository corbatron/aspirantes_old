<?php
require_once('coneccion.php');
class Tutores extends Coneccion{

function Tutores()
{
	$this->coneccion();
}





	function insertar_tutor($nombre,$apellido,$dni)
	{


		$nombre = str_replace("'","",$nombre);
		$apellido = str_replace("'","",$apellido);

		$query_insert="insert into alumnos (apellido,nombre,dni,perfil,password) values ('".$apellido."','".$nombre."','".$dni."',3,'".$dni."');";
		

		
		$resultado_insert = $this->query($query_insert);
		
	}


function obtener_tutores($id)
{

	$query_select="select id,nombre,apellido from alumnos where (TRIM(dni)='".trim($id)."' OR '".trim($id)."'='') and (perfil=3 or perfil=2) order by nombre asc";
	$resultados_query = $this->query($query_select);
	return $resultados_query;
	
}


function actualizar_tutores($id_tutor,$alumno)
{
	$update_alumnos="update alumnos set id_tutor=".$id_tutor." where trim(dni)='".trim($alumno)."'";
	$resultados_query = $this->query($update_alumnos);
	return $resultados_query;
	
}

function grabar_percepcion($id_tutor,$alumno,$numero,$fecha,$texto,$percepcion,$tipo,$texto2,$entrevista)
{




	$query_delete="delete from percepcion where ( id_alumno=".$alumno." and numero_percepcion=".$numero.")";
	$resultados_query = $this->query($query_delete);

	if($entrevista=="true")
	{
		$entrevista = 1;
	}
	else
	{
		$entrevista = 0;
	}
//	echo $texto;
        $texto = str_replace("'", "", $texto);
        $texto2 = str_replace("'", "", $texto2);
        
	$insert_alumnos="INSERT INTO percepcion(id_tutor, id_alumno, numero_percepcion, fecha, texto,percepcion,tipo,texto2,espontanea) select ".$id_tutor.",".$alumno.",".$numero.",'".$fecha."','".$texto."',".$percepcion.",".$tipo.",'".$texto2."',".$entrevista;
//	echo $insert_alumnos;
	$resultados_query = $this->query($insert_alumnos);




session_start();
//Array for MongoDB log
$date = new DateTime();
$date->setTimezone(new DateTimeZone('America/Argentina/Buenos_Aires'));
$arrayMongoLog["date_system"] = $date->format('Y/m/d H:i:s P T');
$arrayMongoLog[	"user"] = trim($alumno);
$arrayMongoLog[	"author"] = trim($_SESSION['id']);
$arrayMongoLog[	"date_user"] = $date->format('Y/m/d H:i:s P T');
$arrayMongoLog[	"origin"] = "SIT PERCEPTION MODULE";
$arrayMongoLog[	"description"] = "La percepcion N ".$numero." fue ingresada";


require('class.seguimiento.php');
$mongo = new Seguimiento();
$mongo->savePM($arrayMongoLog);





	return $resultados_query;
	
}

function percepcion_alumno($id_alumno,$numero)
{
	$select_percepcion="select * from percepcion where (id_alumno=".$id_alumno." and numero_percepcion=".$numero.")";
	//echo $select_percepcion;
	//exit(1);
	$resultado_percepcion=$this->query($select_percepcion);
	return $resultado_percepcion;
}

function devolver_tutor($alumno)
{
	$select_tutor="select * from alumnos where trim(dni)='".trim($alumno)."'";
	$resultados_query = $this->query($select_tutor);
	return $resultados_query;
	
}

function borrar_problematica_alumno($alumno)
{

		$delete = "delete from problematicas_alumno where dni =".$alumno;
		$this->query($delete);

}

function problematica_alumno($alumno, $prob, $fecha, $vez)
{

	if($vez ==1){
		$delete = "delete from problematicas_alumno where dni =".$alumno;
		$this->query($delete);

session_start();
//Array for MongoDB log
$date = new DateTime();
$date->setTimezone(new DateTimeZone('America/Argentina/Buenos_Aires'));
$arrayMongoLog["date_system"] = $date->format('Y/m/d H:i:s P T');
$arrayMongoLog[	"user"] = trim($alumno);
$arrayMongoLog[	"author"] = trim($_SESSION['id']);
$arrayMongoLog[	"date_user"] = $date->format('Y/m/d H:i:s P T');
$arrayMongoLog[	"origin"] = "SIT PRBL MODULE";
$arrayMongoLog[	"description"] = "Problematicas ingresadas";

//$arrayMongoJson['json'] = json_encode($arrayMongoLog);	

require('class.seguimiento.php');
$mongo = new Seguimiento();
//$mongo->save($arrayMongoJson);
$mongo->savePM($arrayMongoLog);

//



	}
	//if($fecha == "") $fecha = "now()";
	$insert = "INSERT INTO problematicas_alumno(problematica, dni, fecha_baja) VALUES (".$prob.",".$alumno.",now())";
	$this->query($insert);



}

function traer_problematica($alumno)
{
	$select = "select problematica, fecha_baja from problematicas_alumno where dni =".$alumno;
	$var = $this->query($select);
	return $var;

}





}
?>