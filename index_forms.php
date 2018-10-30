<?
session_start();
if($_SESSION['id']=="" || $_SESSION=="")
{
	exit();
	die();

}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<head>
<meta charset="utf-8">
<title>Sistema Informatico de Tutorias</title>
<link rel="shortcut icon" href="../favicon.ico">
</head>


<?
include("ver_login.php");
require_once("cabecera_ajax.php");
include("notificaciones.php");
$isIE = "";
if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)){
	echo '<link href="css/menuIE.css" rel="stylesheet" type="text/css"/>';
	$isIE = true;
}else{
	echo '<link href="css/menu.css" rel="stylesheet" type="text/css"/>';
	$isIE = false;
}


?>


<script src="../js/ajax.js"></script>
<script src="../js/dhtml-suite-for-applications.js"></script>
<script>

function abrirWiki(){
 window.open("http://aspirantes.frgp.utn.edu.ar/mediawiki/index.php");

}


function cambiar()
{
	dni = document.getElementById('documento').value;
	ajax_loadContent('cambio_usuario',"ajax_usuario.php?documento="+dni); 
}
function mostrar_div_mensajes()
{
	if(document.getElementById('div_bug').style.display=="block")
	{
		document.getElementById('div_bug').style.display="none";
	}
	else
	if(document.getElementById('div_bug').style.display=="none")
	{
		document.getElementById('div_bug').style.display="block";
	}
}
</script>

<form>
	<div id="mainContainer">
		<div style='display:none;'></div>	
	</div>
</form>
<script>

messageObj = new DHTMLSuite.modalMessage();	// We only create one object of this class
//messageObj.setWaitMessage('Loading message - please wait....');
//messageObj.setShadowOffset(5);	// Large shadow
//DHTMLSuite.commonObj.setCssCacheStatus(false);
function displayMessage(url)
{
	
	messageObj.setSource(url);
//	messageObj.setCssClassMessageBox(false);
//	messageObj.setSize(0,0);
//	messageObj.setShadowDivVisible(true);	// Enable shadow for these boxes
	messageObj.display();
}
<?
include('class.form.php');
include('class.alumnos.php');
include('class.alumnosFormularios.php');
$id_alumno = $_SESSION['id']; 
$alumno = new Alumno($id_alumno);
if($alumno->get_fechaNac() == ""){	?>
displayMessage('actualizarAlumno.php');
<?
}
$formularios = new alumnosFormularios($id_alumno);
session_start();
$formu=$formularios->traerForms();
$directorio = $_SERVER['HTTP_HOST']."/aspirantes";
//Encabezado con los datos personales 
if($_REQUEST['email']!="")
	$email = $_REQUEST['email'];
if($_REQUEST['texto']!="")
	$texto=$_REQUEST['texto'];
if($texto!="" && $email!="")
	$alumno->enviar_mensaje($email,$texto);

?>
</script>
<form>
    <div id='div_bug' class="box" style="display: none;">
        <h1>Cont&aacute;ctenos :</h1>
        <label>
        <span>Email</span>
        <input type="text" class="input_text" name="email" id="email"/>
        </label>
        <label>
        <span>Asunto</span>
        <input type="text" class="input_text" name="subject" id="subject"/>
        </label>
        <label>
        <span>Mensaje</span>
        <textarea class="message" name="texto" id="feedback" wrap='virtual'></textarea>
        <input type="submit" class="button" value="Enviar" />
        </label>
    </div>
<?
if($_SESSION['perfil']!=1){
?>
    <div class="box" id='cambiar_usuario' style='display:none;'>
        <h1>Documento :</h1>
        <label>
        <span>Por favor ingrese el DNI aqu&iacute; </span>
        <input type="text" class="input_text" name="documento" id="documento"/>
        </label>
        
        <input type="button" class="button" value="Cambiar usuario" onclick="cambiar()"/>
    </div>
    
<div id='cambio_usuario'>
</div>
<?
}
//// MARIANO 06/09/2012 - Para cambiar de usuario sin hacer click en el boton de "CAMBIAR USUARIO"
echo "<script>";
if($_REQUEST['documento']!="" and ($_SESSION['perfil']==2 or $_SESSION['perfil']==3))
{
	echo 'ajax_loadContent(\'cambio_usuario\',"ajax_usuario.php?documento='.$_REQUEST['documento'].'")';	
}
echo "</script>";

?>
</form>




<div id='cssmenu'>
<?
	if($isIE) echo "<ul class='topmenu' id='cssmenu3'>";
	else echo "<ul>";

	$menuArray = "";
	$perfil = $_SESSION['perfil'];//simulador de permisos
	$fp = fopen ( "menu_accion.csv" , "r" ); 
	while (( $data = fgetcsv ( $fp , 1000 , ";" )) !== FALSE ) { // Mientras hay l&iacute;neas que leer...	
		if((($data[0][0] == $perfil) || ($data[0][0] == 0)) & $data[0][0]!='#')	$menuArray[]=$data;
	} 
	fclose( $fp ); 
	
	
	for($i = 0; $i< count($menuArray) ; $i++){
        $menu = $menuArray[$i][1];//titulo del menu
		echo "<li class='has-sub'><a href='#'><span class='flecha'>$menu</span></a>";		
		
		$flag= true;
		if($isIE) echo "<div class='submenu'><div class='column'>";
		echo "<ul>";
        for($j = $i+1; $j< count($menuArray) ; $j++){ 
            if($menuArray[$j][1] == $menu){
                $accion = str_replace("SERVER",$_SERVER['HTTP_HOST'],$menuArray[$j][3]);
                $accion = str_replace('"','\'',$accion);
                echo  "<li onclick=".$accion." ><a href='#' ><img src=".$menuArray[$j][4]."><span >".$menuArray[$j][2]."</span></a></li>";
                $i=$j;
            }
        }
		
        echo "</ul>"; 
		
		if($isIE) echo "</div></div>";
		echo "</li>";
	}	
	
	

	
?>
</ul>
</div>

<iframe name ="iframe_1" id="iframe_1" width='100%' height='800px' style='background-color:#FFF'></iframe>



<?php
if($_SESSION['perfil']==1)
{
?>
<script>document.getElementById('iframe_1').src="http://<?echo $_SERVER['HTTP_HOST']?>/aspirantes/alumnosforms.php";</script>
<?php
}else{
?>
<script>document.getElementById('iframe_1').src="http://<?echo $_SERVER['HTTP_HOST']?>/aspirantes/noticias.php";</script>
<?php
}

		
?>		

