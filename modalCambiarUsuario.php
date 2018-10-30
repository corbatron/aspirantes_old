<script>
function cambiarUsuario(){
 	$.ajax({
         async:false,
         cache:false,
         dataType:"html",
         type: 'POST',  
         url: "submit.php",
         data: "from=cambiarUsuarioModal&dni="+$("#dnialumno").val(),
         success:  function(){
		$('#cambiarUsuarioModal').modal('hide');
		//document.getElementById('iframe_1').src="http://<?echo $_SERVER['HTTP_HOST']?>/aspirantes/alumnosFormularios.php";
		location.reload();
		},
         beforeSend:function(){},
         error:function(objXMLHttpRequest){}
         })


}

</script>

<div class="modal fade" id="cambiarUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="cambiarUsuario" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="cambiarUsuario">Cambiar Usuario</h4>
            </div>


            <form role="form" action="javascript:cambiarUsuario();">
                <div class="modal-body">



                    <div class="form-group">
                        <label for="dni">Dni</label>
                        <input type="number" class="form-control" name="dnialumno" id="dnialumno" placeholder="dni">
                    </div>





                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Aceptar</button>
                </div>
            </form>

        </div>
    </div>
</div>


