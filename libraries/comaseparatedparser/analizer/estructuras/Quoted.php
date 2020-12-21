<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'ItemBase.php';
/**
 * Description of Quoted
 *
 * @author ado
 */
class Quoted extends ItemBase{
    public function __construct($t) {
        parent::__construct($t);
    }
    
    public function getText() {
        $text = $this->t->getText();
        
        $text = substr($text, 1, strlen($text) - 2);
        $text = $this->replaceEscapes($text);
        
        return $text;
    }
    
    private function replaceEscapes($input)
    {
        return  str_replace("\\\\\\\"", "\"", $input);
    }
}
