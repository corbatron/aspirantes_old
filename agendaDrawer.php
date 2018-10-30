<?
	include('class.alumnosRespuestasAgenda.php');
	$respagenda = new alumnosRespuestasAgenda();
	
	include('class.evaluacion.formularios.php');
	$formularios_evaluacion = new evaluacionFormularios();
	

	
	$respuesta_general = $respagenda->traerRespuestas($formulario,$dni);
	
	$valor1="['ESTUDIO',".$respuesta_general[0]['estudio']."],['ACTIVIDADES',".$respuesta_general[0]['actividades']."],['FACULTAD',".$respuesta_general[0]['facultad']."],['TRABAJO',".$respuesta_general[0]['trabajo']."]";
	
	

	
	$array_resultados_agenda = $respagenda->traerAgendaCompleta($formulario,$dni);


	foreach($array_resultados_agenda as $resp_res_agenda)
	{
		$array_resp[$resp_res_agenda['id_dia']][$resp_res_agenda['id_hora']] = $resp_res_agenda['id_valor'];
	}
	
	
?>


      <div class="row">
      <div class="col-md-6 text-center" style="padding-top:10Px;">
      <div id="container"  style='width:500Px;'></div>
      </div>
      <div class="col-md-6 text-center" style="padding-top:10Px;">
        <div class="col-md-12 text-center" style="padding-top:10Px;">
          <div style="background-color:#f0ad4e;width:100%;height:75Px;border-radius: 3px;" id="eclo">

          </div>
        </div>
        <div class="col-md-12 text-center" style="padding-top:10Px;">
          <div style="background-color:#337ab7;width:100%;height:75Px;;border-radius: 3px;" id="ec">

          </div>
        </div>
        <div class="col-md-12 text-center" style=";padding-top: 10px;" style="vertical-align:middle;">
          <div style="background-color:#d9534f;width:100%;height:75Px;border-radius: 3px;vertical-align:middle;" id="to">

          </div>
      </div>
      </div>
      </div>
</br>
      <div class="row">
<div class="table-responsive">
	<table class="table table-bordered table-striped">
