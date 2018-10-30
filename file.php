<?php
header('Content-Type: application/json');


$target_dir = "/var/www/html/aspirantes/files_seguimiento/";
$target_file = $target_dir . basename($_FILES["myfile"]["name"]);


$file_extension = pathinfo($target_file,PATHINFO_EXTENSION);
$file_name =   pathinfo($target_file,PATHINFO_FILENAME);

$hash=md5(time());  //($target_dir.$target_file.$file_extension);


$exitoso = move_uploaded_file($_FILES["myfile"]["tmp_name"], $target_dir.$hash.".".$file_extension );



$archivo['status']=$exitoso;
$archivo['hash']=$hash;
$archivo['ext']=$file_extension;
$archivo['original']=$file_name;



echo json_encode($archivo);

?>
