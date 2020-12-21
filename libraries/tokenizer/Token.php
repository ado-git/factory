<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Token
 *
 * @author ado
 */
class Token {
    private $token_class;
    private $text;
    
    function __construct($token_class, $text) {
        $this->token_class = $token_class;
        $this->text = $text;
    }
    
    function getToken_class() {
        return $this->token_class;
    }

    function getText() {
        return $this->text;
    }
}
