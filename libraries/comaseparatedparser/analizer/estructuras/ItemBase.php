<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ItemBase
 *
 * @author ado
 */
abstract class ItemBase {
    protected $t;

    function __construct($t) {
        $this->t = $t;
    }
    
    public abstract function getText();
}
