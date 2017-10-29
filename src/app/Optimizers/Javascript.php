<?php

namespace App\Optimizers;

use \GoogleClosureCompiler\Compiler;

class Javascript extends OptimizerBase {
    function __invoke($folder,$url,$print = false) {
        $path   = $this->getRootFolder(true) . "/" . $folder . ltrim($url,"/");
        $hash   = substr(md5_file($path),0,10);
        $file   = $hash . ".js";
        $cache  = $this->getAssetsFolder(true) . "/" . $file;
        
        if (file_exists($cache) == false || filesize($path) == false) {
            $code       = file_get_contents($path);
            
            $compiler   = new Compiler;
            $response   = $compiler->setJsCode($code)->compile();
            
            $response   = ($response && $response->isWithoutErrors())? $response->getCompiledCode() : $code;
            
            file_put_contents($cache,$response);
        }
        
        if ($print) {
            $content        = file_get_contents($cache);
            $rootfolder     = $this->getRootFolder(true);
            $assetsfolder   = $this->getAssetsFolder();
            $assetsfolderabs= $this->getAssetsFolder(true);
            
            $content    = preg_replace_callback("#" . str_replace("/","\\/",trim(dirname($url),"/")) . "/[a-z0-9/_\.-]+\.js#",function($m) use ($folder,$rootfolder,$assetsfolder,$assetsfolderabs) {
                $url    = $m[0];
                $path   = $folder . ltrim($url,"/");
                
                if (preg_match("#\.min\.js$#",$path)) return $path;
                
                $path   = $rootfolder . "/" . ltrim($path,"/");
                $hash   = substr(md5_file($path),0,10);
                $file   = $hash . ".js";
                $cache  = $assetsfolderabs . "/" . $file;
                
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
                
                return $assetsfolder . "/" . $file;
            },$content);
            
            return $content;
        }
        
        return $this->getAssetsFolder() . "/" . $file;
    }
}