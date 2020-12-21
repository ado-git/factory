<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once LIB_PATH.'/utiles/Arraylist.php';
require_once 'analizer/Analizer.php';
require_once 'analizer/State.php';
require_once 'analizer/Listener.php';
require_once 'ParserException.php';

/**
 * Description of Parser
 *
 * @author ado
 */
class Parser {
    private $input;
    private $fields;
    public $SINGLEITEMINDICATOR = "";
    
    /**
     * $input es la cadena de entrada a procesar.
     * $fields es un arreglo de nombres de field que seran las llaves de los arreglos finales.
     */
    function __construct($input, $fields) {
        $this->input = $input;
        $this->fields = $fields;
    }
    
    private function cleanFieldName($field)
    {
        $field = trim($field);

        if (empty($field)) {
            throw new ParserException("nombre de field vacio");
        }

        return $field;
    }
    
    private function createHash($input)
    {
        $array = array();
        
        for ($i = 0; $i < count($input); $i++) {
            $key = $this->cleanFieldName($this->fields[$i]);//esto hay que hacerlo en el constructor
            
            if (array_key_exists($key, $array)) {
                throw new ParserException("field repetido: " + $key);
            }

            $array[$key] = $input[$i];
        }
        
        return $array;
    }
    
/**
     * En deshuzo
     */
    private function createHashSimple($input)
    {
        $hash = array();
        
        $hash[$this->SINGLEITEMINDICATOR] = $input[0];
        
        return $hash;
    }
    
    /**
     * Convierte un itemlist en un arreglo de strings.
     */
    private function toStringArray($i_list)
    {
        $a = array();
        
        foreach($i_list->getItems() as $itemBase)
        {
            $a[] = $itemBase->getText();
        }
        
        return $a;
    }
    
    /**
     * Extrae maps de field a elemento 
     * Cada map tiene que tener tamaño igual a la cantidad de fields
     */
    public function parse()
    {
        $alist = new Arraylist();
        
        if(empty($this->fields))
            $field_count = 0;
        else
            $field_count = count($this->fields);
        
        $listener = new Listener();
        
        $a = new Analizer($this->input, $listener);
        
        $a->parse();
        
        foreach($listener->getStart()->getItemlist() as $item_list)
        {
            if (empty($item_list->getItems())) {//comprobar esto.
                continue;
            }

            $parsed_fields = $this->toStringArray($item_list);

            if($field_count == 0 && count($parsed_fields) == 1)
            {
                $alist->add($parsed_fields[0]);
            }
            else if ($field_count == count($parsed_fields))
            {
                $alist->add($this->createHash($parsed_fields));
            }
            else
            {
                throw new ParserException("cantidad de elementos incorrecta. Numero de campos: ".$field_count.", elementos encontrados en una de las listas: ".count($parsed_fields));
            }
        }
        
        return $alist->getArray();
    }        
}
