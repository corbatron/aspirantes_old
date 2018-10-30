<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>CorbiLine - Responsive Timeline</title>
        <meta name="viewport" content="width=device-width, minimum-scale= 1.0, initial-scale= 1.0">

        <!-- stylesheets -->
        <link href='http://fonts.googleapis.com/css?family=Dosis:300,400,500,600,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/base.css">

    </head>
   
<link href="css/uploadfile.min.css" rel="stylesheet">    
<script type="text/javascript" src="jquery-latest.min.js"></script>
<script src="js/jquery.uploadfile.min.js"></script>
<script>
hash_file = "";
ext_file ="";
orig_file="";
$(document).ready(function()
{
	$("#archivo").uploadFile({
	url:"file.php",
	fileName:"myfile",
        returnType : "json",
onSuccess:function(files,data,xhr)
{
 hash_file = data.hash;
 ext_file = data.ext;
 orig_file = data.original;
},

        done: function(e,data){
             alert(1);
      }

	});
});

    function insertar() {
       
        

	
	if($("#description").val().length > 1000){
                alert("La descripcion no debe superar los 1000 caracteres");
                exit();
	}





	$("#description").val($("#description").val().replace(/\"/g,''));



        
        var frm = $("#formulario");


        var data = JSON.stringify(frm.serializeArray());


        data = data.replace(/\\r\\n/g, "<br />");







        data = JSON.parse(data);



        var json = "["
        $.each(data, function(index, item) {
            if(item.value.trim()==""){
                alert("Debe completar todos los campos");
                exit();
            }
            json += '{"' + item.name + '":"' + item.value.trim() + '"},';
        });
	 if(hash_file!=""){
	  json += '{"file":"' + hash_file + '.' + ext_file +'"},';
	  json += '{"filename":"' + orig_file +'"},';
	}
        json = json.substring(0, json.length - 1);
        json += "]";

	json =json.replace(/\s\s+/g, ' ');

	json = json.replace(/[\t\n]+/g,"")

        json = JSON.parse(json);


     //   json = data;

        $.post("", {"json": json, "accion": "guardar"}, function() {
            location.reload();
        });

    }
</script>
<?php
session_start();
require_once('ver_login.php');
require_once("class.seguimiento.php");

$seguimiento = new Seguimiento();
$array_solicitud = $seguimiento->read($_REQUEST);

if($_REQUEST['accion']=="guardar"){
  
    $seguimiento->save($_REQUEST);
    exit();
}

?>
<body onload="doOnLoad();">
   <link rel="stylesheet" type="text/css" href="codebase/dhtmlxcalendar.css"></link>
	<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxcalendar_dhx_skyblue.css"></link>
	<script src="codebase/dhtmlxcalendar.js"></script>
	<script>
		var myCalendar;
		function doOnLoad() {
			myCalendar = new dhtmlXCalendarObject(["date_user"]);
		}
	</script>



        <div class="container">
            <h1 class="project-name">Linea del Tiempo</h1>
            <div id="timeline">



<?php

$star="star.svg";
$book="book.svg";
$class = "right";

$a = true;

ksort($array_solicitud);
foreach ($array_solicitud as $solicitud) {
$imagen=$star;
if($solicitud['origin']=="SIT FORMS MODULE" || $solicitud['origin']=="SIT PRBL MODULE" || $solicitud['origin']=="SIT PERCEPTION MODULE"  )
    $imagen = $book;
$a=!$a;
$divclass="";
if($a)
 $divclass=$class;

?>


 <div class="timeline-item">
                    <div class="timeline-icon">
                        <img src="images/<?php echo $imagen; ?>" alt="">
                    </div>
                    <div class="timeline-content <?php echo $divclass; ?>">
                        <h2><? echo $solicitud['date_system'];  ?></h2>
                        <p>
Fecha: <? echo $solicitud['date_user']; ?>
                        </p>
                        <p>
Origen: <? echo $solicitud['origin']; ?>
                        </p>
                        <p>
Comentarios: <? echo $solicitud['description']; ?>
                        </p>
			   <?
				if($solicitud['file']!=""){
?>
                        <p>
<? echo '<a href="files_seguimiento/download.php?file='.$solicitud["file"].'"><img src="images/clip.svg">'.$solicitud["filename"].'</a>'; ?>
  	                      </p>
			<?
			}
?>
                    </div>
                </div>





<?


    
  
}

?>
                <div class="timeline-item">

                    <div class="timeline-icon">
                        <img src="images/star.svg" alt="">
                    </div>
                    <div class="timeline-content">
                        <form id="formulario" name="form_data" enctype="multipart/form-data">
                            <h2>

                                <?php
                                $date = new DateTime();
                                $date->setTimezone(new DateTimeZone('America/Argentina/Buenos_Aires'));
                                $date_system = $date->format('Y/m/d H:i:s P T');
                                echo $date_system;
                                ?>

                            </h2>
                            <p>
                                <input id="date_system" name="date_system" value="<?php echo $date_system; ?>" type="hidden"></input>
				<input id="user" name="user" value="<?php echo $_REQUEST['dni']; ?>" type="hidden"></input>
				<input id="author" name="author" value="<?php echo $_SESSION['id']; ?>" type="hidden"></input>

                                <input id="date_user" name="date_user"  required type="date" placeholder="Fecha" class="input_text"></input>
                            </p>
                            <p>
                                <select id="origin" name="origin" width="100">
                                    <option value="e-Mail">e-Mail</option>
                                    <option value="Telefono">Tel&eacute;fono</option>
                                    <option value="Entrevista">Entrevista</option>
                                    <option value="Entrevista Esp.">Entrevista Esp.</option>
                                    <option value="Otra">Otra</option>
                                </select>
                            </p>
                            <p>
                            <div style="width:200Px;">
                                <input type="file" name="archivo" id="archivo">
                            </div>
                            </p>
                            <p>
                                <textarea id='description' name='description' required style="overflow:auto;resize:none" maxlength="1000" rows="5" cols="50" placeholder="Comentarios (max 1000 caracteres) "></textarea>
                            </p>
                            <a onclick="insertar()" class="btn">Grabar</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </body>
</html>