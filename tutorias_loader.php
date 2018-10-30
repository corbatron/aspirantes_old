
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
        
        ?>
        <form method="POST" enctype="multipart/form-data" target="iframe_tutorias" action="tutorias_loader_include.php">
        <table border="0">
            <tr>
                <td>
                Carrera:    
                </td>
                <td>
                <select name="id_carrera" id="id_carrera">
<?
include('class.carreras.php');
$carreras = new Carreras();
$todas = $carreras->traer_carreras();

foreach($todas as $carrera)
	echo "<option value=".$carrera['carr_id'].">".$carrera['carr_descripcion']."</option>";

?>


                </select>
                </td>
            </tr>
            <tr>
                <td>
                Archivo:    
                </td>
                <td>
                    <input type="file" name="archivo" id="archivo">
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" name="Enviar" value="Enviar">
                </td>
            </tr>
        </table>
        </form>
        <a href='excel/Tutorias_Ingreso TSP_Septiembre 2012.xlsx'>Descargue archivo de ejemplo</a>
        <br>
        <font color='red'>Atenci&oacute;n:</font> No modifique el formato del archivo, ni el orden de las columnas.
        <br>
        <iframe src="tutorias_loader_include.php" name='iframe_tutorias' width="100%" height="400Px;">
        </iframe>
    </body>
</html>
