<?php

namespace App;

class Services {
    function __invoke($app) {
        $container = $app->getContainer();
        
        $container['logger'] = function($c) {
            $logger = new \Monolog\Logger('my_logger');
            $file_handler = new \Monolog\Handler\StreamHandler("../../logs/app.log");
            $logger->pushHandler($file_handler);
            
            return $logger;
            
            // $this->logger->addInfo("Something interesting happened");
        };
        
        $container['view'] = new View($container->get("settings"));
    }
}