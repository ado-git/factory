<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'AnalizerException.php';
/**
 * Description of State
 *
 * @author ado
 */
class State {
    private $states = array();
    private $isFinal;
    private $event;
    
    function __construct($isFinal, $event) {
        $this->isFinal = $isFinal;
        $this->event = $event;
    }
    
    public function addState($token_class, $state)
    {
        if (array_key_exists($token_class, $this->states)) {
            throw new AnalizerException("class already defined");
        }

        $this->states[$token_class] = $state;
    }
    public function getState($token_class)
    {
        if (!array_key_exists($token_class, $this->states)) {
            throw new AnalizerException("Unexpected token class: ".$token_class);
        }

        return $this->states[$token_class];
    }
    public function isFinal() {
        return $this->isFinal;
    }

    public function fireEvent($token)
    {
        $f = $this->event;
        $f($token);        
    }
}
