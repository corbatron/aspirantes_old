<?
include('ver_login.php');
require_once('coneccion.php');
include('class.form.php');
require_once("class.tutores.php");
include('class.alumnos.php');
include('class.carreras.php');
$tutor = new Tutores();

if($_REQUEST['accion']=="guardar")
{
$id_alumno = $_REQUEST['documento'];
$carrera = $_REQUEST['carrera'];
$tutor = $_REQUEST['tutor'];
$telefono = $_REQUEST['telefono'];
$celular = $_REQUEST['celular'];
$cuat = $_REQUEST['cuatrimestre'];

$al = new Alumno($id_alumno);
$al->modificar_carrera($carrera);
$al->modificar_tutor($tutor);
$al->modificar_telefono($telefono);
$al->modificar_celular($celular);
$al->modificar_cuatrimestre($cuat);
//echo "Se modifico la carrera con exito";
exit();


}
if($_REQUEST['accion']=="clave")
{

$id_alumno = $_REQUEST['documento'];
$carrera = $_REQUEST['carrera'];
$tutor = $_REQUEST['tutor'];
$al = new Alumno($id_alumno);
$al->modificar_clave();
//echo "Se modifico la carrera con exito";
exit();


}


?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<!-- Bootstrap core CSS -->
			<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
			<style>
				body { padding-top: 50px; }
			</style>
	</head>
	<body>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
<form class="form-horizontal" role="form"  name='form_alumnos' id='form_alumnos'>


<?php

$tutores = $tutor->obtener_tutores();
$alumno   = new Alumno(0);
$carreras = new Carreras();

$array_carreras_listado = $carreras->traer_carreras();
foreach($array_carreras_listado as $array_carrera)
{
	$arra_carreras.= "<option value='".$array_carrera['carr_id']."'>".$array_carrera['carr_descripcion']."</option>";
}

?>



				<div class="form-group">				 
					<label for="id_carrera_sele" class="col-sm-2 control-label">				
						Carrera
					</label>
					<div class="col-sm-5">
					<select name='carrera_seleccionada' id='id_carrera_sele' class='form-control'>
						<option value='0'>Todas</option>
						<? echo $arra_carreras; ?>
					</select>
					</div>
				</div>
				<div class="form-group"> 
					<label for="numero_docu" class="col-sm-2 control-label">
						Documento
					</label>
					<div class="col-sm-5">
						<input type='number'  class='form-control' maxlength='9' name='numero_docu' id='numero_docu' value='<? echo $_REQUEST['numero_docu']; ?>' />
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						 
						<button type="submit" class="btn btn-primary">
							Buscar
						</button>
					</div>
				</div>
				<input type='hidden' name='guardar' value='guardar'/>
			</form>
<?

