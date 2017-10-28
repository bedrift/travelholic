<?php

namespace App;

use App\Controllers\{
    IndexController,
    PlacesController
};

class Routes {
    function __invoke($app) {
        $container = $app->getContainer();
        
        $app->get('/',IndexController::class . ':index')->setName("index");
        
        $app->get('/places',PlacesController::class . ':index')->setName("places");
        
        $app->get('/places/{id:[a-z0-9]+}[/{name:.*}]',PlacesController::class . ':item')->setName("place");
        
        /*
        // catch-all
        $app->get('/{url:.*}', function (Request $request, Response $response, $args) {
            $response->getBody()->write("Hello World: " . $args["url"]);
            
            return $response;
        });
        */
    }
}