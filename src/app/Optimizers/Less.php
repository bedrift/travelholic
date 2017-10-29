<?php

namespace App\Optimizers;

use \Less_Parser;

class Less extends OptimizerBase {
    function __invoke($folder,$url,$print = false) {
        $files  = glob($this->getRootFolder() . "/" . $folder . trim(dirname($url),"/") . "/*.less");
        
        $hash   = [];
        
        foreach($files as $f) $hash[] = md5_file($f);
        
        $hash   = substr(md5(implode($hash)),0,10);
        
        $file   = $hash . ".css";
        $cache  = $this->getAssetsFolder(true) . "/" . $file;
        
        if (file_exists($cache) == false || filesize($cache) == false) {
            try {
                $parser = new Less_Parser(['compress'=>true]);
                
                $parser->parseFile($this->getRootFolder(true) . "/" . $folder . ltrim($url,"/"),$this->getRootFolder(true) . "/" . $folder . trim(dirname($url),"/") . "/");
                
                $css = $parser->getCss();
                
                file_put_contents($cache,$css);
            }
            catch(Exception $e) {
                $error_message = $e->getMessage();
                
                $cache = $url;
            }
        }
        
        if ($print) return file_get_contents($cache);
        
        return $this->getAssetsFolder() . "/" . $file;
    }
}