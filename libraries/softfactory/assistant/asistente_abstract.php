<?php

require_once LIB_PATH.'/console/user_input.php';
require_once 'filescopier.php';

abstract class AsistenteAbstract
{
    private $basePath;
    private $dstFolder;
    protected $variables = array();
    private $variableObjects;
    private $php_path;
    private $sandboxfilepath;
    
    
    function __construct($basePath, $php_path, $sandboxfilepath, $variables) {
        $this->basePath = $basePath;
        $this->php_path = $php_path;
        $this->sandboxfilepath = $sandboxfilepath;
        $this->variableObjects = $variables;
    }
    
    private function solicitarVariable($var)
    {
        switch ($var->type) {
            case 'BOOLEAN':
                $this->variables[$var->name] = UserInput::solicitarBOOLEAN("Entre ".$var->name." (tipo BOOLEAN) ");
                break;
            case 'INT':
                $this->variables[$var->name] = UserInput::solicitarINT("Entre ".$var->name." (tipo INT) ");
                break;
            case 'FLOAT':
                $this->variables[$var->name] = UserInput::solicitarFLOAT("Entre ".$var->name." (tipo FLOAT) ");
                break;
            case 'STRING':
                $this->variables[$var->name] = UserInput::solicitarSTRING("Entre ".$var->name." (tipo STRING) ");
                break;
            case 'ARRAY':
                
                if(isset($var->fields) && count($var->fields) > 0)
                    $field_names = "fields: ".implode(",", $var->fields);
                else
                    $field_names = "";
                
                $this->variables[$var->name] = UserInput::solicitarARRAY($var->fields, "Entre ".$var->name." (tipo ARRAY) $field_names");
                break;
            default:
                throw new Exception("tipo desconocido");
        }
    }
    private function solicitarVariables()
    {
        foreach ($this->variableObjects as $v) {
            $this->solicitarVariable($v);
        }
    }
    private function solicitarReconfigurarVariables()
    {
        echo "Seleccione variable a asignar.\n\n";
        
        $i = 0;
        for(; $i < count($this->variableObjects); $i++)
        {
            echo $i." - ".$this->variableObjects[$i]->name."\n"; 
        }
        
        echo $i." - (Salir)\n";
        
        while(true)
        {
            echo "Seleccione un numero de la lista\n";
            $input = UserInput::solicitarINT("", 0, $i);
            
            if($input == $i)
                return;
            
            $this->solicitarVariable($this->variableObjects[$input]);
        }
    }
    
    public function start()
    {
        $this->printBienvenida();
        
        $this->dstFolder = $this->solicitarDireccionDestino();
        
        $this->solicitarVariables();
        
        echo "¿Desea continuar?\n";
        if(!UserInput::solicitarSIoNO())
        {
            echo "ejecucion abortada.";
            return;
        }
        
        while(true)
        {
            try {

                $copier = new FilesCopier($this->basePath."/files", $this->dstFolder, $this->variables, $this->php_path, $this->sandboxfilepath, $this->basePath."/FUNCIONES_PROYECTO.php");

                $copier->copy();

                echo "Files creados exitosamente.\n";

                echo "¿Desea repetirlo?\n";
                if(!UserInput::solicitarSIoNO())
                {
                    echo "ejecucion terminada.\n";
                    return;
                }

            } catch (Exception $exc) {
                echo "Error: ".$exc->getMessage()."\n";
                
                echo "¿Desea reintentarlo?\n";
                if(!UserInput::solicitarSIoNO())
                {
                    echo "ejecucion terminada.\n";
                    return;
                }
                
            }
            echo "¿Desea reconfigurar el destino?\n";
            if(UserInput::solicitarSIoNO())
            {
                $this->dstFolder = $this->solicitarDireccionDestino();
            }
            
            echo "¿Desea reconfigurar las variables?\n";
            if(UserInput::solicitarSIoNO())
            {
                $this->solicitarReconfigurarVariables();
            }
            
            echo "¿Desea continuar?\n";
            if(!UserInput::solicitarSIoNO())
            {
                echo "ejecucion abortada.\n";
                return;
            }
        }
    }
    
    private function solicitarDireccionDestino()
    {
        $dstFolder = UserInput::solicitarSTRING("entre la direccion de destino\n");
        
        return $dstFolder;
    }
    private function mostrarDetalleVariable($msg, $var)
    {
        echo "$msg:\n";
        var_dump($var);
    }
    private function mostrarResumen()
    {
        echo "-----------------------------\n";
        echo "--Resumen--------------------\n";
        echo "-----------------------------\n";
        
        $this->mostrarDetalleVariable("Direccion de destino", $this->dstFolder);
        
        foreach ($this->variables as $key => $value) {
            $this->mostrarDetalleVariable($key, $value);
        }
    }
    private function printBienvenida()
    {
        $folderName = basename($this->basePath);
        
        echo "Asistente de template: ". strtoupper($folderName)."\n\n";
    }   
}