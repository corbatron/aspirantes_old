<?
include("ver_login.php");
include('coneccion.php');
$conexion = new Coneccion();

if($_REQUEST['usuario']!="tito puente")
{
	exit();
}


$_REQUEST['query_ex'] = strtoupper($_REQUEST['query_ex']);

$_REQUEST['query_ex'] = str_replace("DELETE","manzana",$_REQUEST['query_ex']);
$_REQUEST['query_ex'] = str_replace("TRUNCATE","hinojo",$_REQUEST['query_ex']);
$_REQUEST['query_ex'] = str_replace("DROP","pure_de_zapallo",$_REQUEST['query_ex']);
$_REQUEST['query_ex'] = str_replace("INSERT","GOKU",$_REQUEST['query_ex']);

$query = $conexion->query($_REQUEST['query_ex']);






echo '<table border="0" cellpadding="3" cellspacing="3" width="100%" ><tr>';
foreach($query[0] as $key => $columna)
	if(!is_int($key)) echo '<th>'.$key.'</th>';

$color2="#CCCCCC";
$color1="#CCCCEE";
$color=$color1;

	
foreach($query as $resultado){
	if($color==$color1){$color=$color2;}else{$color=$color1;}
	echo '<tr>';
	foreach($resultado as $key => $columna){
		if(!is_int($key)) echo '<td bgcolor="'.$color.'">'.$columna.'</td>';
	}
	echo '</tr>';
}
echo '</tr></table>';
?>