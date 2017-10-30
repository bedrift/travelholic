<?php

namespace App;

use \Slim\App;

class Initiate {
    function __invoke(array $settings = []) {
        $dev    = (($_ENV["APP_ENV"] ?? "development") == "development");
        
        $app = new App([
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