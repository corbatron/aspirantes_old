<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="jquery-latest.min.js"></script>
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
     
    $collection->save($arrayMongo);
    exit();
}


?>
<form id='myform' name='myform'>
    <table width='100%' cellpadding='2' cellspacing='2'>
        <tr><td bgcolor='#0000FF'><p style="color:white">Tema</p></td><td><input type="text" size="200" width="200" maxlength="200" id='tema' name='tema'/></td></tr>
        <tr>
            <td bgcolor='#0000FF'><p style="color:white">Descripci&oacute;n</p></td><td>
                <textarea cols="150" rows="5" id='descripcion' name='descripcion'></textarea>
            </td>
        </tr>
        <tr align='center'><td colspan='2'><input type='button' value='Enviar' onclick="insertar();"/></td></tr>
    </table>
    <input type='hidden' name='usuario' id='usuario' value="<? echo $usuario; ?>"/>
</form>


<div style='overflow-y: auto; width: 90%; height: 300px;'>
<table width='100%' align='center' cellpadding='2' cellspacing='2'>
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
        $titulo .= "<td bgcolor='#0000FF'><p style='color:white'>".$k."</p></td>";
        if(trim($sol)=="prueba"){$color="#F79F81";}elseif($sol=="nuevo"){$color="#58FAAC";}else{$color="#CECECE";}
        $fila .= "<td bgcolor='".$color."'>".$sol."</td>";
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
