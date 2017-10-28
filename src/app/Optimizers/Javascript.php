<?php

namespace App\Optimizers;

use \GoogleClosureCompiler\Compiler;

class Javascript {
    function __invoke($folder,$url,$print = false) {
        $path   = $folder . ltrim($url,"/");
        
        $hash   = substr(md5_file($path),0,10);
        $cache  = "assets/" . $hash . ".js";
        
        if (file_exists($cache) == false || filesize($path) == false) {
            $code       = file_get_contents($path);
            
            $compiler   = new Compiler;
            $response   = $compiler->setJsCode($code)->compile();
            
            $response   = ($response && $response->isWithoutErrors())? $response->getCompiledCode() : $code;
            
            file_put_contents($cache,$response);
        }
        
        if ($print) {
            $content    = file_get_contents($cache);
            
            $content    = preg_replace_callback("#" . str_replace("/","\\/",trim(dirname($url),"/")) . "/[a-z0-9/_\.-]+\.js#",function($m) use ($folder) {
                $url    = $m[0];
                $path   = $folder . ltrim($url,"/");
                
                if (preg_match("#\.min\.js$#",$path)) return $path;
                
                $hash   = substr(md5_file($path),0,10);
                $cache  = "assets/" . $hash . ".js";
                
                if (file_exists($cache) == false || filesize($path) == false) {
                    $code       = file_get_contents($path);
                    
                    $compiler   = new Compiler;
                    $response   = $compiler->setJsCode($code)->compile();
                    
                    if ($response && $response->isWithoutErrors()) {
                        $response = $response->getCompiledCode();
                    
                    } else {
                        $response = $code;
                    }
                    
                    file_put_contents($cache,$response);
                }
                
                return "/" . $cache;
            },$content);
            
            return $content;
        }
        
        return "/" . $cache;
    }
}