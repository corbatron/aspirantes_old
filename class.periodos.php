<?php
require_once('coneccion.php');
Class Periodos extends Coneccion{
    private  $periodo;
    private  $nombre;
    private  $carrera;
    private $conexion;
    
    
    public function Periodos($id_periodo){
        $this->conexion = new Coneccion();
    }


    
    public function periodoCrear($id_carrera,$texto){
	    $select=" select 1 as valor from periodos where (id_carrera=".$id_carrera." and nombre='".$texto."') ";
		$resultado_select = $this->query($select);
		
		if($resultado_select[0][0]!="1"){
        $query_insert = " insert into periodos (id_carrera,nombre) values (".$id_carrera.",'".$texto."')";
        $this->query($query_insert);
		}
    }
    public function periodoBorrar(){}
    public function periodosCarrera($id_carrera){
        $query_select="select * from periodos where id_carrera=".$id_carrera;
		$contador = 0;
		$resultados_select = $this->conexion->query($query_select);
                
		foreach($resultados_select as $resu){
			$array_resultados[$contador]['id']   = $resu['id'];
			$array_resultados[$contador]['nombre'] = $resu['nombre'];	
		$contador ++;
		}
		
		
		return json_encode($array_resultados);
    }
    public function periodosMaterias($id_carrera){//id_periodo =".$id_periodo." and
		$query_select="select id,nombre from materias_carrera where id not in (select id_materia from materias_periodo where id_carrera=".$id_carrera.") and carrera=".$id_carrera." order by id asc";
		$resultados_select = $this->query($query_select);
		$contador=0;
		foreach($resultados_select as $resu){
			$array_resultados[$contador]['id']   = $resu['id'];
			$array_resultados[$contador]['nombre'] = $resu['nombre'];	
			$contador ++;
		}

		return json_encode($array_resultados);
	}
	
	
	public function materiasAsignadas($id_periodo){
		$query_select="select nombre,id,materia||'-'||carrera||'-'||plan as id_completo from materias_carrera where id in (select id_materia from materias_periodo where id_periodo=".$id_periodo.")";
                $resultados_select = $this->query($query_select);
		$contador=0;
		foreach($resultados_select as $resu){
			$array_resultados[$contador]['nombre'] = $resu['nombre'];
                     $array_resultados[$contador]['id'] = $resu['id'];
 			$array_resultados[$contador]['id_completo'] = $resu['id_completo'];
			$contador ++;
		}
		return json_encode($array_resultados);
	}
	
        public function asignarMAterias($id_carrera,$id_materia,$id_periodo){
            $query_insert = "insert into materias_periodo (id_carrera,id_materia,id_periodo) values (".$id_carrera.",".$id_materia.",".$id_periodo.")";
            $this->query($query_insert);
        }
	
        public function eliminarMateriasPeriodo($id_periodo,$id_materia){
            $query_delete="DELETE FROM materias_periodo where id_periodo=$id_periodo and id_materia=$id_materia";
            echo $query_delete;
            $this->query($query_delete);
        }
}



?>
