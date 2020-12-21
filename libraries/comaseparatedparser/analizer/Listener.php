<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'AnalizerListener.php';
require_once 'estructuras/Item.php';
require_once 'estructuras/Quoted.php';
require_once 'estructuras/Start.php';
require_once LIB_PATH.'/tokenizer/Token.php';
/**
 * Description of MiListener
 *
 * @author ado
 */
class Listener implements AnalizerListener{
    private $start;
    
    function __construct() {
        $this->start = new Start();
    }
    
    public function item($token) {
        $this->start->getCurrentItemList()->addItemBase(new Item($token));
    }

    public function quoted($token) {
        $this->start->getCurrentItemList()->addItemBase(new Quoted($token));
    }

    public function space_itemlist($token) {
    }

    public function coma($token) {
        $this->start->addNewItemlist();
    }

    public function space_postcoma($token) {
    }

    public function getStart() {
        return $this->start;
    }
}
