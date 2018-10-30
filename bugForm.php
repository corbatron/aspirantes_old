<script>
function save(){
 	$.ajax({
         async:false,
         cache:false,
         dataType:"html",
         type: 'POST',  
         url: "submit.php",
         data: "from=bugModal&mail="+window.btoa(encodeURIComponent($('#mail')[0].value))+"&asunto="+$('#asunto')[0].value+"&detalle="+window.btoa(encodeURIComponent($('#detalle')[0].value))+"&dni="+$("#alumnos").val(),
         success:  function(){
		$('#bugModal').modal('hide');
		},
         beforeSend:function(){},
         error:function(objXMLHttpRequest){}
         })


}

</script>

<div class="modal fade" id="bugModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Reportar error</h4>
            </div>


            <form role="form" action="javascript:save();">
                <div class="modal-body">

<input type='hidden' name='alumnos' id='alumnos' value='<? echo $_SESSION['id']; ?>'></input>


                    <div class="form-group">
                        <label for="mail">Correo Electr&oacute;nico</label>
                        <input type="email" class="form-control" required name="mail" id="mail" placeholder="Ingrese su mail">
                    </div>
                    <div class="form-group">
                        <label for="asunto">Asunto</label>
                        <input type="text" class="form-control" required name="asunto" id="asunto" placeholder="Asunto">
                    </div>


                    <div class="form-group">
                        <label for="">Detalle</label>
			   <textarea style="resize:none" required  name="detalle" id="detalle" maxlength="290" class="form-control" rows="3"></textarea>


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


