<?php
include('coneccion.php');

class DrawingBootstrap extends Coneccion
{
	//Control Select//
	function DrawFieldsetOpen($texto){echo "<fieldset><legend>".$texto."</legend>";}
	
	function DrawFieldsetClose(){echo "</fieldset>";}
	
	function DrawSelect($id)	
	{
	
		$select_opciones = "select * from respuestaspreg where idpadre=".$id." and idpregunta=".$id;
		$opciones = $this->query($select_opciones);
		$opciones_mostrar = "";
		foreach($opciones as $opcion)
		{
			$opciones_mostrar.='<option value="'.$opcion['id'].'"  selected="'.$opcion['estado'].'" >'.$opcion["texto"].'</option>';
		}
	
		$input='<select class="form-control" name="'.$id.'">'.$opciones_mostrar.'</select>';		
		echo $input;
	}	
	
	function DrawText($valor,$nombre,$id,$texto)	
	{
		$this->DrawLabel($texto);
		$input='<input type="text" id="'.$id.'" name="'.$nombre.'" value="'.$valor.'"></input><BR>';	
		echo $input;
	}
	function DrawText2($valor,$nombre,$id)	
	{
		$input='<input type="text" id="'.$id.'" name="'.$nombre.'" value="'.$valor.'"></input>';	
		echo $input;
	}	
	
	function DrawLabel($texto)
	{
		
		$input='<label  class="css-label" for="type">'.$texto.'&nbsp;</label><br>';
		echo $input;
	}

	
	function DrawCheck($texto,$estado,$nombre,$id)
	{
		if($estado=='especificar'){


			
	/*		echo '<input   type="checkbox"></input>';
			$this->DrawText2($texto,$nombre,$id);
			echo '<br>';
	*/		
			
			echo '<div class="checkbox"><label><input data-control="'.$id.'" type="checkbox"></label>';
            		echo '<input type="text" class="form-control" disabled  id="'.$id.'"  name="' . $nombre . '" value="' . $texto . '">';
			echo '</div>';
			
		}else{
			/*$input='<input  class="css-checkbox" name="'.$nombre.'" '.$estado.' id="'.$id.'" value="1" type="checkbox"></input>';	
			echo $input;	
			$this->DrawLabel($texto);
			*/
		 echo ' <div class="checkbox"><label><input type="checkbox" name="' . $nombre. '"  id="' . $id  . '" value="1">' . $texto . '</label></div>';
		
			
		}


	
	}
	



	
	function DrawRadio($texto,$estado,$nombre,$id,$id_pregunta)
	{
		$input='<input name="r_'.$id_pregunta.'" '.$estado.' id="'.$id.'" value="'.$id.'" type="radio">';
		echo $input;
		$this->DrawLabel($texto);
	}	
	
	function DrawTextArea($texto,$nombre,$id,$rows,$cols)
	{
		$input='<textarea class="form-control" maxlength="800" name="'.$nombre.'"  id="'.$id.'" value="'.$nombre.'" rows="'.$rows.'" cols="'.$cols.'" wrap="virtual">Ninguno</textarea>';
		echo $input;
	}	
	
	function DrawGeneric($control)
	{
		echo $control;
	}

    function DrawAgenda() {
		include("agenda_nueva.php");

       // include("class.agenda.php");
    }
	
	function DrawForm($id_formulario)
	{
		$select_preguntas = "select * from preguntasform preg inner join formularios formulario on preg.id_formulario=formulario.id
		where id_formulario=".$id_formulario." and formulario.estado = 1 and preg.estado=1 and (now() <=
		formulario.fecha_hasta and now()>= formulario.fecha_desde) order by orden asc";
		
		//echo $select_preguntas;
		
		$resultado_preguntas_form = $this->query($select_preguntas);
		


		$select_descripcion_larga_form="select descripcion,descripcion_larga from formularios where id=".$id_formulario;
		$resultado_Dlarga= $this->query($select_descripcion_larga_form);


		
		        echo '<div class="well well-large">';
        echo '<div class="panel-group" id="panel-171389"><div class="panel panel-default"><div class="panel-heading">';
        echo '<h1>' .$resultado_Dlarga[0][0] . '</h1><a class="panel-title collapsed" data-toggle="collapse" data-parent="#panel-171389" href="#panel-element-972848"><small>Haga click aqu&iacute;para ocultar/mostrar el texto</small></a>';

        echo '</div><div id="panel-element-972848" class="panel-collapse collapse in"><div class="panel-body">';
        echo '<p>' . $resultado_Dlarga[0][1] . '</p>';
        echo '</div></div></div></div></div>';

		
		
		
	
        echo '<div class="well well-small">';
//		echo '<form name="'.$nombre.'" method="POST" target="iframeproceso" action="processmanager.php" onSubmit="return validar();" >';		

        echo '<form role="form" name="'.$nombre.'" method="POST" target="iframeproceso" action="processmanager.php" onSubmit="return validar();" >';
        echo '<input type="hidden" name="formulario" id="formulario" value="' . $id_formulario . '"></input>';
        echo '<input type="hidden" name="from" id="from" value="drawingBootstrap"></input>';
		


		foreach($resultado_preguntas_form as $resultado_preguntas)
			{		
				$id_pregunta = $resultado_preguntas['id_pregunta'];
				$id_usuario = 1;
				$this->DrawQuestion($id_pregunta,$id_formulario);	
			}
			
		echo "</form>";
        echo "</div>";		
	}
	
