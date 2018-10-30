<?
	session_start();      
	$carrera = 7;
        
        //$_SESSION['id_carrera'];
        /*include("class.carreras.php");
        $carreras = new Carreras();
        $resultados_carreras = $carreras->traer_carreras($carrera);
        
        $carrera = $resultados_carreras[0]['id_materia_sysacad'];*/

        
?>
<html>
<head>
<meta charset="utf-8">
<title>Nuevo PPC</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="shortcut icon" href="bootstrap/img/new_ppc.png">
<script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
<script type="text/javascript" src="bootstrap/dist/js/bootstrap.min.js"></script>
<!--script type="text/javascript" src="bootstrap/js/scripts.js"></script-->
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
			$todasLasMaterias = $objCarreras->devolverMaterias($carrera);
			$select="<select class='form-control'>";
			foreach($todasLasMaterias as $materia){$select.="<option value='$materia[0]'>$materia[1]</option>";}
			$select.="</select>";
		?>
		$('#table_materias').append("<tr id='tr_"+cantidad+"'><td style='text-align: center !important;'><? echo $select;?></td><td style='text-align: center !important;'><input type='radio' name='optionsRadios"+cantidad+"' id='optionsRadios"+cantidad+"' value='option"+cantidad+"'></td><td style='text-align: center !important;'><input type='radio' name='optionsRadios"+cantidad+"' id='optionsRadios"+cantidad+"' value='option"+cantidad+"'></td><td style='text-align: center !important;'><input type='radio' name='optionsRadios"+cantidad+"' id='optionsRadios"+cantidad+"' value='option"+cantidad+"'></td><td style='text-align: center !important;'><input type='radio' name='optionsRadios"+cantidad+"' id='optionsRadios"+cantidad+"' value='option"+cantidad+"'></td><td style='text-align: center !important;'><input type='radio' name='optionsRadios"+cantidad+"' id='optionsRadios"+cantidad+"' value='option"+cantidad+"'></td><td style='text-align: center !important;'><input type='radio' name='optionsRadios"+cantidad+"' id='optionsRadios"+cantidad+"' value='option"+cantidad+"'></td><td style='text-align: center !important;'><i class='glyphicon glyphicon-remove' style='cursor: pointer;' onClick='eliminar_linea("+cantidad+");'></i></td></tr>");
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
</head>
    <body style='background: url("data:image/png;base64,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") repeat scroll center center rgb(182, 192, 204);'>
        <div class="container">
            <div class="row-fluid">
                <!--div class="span-3"></div>  CORBI 26/02/2014     -->
                <div class="span-6">
                    <form>
                    <div class="well well-large">
					<div class="well well-small"><h1>Plan Personal de Carrera<img src="bootstrap/img/new_ppc.png" style="position:relative;height:50Px;left:-14;top:-14" class="img-circle"></h1></div>
                        <div><h3>Materias con finales a Febrero del 2014</h3></div>
			    <div class="accordion" id="accordion2">
                                <?  
                                
                                include("class.periodos.php");
                                $periodos = new Periodos(0);
                                
                                
                                $array_periodos = $periodos->periodosCarrera($carrera);
                           
                                $array_periodos = json_decode($array_periodos);
                                
                              //  print_r($array_periodos);
                                
                                $cont_periodos = 0;
                                foreach($array_periodos as $idObjeto=>$periodo){
                                //print_r($periodo);
                                $cont_periodos = $cont_periodos + 1;
                                ?>
                                <div class="accordion-group">
                                <div class="accordion-heading">
						<button type="button" class="btn btn-success glyphicon glyphicon-minus accordion-toggle" data-parent="#accordion2" id="<? echo $periodo->id; ?>" onclick="colasp(this.id);" > <?echo strtoupper($periodo->nombre);?> </button>
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

		echo "<tr id='tr_finales_$materia->id'><td style='width:300Px' id='td_finales_$materia->id'>";//<label class='checkbox'>
                if($cont_periodos == 1){
                    $checked="checked";
                    $checked1="";
            }else{
                $checked = "";
                $checked1="disabled";
            }
		echo "<input type='checkbox' id='ch_$materia->id' ".$checked." onclick='bloquear_td(this.id);'>&nbsp;";
		echo $materia->nombre;
	
	
?>
                                               <!--/label-->
                                                </td>
                                                <td><input type="text" class="form-control" <?echo $checked1;?> style="width:100Px;height:30Px;"></td>
                                                <td><input type="text" class="form-control" <?echo $checked1;?> style="width:100Px;height: 30Px;"></td>
                                                <td><input type="text" class="form-control" <?echo $checked1;?> style="width:100Px;height: 30Px;"></td>
												 <td>
                                                    <select class="form-control" <?echo $checked1;?>>
                                                        <option>Enero</option>
                                                        <option>Febrero</option>
                                                        <option>Marzo</option>
                                                        <option>Agosto</option>
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
						<br>
						<br>
						<div class="well well-small" style='text-align:center;'>
						<input type="submit" class="btn btn-info" value="Enviar informaci&oacute;n"></input>
						</div>
                    </div>
                    </form>
                </div>
                <!--div class="span-3"></div>   CORBI 26/02/2014-->
            </div>
        </div>
    </body>
</html>

