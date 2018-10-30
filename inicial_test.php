<?php

require_once('class.evaluacion.formularios.php');

$e = new EvaluacionFormularios();
$documento = $_GET['dni'];

$inicial = $e->calcular_encuesta_inicial(18,$documento);

echo "<pre>";
print_r($inicial);
echo "</pre>";
echo "<br>";
echo "Resultado";
echo "<br>";
$cont1=0;
$cont2=0;
echo $cont1." vs ".$cont2;


        foreach($inicial as $crazy)
        {
		
                if($crazy=="+")
                {
                        $cont1++;
                }
                elseif($crazy=="-")
                {
		
                        $cont2++;
                }
        }
echo $cont1." vs ".$cont2;

        if($cont1>$cont2)
        {
                $valor_regular="+";
        }elseif($cont1<$cont2){
                $valor_regular="-";
        }else{
                $valor_regular="NEUTRO";
        }






echo $valor_regular;
echo "<br>";

?>
