<?
include("ver_login.php");
require_once("cabecera_ajax.php");
?>




	<script src="../js/dhtml-suite-for-applications.js"></script>
	<script src="../js/ajax.js"></script>
	<form>	
	<div id="mainContainer">
		<div style='display:none;'></div>	
	</div>
	</form>




<script type="text/javascript">
messageObj = new DHTMLSuite.modalMessage();	// We only create one object of this class
messageObj.setWaitMessage('Loading message - please wait....');
messageObj.setShadowOffset(5);	// Large shadow

DHTMLSuite.commonObj.setCssCacheStatus(false);




function displayMessage(url)
{
	
	messageObj.setSource(url);
	messageObj.setCssClassMessageBox(false);
	messageObj.setSize(500,400);
	messageObj.setShadowDivVisible(true);	// Enable shadow for these boxes
	messageObj.display();
}

function displayStaticMessage(messageContent,cssClass)
{
	messageObj.setHtmlContent(messageContent);
	messageObj.setSize(300,150);
	messageObj.setCssClassMessageBox(cssClass);
	messageObj.setSource(false);	// no html source since we want to use a static message here.
	messageObj.setShadowDivVisible(false);	// Disable shadow for these boxes	
	messageObj.display();
	
	
}

function closeMessage()
{
	messageObj.close();	
}
</script>
<script>
function cambiar()
{
	dni = document.getElementById('documento').value;
	ajax_loadContent('cambio_usuario',"ajax_usuario.php?documento="+dni); 
}
</script>
<?






include('class.form.php');
include('class.alumnos.php');
include('class.alumnosFormularios.php');
$id_alumno = $_SESSION['id']; 
$alumno = new Alumno($id_alumno);
if($alumno->get_fechaNac() == "")	{
	?>
&nbsp;<script>displayMessage('actualizarAlumno.php');</script><?
}



$formularios = new alumnosFormularios($id_alumno);
session_start();
$formu=$formularios->traerForms();
$directorio = $_SERVER['HTTP_HOST']."/aspirantes";
//Encabezado con los datos personales 


if($_REQUEST['email']!="")
{

	$email = $_REQUEST['email'];

}
if($_REQUEST['texto']!="")
{

	$texto=$_REQUEST['texto'];

}

if($texto!="" && $email!="")
{

	$alumno->enviar_mensaje($email,$texto);

}

?>

 
<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxmenu_dhx_skyblue.css">
<script src="codebase/dhtmlxcommon.js"></script>
<script src="codebase/dhtmlxmenu.js"></script>
<script src="codebase/ext/dhtmlxmenu_ext.js" type="text/javascript"></script>

 <body onload="initMenu();Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div style="height: 20Px"><div id="menuObj"></div></div>


<div id='div_bug' name='contacto' style='width:500Px;height:200Px;background-color:#CCCCCD;position:absolute;left:550px;top:50px;border:1Px solid;display:none'>
<form >
<table><tr><td>
e-mail</td><td><input type='text' name='email' size='40'></input></td></tr>
<tr>
<td>
comentario
</td>
<td>
<textarea cols='50' rows='7' name='texto' wrap='virtual'>
</textarea>
</td>
</tr>
<tr>
<td>
<input type='submit' value='enviar'></input>
</td>
<td>
</td>
</tr>
</table></div>
<?
if($_SESSION['perfil']!=1)
{
?>
<div id='cambiar_usuario' style='display:none;background-color:#CCCCCC;'>
<table>
<tr>
<td>
Documento:
</td>
<td>
<input type='text' name='documento' id='documento' >
</td>
<td>
<input type='button' value='Cambiar usuario' onclick='cambiar()' />
</td>
</tr>
</table>
</div>
<div id='cambio_usuario'>
</div>
<?
}
//// MARIANO 06/09/2012 - Para cambiar de usuario sin hacer click en el boton de "CAMBIAR USUARIO"
echo "<script>";
if($_REQUEST['documento']!="" and ($_SESSION['perfil']==2 or $_SESSION['perfil']==3))
{
//echo "alert(11)";
	echo 'ajax_loadContent(\'cambio_usuario\',"ajax_usuario.php?documento='.$_REQUEST['documento'].'")';	
}
echo "</script>";

?>
</form>
<script>

