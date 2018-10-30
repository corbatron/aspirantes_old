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
<?
include("ver_login.php");
include('class.carreras.php');
	$carr = new Carreras();
	$array_carreras_listado = $carr->traer_carreras();
	foreach($array_carreras_listado as $array_carrera)
	{
		$carreras_mostrar.= "<option value='".$array_carrera['carr_id']."'>".$array_carrera['carr_descripcion']."</option>";
	}

include('class.form.php');
	$form = new Form();
	$formularios = $form->showForm();
	foreach($formularios as $formulario)
	{
		$formularios_mostrar.='<option value='.$formulario['id'].'>'.$formulario['descripcion'].'</option>';
	}




?>

<form class="form-horizontal">

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="carreras">Carreras</label>
  <div class="col-md-4">
    <select id="carreras" name="carreras" class="form-control">
      <? echo $carreras_mostrar; ?>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="formularios">Formularios</label>
  <div class="col-md-4">
    <select id="formularios" name="formularios" class="form-control">
      <? echo $formularios_mostrar; ?>

    </select>
  </div>
</div>


<div class="form-group">
 <div class="col-sm-offset-4 col-sm-8">
  <div class="checkbox">
   <label>
    <input  type='checkbox' checked name='ingreso' id='ingreso' value='true'/>Ingreso
   </label>
  </div>
  <div class="checkbox">
   <label> 
    <input  type='checkbox' name='noingreso' id='noingreso' value='true'/>No ingreso
  </label>
 </div>
</div>


						</div>

<div class="form-group">
   <div class="col-sm-offset-4 col-sm-8">
    <input type="button" id="buscar" name="buscar" class="btn btn-primary" value="Buscar" />
  </div>
</div>





</form>
</div>
		<div class="col-md-12">




<div class="col-sm-offset-1 col-md-4" style="text-align:center">
Alumnos no asignados
</div>
<div class="col-md-2" style="text-align:center">
Acciones
</div>
<div class="col-md-4" style="text-align:center">
Alumnos asignados
</div>
</div>
	<div class="col-md-12">



<div class="col-sm-offset-1 col-md-4" id="leftpanel">
<select class="form-control" size="15" multiple="true" style="width: 100%"></select>

</div>
<div class="col-md-2" style="text-align:center;">
 
<div class="btn-group-vertical" role="group" aria-label="button-group">

<button type="button" class="btn btn-primary btn-lg" aria-label="Asignar" id="asignar">
Asignar
  <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
</button>

<button type="button" class="btn btn-success btn-lg" aria-label="Asignartodos" id="asignartodos">
Asignar todos
  <span class="glyphicon glyphicon-fast-forward" aria-hidden="true"></span>
</button>
<br>

<input  type="checkbox" id="forzar"/>Habilitar desasignar

<br>
<button type="button" class="btn btn-warning btn-lg" id="desasignar" aria-label="Desasignar" disabled>
  <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
Desasignar
</button>

<button type="button" class="btn btn-danger btn-lg" id="desasignartodos" aria-label="Desasignartodos" disabled>
  <span class="glyphicon glyphicon-fast-backward" aria-hidden="true"></span>
Desasignar todos
</button>


</div>


</div>

<div class="col-md-4" id="rightpanel">
<select class="form-control" size="15" multiple="true" style="width: 100%"></select>

</div>



</div>


		</div>
	</div>
</div>
	

        <script src="bootstrap/js/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="bootstrap/js/jquery.min.js"><\/script>')</script> 
        <script src="bootstrap/dist/js/bootstrap.min.js"></script> 
<script>
$(document).ready(function($) {
    $("#buscar").click(function() {

        request = "ajax_alumnosform.php?id_formulario=" + $("#formularios").val() + "&id_carrera=" + $("#carreras").val() + "&ingreso=" + $("#ingreso").is(':checked') + "&noingreso=" + $("#noingreso").is(':checked');

        $("#leftpanel").load(request + "&accion=noasignados2");
        $("#rightpanel").load(request + "&accion=asignados2");

    });

    $("#forzar").click(function() {

        $('#desasignar').attr("disabled", !$("#forzar").is(':checked'));
        $('#desasignartodos').attr("disabled", !$("#forzar").is(':checked'));

    });

    $("#asignar").click(function() {

        var dnies = new Array();
        cont = 0;
        id_alumnos = document.getElementById("sinform");

        for (i = 0; i < id_alumnos.options.length; i++) {
            if (id_alumnos.options[i].selected == true)
                dnies[cont++] = id_alumnos.options[i].value;
        }
        if (alumnos(dnies)) return (0);
        //funcion del boton "asignar", asocia los DNI de los alumnos seleccionados con el form

        $.ajax({
            async: false,
            cache: false,
            dataType: "html",
            type: 'GET',
            url: "ajax_alumnosform.php",
            data: "id_formulario=" + $("#formularios").val() + "&id_alumnos=" + dnies + "&accion=asignar",
            success: function(respuesta) {

                $("#buscar").click();

            },
            beforeSend: function() {},
            error: function(objXMLHttpRequest) {}
        });




    });




    $("#asignartodos").click(function() {

        $('#sinform option').prop('selected', true);


        $("#asignar").click();

    });




    $("#desasignar").click(function() {

        var dnies = new Array();
        cont = 0;
        id_alumnos = document.getElementById("conform");

        for (i = 0; i < id_alumnos.options.length; i++) {
            if (id_alumnos.options[i].selected == true)
                dnies[cont++] = id_alumnos.options[i].value;
        }


        forzar = document.getElementById("forzar").checked;
        if (forzar)
            if (!confirm('Usted ha seleccionado la funcionalidad de desasignar, se procedera a borrar las respuestas de los usuarios a desasignar \n ¿Desea continuar?'))
                return (0);



        if (alumnos(dnies)) return (0);
        //funcion del boton "asignar", asocia los DNI de los alumnos seleccionados con el form

        $.ajax({
            async: false,
            cache: false,
            dataType: "html",
            type: 'GET',
            url: "ajax_alumnosform.php",
            data: "id_formulario=" + $("#formularios").val() + "&id_alumnos=" + dnies + "&accion=desasignar&forzar=true",
            success: function(respuesta) {

                $("#buscar").click();

            },
            beforeSend: function() {},
            error: function(objXMLHttpRequest) {}
        });




    });




    $("#desasignartodos").click(function() {
        $('#conform option').prop('selected', true);
        $("#desasignar").click();
    });


});


function alumnos(selected)//funcion de validacion de alumnos seleccionados
{
	if(selected=="")
	{
		alert("Usted no ha seleccionado ningun alumno");
		return(1);
	}
	return(0);
}

</script>
	</body>
</html>