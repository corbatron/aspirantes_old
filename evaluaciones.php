<?php
class Riesgo extends Coneccion{

 function Riesgo(){
		$this->Coneccion();
	}	
	
 function riesgo_foda($documento)
{
	$query_select     = "select 1 as valor from alumnoform where campo_magico='-' and trim(idalumno)='".$documento."' and idform=21";
	$resultado_select = $this->query($query_select);
	$resultado_bien	  = $resultado_select[0]['valor'];
	return $resultado_bien;
}

function guardar_riesgo($documento,$riesgo)
{
	$query_insert = "update alumnos set riesgo='".$riesgo."' where trim(dni)='".trim($documento)."'";

	$resultado_select = $this->query($query_insert);

}

function riesgo_alumno($documento){
    $query="select campo_magico,idform from alumnoform where trim(idalumno)='".$documento."'";
    $resultado = $this->query($query);
    foreach($resultado as $res){
        //print_r($res);
        $array_resultado[$res['idform']]=$res['campo_magico'];
    }
    
    $cantidad = 0;
    $cantidad_positivos = 0;
    $cantidad_asignados = 0;
    
    if(count($array_resultado)<4){
        $this->guardar_riesgo($documento,"INCOMPLETO");
        return "INCOMPLETO";
        
    }
    foreach($array_resultado as $form=>$valor){
        if(($form==21) && $valor=="-"){ 
        $this->guardar_riesgo($documento,"ALTO");
        return "<font color='RED'>ALTO</font>";}
        
        if($form==18 || $form==21 || $form==22 || $form==1 || $form==2 || $form==25 || $form==32){
            if($valor=="-" || $valor=="D"  || $valor=="NEUTRO"){
                $cantidad=$cantidad + 1;
            }elseif($valor=="+" || $valor=="T"){
                $cantidad_positivos = $cantidad_positivos + 1;
            }elseif($valor==""){
                $cantidad_asignados = $cantidad_asignados + 1; 
            }
        }
        
       
        
        
    }
   
    
    
    if($cantidad_asignados >= 1){
        $this->guardar_riesgo($documento,"INCOMPLETO");
        return "INCOMPLETO";
    }
    
    if($cantidad == 2 && $cantidad_positivos == 2){
        $this->guardar_riesgo($documento,"MEDIO");
        return "MEDIO";
    }
    
    if($cantidad >= 3){
        $this->guardar_riesgo($documento,"ALTO");
        return "<font color='RED'>ALTO</font>";
    }
    
    if($cantidad_positivos >=4){
        $this->guardar_riesgo($documento,"NULO");
        return "NULO";
    }
    
    if($cantidad <= 2){
        $this->guardar_riesgo($documento,"BAJO");
        return "BAJO";
    }
    
    if($cantidad == 3){
    $this->guardar_riesgo($documento,"MEDIO");
        return "MEDIO";
    }
 
  //  return $array_resultado;
    
}

}

?>