<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Variable
 *
 * @author ado
 */
class Variable {
    public $name;
    public $type;
    public $fields;
    public $comment;
    
    function __construct($name, $type, $fields, $comment) {
        $this->name = $name;
        $this->type = $type;
        $this->fields = $fields;
        $this->comment = $comment;
    }
    
    function getName() {
        return $this->name;
    }

    function getType() {
        return $this->type;
    }

    function getFields() {
        return $this->fields;
    }

    function getComment() {
        return $this->comment;
    }
}
