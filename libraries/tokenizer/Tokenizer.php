<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'TokenRule.php';
require_once 'TokenizerException.php';
require_once 'TokenMatcher.php';

/**
 * Description of Tokenizer
 *
 * @author ado
 */
class Tokenizer {
    private $rules_array;
    private $group_hash = array();
    private $input;
    
    function __construct($rules_array, $input) {
        
        if (!is_array($rules_array)) {
            throw new TokenizerException("variable de arreglo de reglas invalida.");
        }

        if (count($rules_array) == 0) {
            throw new TokenizerException("arreglo de reglas vacio.");
        }

        $this->rules_array = $rules_array;
        $this->input = $input;
    }
    
    private function buildPatternString()
    {
        $i = 0;
        
        $p = "/^(";
        $p.= "(?<n".$i.">".$this->rules_array[0]->getPatron().")";
        
        $this->group_hash["n".$i] = $this->rules_array[0];
        $i++;
        
        for(;$i < count($this->rules_array); $i++){
            $p.= "|(?<n".$i.">".$this->rules_array[$i]->getPatron().")";
            $this->group_hash["n".$i] = $this->rules_array[$i];
        }
        
        $p.= ")/";
        
        return $p;
    }
    public function getTokenMatcher()
    {
        return new TokenMatcher($this->buildPatternString(), $this->input, $this->group_hash);
    }
}