if($_REQUEST['guardar']!="")
{

$id_carrera   = $_REQUEST['carrera_seleccionada'];
$documento    = $_REQUEST['numero_docu'];
$array_tutores = $tutor->obtener_tutores("");

?>

<table class="table table-bordered table-hover table-responsive">
	<thead>
		<tr>
			<th>Dni</th>
			<th>Nombre</th>
			<th>Apellido</th>
			<th>Correo electr&oacute;nico</th>
			<th>Tel&eacute;fono 1</th>
			<th>Tel&eacute;fono 2</th>
			<th>Carrera</th>
			<th>Cuatrimestre</th>
                        <th>Ingreso</th>
			<th>Tutor</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
<?
	$alumnos_mutantes = $alumno->traer_alumnos($id_instancia,$id_carrera,$documento);

	foreach($alumnos_mutantes as $mutar){

?>
		<tr>
			<td><? echo trim($mutar['dni']);?></td>
			<td><? echo $mutar['nombre'];?></td>
			<td><? echo $mutar['apellido'];?></td>
			<td><? echo "<a href='mailto:".$mutar['mail']."&subject=Tutorias'>".$mutar['mail']."</a>"; ?></td>
			<td><input class="form-control" id="tel1_<? echo trim($mutar['dni']);?>" value="<? echo $mutar['tel_linea']; ?>"/></td>
			<td><input class="form-control" id="tel2_<? echo trim($mutar['dni']);?>" value="<? echo $mutar['tel_cel']; ?>"/></td>



			<td>
				<?
					$arra_carreras="";
				
				foreach($array_carreras_listado as $array_carrera)
				{
					if($mutar['idcarrera'] == $array_carrera['carr_id'])
					{
						$seleccionado="selected='selected'";
					}
					else
					{
						$seleccionado="";
					}
					
					
					$arra_carreras.= "<option value='".$array_carrera['carr_id']."' ".$seleccionado.">".$array_carrera['carr_descripcion']."</option>";

				}
				echo "<select class='form-control' name='select_carrera' id='select_carrera_".trim($mutar['dni'])."'>".$arra_carreras."</select>";

                                
                                
				?>
			</td>

			<td><input class="form-control" id="cuatrimestre_<? echo trim($mutar['dni']);?>" value="<? echo $mutar['cuatrimestre']; ?>"/></td>
                        <td><input class="form-control" id="ingreso_<? echo trim($mutar['dni']);?>" value="<? echo $mutar['tipo_ingreso']; ?>"/></td>
			<td>
				<?

				$arra_tutores="";
				foreach($array_tutores as $array_tutor)
				{
					if($mutar['id_tutor'] == $array_tutor['id'])
					{
						$seleccionado="selected='selected'";
					}
					else
					{
						$seleccionado="";
					}
					
					
					$arra_tutores.= "<option value='".$array_tutor['id']."' ".$seleccionado.">".$array_tutor['nombre'].", ".$array_tutor['apellido']."</option>";

				}
				echo "<select class='form-control' name='select_tutor' id='select_tutor_".trim($mutar['dni'])."'>".$arra_tutores."</select>";

				?>
			</td>
			<td>


                    <div class="btn-group">





                        <button type="button" class="btn btn-success" data-toggle="modal" onClick='cambiar_carrera("<? echo trim($mutar['dni']); ?>")'  >
                            <span class="glyphicon glyphicon-pencil"></span>&nbsp;Guardar
                        </button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#alertResetPassword"  data-editar="<? echo trim($mutar['dni']); ?>">
                            <span class="glyphicon glyphicon-trash"></span>&nbsp;Reset pwd
                        </button>
                    </div>

			</td>
		</tr>

<?
	}
}
?>

	</tbody>
</table>


<div class="modal fade" id="alertResetPassword" tabindex="-1" role="dialog" aria-labelledby="delForm" aria-hidden="true">
    <div class="modal-dialog">
        <div class="bs-alert">
            <div class="alert alert-danger fade in">
                <h4>Atenci&oacute;n</h4>
                <p>El blanqueo de la contrase&ntilde;a solo debe utilizarse si el usuario ha dado su consentimiento, de lo contrario estar&aacute; vulnerando la privacidad del mismo.</p>
				<p>Esta acci&oacute;n tambi&eacute;n conlleva el riesgo de que un tercero pueda acceder al sistema debido a que la contrase&ntilde;a por defecto es poco segura</p>
                <p>&iquest;Desea usted continuar?</p>
                <p>
			<input type="hidden" name="alumno-key" id="alumno-key" value=""/>
                    <button class="btn btn-danger" data-dismiss="modal" id="cancelar" type="button">Cancelar</button>
                    <button class="btn btn-default" type="button" id="resetPwd">Aceptar</button>
                </p>
            </div>
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

function cambiar_carrera(documento)
{	
	carrera_seleccionada = document.getElementById('select_carrera_'+documento).value;
	telefono = document.getElementById('tel1_'+documento).value;
	celular = document.getElementById('tel2_'+documento).value;
	tutor = document.getElementById('select_tutor_'+documento).value;
	cuatrimestre = document.getElementById('cuatrimestre_'+documento).value;

	$.post("alumnosCargar.php?accion=guardar", { documento: documento, carrera: carrera_seleccionada, telefono: telefono, celular: celular, tutor: tutor, cuatrimestre : cuatrimestre } );


	//ajax_loadContent('div_guardar_alumno',"alumnos_cargar_nuevo.php?accion=guardar&documento="+documento+"&carrera="+carrera_seleccionada+"&tutor="+tutor+"&telefono="+telefono); 
}


$(document).ready(function () {
        var dataaction = document.querySelectorAll('[data-editar]');
        for(var i = 0; i < dataaction.length ; i++){
            document.querySelectorAll('[data-editar]').item(i).addEventListener("click",function(){
                $('#alumno-key').val(this.dataset.editar);
            },false);
        }
	
	$("#resetPwd").click(function(){
             $.ajax({
		async:false, 
		cache:false,
		dataType:"html",
		type: 'POST',
		url: "alumnos_cargar_nuevo.php",
         	data: "accion=clave&documento="+$("#alumno-key").val(),
         	success:  function(){
                    $('#cancelar').trigger("click");

			//	location.reload(); 
		},
         	beforeSend:function(){},
         	error:function(objXMLHttpRequest){}
              });
	});
});

</script>
	</body>
</html>