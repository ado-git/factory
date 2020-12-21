<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'filename_atribs_parser.php';
require_once LIB_PATH.'/sandbox/phpsandbox.php';
/**
 * Description of FilesCopier
 *
 * @author ado
 */
class FilesCopier {
    //put your code here
    private $src_dir;
    private $dst_dir;
    private $variables;//arreglo asociativo de variables
    private $filesCreated = array();
    private $php_path;
    private $sandboxfilepath;
    private $require_once_path;
    
    /**
     * @param string $src_dir Directorio de origen.
     * @param string $dst_dir Directorio de destino donde seran creados los arhivos.
     * 
     * @expectedException Exception
     */
    public function __construct($src_dir, $dst_dir, $variables, $php_path, $sandboxfilepath, $require_once_path)
    {
        if(!is_dir($src_dir))
            throw new Exception ("directorio de origen invalido: ".$src_dir);
        
        $this->src_dir = $src_dir;
        
        if(file_exists($dst_dir))
            throw new Exception ("directorio ya existe: ".$dst_dir);
        
        $this->dst_dir = $dst_dir;
        
        $this->variables = $variables;
        $this->php_path = $php_path;
        $this->sandboxfilepath = $sandboxfilepath;
        $this->require_once_path = $require_once_path;
    }
    
    /**
     * Devuelve el path de destino.
     * 
     * @param FilenameAtribsParser $p Es el parser del nombre de filename de origen.
     * @param string $dst_dir Es el path del directorio de destino que contendra el path devuelto.
     * 
     * @return string El path de destino.
     */
    private function prepareDest(FilenameAtribsParser $p, $dst_dir)
    {
        $filenameVar = $p->getFilenameVar();
        
        if($filenameVar)
        {
            if(!isset($this->variables[$filenameVar]))
                throw new Exception("variable no definida: ".$filenameVar);
            
            $subject = $p->getFinalFilename($this->variables[$filenameVar]);
        }
        else
        {
            $subject = $p->getFinalFilename(null);
        }
        
        return $dst_dir."/".$subject;
    }
    /**
     * Chequea si es true o false el parametro include en el filename parseado.
     * 
     * @param FilenameAtribsParser $p El parser del filename.
     * 
     * @return bool true si incluido es true o no esta presente, false en los demas casos.
     */
    private function isIncluded(FilenameAtribsParser $p)
    {
        $includevar = $p->getIncludeVar();
        if(!$includevar)
            return true;

        if(!isset($this->variables[$includevar]))
            throw new Exception("variable no definida: ".$includevar);
        
        if(!is_bool($this->variables[$includevar]))
            throw new Exception("variable no es booleana: ".$includevar);
        
        return $this->variables[$includevar];
    }
    /**
     * Crea el directorio de destino y copia los files y directorios contenidos en el directorio de origen dentro de este.
     * 
     * @expectedException Exception
     */
    public function copy()
    {
        if(!@mkdir($this->dst_dir))
            throw new Exception ("no se pudo crear el directorio: ".$this->dst_dir);
        
        $this->copyIgnoreRoot($this->src_dir, $this->dst_dir);
    }
    /**
     * Ejecuta recurse_copy a partir de los files y diretorios dentro del directorio inicial, ignorando este.
     * 
     * @param string $src_dir Ruta del directorio de origen.
     * @param string $dst_dir Ruta del directorio de destino.
     */
    private function copyIgnoreRoot($src_dir, $dst_dir)
    {
        $dir = opendir($src_dir);
        
        while(false !== ( $file = readdir($dir)) )
        { 
            if(( $file != '.' ) && ( $file != '..' ))
            {
                $this->recurse_copy($src_dir."/".$file, $dst_dir);
            } 
        } 
        closedir($dir);
    }
    /**
     * Copia recursivamente un file o directorio en el directorio especificado
     * 
     * @param string $src Ruta del file o directorio de origen.
     * @param string $dst_dir Ruta del directorio donde sera copiado el file o directorio de origen.
     */
    private function recurse_copy($src, $dst_dir)
    {
        $parser = new FilenameAtribsParser(basename($src));
        
        if(!$this->isIncluded($parser))
            return;
        
        $dstPrepared = $this->prepareDest($parser, $dst_dir);
        
        if(file_exists($dstPrepared))
            throw new Exception ("este file o directorio ya existe: ".$dstPrepared);
        
        if(is_file($src))
        {
            $this->renderCopy($src, $dstPrepared);
            return;
        }
        
        if(!is_dir($src))
            throw new Exception ("no es un directorio o file valido: ".$src);
        
        if(!@mkdir($dstPrepared))
            throw new Exception ("no se pudo crear el directorio: ".$dstPrepared);
        
        $this->filesCreated[] = $dstPrepared;
        
        $this->copyIgnoreRoot($src, $dstPrepared);
    }
    
    /**
     * Ejecuta el codigo php del file de origen y copia la salida en el destino especificado.
     * 
     * @param string $src La ruta del file de origen.
     * @param string $dst La ruta del file de destino.
     */
    private function renderCopy($src, $dst)
    {
        $text = @file_get_contents($src);
        if($text === false)
            throw new Exception("error opening input file: ".$src);
        
        $sbox = new PHPSandBox($this->php_path, $this->sandboxfilepath);

        $sbox->addText($text);
        $sbox->add_require_once($this->require_once_path);
        $sbox->addVariables($this->variables);

        $res = $sbox->run();
        
        if(@file_put_contents($dst, $res) === false)
            throw new Exception("error writing output file: ".$dst);

        $this->filesCreated[] = $dst;
    }
    /**
     * Retorna una array de files y directorios que fueron creados.
     */
    public function getFilesList()
    {
        return $this->filesCreated;
    }
}
