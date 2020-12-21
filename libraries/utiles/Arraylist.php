<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Arraylist
 *
 * @author ado
 */
class Arraylist {
    private $array = array();
    
    public function add($item)
    {
        $this->array[] = $item;
    }
    public function get($index)
    {
        return $this->array[$index];
    }
    public function size()
    {
        return count($this->array);
    }
    
    function getArray() {
        return $this->array;
    }
}
