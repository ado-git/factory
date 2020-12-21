<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TokenRule
 *
 * @author ado
 */
class TokenRule {
    private $token_class;
    private $patron;
    
    function __construct($token_class, $patron) {
        $this->token_class = $token_class;
        $this->patron = $patron;
    }
    
    function getToken_class() {
        return $this->token_class;
    }

    function getPatron() {
        return $this->patron;
    }

}
