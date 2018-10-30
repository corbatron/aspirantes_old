<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<!-- Bootstrap core CSS -->
			<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
			<link href="taginput/bootstrap-tagsinput.css" rel="stylesheet">

			<style>
				body { padding-top: 50px; }
			</style>
	</head>
	<body>


<?
include('class.carreras.php');
$carreras = new Carreras();
$array_carreras_listado = $carreras->traer_carreras();
foreach($array_carreras_listado as $array_carrera){
	if($_REQUEST['carrera_seleccionada']==$array_carrera['carr_id']){
		$seleccion = "selected";
	}else{
		$seleccion = "";
	}
	$arra_carreras.= "<option ".$seleccion." value='".$array_carrera['carr_id']."'>".$array_carrera['carr_descripcion']."</option>";
}
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
<form class="form-horizontal" role="form"  name='form_alumnos' id='form_alumnos'>


				<div class="form-group">				 
					<label for="id_carrera_sele" class="col-sm-2 control-label">				
						Carrera
					</label>
					<div class="col-sm-5">
					<select name='carrera_seleccionada'   id='id_carrera_sele' class='form-control'>
						<? echo $arra_carreras; ?>
					</select>
					</div>
				</div>
<div class="form-group">
 <div class="col-sm-offset-2 col-sm-10">
  <div class="checkbox">
   <label>
    <input  type='checkbox' disabled checked name='ingreso' id='ingreso' value='true'/>Ingreso
   </label>
  </div>
</div>

				<input type='hidden' name='guardar' value='guardar'/>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						 
						<button type="submit" class="btn btn-primary">
							Buscar
						</button>
					</div>
				</div>



</form>
<form class="form-horizontal" role="form"  name='form_alumnos' id='form_alumnos'>
						 <?
$status="disabled";
if($_REQUEST['guardar']!=""){
?>								
	<div class="form-group">				 
					<label for="tutores" class="col-sm-2 control-label">				
						Tutores
					</label>
					<div class="col-sm-5">
						<select multiple class='form-control' id="tutores" name="tutores" data-provide="typeahead" data-role="tagsinput" ></select>
					</div>
	</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">

 


						<button id="btnAsignar" type="button" class="btn btn-primary">
							Asignar
						</button>
					</div>
				</div>
<?
}
?>
</form>


<?

if($_REQUEST['guardar']!="")
{
$idcarrera    = $_REQUEST['carrera_seleccionada'];

?>

<table class="table table-bordered table-hover table-responsive" id="tabla">
	<thead>
		<tr>
			<th>Dni</th>
			<th>Nombre</th>
			<th>Apellido</th>
			<th>Correo electr&oacute;nico</th>
			<th>Tel&eacute;fono 1</th>
			<th>Tel&eacute;fono 2</th>
			<th>Tutor</th>
		</tr>
	</thead>
	<tbody>
<?
	include('class.alumnos.php');
	$alumno   = new Alumno(0);
	$alumnos_mutantes = $alumno->traer_alumnos($id_instancia,$_REQUEST['carrera_seleccionada'],$documento);



	foreach($alumnos_mutantes as $mutar){

	if($mutar['ingreso']!=1) continue;

?>
		<tr>

			<td><? echo trim($mutar['dni']);?></td>
			<td><? echo $mutar['nombre'];?></td>
			<td><? echo $mutar['apellido'];?></td>
			<td><? echo "<a href='mailto:".$mutar['mail']."&subject=Tutorias'>".$mutar['mail']."</a>"; ?></td>
			<td><? echo $mutar['tel_linea']?></td>
			<td><? echo $mutar['tel_cel'];?></td>

			
			<td name="tutor_<? echo trim($mutar['dni']);?>" >
				<input type="hidden" id="id_tutor_<? echo trim($mutar['dni']);?>" />
				<label id="label_tutor_<? echo trim($mutar['dni']);?>" >N/A</label>
			</td>



		</tr>

<?
	}
}
?>

	</tbody>
</table>








		</div>
	</div>
</div>
	

        <script src="bootstrap/js/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="bootstrap/js/jquery.min.js"><\/script>')</script> 
        <script src="bootstrap/dist/js/bootstrap.min.js"></script> 
	<script type="text/javascript" src="taginput/typeahead.js"></script>
	<script type="text/javascript" src="taginput/bootstrap-tagsinput.min.js"></script>
	<script>


var tutores = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: 'api.php?accion=getTutores'

});
tutores.initialize();




$('#tutores').tagsinput({
  itemValue: 'id',
  itemText: 'name',
  typeaheadjs: {
	name: 'tutores',
	displayKey: 'name',
    	source: tutores.ttAdapter()
  }
});



$(document).ready(function() {
	$("#btnAsignar").click(function () {
		var tutoresLocal = $('#tutores').val();
		cantidad = -1;
		$('td[name^=tutor_]').each(function(){
			cantidad = cantidad + 1;
			this.children[1].textContent=getObjects(tutores.index.datums,"id",tutoresLocal [cantidad])[0].name;
			this.children[0].value=tutoresLocal [cantidad];
			if(cantidad==tutoresLocal.length-1){
        	           cantidad = -1
	                }
			var idAlumno = this.children[1].id.replace("label_tutor_","");
			var idTutor = this.children[0].value;
			$.ajax({
  url: "api.php",
  method: "POST",
  async: false,
  data: { accion:"setTutores",idTutor:idTutor,idAlumno:idAlumno },
}).done(function(){ $('td[name^=tutor_'+idAlumno+']').addClass("success"); } );


			//$.ajax("api.php",{accion:"setTutores",idTutor:idTutor,idAlumno:idAlumno}).done(function(){ $('td[name^=tutor_'+idAlumno+']').addClass("success"); } );
			
		});


	});

});


function getObjects(obj, key, val) {
    var objects = [];
    for (var i in obj) {
        if (!obj.hasOwnProperty(i)) continue;
        if (typeof obj[i] == 'object') {
            objects = objects.concat(getObjects(obj[i], key, val));
        } else if (i == key && obj[key] == val) {
            objects.push(obj);
        }
    }
    return objects;
}




/*
$('#tabla tr').each(
function(index){
    $(this).children("td").each(function (index2) 
            {
            	if(index2==1){
                cantidad = cantidad + 1;
              	$(this).text(tutores[cantidad]);
                if(cantidad==tutores.length-1){
                   cantidad = -1
                }
              }
            });
}
);*/




	</script>

	</body>
</html>




