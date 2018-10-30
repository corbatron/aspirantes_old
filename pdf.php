<?
$dni = $_REQUEST['dni'];
session_start();

$file = "/var/www/html/aspirantes/pdf/".$_SESSION['nombre_base']."_".$dni.".pdf";

exec("sudo -u www-data /bin/rm -f ".$file);
exec("sudo -u www-data /home/mcorbalan/wkhtmltopdf.sh http://127.0.0.1/aspirantes/resumen_alumno.php?code=".$dni."_".$_SESSION['nombre_base']." ".$file);
$pdf = file_get_contents($file);

header('Content-Type: application/pdf');
header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
header('Pragma: public');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Content-Length: '.strlen($pdf));
header('Content-Disposition: inline; filename="'.basename($file).'";');
ob_clean(); 
flush(); 
echo $pdf;
?>
