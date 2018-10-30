<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Sistema Informatico de Tutorias</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<meta name="description" content="slick Login">
<meta name="author" content="Webdesigntuts+">
<link rel="stylesheet" type="text/css" href="styleform.css" />
<link rel="shortcut icon" href="../favicon.ico"> 
<link rel="stylesheet" type="text/css" href="css/default.css" />
<link rel="stylesheet" type="text/css" href="css/component.css" />
<script src="js/modernizr.custom.js"></script>
<script type="text/javascript" src="jquery-latest.min.js"></script>
<script src="modernizr-latest.js"></script>
<script type="text/javascript" src="placeholder.js"></script>
</head>
<body>
<script>
function cambiar_cohorte(id)
{
	if(id==1)
	{
		if(parseInt($('#anio_ingreso').val())>=2013)
		{
			$('#anio_ingreso').val(parseInt($('#anio_ingreso').val())-1);
			$('#boton_enviar').val("Ingrese al SIT "+$('#anio_ingreso').val());
		}
	}
	else
	{
		if(parseInt($('#anio_ingreso').val())<=2015)
		{
			$('#anio_ingreso').val(parseInt($('#anio_ingreso').val())+1);
			$('#boton_enviar').val("Ingrese al SIT "+$('#anio_ingreso').val());
		}
	}
}
</script>
<form id="slick-login" name="myForm" method="post" action="veriflogin.php" enctype="multipart/form-data">
<label for="firstname">Usuario</label><input type="text" name="firstname" class="placeholder" placeholder="usuario">
<label for="lastname">Constraseña</label><input type="password" name="lastname" class="placeholder" placeholder="contrase&ntilde;a">
<br>
<select required name="anio_ingreso" id="anio_ingreso">
	<option selected value="0" >Seleccione a&ntilde;o de ingreso</option>
	<option value="2012">A&ntilde;o 2012</option>
	<option value="2013">A&ntilde;o 2013</option>
	<option value="2014">A&ntilde;o 2014</option>
	<option value="2015">A&ntilde;o 2015</option>
        <option value="2016">A&ntilde;o 2016</option>
</select>
<input type="submit" name="boton_enviar" id="boton_enviar" value="Ingrese al SIT">

</form>
<!--input type="hidden" name="anio_ingreso" id="anio_ingreso" value="2015"
<br>
<br>
<font color="white" size="2" onclick="cambiar_cohorte(1);" style="cursor:pointer;"> << Ingresar a la cohorte anterior..</font>
<br>
<font color="white" size="2" onclick="cambiar_cohorte(0);" style="cursor:pointer;"> Ingresar a la cohorte siguiente >> </font>

-->
<div class="md-modal md-effect-1" id="modal-1">
	<div class="md-content">
		<h3>Atenci&oacute;n</h3>
		<div>
			<p>Usuario o contrase&ntilde;a incorrecta</p>
			<ul>	
				<li>Se ha detectado un error en la autenticaci&oacute;n del usuario</li>
				<li>Por favor verifique que el usuario, contrase&ntilde;a y cohorte seleccionadas sean correctas</li>
				<li>En caso de que el problema persista, puede acercarse personalmente a las oficinas de tutor&iacute;as<li>
			</ul>
			<button class="md-close">Cerrar</button>
		</div>
	</div>
</div>
<p class="md-trigger"  data-modal="modal-1" id='modal1'></p>
<div class="md-overlay"></div><!-- the overlay element -->
<script src="js/classie.js"></script>
<script src="js/modalEffects.js"></script>


<!-- for the blur effect -->
<!-- by @derSchepp https://github.com/Schepp/CSS-Filters-Polyfill -->
<script>
	// this is important for IEs
	var polyfilter_scriptpath = '/js/';
</script>
<script src="js/cssParser.js"></script>
<script src="js/css-filters-polyfill.js"></script>

</body>
</html>
<?
if($_GET['error']=="KO")
{
echo "<audio src='sounds/tun.3gp' autoplay></audio>";
?>
<script>
document.getElementById('modal1').click();
</script>
<?
}
session_destroy();
?>