    function DrawSubmit($texto) {
        echo '<div class="well well-small" style="text-align:center;">';
        echo '<button type="submit" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-send"></span>&nbsp;' . $texto . '</button></div>';
    }

	function DrawPlanCarrera()
	{
            
            include('ppc.php');
           // exit();
		
	
	}
	
	function DrawPlanCarreraReporte()
	{
		include("class.alumnos.php");
		
		$id_alumno = $_SESSION['id'];
		$alumno = new Alumno($id_alumno);
		
		$plan_carrera = $alumno->traer_plan_carrera();
		
		$array_materias_cursar = $plan_carrera[0]['mat_cursar'];
		
		$array_materias_cursar_deserializado = unserialize($array_materias_cursar);
		
		  foreach($array_materias_cursar_deserializado as $mat){
	    if($mat['llamado']!="APROBADA")
            $materias_cursar_filtro[$mat['materias']] = $mat;
        }

		
		echo "Programadas:";
		echo "<br>";
		echo "<ul>";
		$cantidad= 0;
		foreach($materias_cursar_filtro as $key=>$mate)
		{
			$materia = explode('-',$mate['materias']);
			$query="select * from materias_carrera where materia=".$materia[0]." and plan=".$materia[2]." and carrera=".$materia[1]."";
			$resultado = $this->query($query);
			echo "<li>";	
			echo $resultado[0]['nombre'];
			if($resultado[0]['nombre'] != "") $cantidad++; 
			echo "</li>";
		}
		echo "</ul>";
		
		
require_once('class.sysacadMateriasAprobadas.php');
$sysacad = new Sysacad();
$resultado = $sysacad->obtenerMaterias($id_alumno);

		$con = new Coneccion();


		echo "Aprobadas:";
		echo "<br>";
		echo "<ul>";
		foreach($resultado as $mate)
		{
			$query="select * from materias_carrera where materia=".$mate['materia']." and plan=".$mate['plan']." and carrera=".$mate['especialidad']."";
			//echo $query;
			$resultado2 = $this->query($query);

			echo "<li>";	
			echo $resultado2[0]['nombre'];
			echo "</li>";
		}
		echo "</ul>";
		
		//$cantidad = count($array_materias_cursar_deserializado);
		$cantidad2 = count($resultado);
		
		echo "<br>";
		echo "Efectividad: ".$cantidad2." / ".$cantidad;
		
		
		echo '<input type="hidden" name="155" id="155" value="Ninguno"></input>';

	}
	
	
	function DrawQuestion($id_pregunta,$id_formulario)
	{


		$select_valores_pregunta = "select * from preguntastitulo where id_pregunta=".$id_pregunta;
		$resultado_valores_pregunta_titulo = $this->query($select_valores_pregunta);
		$texto_pregunta     = $resultado_valores_pregunta_titulo[0]['texto'];
		$color              = $resultado_valores_pregunta_titulo[0]['color'];
		$color2              = $resultado_valores_pregunta_titulo[0]['color2'];
		$texto_descripcion  = $resultado_valores_pregunta_titulo[0]['descripcion'];     
		
		if($texto_pregunta!="")
		{

			echo "<div style='width:100%'><font face='Arial' size='+2' color='".$color."'>".$texto_pregunta."</ul></font><br><font face='Arial' color='".$color2."'>".$texto_descripcion."</font></div>";
		}

		$select_valores_pregunta = "select * from preguntas where idpregunta=".$id_pregunta;
		$resultado_valores_pregunta = $this->query($select_valores_pregunta);
		$texto_pregunta = $resultado_valores_pregunta[0]['texto'];
		
		//echo "1";
		$select_preguntas_form="select * from respuestaspreg preg inner join tipospreguntas tipo
		on preg.idtipo=tipo.idtipo where idpregunta=".$id_pregunta." and idpadre is null order by orden asc";
		
		$resultado_preguntas_form = $this->query($select_preguntas_form);
		if(count($resultado_preguntas_form)==0)
		{
			return 0;
		}
		
		echo '<div  id="'.$id_pregunta.'" class="panel panel-primary"><div class="panel-heading"><h3 class="panel-title">' . $texto_pregunta . '</h3></div><div class="panel-footer">';

	//	echo '<fieldset id="'.$id_pregunta.'"><legend>'.$texto_pregunta.'</legend>';

		
		foreach($resultado_preguntas_form  as $pregunta)
		{	
			switch($pregunta['tipo_control']){			
				case 'label':
					$this->DrawLabel($pregunta['texto']);break;
				case 'select':
					$this->DrawSelect($id_pregunta); break;
				case 'text':
					$this->DrawText($pregunta['valor'],$pregunta['id'],$pregunta['id'],$pregunta['texto']); break;
				case 'check':
					$this->DrawCheck($pregunta['texto'],$pregunta['estado'],$pregunta['id'],$pregunta['id']); break;
				case 'radio'://radiogroup
					$this->DrawRadio($pregunta['texto'],$pregunta['estado'],$pregunta['name'],$pregunta['id'],$id_pregunta); break;
				case 'area':
					$this->DrawTextArea($pregunta['texto'],$pregunta['id'],$pregunta['id'],$pregunta['rows'],$pregunta['cols']); break;	
				case 'submit':
					$this->DrawSubmit($pregunta['texto']);break;
				case 'tabla_agenda':
					$this->DrawAgenda();break;
				case 'plan_de_carrera':
					$this->DrawPlanCarrera();break;
				case 'plan_carrera_reporte':
					$this->DrawPlanCarreraReporte();
				break;
			}
		}		

		echo '</div></div>';	
	}
}
?>
