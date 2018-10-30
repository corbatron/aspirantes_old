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
include('ver_login.php');
include('class.form.php');	

include("alertFormDelete.php");

$objFormulario = new Form();
$formularios = $objFormulario->showForm();
?>
<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>
                    C&oacute;digo
                </th>
                <th>
                    Descripci&oacuten
                </th>
                <th>
                    Introducci&oacuten
                </th>
                <th>
                    Estado
                </th>

                <th>
                    Acciones posibles
                </th>
            </tr>
        </thead>
        <tbody>

            <?
            foreach($formularios as $formulario){
            ?>
            <tr id="formulario_row_<? echo  $formulario['id']; ?>">
                <td>    
			<input type="text" disabled class="form-control" id="formulario_code_<? echo  $formulario['id']; ?>" value="<? echo $formulario['codigo']; ?> ">
                </td>
                <td>
			<input type="text" disabled class="form-control" id="formulario_desc_<? echo  $formulario['id']; ?>" value="<? echo $formulario['descripcion']; ?>">
                </td>
                <td>
              	<textarea readonly class="form-control" id="formulario_enca_<? echo  $formulario['id']; ?>"   >
			<? echo  $formulario['descripcion_larga']; ?>
			</textarea>
                </td>
                <td>
                    <? if($formulario['estado'] == 1) echo '<span class="glyphicon glyphicon-ok-circle"></span>&nbsp;Activo';
                    else echo '<span class="glyphicon glyphicon-ban-circle"></span>&nbsp;No activo'; ?>
                    <!--span class="glyphicon glyphicon-ok-circle"></span>&nbsp;Activo-->
                </td>
                <td>
                    <div class="btn-group">





                        <button type="button" class="btn btn-success" data-toggle="modal" id="btn_<? echo  $formulario['id']; ?>" data-editable="<? echo  $formulario['id']; ?>">
                            <span class="glyphicon glyphicon-pencil"></span>&nbsp;<span id="formulario_btn_lbl_<? echo  $formulario['id']; ?>" >Editar</span>
                        </button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#alertFormDelete" data-editar="<? echo  $formulario['id']; ?>">
                            <span class="glyphicon glyphicon-trash"></span>&nbsp;Borrar
                        </button>
                    </div>

            </tr>
            <?
            }
            ?>
            <tr class="info">
                <td><input type="text" disabled class="form-control" id="formulario_code_aux" value=""></td>
                <td><input type="text" disabled class="form-control" id="formulario_desc_aux" value=""></td>
                <td><textarea readonly class="form-control" id="formulario_enca_aux"   ></textarea></td>
                <td><span class="glyphicon glyphicon-ok-circle"></span>&nbsp;Activo</td>
                <td><div class="btn-group">
                        <button type="button" class="btn btn-info" id="aux">
                            <span class="glyphicon glyphicon-plus"></span><span id="formulario_btn_lbl_aux">&nbsp;Nuevo formulario</span>
                        </button>

                    </div>
                </td></tr>
        </tbody>
    </table>
</div>

		</div>
	</div>
</div>
	

        <script src="bootstrap/js/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="bootstrap/js/jquery.min.js"><\/script>')</script> 
        <script src="bootstrap/dist/js/bootstrap.min.js"></script> 

<script>
$(document).ready(function () {
        var dataaction = document.querySelectorAll('[data-editar]');
        for(var i = 0; i < dataaction.length ; i++){
            document.querySelectorAll('[data-editar]').item(i).addEventListener("click",function(){
                $('#form-key').val(this.dataset.editar);
            },false);
        }
	
	$("#deacform").click(function(){
             $.ajax({
		async:false, 
		cache:false,
		dataType:"html",
		type: 'POST',
		url: "submit.php",
         	data: "from=deleteFormulario&formulario="+$("#form-key").val(),
         	success:  function(){
                    $('#cancelar').trigger("click");

				location.reload(); 
		},
         	beforeSend:function(){},
         	error:function(objXMLHttpRequest){}
              });
	});
        
        $("#aux").click(function(){
		$("#formulario_code_aux").prop('disabled', false); 
		$("#formulario_desc_aux").prop('disabled', false); 
		$("#formulario_enca_aux").prop('readonly',false); 
		$("#formulario_btn_lbl_aux").html("&nbsp;Guardar");
                $("#aux").off();
                this.addEventListener("click",function(){
                    $.ajax({
			async:false, 
			cache:false,
			dataType:"html",
			type: 'POST',
			url: "submit.php",
         		data: "from=crearFormulario&codigo="+$("#formulario_code_aux")[0].value+"&descripcion="+$("#formulario_desc_aux")[0].value+"&encabezado="+$("#formulario_enca_aux").val(),
         		success:  function(){
				location.reload(); 
			},
         		beforeSend:function(){},
         		error:function(objXMLHttpRequest){}
                    });
                });
	});

            



        var dataaction = document.querySelectorAll('[data-editable]');
        for(var i = 0; i < dataaction.length ; i++){
            document.querySelectorAll('[data-editable]').item(i).addEventListener("click",function(){
				$("#formulario_code_"+this.dataset.editable).prop('disabled', false); 
				$("#formulario_desc_"+this.dataset.editable).prop('disabled', false); 
				$("#formulario_enca_"+this.dataset.editable).prop('readonly',false); 
				$("#formulario_btn_lbl_"+this.dataset.editable).html("Guardar");
				$("#btn_"+this.dataset.editable).off();
				this.addEventListener("click",function(){
					$.ajax({
						async:false, 
						cache:false,
						dataType:"html",
						type: 'POST',
						url: "submit.php",
         					data: "from=editarFormulario&formulario="+this.dataset.editable+"&codigo="+$("#formulario_code_"+this.dataset.editable)[0].value+"&descripcion="+$("#formulario_desc_"+this.dataset.editable)[0].value+"&encabezado="+$("#formulario_enca_"+this.dataset.editable).val(),
         					success:  function(){
							location.reload(); 
						},
         					beforeSend:function(){},
         					error:function(objXMLHttpRequest){}
         				});

				},false);		
			},false);
        }



	});



</script>



	</body>
</html>