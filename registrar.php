<?php

$ip = $_SERVER['REMOTE_ADDR'];



$val = ip_is_private($ip); 



function isPublicAddress($ip) {

    //Private ranges...
    //http://www.iana.org/assignments/iana-ipv4-special-registry/
    $networks = array('10.0.0.0'        =>  '255.0.0.0',        //LAN.
                      '172.16.0.0'      =>  '255.240.0.0',      //LAN.
                      '192.168.0.0'     =>  '255.255.0.0',      //LAN.
                      '127.0.0.0'       =>  '255.0.0.0',        //Loopback.
                      '169.254.0.0'     =>  '255.255.0.0',      //Link-local.
                      '100.64.0.0'      =>  '255.192.0.0',      //Carrier.
                      '192.0.2.0'       =>  '255.255.255.0',    //Testing.
                      '198.18.0.0'      =>  '255.254.0.0',      //Testing.
                      '198.51.100.0'    =>  '255.255.255.0',    //Testing.
                      '203.0.113.0'     =>  '255.255.255.0',    //Testing.
                      '192.0.0.0'       =>  '255.255.255.0',    //Reserved.
                      '224.0.0.0'       =>  '224.0.0.0',        //Reserved.
                      '0.0.0.0'         =>  '255.0.0.0');       //Reserved.

    //inet_pton.
    $ip = @inet_pton($ip);
    if (strlen($ip) !== 4) { return false; }

    //Is the IP in a private range?
    foreach($networks as $network_address => $network_mask) {
         $network_address   = inet_pton($network_address);
         $network_mask      = inet_pton($network_mask);
         assert(strlen($network_address)    === 4);
         assert(strlen($network_mask)       === 4);
         if (($ip & $network_mask) === $network_address)
            return true;
    }

    //Success!
    return false;

}




function ip_is_private ($ip) {
    $pri_addrs = array (
                      '10.0.0.0|10.255.255.255', // single class A network
                      '172.16.0.0|172.31.255.255', // 16 contiguous class B network
                      '192.168.0.0|192.168.255.255', // 256 contiguous class C network
                      '169.254.0.0|169.254.255.255', // Link-local address also refered to as Automatic Private IP Addressing
                      '127.0.0.0|127.255.255.255' // localhost
                     );

    $long_ip = ip2long ($ip);
    if ($long_ip != -1) {

        foreach ($pri_addrs AS $pri_addr) {
            list ($start, $end) = explode('|', $pri_addr);

             // IF IS PRIVATE
             if ($long_ip >= ip2long ($start) && $long_ip <= ip2long ($end)) {
                 return true;
             }
        }
    }

    return false;
}

?>
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
  </head>
    <body>
    	<!-- start Login box -->
    	<div class="container" id="login-block">
    		<div class="row">
			    <div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">
			       <div class="login-box clearfix animated flipInY">
			        	<div class="login-logo">
			        					        		<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="180px" height="180px" viewBox="0 0 180 180" enable-background="new 0 0 180 180" xml:space="preserve">
<path fill-rule="evenodd" clip-rule="evenodd" fill="#2A2A2A" d="M0,90c0,49.71,40.29,90,90,90s90-40.29,90-90S139.71,0,90,0  S0,40.29,0,90z M40.5,80.5h39v-1.22c-22.32-5.01-39-24.94-39-48.78h20c0,12.69,7.87,23.53,19,27.92V30.5h20v28.62  c12.17-3.82,21-15.19,21-28.62h20c0,24.54-17.68,44.95-41,49.19v0.81h41v20h-41v0.81c23.32,4.24,41,24.65,41,49.19h-20  c0-13.43-8.83-24.8-21-28.63v28.63h-20v-27.92c-11.13,4.39-19,15.23-19,27.92h-20c0-23.84,16.68-43.77,39-48.79v-1.21h-39V80.5z"/>
</svg>
			        	</div> 
			        	<hr />
			        	<div class="login-form">
                                               
                                                <?php



                                                   if ($val==false || $ip=='192.168.0.226') {
                 

						?>

			        		<div class="alert alert-error">
								  <h4>Atenci&oacute;n!</h4>
								   Solo se podra anotar desde una computadora de la universidad
						</div>

						     <?php

							             }else {

						?>

			        		<!--form action="#" method="get" -->
						   		 <input type="text" pattern="[0-9]{7,8}" max-lenght="8" placeholder="Documento" id="documento" required/>
			        			
						   		 <input type="text" placeholder="Nombre" id="nombre" required/> 
								 <input type="text" placeholder="Apellido" id="apellido" required/> 
                                                                 <select  placeholder="Carrera" id="carrera" name="carrera">
<option value="24118">INGENIERIA CIVIL </option>
<option value="24119">INGENIERIA ELECTRICA </option>
<option value="34835">INGENIERIA EN INDUSTRIA AUTOMOTRIZ </option>
<option value="24117">INGENIERIA MECANICA </option>
<option value="24120">LICENCIATURA EN ORGANIZACION INDUSTRIAL </option>
<option value="35580">TEC. SUP. EN MOLDES, MATRICES Y DISPOSITIVOS</option>
<option value="33887">TEC. SUP. GESTION DE LA INDUSTRIA AUTOMOTRIZ </option>
<option value="27265">TEC. SUP. PROGRAMACION GRAL. PACHECO </option>
<option value="27266">TEC. SUP. PROGRAMACION J.C.PAZ </option>
 								 </select>
						   		 <button type="submit" id="btnLogOn" class="btn btn-red">Registrar</button> 
							<!--/form-->	

						     <?php
}

						?>   
							<div class="login-links"> 
					            <br />
					             <a href="/aspirantes/index.php">
					             &iquest;ya tenes una cuenta?  <strong>Ingres&aacute;</strong>
					            </a>
							</div> 
  		
			        	</div> 
			       </div>
			    </div>
			</div>
    	</div>

<div class="md-modal md-effect-1" id="modal-1">
	<div class="md-content">
		<h3>Atenci&oacute;n</h3>
		<div>
			<p>No se pudo registrar</p>
			<ul>	
				<li>El documento ya existe en la base de datos.</li>


				
			</ul>
			<button class="md-close" id="md-close">Cerrar</button>
		</div>
	</div>
</div>



<div class="md-overlay"></div>

    	 
        <!-- End Login box -->
        <script src="bootstrap/js/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="bootstrap/js/jquery.min.js"><\/script>')</script> 
        <script src="bootstrap/dist/js/bootstrap.min.js"></script> 
        <script src="customjs/placeholder-shim.min.js"></script>        
        <script src="customjs/custom.js"></script>
        <script src="customjs/register.js"></script>
    </body>
</html>
