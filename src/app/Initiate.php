<?php

namespace App;

use \Slim\App;

class Initiate {
    function __invoke(array $settings = []) {
        $app = new App([
            'settings' => array_merge(
                $settings,
                [
                    "displayErrorDetails" => (($_ENV["APP_ENV"] ?? "development") == "development"),
                    "addContentLengthHeader" => false
                ]
            )
        ]);
        
        return $app;
    }
}