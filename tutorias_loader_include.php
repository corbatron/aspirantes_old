<?php
require_once ("../aspirantes/excel/Classes/PHPExcel/IOFactory.php");

//$alumno = new Alumno();

//print_r($_REQUEST);
//print_r($_FILES);



if($_REQUEST['guardar']=='guardar')
{
 include("coneccion.php");
 
 include("class.alumnos.php");
 $alumno = new Alumno();
 
$excel_identificadores = $_REQUEST['check'];    

$carrera = $_POST['carreras'];

foreach($excel_identificadores as $identificador)
{
    
    $array_documentos[$identificador]=1;
    
}

$array_excel = $_POST['array_excel'];
$array_excel = unserialize($array_excel);


foreach($array_excel as $clave=>$excel_position)
{
	

    
    if($array_documentos[$excel_position[$clave]['D']]==1)
    {
	if($excel_position[$row]['F']=="")$excel_position[$row]['F']='0';

        $alumno->insertar_alumno_cuatrimestre($excel_position[$clave][C],$excel_position[$clave][B],$excel_position[$clave][D],$excel_position[$clave]['E'],'',$carrera,$excel_position[$clave]['F']);
		echo "OK";
		echo "<br>";
                
    }

    
}

exit();
}

if(move_uploaded_file($_FILES['archivo']['tmp_name'],'../aspirantes/logs/temporal.xls'))
{
}
else {
exit();
}

$inputFileType = 'Excel2007';
$inputFileName = '../aspirantes/logs/temporal.xls';

$inputFileType = PHPExcel_IOFactory::identify($inputFileName);  
$objReader = PHPExcel_IOFactory::createReader($inputFileType);  
$objReader->setReadDataOnly(true);  
/**  Load $inputFileName to a PHPExcel Object  **/  
$objPHPExcel = $objReader->load($inputFileName);  
$total_sheets=$objPHPExcel->getSheetCount(); // here 4  
$allSheetName=$objPHPExcel->getSheetNames(); // array ([0]=>'student',[1]=>'teacher',[2]=>'school',[3]=>'college')  
$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
$highestRow = $objWorksheet->getHighestRow();
$highestColumn = $objWorksheet->getHighestColumn();

$headingsArray = $objWorksheet->rangeToArray('A1:'.$highestColumn.'1',null, true, true, true);
$headingsArray = $headingsArray[1];

$r = -1;
$namedDataArray = array();

?>
<style>

*
{
	border: 0;
	margin: 0;
	padding: 0;
}

table 
{
	text-align: left;
	border-spacing: 0px;
	border: 1px solid #aeb3b6;
	border-collapse: collapse;
	width:100%;
}


table a, table, tbody, tfoot, tr, th, td 
{
   font-family: Arial, Helvetica, sans-serif;
	line-height: 2.0em;
	font-size: 13px;
	color: #55595c;
}
tbody td{
	line-height: 2.5em;
}

table caption
{
	padding: .4em 0 ;
	font-size: 240%;
	font-style: normal;
	color: #FB7E00;
}

table a
{
	display: block;
	text-decoration: none;
	color: #FF8E53;
	padding-right: 1.5em;
	
}

table a:hover, table a:focus
{
text-decoration: underline;
}

table th a
{
	color: #FF8E53;
	text-align: right;
}
table .odd th a,table .odd td a,table .odd td{
	color: #666;
	padding-right: 1.0 em;
}

table th a:hover, table th a:focus, tbody tr:hover th
{   
   background-color: #FFCC99;
	color: #fff !important;
}
table .odd th,table .odd td{
	background-color: #DDDDDD;
}

thead th
{
	background-image: url(images/verlauf_schwarz.gif);
	text-transform: uppercase;
	font-weight: normal;
	letter-spacing: 1px;
	color: #fff;
	
}
tfoot{
	background-image: url(images/verlauf_schwarz.gif);
	border-top: 1px solid #fff;
	
	
}
tfoot th,tfoot td{
	color: #fff;
}

tbody th
{
   padding-right: 1.0em;
	color: #25c1e2;
	font-style: normal;
	background-color: #fff;
	border-bottom: 1px dotted #aeb3b6;
}

td
{
   color: #FF8E1C;
	border-bottom: 1px dotted #aeb3b6;
	padding-right: 0.5em;
	
}

tbody tr.odd
{
	border-bottom: 1px dotted #aeb3b6;
}

tbody tr:hover td
{
  background-color: #FFCC99;
}

tbody tr:hover td,tbody tr:hover th, tbody tr:hover a
{
	color: #fff !important;
}
    
    
</style>

<?
echo "<div id='div_errores'></div>";
echo "<form method='POST'>";
echo "<table>";
echo "<thead><tr><th scope='col'>seleccione</th><th scope='col'>APELLIDO</th><th scope='col'>NOMBRE</th><th scope='col' >DOCUMENTO</th><th scope='col' >EMAIL</th><th scope='col' >Cuatrimestre</th></tr></thead>";
echo "<tbody>";
for ($row = 4; $row <= $highestRow; ++$row) {
    $dataRow = $objWorksheet->rangeToArray('A'.$row.':'.$highestColumn.$row,null, true, true, true);
    $row_general[$row] = $dataRow;
    if($dataRow[$row]['B']=="" || $dataRow[$row]['C']=="" || $dataRow[$row]['D']=="" || $dataRow[$row]['E']=="" )
    {
      echo "<tr><td colspan='5'>ERROR - verifique la fila ".$row."</td></tr>";
      $color = '"red"';
      echo "<script>document.getElementById('div_errores').innerHTML='<font color=".$color.">SE ENCONTRARON ERRORES, Verifique la tabla</font>';</script>";
    }
 else {
     echo "<script>document.getElementById('div_errores').innerHTML='';</script>";
    echo "<tr>";
    echo "<td>";
    echo "<input type='checkbox'checked='checked' name='check[]' value='".$dataRow[$row]['D']."'>";
    echo "</td>";
    echo "<td>";
    echo $dataRow[$row]['B'];
    echo "</td>";
    echo "<td>";
    echo $dataRow[$row]['C'];
    echo "</td>";
    echo "<td>";
    echo $dataRow[$row]['D'];
    echo "</td>";
    echo "<td>";
    echo $dataRow[$row]['E'];
    echo "</td>";
    echo "<td>";
	if($dataRow[$row]['F']=="")$dataRow[$row]['F']=0;
    echo $dataRow[$row]['F'];
    echo "</td>";
    echo "</tr>";
 }
 
}
echo "<tr><td colspan='6'><input  type='hidden' name='array_excel' id='array_excel' value='".serialize($row_general)."'></input></td></tr>";
echo "<tr><td colspan='6' align='center'><input type='button' value='Guardar' onclick='submit();'/></td></tr>";
echo "</tbody>";
echo "</table>";
echo "<br>";
echo "<input type='hidden' name='guardar' value='guardar'></input>";
echo "<br>";
echo "<input type='hidden' name='carreras' value='".$_REQUEST['id_carrera']."'></input>";
echo "</form>";



?>
