<?php
Class Ingreso extends Coneccion{

    
    private $resultado_formularios = null;
    
    function Ingreso(){
        $select_formulario = "select * from tipo_ingreso";		
	$this->resultado_formularios = $this->query($select_formulario);
    }
    
    public function getIngreso(){
        
        return $this->$resultado_formularios;
        
    }

}
?>