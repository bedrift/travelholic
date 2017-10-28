<?php

namespace App\Api;

use \Psr\Http\Message\{
    ServerRequestInterface as Request,
    ResponseInterface as Response
};

class Url extends ApiHandler {
    function translate(Request $request) {
        $path   = $request->getUri()->getPath();
        
        if (preg_match("#^/steder$#",$path)) $data = ["path" => "/places", "language" => "da"];
        elseif (preg_match("#^/steder/(.+)$#",$path,$m)) $data = ["path" => "/places/" . $m[1], "language" => "da"];
        
        if (isset($data)) {
            if (isset($data["language"])) $request = $request->withAttribute("language",$data["language"]);
            
            $request    = $request->withUri($request->getUri()->withPath($data["path"]));
        }
        
        return $request;
    }
}