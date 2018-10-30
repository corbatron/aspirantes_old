<?php
//session_start();
Class Seguimiento{


function savePM($request){

   $con = new Mongo(); // Connect to Mongo Server
   $db = $con->selectDB("seguimiento"); // Connect to Database
   $collection = new MongoCollection($db, "seguimiento".$_SESSION['nombre_base']);

 $collection->save($request);


}


function save($request){
    $con = new Mongo(); // Connect to Mongo Server
   $db = $con->selectDB("seguimiento"); // Connect to Database
  $collection = new MongoCollection($db, "seguimiento".$_SESSION['nombre_base']);

 foreach ($request['json'] as $key => $arrayjr)
 	foreach ($arrayjr as $name => $value) 
  		$arrayMongo[$name]=$value;
         
 $collection->save($arrayMongo);
 
    
}

function read($request){
	
   $con = new Mongo(); // Connect to Mongo Server
   $db = $con->selectDB("seguimiento"); // Connect to Database
   $collection = new MongoCollection($db, "seguimiento".$_SESSION['nombre_base']);
   $busqueda = "";
   $busqueda = array('user' => $request['dni']);  

   $cursor = $collection->find($busqueda);
   $array_solicitud = iterator_to_array($cursor);
   return $array_solicitud;
}

}
