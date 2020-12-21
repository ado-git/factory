<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'ItemBase.php';
/**
 * Description of Item
 *
 * @author ado
 */
class Item extends ItemBase{
    public function __construct($t) {
        parent::__construct($t);
    }

    public function getText() {
        return $this->t->getText();
    }

}
