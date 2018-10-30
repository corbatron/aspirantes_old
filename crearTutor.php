<script>
function altaTutor(){
 	$.ajax({
         async:false,
         cache:false,
         dataType:"html",
         type: 'POST',  
         url: "submit.php",
         data: "from=crearTutorModal&dni="+$("#dnitutor").val()+"&nombre="+$("#nombretutor").val()+"&apellido="+$("#apellidotutor").val(),
         success:  function(){
		alert("Se ha dado de alta el tutor con la contrase\u00f1a por defecto");
		$('#crearTutorModal').modal('hide');


		},
         beforeSend:function(){},
         error:function(objXMLHttpRequest){}
         })



  url: "createUserImplementation.php",
            data: "nombre=" + $('#nombre')[0].value + "&apellido=" + $('#apellido')[0].value+"&documento="+$('#documento')[0].value+"&carrera="+$('#carrera').val(),
          

}

</script>


<div class="modal fade" id="crearTutorModal" tabindex="-1" role="dialog" aria-labelledby="crearTutor" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="crearTutor">Crear tutor</h4>
            </div>



	<form role="form" method="post" action="javascript:altaTutor();">

                <div class="modal-body">
				
                    <div class="form-group">
                        <label for="dnitutor">Dni</label>
                        <input type="number" class="form-control" name="dnitutor" id="dnitutor" required placeholder="dnitutor"    />
                    </div>


                    <div class="form-group">
                        <label for="nombretutor">Nombre del tutor</label>
                        <input type="text" class="form-control" name="nombretutor" id="nombretutor" required placeholder="Nombre" />
                    </div>


                    <div class="form-group">
                        <label for="apellido">Apellido del tutor</label>
                        <input type="text" class="form-control" name="apellidotutor" id="apellidotutor" required placeholder="Apellido" />
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </form>


        </div>
    </div>
</div>