<?php

define("DATA_PATH", "./data");
define("LIB_PATH", "./libraries");
define("TEMP_PATH", "./tmp");
define("SANDBOXFILE_PATH", "./tmp/sandboxfile.php");
define("PHP_PATH", "./php5.6.35/php.exe");

require_once LIB_PATH."/console/user_input.php";


function dirnamesArray($dir_path)
{
    $res = array();
    
    $dir = opendir($dir_path);
    if(!$dir)
        throw new Exception ("error abriendo el directorio.");
    
    while(false !== ( $file = readdir($dir)) )
    { 
        if(( $file != '.' ) && ( $file != '..' ))
        {
            $fullpath = $dir_path."/".$file; 
            if(is_dir($fullpath) && is_file($fullpath."/asistente.php"))
            {
                $res[] = $file;
            }
        } 
    } 
    closedir($dir);
    
    return $res;
}
/**
 * Devuelve la posicion en el arregle del elemento seleccionado por el usuario.
 * @param array $a Arreglo de nombres a mostrar al usuario.
 */
function solicitarSelecionarAsistente($a)
{
    echo "Seleccione un asistente de la lista:\n";
    
    $a_count = count($a);
    if($a_count == 0)
        throw new Exception ("arreglo vacio");
    
    for($i = 0; $i< $a_count; $i++)
    {
        echo $i." - ".$a[$i]."\n";
    }
    
    return UserInput::solicitarINT(null, 0 ,$a_count - 1);
}


//start-------------------------------------------------------

$a_array = dirnamesArray(DATA_PATH);

$opcion = solicitarSelecionarAsistente($a_array);

$basepath = DATA_PATH.'/'.$a_array[$opcion];

require_once $basepath.'/asistente.php';

$as = new Asistente($basepath, PHP_PATH, SANDBOXFILE_PATH);

$as->start();