var menu;
var menuData;
function initMenu() {
		menuData = {
        parent: "menuObj",
        icon_path: "common/imgs/",
        items: [{
            id: "log_1",
            text: "Login",
            items: [{
                id: "cla_1",
                text: "Cambio de clave",
                img: "new.gif"
            }, {
                id: "sep0",
                type: "separator"
            }, {
                id: "logou_1",
                text: "Logout",
                img: "close_dis.gif"
            
            }]
            },
			
			<?
			
			session_start();
			if($_SESSION['perfil']!=1)
			{
			if($_SESSION['perfil']!=3)
			{
			?>

			{
            id: "Administrador",
            text: "Administrador",
            items: [{
                id: "form_1",
                text: "Formularios",
                img: "paste.gif"
            },{
                id: "sep3",
                type: "separator"
            }, {
                id: "preg_1",
                text: "Preguntas formularios",
                img: "new.gif"
            }, {
                id: "asign_1",
                text: "Asignacion de formularios",
                img: "new.gif"
            },  {
                id: "alumnos_1",
                text: "Alumnos",
                img: "new.gif"
            }, {
                id: "sepImp",
                type: "separator"
            },{
                id: "importacion",
                text: "Importaci&oacute;n de alumnos",
                img: "new.gif"
            } ]
            },
			{
            id: "Reporte",
            text: "Reporte",
            items: [{
                id: "repo_01",
                text: "Reporte",
                img: "about.gif"
            }]
			},
			<?
			}
			?>
			{
            id: "Instrumentos",
            text: "Instrumentos cargados",
            items: [{
                id: "repo_02",
                text: "Reporte Instrumentos",
                img: "about.gif"
            },
			{
				id: "cambiar_1",
				text: "Cambiar usuario",
				img: "about.gif"
			},
			{
				id: "evaluacion_1",
				text: "Percepci&oacute;n tutor",
				img: "about.gif"
			}
			]
			},
			
			<?
			}
			?>
				{
            id: "Ayuda",
            text: "Ayuda",
            items: [{
                id: "Bug",
                text: "Reportar error",
                img: "about.gif"
            }]
            }]
        };
    menu = new dhtmlXMenuObject(menuData);
	menu.attachEvent("onClick", menuClick);

}

</script>
<script>
function menuClick(id)
{
switch(id)
{
case "preg_1":
document.all.iframe_1.src="http://<?echo $_SERVER['HTTP_HOST']?>/aspirantes/template_formularios_preguntas_respuestas.php/";		
break;
case "logou_1":
location.href="http://<?echo $_SERVER['HTTP_HOST']?>/aspirantes/index.php";
break;
case "form_1":
document.all.iframe_1.src="http://<?echo $_SERVER['HTTP_HOST']?>/aspirantes/formularios.php";
break;
case "repo_01":
document.all.iframe_1.src="http://<?echo $_SERVER['HTTP_HOST']?>/aspirantes/reporte_encuestas.php";
break;
case "Bug":
mostrar_div_mensajes();
break;
case "alumnos_1":
document.all.iframe_1.src="http://<?echo $_SERVER['HTTP_HOST']?>/aspirantes/alumnos_cargar_nuevo.php";
break;
case "repo_02":
document.all.iframe_1.src="http://<?echo $_SERVER['HTTP_HOST']?>/aspirantes/reporte_instrumentos_cargados_alumnos.php";
break;
case "asign_1":
document.all.iframe_1.src="http://<?echo $_SERVER['HTTP_HOST']?>/aspirantes/template_formularios_alumnos.php";
break;
case "cambiar_1":
document.getElementById('cambiar_usuario').style.display='block';
break;
case "evaluacion_1":
document.all.iframe_1.src="http://<?echo $_SERVER['HTTP_HOST']?>/aspirantes/tutor_percepcion.php";
break;
case "importacion":
document.all.iframe_1.src="http://<?echo $_SERVER['HTTP_HOST']?>/aspirantes/tutorias_loader.php";
break;

}
}


</script>
<iframe name ="iframe_1" id="iframe_1" width='100%' height='800px'>


</iframe>
</body>

<?
if($_SESSION['perfil']==1)
{
?>
<script>
document.all.iframe_1.src="http://<?echo $_SERVER['HTTP_HOST']?>/aspirantes/alumnosforms.php";
</script>
<?
}
?>

<script>

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

