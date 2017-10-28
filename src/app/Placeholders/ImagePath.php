<?php

namespace App\Placeholders;

class ImagePath {
    private $folder;
    
    function __construct($folder) {
        $this->folder = $folder;
    }
    
    function __invoke($file) {
        return "/" . $this->folder . ltrim($file,"/");
    }
}