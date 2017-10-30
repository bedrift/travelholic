<?php

require("../vendor/autoload.php");

if (!isset($_ENV["APP_ENV"])) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

$app = (new \App\Initiate)([
    "language" => "en",
    "languages" => ['en','da'], // supported languages
    "country" => "dk", // CloudFront-Viewer-Country (http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2)
    "device" => [
        "mobile" => false, // CloudFront-Is-Mobile-Viewer
        "tablet" => true, // CloudFront-Is-Tablet-Viewer
        "smarttv" => false, // CloudFront-Is-SmartTV-Viewer
        "desktop" => true // CloudFront-Is-Desktop-Viewer
    ],
    "template" => [
        "folder" => "default",
        "extension" => "phtml"
    ]
]);

(new \App\Services)($app);
(new \App\Middleware)($app);
(new \App\Routes)($app);

$app->run();