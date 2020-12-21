<?php

class PHPSandBox
{
    private $php_path;
    private $sandboxfilepath;
    private $code = "";
    
    /**
     * primer parametro: el path del interprete php
     * segundo parametro: el path del file del sandbox
     */
    public function __construct($php_path, $sandboxfilepath) {
        $this->php_path = realpath($php_path);
        $this->sandboxfilepath = realpath($sandboxfilepath);
    }
    
    /**
     * Adiciona texto al file que sera ejecutado.
     */
    public function addText($text)
    {
        $this->code .= $text;
    }
    /**
     * Adiciona una entrada de requiere_once para el file especificado.
     * Convierte rutas relativas en rutas absolutas.
     * Siempre sera ubicado al principio del file a ejecutar.
     */
    public function add_require_once($file_path)
    {   
        $file_path = realpath($file_path);
        
        if(!$file_path)
            throw new Exception ("file no existe: ".$file_path);
        
        $this->code = "<?php require_once '$file_path';?>".$this->code;
    }
    /**
     * Adiciona variables al codigo.
     * Espera un arreglo asociativo con los nombres de variable como keys
     */
    public function addVariables($vars)
    {
        $res = "<?php\n";
        
        foreach($vars as $key => $value)
        {
            $res.= "\$$key = ".var_export($value, true).";\n";
        }
        $res .= "?>";
        
        $this->code = $res.$this->code;
    }
    
    /**
     * Ejecuta el file y devuelve la salida generada.
     * Tiene el problema de que no reporta errores de ejecucion del script, hay que verificar los archivos generados manualmente.
     */
    public function run()
    {
        if(file_exists($this->sandboxfilepath) && !@unlink($this->sandboxfilepath))
            throw new Exception ("No se pudo eliminar el file de sandbox: ".$this->sandboxfilepath);
        
        if(file_put_contents($this->sandboxfilepath, $this->code) === false)
            throw new Exception ("No se pudo crear el file de sandbox: ".$this->sandboxfilepath);
        
        return shell_exec("\"".$this->php_path."\" -f \"".$this->sandboxfilepath."\"");
    }
    /**
     * Borra todo el texto que se ha guardado
     */
    public function reset()
    {
        $this->code = "";
    }

}