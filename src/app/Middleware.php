<?php

namespace App;

use \Psr\Http\Message\{
    ServerRequestInterface as Request,
    ResponseInterface as Response
};
use App\Api;

class Middleware {
    // Middleware is executed with first added Middleware runned last, and last added first for Requests
    
    function __invoke($app) {
        // translate URLs and fetch data from API
        $app->add(function(Request $request, Response $response, callable $next) {
            $api        = new Api\Url();
            
            $request    = $api->translate($request);
            
            if ($request->getAttribute("language")) $this->get("settings")["language"] = $request->getAttribute("language");
            
            return $next($request, $response);
        });
        
        // default Accept-Language value
        $app->add(function (Request $request, Response $response, callable $next) {
            $languageHeader = explode(',',$request->getHeaderLine('Accept-Language')??'en-US');
            $languages      = array(); 
            
            foreach($languageHeader as $lang) {
                $name = preg_replace('/([^;]+);.*$/', '${1}', $lang);
                $q = preg_replace('/^[^q]*q=([^\,]+)*$/', '${1}', $lang);
                $q = is_numeric($q) ? floatval($q) : 1.0; 
                $languages[$name] = $q;
            }
            
            array_multisort($languages, SORT_DESC , SORT_NATURAL);
            
            $valid      = $this->get("settings")["languages"];
            $languages  = array_filter($languages,function($language) use ($valid){return in_array($language,$valid);},ARRAY_FILTER_USE_KEY);
            
            if ($languages) $this->get("settings")["language"] = key($languages);
            
            return $next($request, $response);
        });
        
        // remove trailing slashes
        $app->add(function (Request $request, Response $response, callable $next) {
            $uri = $request->getUri();
            $path = $uri->getPath();
            
            if ($path != '/' && substr($path, -1) == '/') {
                $uri = $uri->withPath(substr($path, 0, -1));
                
                if ($request->getMethod() == 'GET') {
                    return $response->withRedirect((string)$uri, 301);
                }
                else {
                    return $next($request->withUri($uri), $response);
                }
            }
        
            return $next($request, $response);
        });
    }
}