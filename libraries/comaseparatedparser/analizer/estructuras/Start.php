<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Itemlist.php';
/**
 * Description of Start
 *
 * @author ado
 */
class Start {
    private $itemlists = array();
    private $index = -1;
    
    function __construct() {
        $this->addNewItemlist();
    }
    
    public function getCurrentItemList()
    {
        return $this->itemlists[$this->index];
    }
    
    public function addNewItemlist()
    {
        $this->itemlists[] = new Itemlist();
        $this->index++;
    }

    public function getItemlist() {
        return $this->itemlists;
    }
    

}
