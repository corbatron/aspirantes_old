<?
require('coneccion.php');
require('class.alumnosFormularios.php');

$array_respuestas = $_REQUEST;
session_start();


//echo $_SESSION['id'];

$id_alumno = $_SESSION['id'];

$alumno_form = new alumnosFormularios($id_alumno);






//Array for MongoDB log
$date = new DateTime();
$date->setTimezone(new DateTimeZone('America/Argentina/Buenos_Aires'));
$arrayMongoLog["date_system"] = $date->format('Y/m/d H:i:s P T');
$arrayMongoLog[	"user"] = trim($_SESSION['id']);
$arrayMongoLog[	"author"] = trim($_SESSION['id']);
$arrayMongoLog[	"date_user"] = $date->format('Y/m/d H:i:s P T');
$arrayMongoLog[	"origin"] = "SIT FORMS MODULE";
$arrayMongoLog[	"description"] = "El instrumento ".$alumno_form->get_descripcion($_REQUEST['formulario'])." fue completado";

//$arrayMongoJson['json'] = json_encode($arrayMongoLog);	

require('class.seguimiento.php');
$mongo = new Seguimiento();
//$mongo->save($arrayMongoJson);
$mongo->savePM($arrayMongoLog);

//








$id_formulario = $_REQUEST['formulario'];
$array_preguntas_formulario = devolver_preguntas_formulario($_REQUEST['formulario']);


if($_REQUEST['plan_de_carrera']=="plan_de_carrera")
{
    foreach($_REQUEST as $request=>$c){
        if(substr($request, 0,2)=="ch"){
            $cont++;
            $array_materia = explode("_",$request);
            $array_total[$cont]['materias'] = $array_materia[1];
            $array_total[$cont]['parcial_1'] = $_REQUEST['p1_'.$array_materia[1]];
            $array_total[$cont]['parcial_2'] = $_REQUEST['p2_'.$array_materia[1]];
            $array_total[$cont]['parcial_3'] = $_REQUEST['p3_'.$array_materia[1]];
            $array_total[$cont]['llamado'] = $_REQUEST['planificacion_'.$array_materia[1]];
        }elseif(substr($request, 0,strlen('materias_prox_'))=="materias_prox_"){
            $cont2++;
            $array_materia_prox = explode("_",$request);
            $array_total_2[$cont2]['materia'] = $_REQUEST[$request]; 
            $array_total_2[$cont2]['dia'] = $_REQUEST['optionsRadios'.$array_materia_prox[2]]; 
            
        }
        
        
    }
	include("class.carreras.php");
	$paraGrabar = new Carreras();
	$paraGrabar->grabarPPC($id_formulario,$id_alumno,  serialize($array_total),serialize($array_total_2));	
	
	$alumno_form->formularioCerrar($id_formulario);
if($_REQUEST['from']=="drawingBootstrap"){
	echo "&nbsp;<script>top.location.href='main.php';</script>";

}
//index_form
	echo "&nbsp;<script>top.location.href='main.php';</script>";
	exit();
}
if($_REQUEST['agenda']!="")
{

	print_r($_REQUEST);
	echo "<br>";
	for($i=0;$i<19;$i++)
	{
		for($v1=1;$v1<8;$v1++)
		{
			//echo "i_".$i."_".$v1;
			

			if(isset($_REQUEST['i_'.$i."_".$v1]))
			{
				$valor = $_REQUEST['i_'.$i."_".$v1];
			}
			else
			{
				$valor = 1;
			}
			$alumno_form->insertarAgenda($v1,$i,$valor,$id_formulario);
			
			echo "&nbsp;";
		}
		echo "<br>";
	}

	//$id_formu = $_REQUEST['formulario'];
	$alumno_form->formularioCerrar($id_formulario);
if($_REQUEST['from']=="drawingBootstrap"){
	echo "&nbsp;<script>top.location.href='main.php';</script>";
exit();
}
//index_form
	echo "&nbsp;<script>top.location.href='main.php';</script>";
	exit();
}


foreach($array_preguntas_formulario as $id_preg_form)
{

//echo $id_preg_form['id_pregunta'];
//echo "<br>";

	$valor_existe = 0;

	/*echo "<pre>";
	print_R($array_respuestas);
	echo "</pre>";

echo "---------";
	echo "<pre>";
	print_R($id_preg_form);
	echo "</pre>";*/

	if($id_preg_form['id_pregunta']==155) continue 1;
	foreach($array_respuestas as $res1=>$val1)
	{	

		if($res1!="formulario" && $res1!="PHPSESSID")
		{

			$id_pregunta_respuesta=devolver_id_pregunta($res1);
			if($id_pregunta_respuesta == $id_preg_form['id_pregunta'])
			{
				$valor_existe = 1;

				if($val1=="")
				{
					echo "&nbsp;<script>alert(' Debe cargar la pregunta: ".select_texto_pregunta($id_preg_form['id_pregunta'])."');</script>";
					exit();
				}

			}


		}
	}
	if($valor_existe == 0)
	{
		
		//echo $id_preg_form['id_pregunta'];
		//echo " ".select_texto_pregunta($id_preg_form['id_pregunta']);
		echo "&nbsp;<script>alert(' Debe cargar la pregunta: ".select_texto_pregunta($id_preg_form['id_pregunta'])."');</script>";
		//echo "<br>";
		exit();
	
	}

}

	

foreach($array_respuestas as $respuesta=>$valor)
{

$array_respuesta = split("_",$respuesta);

//print_r($array_respuesta);
	if(count($array_respuesta)==2)
	{
		echo $array_respuesta[1]." radio: ".$valor;
	}
	else
	{	
		if($respuesta!="formulario" && $respuesta!="PHPSESSID")
		{
			echo $respuesta." otro: ".$valor;
            $alumno_form->insertarRespuestas($respuesta,$valor,$_REQUEST['formulario']);
            
		}
	}

echo "<br>";

}

$id_formu = $_REQUEST['formulario'];

$alumno_form->formularioCerrar($id_formu);
if($_REQUEST['from']=="drawingBootstrap"){
	echo "&nbsp;<script>top.location.href='main.php';</script>";

}
//index_forms
echo "&nbsp;<script>top.location.href='main.php';</script>";


function devolver_id_pregunta($id_respuesta)
{
	
	$cone = new Coneccion();
	$select_devolver_preguntas = " select idpregunta from respuestaspreg where id=".$id_respuesta;
	$resultados_coneccion = $cone->query($select_devolver_preguntas);
	$id_pregunta = $resultados_coneccion[0]['idpregunta'];
	
	return $id_pregunta;

}

function devolver_preguntas_formulario($id_formulario)
{

	$cone = new Coneccion();
	$select_devolver_preguntas_formulario = " select distinct id_pregunta from preguntasform pf inner join respuestaspreg rpreg on pf.id_pregunta=rpreg.idpregunta
	where id_formulario = ".$id_formulario." and pf.obligatoria = 1 and pf.estado =1 and (rpreg.idtipo <> 4 and rpreg.idtipo <> 7) ";
	$array_preguntas_formulario = $cone->query($select_devolver_preguntas_formulario);
	return $array_preguntas_formulario;

}

function select_texto_pregunta($id_pregunta)
{	
	$cone = new Coneccion();
	$query_texto_pregunta = "select texto from preguntas where idpregunta=".$id_pregunta;
	$resultados_preguntas = $cone->query($query_texto_pregunta);
	return $resultados_preguntas[0]['texto'];
}
?>
