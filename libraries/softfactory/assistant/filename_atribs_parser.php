<?php

class FilenameAtribsParser
{
    private $includeVar = null;
    private $filenameVar = null;
    private $filenamePart;
    
    public function __construct($filename) {
        

        preg_match("/^\[&include=([_a-zA-Z]\w*)\]/", $filename, $matches);

        if($matches)
        {
            $this->includeVar = $matches[1];
            $this->filenamePart = str_replace($matches[0], "", $filename);
        }
        else
        {
            $this->filenamePart = $filename;
        }
        
        preg_match("/\[#([_a-zA-Z]\w*)\]/", $this->filenamePart, $matches);

        if($matches)
        {
            $this->filenameVar = $matches[1];
        }
        
        
    }
    /**
     * Devuelve el nombre del fichero de acuerdo al valor de la variable correspondiente
     */
    public function getFinalFilename($var_value)
    {
        if(empty($this->filenameVar))
            return $this->filenamePart;
        
        return str_replace("[#".$this->filenameVar."]", $var_value, $this->filenamePart);
    }
    
    /**
     * Devuelve el nombre de la variable que dice si se incluye o no.
     * * null en caso no existir
     */
    public function getIncludeVar() {
        return $this->includeVar;
    }

    /**
     * Devuelve el nombre de la variable que determina el nombre del file.
     * null en caso no existir
     */
    public function getFilenameVar() {
        return $this->filenameVar;
    }


}
