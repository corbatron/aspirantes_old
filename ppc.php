<script>
	var cantidad=1;
	function colasp(componente){
		//var parent = $("#"+componente).parent();
		//var siguiente = parent.next();
		//var tog;
			
		 $("#"+componente).parent().next().collapse('toggle');
		if($("#"+componente)[0].className.contains("minus"))
			$("#"+componente).attr("class","btn btn-success glyphicon glyphicon-plus accordion-toggle");
		else
			$("#"+componente).attr("class","btn btn-success glyphicon glyphicon-minus accordion-toggle");

		//if( siguiente.attr("estado")=="1"){	
		//	$(siguiente).collapse('show');
		//	siguiente.attr("estado")=="2";
		//}else{		
		//$(siguiente).collapse('toggle');
		//siguiente.attr("estado")=="1";
		//}
	}
		

	
	function agregar_materias(){
		cantidad ++;
		if(cantidad >= 20){
			alert("No se pueden agregar mas de 20 materias");
			return 1;
		}
			

		<?php
			include("class.carreras.php");
			$objCarreras = new Carreras();
			$carreraCodeSysacad = $objCarreras->transco($_SESSION['id_carrera']);
			$todasLasMaterias = $objCarreras->devolverMaterias($carreraCodeSysacad);
			//$select="<select name='materias_prox_".."'>";
			foreach($todasLasMaterias as $materia){
$materia_anio=explode("-",$materia[0]);
$select.="<option value='$materia[0]'>$materia[1] (plan $materia_anio[2])</option>";}
			//$select.="</select>";
		?>


		
		$('#table_materias').append("<tr id='tr_"+cantidad+"'><td style='text-align: center !important;'><select class='form-control' name='materias_prox_"+cantidad+"'><? echo $select;?></select></td><td style='text-align: center !important;'><input type='radio' name='optionsRadios"+cantidad+"' id='optionsRadios"+cantidad+"' value='1'></td><td style='text-align: center !important;'><input type='radio' name='optionsRadios"+cantidad+"' id='optionsRadios"+cantidad+"' value='2'></td><td style='text-align: center !important;'><input type='radio' name='optionsRadios"+cantidad+"' id='optionsRadios"+cantidad+"' value='3'></td><td style='text-align: center !important;'><input type='radio' name='optionsRadios"+cantidad+"' id='optionsRadios"+cantidad+"' value='4'></td><td style='text-align: center !important;'><input type='radio' name='optionsRadios"+cantidad+"' id='optionsRadios"+cantidad+"' value='5'></td><td style='text-align: center !important;'><input type='radio' name='optionsRadios"+cantidad+"' id='optionsRadios"+cantidad+"' value='6'></td><td style='text-align: center !important;'><i class='glyphicon glyphicon-remove' style='cursor: pointer;' onClick='eliminar_linea("+cantidad+");'></i></td></tr>");
	}




	function eliminar_linea(id){
		$('#tr_'+id).remove();
	}

	function bloquear_td(id){
		var val_td = $("#"+id+":checked").val();
		var parent = $("#"+id).parent();
		var tr;             
		tr = parent.parent();
		if(val_td == 'on'){
			tr.find("input:text,button,textarea,select").attr("disabled", false);
		}else{
			tr.find("input:text,button,textarea,select").attr("disabled", true);
		}
	}
	</script>

<!--                    <div class="well well-large">
					<div class="well well-small"><h1>Plan Personal de Carrera<img src="bootstrap/img/new_ppc.png" style="position:relative;height:50Px;left:-14;top:-14" class="img-circle"></h1></div>
-->
                        
			    <div class="accordion" id="accordion2">
                                <?  
                                
                                include("class.periodos.php");
                                $periodos = new Periodos(0);
                                
                                
                                $array_periodos = $periodos->periodosCarrera($carreraCodeSysacad);
                           
                                $array_periodos = json_decode($array_periodos);
                                
                              //  print_r($array_periodos);
                                
                                
                                foreach($array_periodos as $idObjeto=>$periodo){
                                 $cont_periodos = $cont_periodos + 1;
                                //print_r($periodo);
                                ?>
                                <div class="accordion-group">
                                <div class="accordion-heading">
						<button type="button" class="btn btn-success glyphicon glyphicon-minus accordion-toggle ppc-button" data-parent="#accordion2" id="<? echo $periodo->id; ?>" onclick="colasp(this.id);" > <?echo strtoupper($periodo->nombre);?> </button>
                                </div>
                                <div id="collapseOne" class="accordion-body collapse in" >
                                    <div class="accordion-inner">
                                        <table class="table">
                                            <tr>
                                                <th>Materia</th>
                                                <th>Parcial 1</th>
                                                <th>Parcial 2</th>
                                                <th>Parcial 3</th>
												<th>Planificaci&oacute;n</th>
                                            </tr> 
<?php
	
	$arrayMaterias = json_decode($periodos->materiasAsignadas($periodo->id));
	foreach($arrayMaterias as $idObjIndice=>$materia){

		echo "<tr id='tr_finales_$materia->id_completo' checked='checked'><td style='width:300Px' >";//<label class='checkbox'>
                
                if($cont_periodos == 1){
                     $checked="checked";
                    $checked1="";
                }else{
                 $checked = "";
                 $checked1="disabled";
                }
                
		echo "<input type='checkbox' id='ch_$materia->id_completo' name='ch_$materia->id_completo' value='on' ch='checked' ".$checked." onclick='bloquear_td(this.id);'>&nbsp;";
		echo $materia->nombre;
	
	
?>
                                               <!--/label-->
                                                </td>
                                                <td><input class="form-control" type="text" style="width:100Px;height: 30Px;" <?echo $checked1;?> name='p1_<? echo $materia->id_completo;?>'></td>
                                                <td><input class="form-control" type="text" style="width:100Px;height: 30Px;" <?echo $checked1;?> name='p2_<? echo $materia->id_completo;?>'></td>
                                                <td><input class="form-control" type="text" style="width:100Px;height: 30Px;" <?echo $checked1;?> name='p3_<? echo $materia->id_completo;?>'></td>
							<td>
                                                    <select class="form-control" <?echo $checked1;?> name='planificacion_<? echo $materia->id_completo;?>'>
                                                        <option>Diciembre</option>		
                                                        <option>Febrero/Marzo</option>						
                                                        <option>Mayo</option>
                                                        <option>Julio</option>
                                                        <option>Octubre</option>

								
                                                        <option>PROMOCIONADA</option>
                                                        <option>APROBADA</option>
                                                    </select>
                                                </td>

                                            </tr> 

<?php

	}

?>





                                        </table>
                                    </div>
                                </div>
                            </div>
                           <?
                           }?>
                        </div>

						<div><h3>Materias a cursar</h3></div>
						<table class="table" id='table_materias'><tr><th style='width:400Px'>Materia</th><th>Lunes</th><th>Martes</th><th>Miercoles</th><th>Jueves</th><th>Viernes</th><th>Sabado</th><th>Eliminar</th></tr></table>
						<input type="button" class="btn btn-success" value="Agregar materia" onclick='agregar_materias();'></input>
						<!--<br>
						<br>
						<div class="well well-small" style='text-align:center;'>
						<input type="submit" class="btn btn-info" value="Enviar informaci&oacute;n"></input>
						</div>
                    </div>-->
			<input type="hidden" name="plan_de_carrera" value="plan_de_carrera"/>	