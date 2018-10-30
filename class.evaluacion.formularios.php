<?php
require_once('coneccion.php');
class evaluacionFormularios extends Coneccion{

function evaluacionFormularios()
{
	$this->coneccion();
}

function calcular_valores_agenda($horas_trabajo,$horas_osio,$horas_estudio,$horas_estudio_facultad)
{

	/*//echo $horas_trabajo;
	//echo "<br>";
	//echo $horas_osio;
	//echo "<br>";
	//echo $horas_estudio;
	//echo "<br>";
	//echo $horas_estudio_facultad;*/
	$valores_agenda['general'] = (($horas_estudio + $horas_estudio_facultad) / ($horas_trabajo + $horas_osio));
	$valores_agenda['equilibrio_estudio'] = ($horas_estudio / $horas_estudio_facultad);
	$valores_agenda['equilibrio_personal'] = ($horas_trabajo / $horas_osio);
	
	return $valores_agenda;

}


function calcular_valores_orientacion($formulario,$alumno)
{

$pregunta_clave= 6;
///encuesta de orientacion de TSP

if(($formulario == 28 && $_SESSION['nombre_base']==2012) || ($formulario == 25 && $_SESSION['nombre_base']>=2013) ){ $pregunta_clave = 140; }
///TSA
if($formulario == 28 && $_SESSION['nombre_base']>=2013 ) { $pregunta_clave = 141; }
//TSMMM
if($formulario == 32 ) { $pregunta_clave = 66; }

	$query_respuestas_valores="select * from (SELECT *,cr.idpregunta as milanga,ra.idrespuesta as resp FROM respuestaalumno ra inner join categoriasrespuestas
 cr on ra.idrespuesta = cr.idrespuesta inner join causas causa on causa.id = cr.causas
  where codform ='$formulario' and idalumno='$alumno' and valor='1'
union all
SELECT *,cr.idpregunta as milanga,ra.idrespuesta as resp FROM respuestaalumno ra inner join categoriasrespuestas
 cr on cast(ra.valor as integer) = cr.idrespuesta inner join causas causa on causa.id = cr.causas
  where codform ='$formulario' and idalumno='$alumno' and (select (valor ~ '^[0-9]+$' )) and cr.idpregunta = ".$pregunta_clave." 
)xx order by milanga asc";

   // echo $query_respuestas_valores;

	$valores = $this->query($query_respuestas_valores);
$vBanderita=0;


	foreach($valores as $x=>$valor){

		if($formulario == 28 && $_SESSION['nombre_base']>=2013 )
		{
			if($valor['idpregunta']==141){
				if($valor['idrespuesta'] == 513) return "D";

			}
		}

		if($formulario == 32)
		{
			if($valor['idpregunta']==66){
				if($valor['idrespuesta'] == 139) return "D";
				//if($valor['idrespuesta'] == 505) return "OP";
				//if($valor['idrespuesta'] == 504) return "T";

			}


		}
		if($formulario == 25)
		{
			if($valor['idpregunta']==140){
				if($valor['idrespuesta'] == 506) return "D";
				//if($valor['idrespuesta'] == 505) return "OP";
				//if($valor['idrespuesta'] == 504) return "T";

			}


		}
		if($valor['idpregunta']==6)
		{
			$vBanderita=1;
			$valor1= $valor['valor'];
			$carrera = "select * from respuestaspreg where id=".$valor1."";
			

			$array_resultado_carrera = $this->query($carrera);
			
			$carrera = $array_resultado_carrera[0]['id'];
			
			if($carrera =="49")
			{
				return "PASE";
			}	
			if($carrera=="97")
			{
				return "D";
			}
			$select_carreras = "select * from respuestascarreras where id_respuesta=".$carrera."";
			$resultados_carreras = $this->query($select_carreras);
	
		}else{
				
			$array_valores[$valor['milanga']][$valor['resp']][$valor['causa']]+=1;
		}


		
	
	
	}

	if($vBanderita == 0)
		$resultados_carreras[0]['id_carrera']=33887;


	if(($formulario == 28 && $_SESSION['nombre_base']==2012) || ($formulario == 25 && $_SESSION['nombre_base']>=2013 ))
		$resultados_carreras[0]['id_carrera']=27265;

	if($formulario == 28 && $_SESSION['nombre_base']>=2013 )  //si es la enc. de orientacion de TSP
		$resultados_carreras[0]['id_carrera']=27555;

	if($formulario == 32) $resultados_carreras[0]['id_carrera']=35580;


	$cantidad = 0;

	foreach($array_valores as $arra_val)
	{
		
		foreach($arra_val as $val)
		{

			
		    $cantidad = $cantidad + 1;
			
			$carre = $resultados_carreras[0]['id_carrera'];
			if($val[$carre]=="1" ) 
			{
				$valor_total = $valor_total + 1;
			}
			else
			{
				//$valor_total = $valor_total - 1;
			}
		
		}
	
	}
	



if((($valor_total * 100)/$cantidad)>55)
{
	return "T";// - $valor_total - $cantidad";
}
elseif((($valor_total * 100)/$cantidad)>45)
{
	return "OP";
}
else
{
	return "D";
}
	
	
	
		
		
		

