<?php

namespace App\Placeholders;

class Translate {
    private $language;
    
    function __construct($language) {
        $this->language = $language;
    }
    
    function __invoke($m) {
        $language       = $this->language;
        
        $placeholder    = $m[0];
        $handler        = $m[1]?? null;
        $options        = $m[2]?? null;
        $default        = $m[3]?? null;
        
        $translation    = [
            "menu" => [
                "children" => [
                    "places" => [
                        "da" => "Steder"
                    ],
                    "accommodations" => [
                        "da" => "Ophold"
                    ],
                    "restaurants" => [
                        "da" => "Mad & Drikke"
                    ],
                    "todo" => [
                        "da" => "Seværdigheder"
                    ],
                    "deals" => [
                        "da" => "Rejser"
                    ]
                ]
            ]
        ];
        
        $data               = $translation;
        
        while(preg_match("#^([a-z0-9-]+)\.(.+)$#i",$handler,$m)) {
            $main           = $m[1];
            
            if (array_key_exists($main,$data) && array_key_exists("children",$data[$main])) {
                $data       = $data[$main]["children"];
                $handler    = $m[2];
            }
            else return $default;
        }
        
        $translation        = null;
        
        if (array_key_exists($handler,$data)) {
            if (array_key_exists($language,$data[$handler])) $translation = $data[$handler][$language];
        }
        elseif (array_key_exists($language,$data)) $translation = $data[$language];
        
        if ($translation) {
            if ($options && ($options = array_flip(explode(":",substr($options,1))))) {
                if (array_key_exists("dehtml",$options) == false) $translation = htmlspecialchars($translation);
                
                return $translation;
            }
        }
        
        return $default ?? $placeholder;
    }
}