<thead>
<tr><th>#</th>
<th style="text-align:center">6</th><th style="text-align:center">7</th><th style="text-align:center">8</th><th style="text-align:center">9</th><th style="text-align:center">10</th><th style="text-align:center">11</th><th style="text-align:center">12</th><th style="text-align:center">13</th><th style="text-align:center">14</th><th style="text-align:center">15</th><th style="text-align:center">16</th><th style="text-align:center">17</th><th style="text-align:center">18</th><th style="text-align:center">19</th><th style="text-align:center">20</th><th style="text-align:center">21</th><th style="text-align:center">22</th><th style="text-align:center">23</th><th style="text-align:center">24</th></tr>
</thead>
<tbody>
<?

	$array_dia[1]="Lunes";
	$array_dia[2]="Martes";
	$array_dia[3]="Mi&eacute;rcoles";
	$array_dia[4]="Jueves";
	$array_dia[5]="Viernes";
	$array_dia[6]="S&aacute;bado";
	$array_dia[7]="Domingo";
	$cantidades="";
	for($dia = 1;$dia<8;$dia++){	
		echo "<tr>";
		echo "<td>";
		echo $array_dia[$dia];
		echo "</td>";

		for($hora = 0;$hora<19;$hora++)
		{
			echo "<td style='text-align:center'><span name='span_".$array_resp[$dia][$hora]."' ></span></td>";
			$cantidades[$array_resp[$dia][$hora]] = $cantidades[$array_resp[$dia][$hora]] + 1;
		
		}
		echo "</tr>";
	}
	
		
	
		$valores_evaluacion = $formularios_evaluacion->calcular_valores_agenda($cantidades[3],$cantidades[1],$cantidades[0],$cantidades[2]);
		
		$X1 = $valores_evaluacion['general'];
		$Y1 = $valores_evaluacion['equilibrio_estudio'];
	
		$RESULTADO = $X1 + $Y1;
		if($RESULTADO>="1.30")
		{
			$valor_regular = "+";
		}
		
		if($RESULTADO>"0.85" && $RESULTADO<"1.30")
		{
			$valor_regular = "NEUTRO";
		}
		
		if($RESULTADO<="0.85")
		{
			$valor_regular = "-";
		}
		
		$formularios_evaluacion->actualizar_alumnoform($formulario,$dni,$valor_regular);
		
		
		if($valores_evaluacion['general']>="0.50" ){
			$eclo="<H2>(E+C / L+O) OK</H2><p class='lead'>".(round($valores_evaluacion['general']*100)/100)."</p>";
			$eclocolor="337ab7";
		}elseif($valores_evaluacion['general']<"0.50" && $valores_evaluacion['general']>"0.35"){
			$eclo="<H2>(E+C / L+O) MODERADO</H2><p class='lead'>".(round($valores_evaluacion['general']*100)/100)."</p>";
			$eclocolor="f0ad4e";
		}elseif($valores_evaluacion['general']<="0.35"){
			$eclo="<H2>(E+C / L+O) NO</H2><p class='lead'>".(round($valores_evaluacion['general']*100)/100)."</p>";
			$eclocolor="d9534f";

		}
		
		if($valores_evaluacion['equilibrio_estudio']>"0.8"){
			$ec="<H2>(E / C) OK</H2><p class='lead'>".(round($valores_evaluacion['equilibrio_estudio']*100)/100)."</p>";
			$eccolor="337ab7";
		}elseif($valores_evaluacion['equilibrio_estudio']>="0.5" && $valores_evaluacion['equilibrio_estudio']<="0.8"){
			$ec="<H2>(E / C) MODERADO</H2><p class='lead'>".(round($valores_evaluacion['equilibrio_estudio']*100)/100)."</p>";
			$eccolor="f0ad4e";
		}elseif($valores_evaluacion['equilibrio_estudio']<"0.5"){
			$ec="<H2>(E / C) NO</H2><p class='lead'>".(round($valores_evaluacion['equilibrio_estudio']*100)/100)."</p>";
			$eccolor="d9534f";
		}
		
		if($valores_evaluacion['equilibrio_personal']<1){
			$to="<H2>(T / O) OK</H2><p class='lead'>".(round($valores_evaluacion['equilibrio_personal']*100)/100)."</p>";
			$tocolor="337ab7";
		}else{
			$to="<H2>(T / O) NO</H2><p class='lead'>".(round($valores_evaluacion['equilibrio_personal']*100)/100)."</p>";
			$tocolor="d9534f";
		}
?>

</tbody>
	</table>
</div>
      </div>
	  
<script> 	  
function graficar() {
    cargarIndicadores();
    $('#container').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
        title: {
            text: ''
        },
        credits: {
            enabled: false
        },

        plotOptions: {
            pie: {
                innerSize: 100,
                depth: 45//,
				// dataLabels: {
                //    enabled: true,
                //    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                //}
            }
        },
        series: [{
            showInLegend: false,
            name: '',
            data: [ <? echo $valor1; ?> ],
        }]
    });
}
function cargarIndicadores(){
	$("#eclo").append("<? echo $eclo; ?>");
	$("#eclo").css("background-color","#<? echo $eclocolor; ?>");
	$("#ec").append("<? echo $ec; ?>");
	$("#ec").css("background-color","#<? echo $eccolor; ?>");
	$("#to").append("<? echo $to; ?>");
	$("#to").css("background-color","#<? echo $tocolor; ?>");

	/*
	    * glyphicon glyphicon-wrench
     * glyphicon glyphicon-briefcase
     * glyphicon glyphicon-book
     * glyphicon glyphicon-headphones
	*/


	$('[name="span_0"]').addClass("glyphicon glyphicon-book");//estudio
	$('[name="span_1"]').addClass("glyphicon glyphicon-headphones");//tiempo_libre
	$('[name="span_2"]').addClass("glyphicon glyphicon-briefcase");//cursada
	$('[name="span_3"]').addClass("glyphicon glyphicon-wrench");//trabajo
}

</script>	 







 
	  
