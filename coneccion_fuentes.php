<?php
class ConeccionFuentes
{
    var $coneccion;
    
    function ConeccionFuentes()
    {
        $coneccion = pg_connect("host=localhost port=5432 user=postgres password=root dbname=fuentes");
        if(!$coneccion){
            return true;
        }else{
            return false;
        }
    }

    function query($consultasql)
    {
        $resultado = pg_query($consultasql);
        while($res = pg_fetch_array($resultado)){
            $resultado_devolver[]=$res;
        }  
        return $resultado_devolver;	
    }

}
?>
