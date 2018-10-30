<?php
session_start();
include('coneccion.php');
include('class.alumnos.php');	

require_once('class.carreras.php');

$carreras = new Carreras();
$array_carreras_listado = $carreras->traer_carreras();




$alumno=new Alumno($_SESSION['id']);
$id_alumno = $_SESSION['id'];


foreach($array_carreras_listado as $array_carrera)
{
	$selected="";
	if($array_carrera['carr_id']==$_SESSION['id_carrera'])	$selected="selected";

	$arra_carreras.= "<option value='".$array_carrera['carr_id']."' $selected >".$array_carrera['carr_descripcion']."</option>";

}


?>


<div class="modal fade" id="datosPersonalesModal" tabindex="-1" role="dialog" aria-labelledby="userData" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="userData">Datos personales</h4>
            </div>



<form role="form" method="post" action="modificar_alumno.php" target='iframe_modificar' enctype="multipart/form-data">
<input type='hidden' name='alumnos' id='alumnos' value='<? echo $_SESSION['id']; ?>'></input>
                <div class="modal-body">
				
         		<div class="form-group">
                        <label for="bdate">Foto de perfil (opcional)</label>
    			<input type="file" name="photo" id="photo">
                    </div>

                   <div class="form-group">
                        <label for="carrera">Carrera</label>

<select  class="form-control" name='carrera_seleccionada' id='id_carrera_sele'>"<? echo $arra_carreras; ?>"</select>

                    </div>

                    <div class="form-group">
                        <label for="fecha_nac">Fecha de nacimiento</label>
                        <input type="date" class="form-control" name="fecha_nac" id="fecha_nac" required placeholder="Fecha de nacimiento"   value="<? echo $alumno->get_fechaNac();?>" />
                    </div>

                    <div class="form-group">
                        <label for="telefono">Tel&eacute;fono de contacto 1</label>
                        <input type="text" class="form-control" name="telefono" id="telefono" required placeholder="Telefono" value="<? echo $alumno->get_telLinea();?>" />
                    </div>
					
                    <div class="form-group">
                        <label for="celular">Tel&eacute;fono de contacto 2</label>
                        <input type="text" class="form-control" name="celular" id="celular" placeholder="Celular"  value="<? echo $alumno->get_telCel();?>" />
                    </div>					
					
                    <div class="form-group">
                        <label for="email">Correo Electr&oacute;nico</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Ingrese su mail"  value="<? echo $alumno->get_mail();?>" />
                    </div>
					
                    <div class="form-group">
                        <label for="pass">Contrase&ntilde;a actual</label>
                        <input type="password" class="form-control" name="pass" id="pass" placeholder="password" value="<? echo $alumno->get_pass();?>" />
                    </div>

					<div class="form-group">
                        <label for="pass2">Contrase&ntilde;a nueva</label>
                        <input type="password" class="form-control" name="pass2" id="pass2" placeholder="password" value="<? echo $alumno->get_pass();?>" />
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </form>
<iframe style='display:none' width='300' height='100' name='iframe_modificar' id='iframe_modificar'></iframe>

        </div>
    </div>
</div>