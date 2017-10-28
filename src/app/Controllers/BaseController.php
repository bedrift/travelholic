<?php

namespace App\Controllers;

class BaseController {
    protected $container;
    protected $logger;
    protected $view;
    
    function __construct($container) {
        $this->container    = $container;
        
        $this->logger       = $this->container->get("logger");
        $this->view         = $this->container->get("view");
    }
}