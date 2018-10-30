<!DOCTYPE html>
<html class="no-js" lang="es"><!--<![endif]--><head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>SIT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
<!-- alert start  <link href="customcss/default.css" rel="stylesheet"> -->
    <link href="customcss/component.css" rel="stylesheet">
<!--- fin alert -->

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="customcss/login.css" rel="stylesheet">
    <link href="customcss/animate-custom.css" rel="stylesheet">
   


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="bootstrap/js/html5shiv.js"></script>
      <script src="bootstrap/js/respond.min.js"></script>
    <![endif]-->
    
     <!-- script src="customjs/custom.modernizr.js" type="text/javascript"></script -->
   
  </head>
    <body>
    	<!-- start Login box -->
    	<div class="container" id="login-block">
    		<div class="row">
			    <div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">
			    	<!--h3 class="animated bounceInDown">Login</h3-->
			       <div class="login-box clearfix animated flipInY">
			        	<div class="login-logo">
			        		<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="180px" height="180px" viewBox="0 0 180 180" enable-background="new 0 0 180 180" xml:space="preserve">
<path fill-rule="evenodd" clip-rule="evenodd" fill="#2A2A2A" d="M0,90c0,49.71,40.29,90,90,90s90-40.29,90-90S139.71,0,90,0  S0,40.29,0,90z M40.5,80.5h39v-1.22c-22.32-5.01-39-24.94-39-48.78h20c0,12.69,7.87,23.53,19,27.92V30.5h20v28.62  c12.17-3.82,21-15.19,21-28.62h20c0,24.54-17.68,44.95-41,49.19v0.81h41v20h-41v0.81c23.32,4.24,41,24.65,41,49.19h-20  c0-13.43-8.83-24.8-21-28.63v28.63h-20v-27.92c-11.13,4.39-19,15.23-19,27.92h-20c0-23.84,16.68-43.77,39-48.79v-1.21h-39V80.5z"/>
</svg>
			        	</div> 
			        	<hr>
			        	<div class="login-form">
			        		<div class="alert alert-error hide">
								  <button type="button" class="close" data-dismiss="alert">×</button>
								  <h4>Error!</h4>
								   Your Error Message goes here
							</div>
			        		<!--form id="form" action="#" method="get"-->
						   		 <input type="text" placeholder="DNI" id="username"  required=""> 
						   		 <input type="password" placeholder="Contrase&ntilde;a"  id="password"  required=""> 

<select required name="anio_ingreso" id="anio_ingreso">
	<option selected value="0" >Seleccione a&ntilde;o de ingreso</option>
	<option value="2012">A&ntilde;o 2012</option>
	<option value="2013">A&ntilde;o 2013</option>
	<option value="2014">A&ntilde;o 2014</option>
	<option value="2015">A&ntilde;o 2015</option>
        <option value="2016">A&ntilde;o 2016</option>
        <option value="2017">A&ntilde;o 2017</option>
        <option value="2018">A&ntilde;o 2018</option>
        <option value="2019">A&ntilde;o 2019</option>
</select>




						   		 <button type="submit" id="btnLogOn" class="btn btn-red">Ingresar</button> 
							<!--/form-->	
							<div class="login-links"> 
					            <a href="/aspirantes/registrar.php">
					              <strong>Registrate</strong> haciendo click aqu&iacute;
					            </a>
							</div>      		
			        	</div> 			        	
			       </div>
			  	   	
	
			    </div>
			</div>
    	</div>
<!--- cartel rojo -->    
<div class="md-modal md-effect-1" id="modal-1">
	<div class="md-content">
		<h3>Atenci&oacute;n</h3>
		<div>
			<p>Usuario o contrase&ntilde;a incorrecta</p>
			<ul>	
				<li>Se ha detectado un error en la autenticaci&oacute;n del usuario</li>
				<li>Por favor verifique que el usuario, contrase&ntilde;a y cohorte seleccionadas sean correctas</li>
				<li>En caso de que el problema persista, puede acercarse personalmente a las oficinas de tutor&iacute;as</li>
			</ul>
			<button class="md-close" id="md-close">Cerrar</button>
		</div>
	</div>
</div>
<div class="md-overlay"></div> 

<!--
<script src="customjs/classie.js"></script>
<script src="customjs/modalEffects.js"></script><!-- for the blur effec
<!-- by @derSchepp https://github.com/Schepp/CSS-Filters-Polyfill 
<script>
	// this is important for IEs
	var polyfilter_scriptpath = '/js/';
</script>
<script src="customjs/cssParser.js"></script>
<script src="customjs/css-filters-polyfill.js"></script>-->

<!--- fin alert  -->




        <script src="bootstrap/js/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="bootstrap/js/jquery.min.js"><\/script>')</script> 
        <script src="bootstrap/dist/js/bootstrap.min.js"></script> 
        <script src="customjs/placeholder-shim.min.js"></script>        
        <script src="customjs/custom.js"></script>
        <script src="customjs/login.js"></script>
    
<?
session_start();

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();
?>
</body></html>
