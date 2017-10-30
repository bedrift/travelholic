<?php

namespace App\Optimizers;

class Css extends OptimizerBase {
    function __invoke($folder,$url,$print = false) {
        // external
        if (preg_match("#^(https?:)?\/\/(.+)$#",$url,$m)) {
            if ($m[1] == false) $url = "https:" . $url;
            
            $content    = file_get_contents($url);
        }
        // internal
        else {
            $content    = file_get_contents($this->getRootFolder(true) . "/" . $folder . ltrim($url,"/"));
        }
        
        $optimized      = $content;
        $optimized      = preg_replace("#\s+#"," ",trim($optimized));
        $optimized      = preg_replace("#\s*(\{|\}|;|\:|,)\s*#","$1",$optimized);
        $optimized      = str_replace(" format(","format(",$optimized);
        $optimized      = str_replace(";}","}",$optimized);
        $optimized      = trim($optimized);
        
        if ($print) return rtrim($optimized,";") . ";";
        
        $hash           = substr(md5($content),0,10);
        $file           = $hash . ".css";
        $cache          = $this->getAssetsFolder(true) . "/" . $file;
        
        if (file_exists($cache) == false || filesize($cache) == false) file_put_contents($cache,$optimized);
        
        return $this->getAssetsFolder() . "/" . $file;
    }
}