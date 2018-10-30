<link type="text/css" href="css/jquery.toastmessage.css" rel="stylesheet"/>
<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="js/jquery.toastmessage.js"></script>
<body>
<?

include("ver_login.php");

if($_SESSION['perfil'] != 2)  return 0;

require_once('coneccion.php');
$conex = new Coneccion();
//$conex->query("update mensajesalumnos set visto=0");

$cuack = $conex->query("select count(id) from mensajesalumnos where visto is null or visto='0'");
$conex->query("update mensajesalumnos set visto=1");

//echo '<a href="$().toastmessage(\'showNoticeToast\', \'Hay '.$cuack[0][0].' mensajes nuevos\');">asdf</a>';

if($cuack[0][0]!=0){
echo '<script> $().toastmessage(\'showNoticeToast\', \'Hay '.$cuack[0][0].' mensajes nuevos\');   </script>';
}

 /*echo " <script>  $().toastmessage('showToast', {
       text     : 'Hello World',
       sticky   : true,
       position : 'top-right',
       type     : 'success',
       close    : function () {alert(\"toast is closed ...\");}
    });   </script>";
*/
	?>
	
	<script>  
	$().toastmessage('showToast', {
       text     : '<a href="http://aspirantes.frgp.utn.edu.ar/aspirantes/main.php"><font color="white">El SIT se encuentra en proceso de actualizacion y puede presentar funcionamiento inestable en algunos modulos. Si usted quiere utilizar la nueva version (aun en desarrollo) del SIT, por favor haga click aqui</font></a>',
       sticky   : true,
    });   
	
	</script>
	
</body>