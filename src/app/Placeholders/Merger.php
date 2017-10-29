<?php

namespace App\Placeholders;

use App\Placeholders\{
    ImagePath,
    Brand,
    Page
};

class Merger {
    private $folder;
    private $language;
    
    function __invoke($html,$folder,$language) {
        $this->folder   = $folder;
        $this->language = $language;
        
        // images and other media files relative to template folder
        $html   = preg_replace_callback("#(src=['\"]*)/?(?!assets/)((?:[a-z0-9][a-z0-9_\.\-]*)(?:\/[a-z0-9][a-z0-9_\.\-]*)*\.(?:jpe?g|png|gif|svg))#i",function($m){return $m[1] . (new ImagePath($this->folder))($m[2]);},$html);
        
        // remove css from content
        $css    = [];
        $html   = preg_replace_callback("#<style.+?</style>#i",function($m) use (&$css) {
            $css[] = $m[0];
            
            return "INLINECSSREPLACE" . count($css);
        },$html);
        
        // remove javascript from content
        $js     = [];
        $html   = preg_replace_callback("#<script.+?</script>#i",function($m) use (&$js) {
            $js[] = $m[0];
            
            return "INLINEJSREPLACE" . count($js);
        },$html);
        
        // brand content
        $html   = preg_replace_callback("#\{brand(\.[a-z0-9]+(?:\-[a-z0-9]+)*)+(?!\.)((?:\:[a-z0-9]+(?:\-[a-z0-9\.]+)*)+)*(?!\.)(?:\{(.+?)\})?\}#i",(new Brand($this->language)),$html);
        
        // page content
        $html   = preg_replace_callback("#\{page(\.[a-z0-9]+(?:\-[a-z0-9]+)*)+(?!\.)((?:\:[a-z0-9]+(?:\-[a-z0-9\.]+)*)+)*(?!\.)(?:\{(.+?)\})?\}#i",(new Page($this->language)),$html);
        
        // translation
        $html   = preg_replace_callback("#\{((?:[a-z0-9]+(?:[a-z0-9-]*[a-z0-9])*)(?:(?:\.[a-z0-9]+(?:[a-z0-9-]*[a-z0-9])*))*)((?:\:[a-z0-9\.-]+)+)?(?:\{(.+?)\})?\}(?!\})#i",(new Translate($this->language)),$html);
        
        // return css to content
        $html   = preg_replace_callback("#INLINECSSREPLACE([0-9]+)#",function($m) use ($css) {
            return $css[$m[1] - 1];
        },$html);
        
        // return js to content
        $html   = preg_replace_callback("#INLINEJSREPLACE([0-9]+)#",function($m) use ($js) {
            return $js[$m[1] - 1];
        },$html);
        
        return $html;
    }
}