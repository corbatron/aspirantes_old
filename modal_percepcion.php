
			 <!--a id="modal-727445" href="#modal-container-727445" role="button" class="btn" data-toggle="modal">Percepcion N</a-->
			<form class="form-horizontal" role="form" target="iframesubmission" action="tutor_percepcion0.php">
			<div class="modal fade" id="modal-container-727445" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							 
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								x
							</button>
							<h4 class="modal-title" id="myModalLabel">
								<input type="hidden" id="nro" name="nro" value=""/>

								Percepci&oacute;n <label id="nroPercepcion"/>
							</h4>
						</div>
						<div class="modal-body">
							
							
							
							
							
				<div class="form-group">			 			 
					<label for="entrevista" class="col-sm-2 control-label">
						Tipo de entrevista
					</label>
					<div class="col-sm-10">
						<select name='entrevista' required id='entrevista' class="form-control">
							<option value='0'></option>
							<option value='1'>Intervenci&oacute;n</option>
							<option value='2'>Asesoramiento</option>
							<option value='3'>Recomendaci&oacute;n</option>
							<option value='4'>No aplica</option>
						</select>

					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<div class="checkbox">
							 
							<label>
								<input type="checkbox" id="espontanea" name="espontanea"/> Espont&aacute;nea
							</label>
						</div>
					</div>
				</div>

				<div class="form-group">			 			 
					<label for="percepcion" class="col-sm-2 control-label">
						Percepci&oacute;n
					</label>
					<div class="col-sm-10">
						<select name='percepcion'  id='percepcion' class="form-control">
							<option value='1'>Alta</option>
							<option value='2'>Media</option>
							<option value='3'>Baja</option>
							<option value='4'>Nula</option>
							<option value='5'>Sin percepcion</option>
						</select>

					</div>
				</div>	
				
				<div class="form-group">			 			 
					<label for="tutor" class="col-sm-2 control-label">
						Tutor
					</label>
					<div class="col-sm-10">
						<select name='tutor' required id='tutor' class="form-control">
<?
$tutores_array = "";
foreach($tutores as $val)
{
	$tutores_array.="<option value='".$val['id']."'>".$val['nombre']." ".$val['apellido']."</option>"; 
}
echo $tutores_array;
?>
						</select>

					</div>
				</div>			
				<div class="form-group">			 			 
					<label for="fecha" class="col-sm-2 control-label">
						Fecha
					</label>
					<div class="col-sm-10">
						<input type="date" required name="fecha" id="fecha" class="form-control"/>

					</div>
				</div>
				
				
				<div class="form-group">			 			 
					<label for="detalle" class="col-sm-2 control-label">
					Detalle de necesidades
					</label>
					<div class="col-sm-10">
						<textarea class="form-control" required id="detalle" name="detalle" rows="4"></textarea>

					</div>
				</div>
				<div class="form-group">			 			 
					<label for="acuerdos" class="col-sm-2 control-label">
					Acuerdos logrados / Intervenciones
					</label>
					<div class="col-sm-10">
						<textarea class="form-control" required id="acuerdos" name="acuerdos" rows="4"></textarea>

					</div>
				</div>				

							
							
							
		
					
							
							
							<input type="hidden" id="dni_percepcion" name="dni_percepcion" value=""/>
							<input type="hidden" id="origen" name="origen" value="modal_percepcion"/>

						</div>
						<div class="modal-footer">
							 
							<button type="button" class="btn btn-default" data-dismiss="modal">
								Cancelar
							</button> 
							<button type="submit" class="btn btn-primary">
								Guardar
							</button>
						</div>
						
						
					</div>
					
				</div>
				
			</div>
			</form>
					
