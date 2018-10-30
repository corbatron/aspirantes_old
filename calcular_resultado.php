<?
//select * from alumnoform where idalumno like '36624344%'

$cont=0
foreach($formularios_alumno as $single_form)
{
	if($single_form['campo_magico']="T")
		$cont++;
	elseif($single_form['campo_magico']="OP")
		$cont--;
	
	

	if($single_form['campo_magico']="+")
		$cont++;
	elseif($single_form['campo_magico']="-")
		$cont--;
	//valores del 1 instrumento T D OP
	//valores del 2,3 y 4 instrumento + - N
	

}

if($cont==4)
	$riesgo="Nulo";//tiene todo bien

if($cont==-4)
	$riesgo="Alto";//tiene todo mal


?>