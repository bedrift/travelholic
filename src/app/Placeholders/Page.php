<?php

namespace App\Placeholders;

class Page {
    private $language;
    
    function __construct($language) {
        $this->language = $language;
    }
    
    function __invoke($m) {
        $attribute  = $m[1] ?? null;
        $options    = $m[2] ?? null;
        $default    = $m[3] ?? null;
        
        if ($attribute && ($attribute = substr($attribute,1))) {
            if ($attribute == "language") return $this->language;
        }
        
        if ($options && ($options = substr($options,1))) {
            foreach(explode(":",$options) as $option) {
                
            }
        }
        
        return $default ?? $m[1];
    }
}