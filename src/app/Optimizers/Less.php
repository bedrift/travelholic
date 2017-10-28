<?php

namespace App\Optimizers;

use \Less_Parser;

class Less {
    function __invoke($folder,$url,$print = false) {
        $files  = glob($folder . trim(dirname($url),"/") . "/*.less");
        
        $hash   = [];
        
        foreach($files as $f) $hash[] = md5_file($f);
        
        $hash   = substr(md5(implode($hash)),0,10);
        
        $cache  = "assets/" . $hash . ".css";
        
        if (file_exists($cache) == false || filesize($cache) == false) {
            try {
                $parser = new Less_Parser(['compress'=>true]);
                
                $parser->parseFile($folder . ltrim($url,"/"),$folder . trim(dirname($url),"/") . "/");
                
                $css = $parser->getCss();
                
                file_put_contents($cache,$css);
            }
            catch(Exception $e) {
                $error_message = $e->getMessage();
                
                $cache = $url;
            }
        }
        
        if ($print) return file_get_contents($cache);
        
        return "/" . $cache;
    }
}