<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'TokenMatcherException.php';
/**
 * Description of Matcher
 *
 * @author ado
 */
class TokenMatcher {
    private $patron;
    private $input;
    private $group_hash;
    private $start = 0;
    
    function __construct($patron, $input, $group_hash) {
        $this->patron = $patron;
        $this->input = $input;
        $this->group_hash = $group_hash;
    }

    
    public function next()
    {
        $sub_input = substr($this->input, $this->start);
        
        $matches = array();
        if(preg_match($this->patron, $sub_input, $matches)!== 1){
            throw new TokenMatcherException("no se encontró el patrón");
        }
        
        $this->start += strlen($matches[1]);
        
        $group_name = $this->findGroup($matches);
        
        return new Token($this->group_hash[$group_name]->getToken_class(), $matches[1]);
    }
    public function hasNext()
    {
        return $this->start >= strlen($this->input);
    }
    private function findGroup($matches)
    {
        foreach($this->group_hash as $key => $value)
        {
            if(isset($matches[$key]) && !empty($matches[$key]))
                return $key;
        }
        
        throw new TokenMatcherException("grupo no encontrado");
    }
}
