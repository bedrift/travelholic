<?php

namespace App\Controllers;

use App\Controller;

class PlacesController extends BaseController {
    function index($request, $response, $args) {
        $response = $this->view->render($response,"places");
        
        //$response = $response->getBody()->write("<title>Places</title>Places");
        
        return $response;
    }
    
    function item($request, $response, $args) {
        $response = $this->view->render($response,"places",["id" => $args["id"]]);
        
        //$response = $response->getBody()->write("<title>Place</title>Place: " . $args["id"] . " = " . $args["name"] . " (" . $request->getAttribute('foo') .")");
        
        //$this->container->get("logger")->addInfo("Something interesting happened");
        
        return $response;
    }
}