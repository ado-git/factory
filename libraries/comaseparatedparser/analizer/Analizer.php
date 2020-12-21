<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once LIB_PATH.'/tokenizer/Token.php';
require_once LIB_PATH.'/tokenizer/Tokenizer.php';
require_once LIB_PATH.'/tokenizer/TokenRule.php';


/**
 * Description of Analizer
 *
 * @author ado
 */
class Analizer {
    private $start;
    private $tokenizer;
    private $listener;
    
    function __construct($input, $listener) {
        $this->listener = $listener;
        
        $rules_array = array();
        $rules_array[] = new TokenRule("coma", ",");
        $rules_array[] = new TokenRule("quoted", "\"(|(.*?[^\\\\]))\"");
        $rules_array[] = new TokenRule("whitespace", "\\s+");
        $rules_array[] = new TokenRule("item", "[^\\s,\"\\r\\n\\t]+");

        $this->tokenizer = new Tokenizer($rules_array, $input);
        
        $this->start = new State(false, function($t){
        });
        $item = new State(true, function($t){
            $this->listener->item($t);
        });
        $quoted = new State(true, function($t){
            $this->listener->quoted($t);
        });
        $space_itemlist = new State(true, function($t){
            $this->listener->space_itemlist($t);
        });
        $coma = new State(false, function($t){
            $this->listener->coma($t);
        });
        $space_postcoma = new State(false, function($t){
            $this->listener->space_postcoma($t);
        });

        $this->start->addState("item", $item);
        $this->start->addState("quoted", $quoted);
        
        $item->addState("whitespace", $space_itemlist);
        $item->addState("coma", $coma);
        
        $quoted->addState("whitespace", $space_itemlist);
        $quoted->addState("coma", $coma);
        
        $space_itemlist->addState("item", $item);
        $space_itemlist->addState("quoted", $quoted);
        $space_itemlist->addState("coma", $coma);
        
        $coma->addState("whitespace", $space_postcoma);
        $coma->addState("item", $item);
        $coma->addState("quoted", $quoted);
        
        $space_postcoma->addState("item", $item);
        $space_postcoma->addState("quoted", $quoted);
    }
    
    public function parse()
    {
        $m = $this->tokenizer->getTokenMatcher();
        
        $s = $this->start;

        while(!$m->hasNext())
        {
            $token = $m->next();
            
            $s = $s->getState($token->getToken_class());
            $s->fireEvent($token);
        }
        
        if (!$s->isFinal()) {
            throw new AnalizerException("unexpected end of input");
        }
    }
}
