<?php

namespace App;

class Initiate {
    function __invoke(array $settings = []) {
        $dev    = $settings["dev"]?? false;
        
        unset($settings["dev"]);
        
        $app = new \Slim\App([
            'settings' => array_merge(
                $settings,
                [
                    "displayErrorDetails" => $dev,
                    "addContentLengthHeader" => false
                ]
            )
        ]);
        
        return $app;
    }
}