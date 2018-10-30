<? 
function escribirArchivo($filepath, $row){
    opendir($filepath);
    echo "<br> archivos recuperados: ".$filepath;
    $archivo =  $filepath.$row['file'].".backup";
//    echo "-".$archivo;
    $fch = fopen($archivo, "w"); // Abres el archivo para escribir en él
    fwrite($fch, pg_unescape_bytea($row['content'])); // Grabas
    fclose($fch); // Cierras el archivo
}    
function crearCarpeta($filepath){
    if(!opendir($filepath)){
        //si hay error al abrir el directorio, hay que crearlo y despues se abre
        mkdir($filepath, 0777, true);
        if(!opendir($filepath)){ crearCarpeta($filepath); }    
    } 
}
include('coneccion_fuentes.php');
$con = new ConeccionFuentes();


$result = $con->query("select * from fuentes");




foreach($result as $row){
    $filepath = getcwd();
    $filepath .= $row['path'];
    
    if( $row['path'] != DIRECTORY_SEPARATOR){
        //hay un directorio presente en la tabla y hay que abrirlo
        crearCarpeta($filepath);
//        echo "<br> - ".$filepath; 
        escribirArchivo($filepath,$row);
    }else{
        //el directorio es el getcwd
        escribirArchivo($filepath,$row);
    }
    
   // $filepath = str_replace($filepath,DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR,DIRECTORY_SEPARATOR );
    // el nombre de tu archivo
   
}
?>