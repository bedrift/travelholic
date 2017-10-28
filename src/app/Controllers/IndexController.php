<?php

namespace App\Controllers;

use App\Controller;

class IndexController extends BaseController {
    function index($request, $response, $args) {
        $response = $this->view->render($response,"index");
        
        return $response;
    }
}