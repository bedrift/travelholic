<?php

namespace App;

use Psr\Http\Message\ResponseInterface as Response;
use App\Optimizers\{
    Css,
    Less,
    Javascript,
    Html
};
use App\Placeholders\Merger;

class View {
    private $settings;
    private $attributes;
    
    function __construct(\Slim\Collection $settings,array $attributes = []) {
        $this->settings     = $settings;
        $this->attributes   = $attributes;
    }
    
    function getSettings() {
        return $this->settings;
    }
    
    function getSetting($name,$default = null) {
        return $this->settings[$name]?? $default;
    }
    
    function getFolder() {
        return "templates/" . trim($this->getSettings("template")["folder"]?? "default","/") . "/";
    }
    
    function getExtension() {
        return $this->getSettings("template")["extension"]?? "phtml";
    }
    
    function getLanguage() {
        return $this->getSetting("language")?? "en";
    }
    
    function render(Response $response,$template,array $args = []) {
        if (preg_match("#^(.+)\.(php|phtml)$#",$template,$m)) $template = $m[1];
        
        $output             = $this->fetch($template,$args);
        
        $response->getBody()->write($output);
        
        return $response;
    }
    
    function fetch($template,array $data = []) {
        $data = array_merge($this->attributes,$data);
        
        try {
            ob_start();
            
            $this->protectedIncludeScope($template,$data);
            
            $output = ob_get_clean();
        }
        catch(\Throwable $e) { // PHP 7+
            ob_end_clean();
            
            throw $e;
        }
        catch(\Exception $e) { // PHP < 7
            ob_end_clean();
            
            throw $e;
        }
        
        $output = (new Html)($output);
        
        $output = (new Merger)($output,$this->getFolder(),$this->getLanguage());
        
        return $output;
    }
    
    protected function protectedIncludeScope($file,array $data = []) {
        extract($data);
        
        include($this->getFolder() . $file . "." . $this->getExtension());
    }
    
    function css($url,$print = false) {
        return (new Css)($this->getFolder(),$url,$print);
    }
    
    function less($url,$print = false) {
        return (new Less)($this->getFolder(),$url,$print);
    }
    
    function js($url,$print = false) {
        return (new Javascript)($this->getFolder(),$url,$print);
    }
    
    function alternate() {
        return "<link rel='alternate' href='https://www.travelholic.com/' hreflang='x-default' />";
    }
}