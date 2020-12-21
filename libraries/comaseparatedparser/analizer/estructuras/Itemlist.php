<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Itemlist
 *
 * @author ado
 */
class Itemlist {
    private $items = array();
    
    public function addItemBase($i)
    {
        $this->items[] = $i;
    }

    public function getItems() {
        return $this->items;
    }
}
