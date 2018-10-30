<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<!-- Bootstrap core CSS -->
			<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
			<style>
				body { padding-top: 20px; }
			</style>
	</head>
	<body>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">


<?
include('ver_login.php');

include('classes/class.respuestasPreguntas.php');
?>
<div style='background-color:#556;
background-image: linear-gradient(30deg, #445 12%, transparent 12.5%, transparent 87%, #445 87.5%, #445),
linear-gradient(150deg, #445 12%, transparent 12.5%, transparent 87%, #445 87.5%, #445),
linear-gradient(30deg, #445 12%, transparent 12.5%, transparent 87%, #445 87.5%, #445),
linear-gradient(150deg, #445 12%, transparent 12.5%, transparent 87%, #445 87.5%, #445),
linear-gradient(60deg, #99a 25%, transparent 25.5%, transparent 75%, #99a 75%, #99a), 
linear-gradient(60deg, #99a 25%, transparent 25.5%, transparent 75%, #99a 75%, #99a);
background-size:80px 140px;
background-position: 0 0, 0 0, 40px 70px, 40px 70px, 0 0, 40px 70px;'>

 
        <div class="container">
            <div class="row-fluid">
                <!--div class="span-3"></div>  CORBI 26/02/2014     -->
                <div class="span-6">

<?

include('class.drawingBootstrap.php');

$objeto= new DrawingBootstrap();

echo "<table align='center'><tr><td style='color: white;'>";
echo "Para volver a la pantalla principal haga click <a href='#' onClick='redirect();'>aqu&iacute;</a>";
echo "</td></tr></table>";
echo "<h2 style='color: white;'>".$_SESSION['apellido'].", ".$_SESSION['nombre']." (".$_SESSION['id'].")"."</h2>";
echo "<hr align='left' width='100%'>";




echo '<div class="form-container">';
	$objeto->DrawForm($_REQUEST['formulario']); 
echo "</div>";
echo "<iframe style='display:none' width='100%' height='40%'  name='iframeproceso'>";
echo "</iframe>";


?>
</div>
</div>
               
            </div>
        </div>
        <script src="bootstrap/js/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="bootstrap/js/jquery.min.js"><\/script>')</script> 
        <script src="bootstrap/dist/js/bootstrap.min.js"></script> 
        <script src="bootstrap/js/tooltip.js"></script>


<script>
$(document).ready(function () {
        var dataform = document.querySelectorAll('[data-form]');
        for(var i = 0; i < dataform.length ; i++){
            document.querySelectorAll('[data-form]').item(i).addEventListener("click",function(){
		//$('#iframe_1').attr("src","formBuilder.php?formulario="+this.dataset.form);
            
			window.location.href = "formBuilder.php?formulario="+this.dataset.form;
		},false);
        }
});
</script>
	</body>
<script>

$(document).ready(function () {
        var datacontrol = document.querySelectorAll('[data-control]');
        for(var i = 0; i < datacontrol.length ; i++){
            document.querySelectorAll('[data-control]').item(i).addEventListener("click",function(){
                $('#'+this.dataset.control)[0].disabled = !$('#'+this.dataset.control)[0].disabled ;
            },false);
        }
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

});



function validar()
{
	var valor;

	valor = confirm("\u00BFDesea enviar sus datos?");

	return valor;
}

function redirect()
{
	top.location.href="http://<? echo $_SERVER['HTTP_HOST']; ?>/aspirantes/main.php";
}
setInterval(function() { alert("Atencion: Su sesion esta por vencerse, esto puede ocasionar perdida de datos"); }, 1000*60*20); // call on interval

$(document).ready( function(){
           var array_iconos=[];
           array_iconos[3]="glyphicon glyphicon-wrench";
           array_iconos[2]="glyphicon glyphicon-briefcase";
           array_iconos[0]="glyphicon glyphicon-book";
           array_iconos[1]="glyphicon glyphicon-headphones";
           
           var array_colores=[];
           array_colores[0] = "btn btn-default";
           array_colores[1] = "btn btn-primary";
           array_colores[2] = "btn btn-success";
           array_colores[3] = "btn btn-warning";

          var array_tooltip=[];
           array_tooltip[0] = "Estudio fuera de la facu";
           array_tooltip[1] = "Otras actividades";
           array_tooltip[2] = "Estudio en la facultad";
           array_tooltip[3] = "Trabajo";


    
    $(".btn-agenda").click(function(){
           if(parseInt($(this).attr("valo"))==3){
             $(this).attr("valo",-1);
             $('#h_'+this.id).attr("value",-1);
           }
           $(this).attr("valo",parseInt($(this).attr("valo"))+1);
           $("#h_"+this.id).attr("value",parseInt($("#h_"+this.id).attr("value"))+1);
           changeImage(this);
    });
    



     
    
    $(".btn-agenda").on('contextmenu',function(e){
           if(parseInt($(this).attr("valo"))==0){
             $(this).attr("valo",4);
             $('#h_'+this.id).attr("value",4);
           }
           $(this).attr("valo",parseInt($(this).attr("valo"))-1);
           $("#h_"+this.id).attr("value",parseInt($("#h_"+this.id).attr("value"))-1);
           changeImage(this);
        e.preventDefault();
    });
    
    $(".btn-lg").off();
    





    function changeImage(element){
            var valor = $(element).attr("valo");  
            $("input:checkbox:checked").each(function(){
                //cada elemento seleccionado
                var spli;
                var spli_elemento;
                
                spli_elemento = $(element).attr('id').split("_");
                
                spli = $(this).attr('id').split("_"); 
             
                
                if(spli_elemento[1]!= spli[1]){
                      $('#'+spli_elemento[0]+'_'+spli[1]).removeClass().toggleClass(array_colores[valor]);
                      $('#'+spli_elemento[0]+'_'+spli[1]).children().removeClass().toggleClass(array_iconos[valor]);
                      $('#'+spli_elemento[0]+'_'+spli[1]).attr("valo",valor);
                      $('#h_'+spli_elemento[0]+'_'+spli[1]).attr("value",valor);
                      $('#'+spli_elemento[0]+'_'+spli[1]).attr("title",array_tooltip[valor]);

$('#'+spli_elemento[0]+'_'+spli[1]).tooltip('destroy');
$('#'+spli_elemento[0]+'_'+spli[1]).tooltip();
//$('#'+spli_elemento[0]+'_'+spli[1]).tooltip('show');
                }               
            });
           
  
           $(element).removeClass().toggleClass(array_colores[valor]);
           $(element).children().removeClass().toggleClass(array_iconos[valor]);
           $(element).attr("title",array_tooltip[valor]);

$(element).tooltip('destroy');
$(element).tooltip();
$(element).tooltip('show');


/*
  $('[data-toggle="tooltip"]').tooltip('destroy');
  $('[data-toggle="tooltip"]').tooltip();
  $('[data-toggle="tooltip"]').tooltip('show');
*/


    }
});

</script>
</html>

