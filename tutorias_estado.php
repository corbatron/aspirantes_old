<form method="post" name="form">
<table width="50%" align="center">
    <tr>
        <td colspan="2">
            Actualizar estado:
            <br>
            Pegue aqu&iacute; los DNI separados por comas (,)
        <td>
        </td>
    <tr>
    <tr>
        <td colspan="2">
            <textarea cols="100" rows="10" name="registros"></textarea>
        </td>
    </tr>
    <tr>
        <td align="center"><input type="submit" name="si" value="Actualizar a ingres&oacute;"></td>
        <td align="center"><input type="submit" name="no" value="Actualizar a no ingres&oacute;"></td>
    </tr>
</table>
</form>
<?php

if(isset($_REQUEST['si'])){
    
    recorrer_registros($_REQUEST['registros'],1);
    
}elseif($_REQUEST['no']){
    
     recorrer_registros($_REQUEST['registros'],0);
    
}



function recorrer_registros($registro,$val){
require_once('coneccion.php');
include('class.alumnos.php');
   $registro = explode(",",$registro);
   foreach($registro as $reg){
        
        if($val==1){
	$dni = trim($reg);
	$alumno   = new Alumno($dni);
	$alumno->activar();
        }elseif($val==0){
        $dni = trim($reg);
	$alumno   = new Alumno($dni);
	$alumno->desactivar();
        }
   }
}
//32496765,32755392
?>