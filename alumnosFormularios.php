<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<!-- Bootstrap core CSS -->
			<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
			<style>
				body { padding-top: 20px; }
			</style>
	</head>
	<body>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">

<?
include('ver_login.php');
include('class.form.php');
include('class.alumnos.php');
include('class.alumnosFormularios.php');
$id_alumno = $_SESSION['id']; 
$alumno = new Alumno($id_alumno);
$formularios = new alumnosFormularios($id_alumno);
session_start();
$formu=$formularios->traerForms();
$directorio = $_SERVER['HTTP_HOST']."/aspirantes";
//Encabezado con los datos personales 

?>

<div class="row clearfix">
    <div class="col-md-6 column">
        <h4>
            Nombre y apellido: <? echo $alumno->get_nombre().", ".$alumno->get_apellido(); ?>
        </h4>
    </div>

    <div class="col-md-6 column">
        <h4 class="text-right">
            DNI: <? echo $alumno->get_id(); ?>
        </h4>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Formularios asignados</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
<?


foreach($formu as $form){
	if($form['campo_magico'] == "" && $form['fecha_realizacion'] != "") {
		session_start();
		exec("sudo -u www-data /usr/bin/php /var/www/html/aspirantes/batch.php ".trim($alumno->get_id())." ".trim($form['idform'])." ".trim($form['lugar_reporte'])." ".trim($_SESSION['nombre_base'])." ".trim($_SESSION['id_carrera']));
	}
 }
$formu=$formularios->traerForms();




	$cont=0;

foreach($formu as $form){
	$clase="";
	if( $form[2] == "0000-00-00" or $form[2] == ""){
		$clase="success";
	}
	echo "<tr class='".$clase."'><td>";
	echo $formularios->get_descripcion($form[0]);
	echo "</td><td>";
	echo $tablerow;
	if( $form[2] == "0000-00-00" or $form[2] == ""){
		echo '<button type="button" class="btn btn-link" data-form="'.$form[0].'">A completar</button>';
		$cont++;
	}else{
                if($form['campo_magico']=="OP") $form['campo_magico']="Orientaci&oacute;n Parcial";
                if($form['campo_magico']=="T") $form['campo_magico']="Orientaci&oacute;n Total";
                if($form['campo_magico']=="D") $form['campo_magico']="Desorientaci&oacute;n";
				$cont++;

                
                
		echo 'Completado el d&iacute;a &nbsp;'.$form[2].' / resultado:&nbsp;'.$form['campo_magico'] ;
	}
	echo "</tr>";
}
if($cont==0){
?>
			<tr><td colspan="3" align="center">Usted no tiene instrumentos asignados en este momento, por favor comun&iacute;quese con la oficina de Tutor&iacute;as</button></td></tr>

<?
}
?>
			<tr><td colspan="3" align="center"><button type="button" class="btn btn-link" data-target="#bugModal" data-toggle="modal">&iquest;Tiene alg&uacute;n inconveniente? Rep&oacute;rtelo haciendo click aqu&iacute;!!</button></td></tr>
         <?   

include("bugForm.php");
           

?>
     </tbody>
            </table>
        </div>
    </div>
</div>



		</div>
	</div>
</div>
	

        <script src="bootstrap/js/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="bootstrap/js/jquery.min.js"><\/script>')</script> 
        <script src="bootstrap/dist/js/bootstrap.min.js"></script> 
<script>
$(document).ready(function () {
        var dataform = document.querySelectorAll('[data-form]');
        for(var i = 0; i < dataform.length ; i++){
            document.querySelectorAll('[data-form]').item(i).addEventListener("click",function(){
		//$('#iframe_1').attr("src","formBuilder.php?formulario="+this.dataset.form);
            
			window.location.href = "formBuilder.php?formulario="+this.dataset.form;
		},false);
        }
});
</script>
	</body>
</html>

