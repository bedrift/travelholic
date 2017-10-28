<?php

namespace App\Optimizers;

class Css {
    function __invoke($folder,$url,$print = false) {
        $hash           = null;
        
        // external
        if (preg_match("#^(https?:)?\/\/(.+)$#",$url,$m)) {
            if ($m[1] == false) $url = "https:" . $url;
            
            $content    = file_get_contents($url);
        }
        // internal
        else {
            $content    = file_get_contents($folder . ltrim($url,"/"));
            $hash       = substr(md5($content),0,10);
        }
        
        $content        = preg_replace("#\s+#"," ",trim($content));
        $content        = preg_replace("#\s*(\{|\}|;|\:|,)\s*#","$1",$content);
        $content        = str_replace(" format(","format(",$content);
        $content        = str_replace(";}","}",$content);
        $content        = trim($content);
        
        if ($print) return $content;
        
        $cache          = "assets/" . $hash . ".css";
        
        if (file_exists($cache) == false || filesize($cache) == false) file_put_contents($cache,$content);
        
        return "/" . $cache;
    }
}