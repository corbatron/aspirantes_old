<?
/*-----FUNCIONES-----*/
function listarArchivos($pathrel)
{
    $path=getcwd();//se obtiene el patch absoluto
    if($pathrel != "" ) {
        $path = $path.$pathrel;//se concatena el path relativo
    }
    $dir = opendir($path);//se abre la carpeta
    while ($elemento = readdir($dir)) {//se lee el contenido     
        if ($elemento != "." && $elemento != "..") {// Tratamos los elementos . y .. que tienen todas las carpetas
            if (is_dir($path . DIRECTORY_SEPARATOR . $elemento)) { // Si es una carpeta... se llama
                $ficheros_array = listarArchivos( $pathrel. DIRECTORY_SEPARATOR . $elemento);
                $lista_ficheros[DIRECTORY_SEPARATOR.$elemento][]= $ficheros_array;              
            } else {
                echo "<br />". $path . DIRECTORY_SEPARATOR . " @  ".$elemento;
                $lista_ficheros[DIRECTORY_SEPARATOR][].=$elemento;
            }
        }
    }
    return $lista_ficheros;
}
/*---------------------------------*/
function prepararInsert($ficheros_array,$path, $conf){    
    
    
    
    
    foreach ($ficheros_array as $key=>$file) {
        if($key[0]==DIRECTORY_SEPARATOR){
            //echo "<br>-------------------------------------KEY: ".$key."- PATH: ".$path."-----";
            prepararInsert($file,$path.$key, $conf);
       }elseif(is_array($file)){
            prepararInsert($file,$path, $conf);     
       }else{
            //echo "<br>".$path." @ ".$file;
            //echo "<br>".$path.DIRECTORY_SEPARATOR.$key.DIRECTORY_SEPARATOR.$file;
            opendir(dirname($path));
            //$file_content = file_get_contents($file);

$handle = fopen($file, "rb");
$file_content = fread($handle, filesize($file));
$file_content = pg_escape_bytea($file_content);     
fclose($handle);

echo $file_content;

             
            $data = "INSERT INTO fuentes(path, file, modif, content) VALUES ('".pg_escape_string($path)."','".$file."', (now()),'".$file_content."')";
            echo "<br>".$data;
            $conf->query($data);         
        }
    }
}



/*-----------FIN FUNCIONES-------------*/
include ('coneccion.php');
include ('coneccion_fuentes.php');

$con = new Coneccion();
$conf = new ConeccionFuentes();

if ($conf) {//problema en la conexion o BD no existente, toca crearla
    $con->query('create database fuentes');//se crea la BD con cualquier conexion
    $conf = new ConeccionFuentes(); //se vuelve a conectar 
    //se crea la tabla 
    $conf->query('CREATE TABLE fuentes
        (
        id serial NOT NULL,
        path character varying,
        file character varying,
        modif date,
        content bytea,
        CONSTRAINT fuentes_pkey PRIMARY KEY (id)
        )');
    
    $conf->query('CREATE SEQUENCE fuentes_id_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;
        ALTER TABLE fuentes_id_seq
        OWNER TO postgres');
}




echo "<pre>";
$ficheros_array = listarArchivos("");
echo "<br>---fin--<br>";
//print_r($ficheros_array);
prepararInsert($ficheros_array,"", $conf);
echo "</pre>";







?>
