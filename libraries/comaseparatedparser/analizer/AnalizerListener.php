<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author ado
 */
interface AnalizerListener {
    public function item($token);
    public function quoted($token);
    public function space_itemlist($token);
    public function coma($token);
    public function space_postcoma($token);
}
