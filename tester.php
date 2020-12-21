<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once './libraries/console/comma_separated_extractor.php';

//UserInput::solicitarINT("entre valor de prueba");


$c = new CommaSeparatedExtractor(",1,2,3,",array("campo"));

var_dump($c->parse());