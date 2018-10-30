<?php
session_start();
$usuario = $_SESSION['usuario'];

require_once('ver_login.php');

if($usuario==""){
    exit();
}

$con = new Mongo(); // Connect to Mongo Server
$db = $con->selectDB("solicitudes"); // Connect to Database
$collection = new MongoCollection($db, "solicitudes");

//$busqueda = "";
//$busqueda = array('_id' => new MongoId($id));  
$cursor = $collection->find();
$array_solicitud = iterator_to_array($cursor);

if($_REQUEST['accion']=="guardar"){
  
    
    
    foreach ($_REQUEST['json'] as $key => $arrayjr)
         foreach ($arrayjr as $name => $value) 
            $arrayMongo[$name]=$value;
    
     $arrayMongo['estado']="nuevo";
     print_r($arrayMongo);
    $collection->save($arrayMongo);
    exit();
}
?>	
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<!-- Bootstrap core CSS -->
		<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
		<style>
			body { padding-top: 50px; }
		</style>
	</head>
	<body>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
	
	<form class="form-horizontal" role="form"  id='myform' name='myform'>

	<div class="form-group">
  <label class="col-md-4 control-label" for="tema">Asunto</label>
  <div class="col-md-4">
    <input id="tema" name="tema" type="text"  size="200" width="200" maxlength="200" placeholder="Tema" class="form-control input-md">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textarea">Descripci&oacute;n</label>
  <div class="col-md-4">                     
    <textarea cols="150" rows="5" class="form-control" id="descripcion" name="descripcion"></textarea>
  </div>
</div>
	
	
	
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						 
						<button type="submit" class="btn btn-primary"  onclick="insertar();">
							Grabar
						</button>
					</div>
				</div>
	
	
	
	
    <input type='hidden' name='usuario' id='usuario' value="<? echo $usuario; ?>"/>
</form>


<table class='table table-bordered table-striped'  width='100%' align='center' cellpadding='2' cellspacing='2'>
<?php
$a = 0;

foreach ($array_solicitud as $solicitud) {

	if($solicitud['estado']=="cerrado") continue 1;
		$fila = "";
		$fila .= "<tr>";
		$titulo .="<tr>";
		ksort($solicitud);
		foreach ($solicitud as $k => $sol) {      
		  //  if($k=="descripcion"){ $sol="<textarea>".$sol."</textarea>";}

			$titulo .= "<th>".$k."</th>";
			if(trim($sol)=="prueba"){$color="success";}	elseif($sol=="nuevo"){$color="info";}else{$color="";}
			$fila .= "<td class='".$color."'>".$sol."</td>";			
			
		}
		$fila .= "</tr>";
		$titulo .="</tr>";
		if($a==0){
			echo $titulo;
		}
		$a = 1;
		echo $fila;
}

?>
</table>
</div>	
		
		
		
		
		
		
		</div>
	</div>
</div>
	

        <script src="bootstrap/js/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="bootstrap/js/jquery.min.js"><\/script>')</script> 
        <script src="bootstrap/dist/js/bootstrap.min.js"></script> 		
		<script>

function insertar(){
     var frm = jQuery(document.myform);

     var data = JSON.stringify(frm.serializeArray());

data = data.replace(/\\r\\n/g, "<br />");


     data =JSON.parse(data);


     var json = "["
     $.each(data,function(index,item){
         
         json+='{"'+item.name+'":"'+item.value.trim()+'"},';
     });
     


     json = json.substring(0,json.length-1);
     json+="]";
     json = JSON.parse(json);
    
     $.post("",{"json":json,"accion":"guardar"},function(){location.reload();});

    
}    
</script>

	</body>
</html>





