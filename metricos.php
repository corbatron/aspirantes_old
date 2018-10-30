<!DOCTYPE html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
</head>
<?php

session_start();




require_once("coneccion.php");




for ($i = 2012; $i <= 2016; $i++) {
    $_SESSION['nombre_base'] = $i;
    $_SESSION['id'] = $i;


    $con = new Coneccion();


    

    $resultados = $con->query("select valor,idrespuesta,codform from respuestaalumno where codform='21' and idalumno in (select dni from alumnos where trim(dni)!='')");


       $respuestas = $con->query("select * from respuestaspreg ");
	



    $preguntas_select = $con->query("select * from respuestaspreg where idtipo=4");

    $preguntas= $con->query("select * from preguntas");
	foreach($preguntas as $pregunta)
		$array_preguntas[$pregunta['idpregunta']]=$pregunta['texto'];



  
  foreach ($resultados as $resultado) {
	if(!strstr($resultado[0],'Otr') && !strstr($resultado[0],'ingun') && !strstr($resultado[0],'Nada') && !strstr($resultado[0],'nada')){
		foreach ($respuestas as $resp){
			if($resp['id']==$resultado[1]){
				if(!is_numeric($resultado[0]))
					//$resumen[$i][$array_preguntas[$resp['idpregunta']]][$resp['texto']].=$resultado[0];					
					$resumen[$i][$array_preguntas[$resp['idpregunta']]][$resp['texto']].=$resultado[0]."<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				else
					if($resultado[0]==1)
						if($resumen[$i][$array_preguntas[$resp['idpregunta']]][$resp['texto']]=="")
							$resumen[$i][$array_preguntas[$resp['idpregunta']]][$resp['texto']]=1;
						else
							$resumen[$i][$array_preguntas[$resp['idpregunta']]][$resp['texto']]++;
					else{
						
						foreach($preguntas_select as $select){
							if($resultado[0]==$select['id']){
								if($resumen[$i][$array_preguntas[$select['idpadre']]][$select['texto']]==="") 
									$resumen[$i][$array_preguntas[$select['idpadre']]][$select['texto']]=0;
								else
							       		$resumen[$i][$array_preguntas[$select['idpadre']]][$select['texto']]=$resumen[$i][$array_preguntas[$select['idpadre']]][$select['texto']]+1;	
							}
						}



					}



				}
		}



	}	

       
    }



echo "<pre>";
print_r($resumen);
echo "</pre>";
    




}
?>
