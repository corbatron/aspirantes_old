<?
session_start();
if($_SESSION['id']=="" || $_SESSION=="")
	Header("Location: /aspirantes/index.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>SIT</title>

        <!-- Mobile viewport optimized -->
        <meta name="viewport" content="width=device-width">
        <!-- Le styles -->
        <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Le JS -->
        <script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
        <script type="text/javascript" src="bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/modal.js"></script>
        <script type="text/javascript" src="bootstrap/js/tooltip.js"></script>
<script type="text/javascript" src="customjs/dataaction.js"></script>

    </head>
    <body  style="padding-top: 50px;">
        <div id="divContainer" class="container">
            <div class="row clearfix">


                <nav id="myNavbar" class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">

                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <?   /*a class="navbar-brand" href="#">Tutorias <? echo $_SESSION['nombre_base']; ?></a*/  ?>
<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarCollapse" aria-expanded="true" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
						<a class="navbar-brand" data-toggle="" href="main.php">Tutorias <? echo $_SESSION['anioActual'][0]; ?></a>


<!--dropdown-toggle-->
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->

                    <div class="collapse navbar-collapse" id="navbarCollapse">

                        <ul class="nav navbar-nav">

               

                            <?
                            $perfil = $_SESSION['perfil']; //simulador de permisos para tests
				if($perfil==""){
					include('class.form.php');
					$id_alumno = $_SESSION['id']; 
					$alumno = new Alumno($id_alumno);			

				}


                            $fp = fopen("menu_accion_main.csv", "r");
                            while (( $data = fgetcsv($fp, 1000, ";")) !== FALSE) { // Mientras hay líneas que leer...
                                if ((($data[0][0] == $perfil) || ($data[0][0] == 0)) & $data[0][0] != '#')
                                    $menuArray[] = $data;
                            }
                            fclose($fp);


                            for ($i = 0; $i < count($menuArray); $i++) {
                                $menu = $menuArray[$i][1]; //titulo del menu
                                echo '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">' . $menu . ' <b class="caret"></b></a><ul class="dropdown-menu">';


                                for ($j = $i + 1; $j < count($menuArray); $j++) {
                                    if ($menuArray[$j][1] == $menu) {
                                        $accion = str_replace("SERVER", $_SERVER['HTTP_HOST'], $menuArray[$j][3]);
                                        $accion = str_replace('"', '\'', $accion);
                                        echo '<li  ' . $accion . ' ><a href="#"><span class="' . $menuArray[$j][4] . '"></span> ' . $menuArray[$j][2] . '</a></li>';
                                        $i = $j;
                                    }
                                }
                                echo "</ul>";

                                echo "</li>";
                            }
                            ?>


                        </ul>

                    </div>
                </nav>

            </div>

            <?

//pantallas adicionales
            include("bugForm.php");
            include("datosPersonales.php");
            ?>
         </div>    
        <div id="content-area">
<iframe name ="iframe_1" id="iframe_1" width='100%'  style='background-color:#FFF'></iframe>

<? 
if($_SESSION['perfil']==""){
    include("classes/class.personas.php");
    $persona = new Persona(); 
    $_SESSION['perfil'] = $persona->get_perfil($_SESSION['dni']);
}


if($_SESSION['perfil']==1)
{
?>
<script>document.getElementById('iframe_1').src="http://<?echo $_SERVER['HTTP_HOST']?>/aspirantes/alumnosFormularios.php";</script>
<?php
}else{
            include("modalCambiarUsuario.php");
            include("modalCrearTutor.php");
            include("modalFechasSysacad.php");

?>
<script>document.getElementById('iframe_1').src="http://<?echo $_SERVER['HTTP_HOST']?>/aspirantes/noticias.php";</script>
<?php
}


?>
<script>
$(function() {    

	if($("#fecha_nac").val()==""  || $("#email").val()==""){

		$("#datosPersonalesModal").modal();

	}


	var aboveHeight = $("#divContainer").outerHeight(true);    
	$(window).resize(function() {        
		$('#iframe_1').height( $(window).height() - aboveHeight - 60);    
		}).resize();}
);



</script>
        </div>




    </body>
</html>
