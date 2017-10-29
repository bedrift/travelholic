<?php

namespace App\Optimizers;

class OptimizerBase {
    private $rootFolder;
    
    function __construct() {
        $this->rootFolder = dirname($_SERVER['SCRIPT_FILENAME']);
    }
    
    function getRootFolder() {
        return $this->rootFolder;
    }
    
    function getAssetsFolder($absolute = false) {
        if ($absolute == false) return "/assets";
        
        return $this->getRootFolder() . $this->getAssetsFolder();
    }
    
    function getTemplatesFolder($absolute = false) {
        if ($absolute == false) return "/templates";
        
        return $this->getRootFolder() . $this->getTemplatesFolder();
    }
}