	//return "<img src='http://elsibaritaurbano.com/wp-content/uploads/2011/02/under-construction.gif'><br><h1>Este instrumento se encuentra en desarrollo</h1><br>";
/*
select * from (

SELECT *,cr.idpregunta as milanga FROM respuestaalumno ra inner join categoriasrespuestas
 cr on ra.idrespuesta = cr.idrespuesta
 inner join causas causa on causa.id = cr.causas
  where codform ='1' and idalumno='26200201'
union all
SELECT *,cr.idpregunta as milanga FROM respuestaalumno ra inner join categoriasrespuestas
 cr on cast(ra.valor as integer) = cr.idrespuesta
 inner join causas causa on causa.id = cr.causas
  where codform ='1' and idalumno='26200201' and valor not ilike '%Otra%' and valor not ilike ''

)xx   order by milanga asc

*/



}

function actualizar_alumnoform($id_formulario,$id_alumno,$valor_respuesta)
{
	
		
		$query_update = "update alumnoform set campo_magico='".$valor_respuesta."' where idalumno='".$id_alumno."' and idform=".$id_formulario." and campo_magico is null";
		$this->query($query_update);


}


function calcular_foda($id_formulario,$id_alumno)
{

	$query_select="SELECT * FROM respuestaalumno ra  
inner join respuestaspreg resp on resp.id=ra.idrespuesta 
where (codform ='$id_formulario' and idalumno='$id_alumno')
union all
SELECT * FROM respuestaalumno ra  
inner join respuestaspreg resp on (resp.id=cast(valor as integer) and codform ='$id_formulario') 
where codform ='$id_formulario' and idalumno='$id_alumno' 
 and (select (valor ~ '^[0-9]+$' )) and valor <> '1'";


$resultado = $this->query($query_select);
$valor_negativo = 0;
foreach($resultado as $resval)
{

	if($resval['categorizacion']=="1")
	{
		$valor_bien = $valor_bien + 1;
	}
	elseif($resval['categorizacion']=="2")
	{
		$valor_negativo = $valor_negativo + 1;
	}


}


if(($valor_bien / $valor_negativo)>1 || ($valor_negativo==0))
	{
		return "+";
	}
	elseif(($valor_bien / $valor_negativo)<1)
	{
		return "-";
	}
	if(($valor_bien/$valor_negativo)==1)
	{
		return "NEUTRO";
	}

}

function calcular_encuesta_inicial($id_formulario,$id_alumno)
{

	$query_select="SELECT * FROM respuestaalumno ra  
inner join respuestaspreg resp on resp.id=ra.idrespuesta 
where (codform ='$id_formulario' and idalumno='$id_alumno')
union all
SELECT * FROM respuestaalumno ra  
inner join respuestaspreg resp on (resp.id=cast(valor as integer) and codform ='$id_formulario') 
where codform ='$id_formulario' and idalumno='$id_alumno' 
 and (select (valor ~ '^[0-9]+$' )) and valor <> '1'";


$resultado = $this->query($query_select);


foreach($resultado as $resu)
{
	if($resu['texto']!="Otro"){
	
		$array_resu[$resu[7]][$resu['categorizacion']]=$array_resu[$resu[7]][$resu['categorizacion']]+1;
	}
}

if($array_resu[102]['2']==4)
{
	$array_resu[102]['2']="0";
}

$ciento1_ciento2plus  = $array_resu[101]['1'];
$ciento1_ciento2minus = $array_resu[101]['2'] + $array_resu[102]['2'];
if($ciento1_ciento2plus>$ciento1_ciento2minus)
{
	$valo1 = "+";
}
elseif($ciento1_ciento2plus>$ciento1_ciento2minus)
{
	$valo1 = "NEUTRO";
}
elseif($ciento1_ciento2plus<$ciento1_ciento2minus)
{
	$valo1 = "-";
}

//no agrupadas
$salud="NEUTRO";
$ciento3 = $array_resu[103][2];
if($ciento3>=1) 
	$salud="-";


$viaje="NEUTRO";
if($array_resu[104][1]>$array_resu[104][2])
{
	$viaje="+";
}
elseif($array_resu[104][1]<$array_resu[104][2])
{
	$viaje="-";
}


$ciento76pos=$array_resu[106]['1']+$array_resu[107]['1'];
$ciento76neg=$array_resu[106]['2']+$array_resu[107]['2'];
if($ciento76pos>$ciento76neg)
{
	$trabajo="+";
}
elseif($ciento76pos==$ciento76neg)
{
	$trabajo="NEUTRO";
}
else
{
	$trabajo="-";
}

$ciento8910pos=$array_resu[108]['1']+$array_resu[109]['1']+$array_resu[110]['1'];
$ciento8910neg=$array_resu[108]['2']+$array_resu[109]['2']+$array_resu[110]['2'];
if($ciento8910pos>$ciento8910neg)
{
	$estudio="+";
}else{
	$estudio="-";
}


 $array_encuesta_inicial['convivencia']=$valo1;
 $array_encuesta_inicial['salud']=$salud;
 $array_encuesta_inicial['viaje']=$viaje;
 $array_encuesta_inicial['trabajo']=$trabajo;
 $array_encuesta_inicial['estudio']=$estudio;
 //$array_encuesta_inicial['segurida']=$valo1;
 

	return $array_encuesta_inicial;

}



}	

?>