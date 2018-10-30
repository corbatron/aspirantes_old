<script>
function setFechas(){
 	$.ajax({
         async:false,
         cache:false,
         dataType:"html",
         type: 'POST',  
         url: "submit.php",
         data: "from=setFechas&fechaInicio="+$("#fechainicio").val()+"&fechafin="+$("#fechafin").val(),
         success:  function(){
		$('#sysacadFecha').modal('hide');


		},
         beforeSend:function(){},
         error:function(objXMLHttpRequest){}
         })


}

</script>


<div class="modal fade" id="sysacadFecha" tabindex="-1" role="dialog" aria-labelledby="crearTutor" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="sysacadFecha">Definir fechas</h4>
            </div>



	<form role="form" method="post" action="javascript:setFechas();">

                <div class="modal-body">
				
			<? session_start(); ?>
                   


                    <div class="form-group">
                        <label for="fechaini">Fecha inicio</label>
                        <input type="date" class="form-control" name="fechainicio" id="fechainicio" required value="<? echo $_SESSION['fecha_ini']; ?>"/>
                    </div>


                    <div class="form-group">
                        <label for="fechafin">Fecha fin</label>
                        <input type="date" class="form-control" name="fechafin" id="fechafin" required  value="<? echo $_SESSION['fecha_fin']; ?>"/>
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