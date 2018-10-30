
			 <!--a id="modal-727445" href="#modal-container-727445" role="button" class="btn" data-toggle="modal">Percepcion N</a-->
			<form class="form-horizontal" role="form" target="iframesubmission" action="tutor_percepcion0.php">
			<div class="modal fade" id="modal-container-727987" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							 
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								x
							</button>
							<h4 class="modal-title" id="myModalLabel">

								Problem&aacute;ticas
							</h4>
						</div>
						<div class="modal-body">
							
							
							
							
							

		
				<div class="form-group">			 			 
					<label for="fecha_problematica" class="col-sm-2 control-label">
						Fecha
					</label>
					<div class="col-sm-10">
						<input type="date" required name="fecha_problematica" id="fecha_problematica" class="form-control"/>

					</div>
				</div>
				
				
				<div class="form-group">			 			 
					<label for="detalle" class="col-sm-2 control-label">
					Problem&aacute;ticas
					</label>
					<div class="col-sm-10">

						
<?
$string="";
foreach ($problematicas as $value) {
	if( $value['orden'] == 0){ 
		$string .= "<input  type='CHECKBOX' id='".$value['id']."' name='".$value['id']."'></input>".$value['descripcion']."<br>";
		if($value['campos_hijos'] != ""){
			foreach($problematicas as $campo){
				if( $campo['orden'] == 1){ 
					$string.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='CHECKBOX' id='".$campo['id']."' name='".$campo['id']."'></input>".$campo['descripcion']."<br>";
					if($campo['campos_hijos'] != ""){
						foreach($problematicas as $campojr){
							if( $campojr['orden'] == 2  ) 
							$string.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='CHECKBOX' id='".$campojr['id']."' name='".$campojr['id']."'></input>".$campojr['descripcion']."<br>";					
						}

					}
				
				}
			}	

	
		}

	}
}
echo $string;
?>

						
						
					</div>
				</div>
			
					
							
							
							<input type="hidden" id="dni_problematica" name="dni_problematica" value=""/>
							<input type="hidden" id="origen" name="origen" value="modal_problematica"/>

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
					
