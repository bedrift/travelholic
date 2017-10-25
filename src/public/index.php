<?php

error_reporting(E_ALL);
ini_set("display_errors",1);

require '../vendor/autoload.php';

$dev = true;

if ($dev) {
    error_reporting(E_ALL);
    ini_set("display_errors",1);
}

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Travelholic;

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => $dev,
        'addContentLengthHeader' => false
    ]
]);

$container = $app->getContainer();

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("../../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};

$app->get('/[{url:.*}]', function (Request $request, Response $response, $args) {
    $test = new Travelholic();
    
    $response->getBody()->write("Hello World: " . $test->output() . " - " . $args["url"]);
    
    //$this->logger->addInfo("Something interesting happened");

    return $response;
});

$app->run();

exit();

// variables (from CloudFront header)
$country    = "dk";
$language   = "da"; // skal kunne overskrives af URL afhængigt sprog

// css styles caching
function css($url,$output = false) {
    $hash           = null;
    
    // external
    if (preg_match("#^(https?:)?\/\/(.+)$#",$url,$m)) {
        if ($m[1] == false) $url = "https:" . $url;
        
        $content    = file_get_contents($url);
    }
    // internal
    else {
        $content    = file_get_contents($url);
        $hash       = substr(md5($content),0,10);
    }
    
    $content        = preg_replace("#\s+#"," ",trim($content));
    $content        = preg_replace("#\s*(\{|\}|;|\:|,)\s*#","$1",$content);
    $content        = str_replace(" format(","format(",$content);
    $content        = str_replace(";}","}",$content);
    
    if ($output) return $content;
    
    $cache          = "assets/" . $hash . ".css";
    
    if (file_exists($cache) == false || filesize($cache) == false) file_put_contents($cache,$content);
    
    return "/" . $cache;
}

function less($folder,$file,$output = false) {
    $files  = glob($folder . "/*.less");
    
    $hash   = [];
    
    foreach($files as $f) $hash[] = md5_file($f);
    
    $hash   = substr(md5(implode($hash)),0,10);
    
    $cache  = "assets/" . $hash . ".css";
    
    if (file_exists($cache) == false || filesize($cache) == false) exec("lessc --compress --clean-css --rootpath=/styles " . $folder . "/" . $file . " " . $cache);
    
    if ($output) return file_get_contents($cache);
    
    return "/" . $cache;
}

// javascript optimizing
function js($path,$output = false) {
    $hash   = substr(md5_file($path),0,10);
    $cache  = "assets/" . $hash . ".js";
    
    if (file_exists($cache) == false || filesize($path) == false) {
        $code       = file_get_contents($path);
        
        $compiler   = new GoogleClosureCompiler\Compiler;
        $response   = $compiler->setJsCode($code)->compile();
        
        $response   = ($response && $response->isWithoutErrors())? $response->getCompiledCode() : $code;
        
        file_put_contents($cache,$response);
    }
    
    if ($output) {
        $content    = file_get_contents($cache);
        
        $content    = preg_replace_callback("#scripts/[a-z0-9/_\.-]+\.js#",function($m) {
            $path   = $m[0];
            
            if (preg_match("#\.min\.js$#",$path)) return $path;
            
            $hash   = substr(md5_file($path),0,10);
            $cache  = "assets/" . $hash . ".js";
            
            if (file_exists($cache) == false || filesize($path) == false) {
                $code       = file_get_contents($path);
                
                $compiler   = new GoogleClosureCompiler\Compiler;
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

// load content
ob_start();

include("templates/main.php");

$content = ob_get_contents();

ob_clean();

include("templates/header.php");

$header = ob_get_contents();

ob_clean();

include("templates/footer.php");

$footer = ob_get_contents();

ob_clean();

$output = $header . $content . $footer;

// placeholders
$translation = [
    "menu" => [
        "children" => [
            "places" => [
                "da" => "Steder"
            ],
            "accommodations" => [
                "da" => "Ophold"
            ],
            "restaurants" => [
                "da" => "Mad & Drikke"
            ],
            "todo" => [
                "da" => "Seværdigheder"
            ],
            "deals" => [
                "da" => "Rejser"
            ]
        ]
    ]
];

$output = preg_replace_callback("#\{([a-z0-9\.-]+)((?:\:[a-z0-9\.-]+)+)?(?:\{(.+?)\})?\}#i",function($m) use ($translation, $language) {
    // brand.name
    // unhtml()
    
    $placeholder            = $m[0];
    $handler                = $m[1];
    $options                = (isset($m[2]) && $m[2] == true)? array_flip(explode(":",substr($m[2],1))) : [];
    $default                = (isset($m[3]))? $m[3] : null;
    
    if (preg_match("#^brand((?:\.[a-z0-9-]+)+)$#",$handler,$m)) {
        $handler            = substr($m[1],1);
        
        if ($handler == "name") return "Travelholic";
    }
    else {
        $data               = $translation;
        
        while(preg_match("#^([a-z0-9-]+)\.(.+)$#i",$handler,$m)) {
            $main           = $m[1];
            
            if (array_key_exists($main,$data) && array_key_exists("children",$data[$main])) {
                $data       = $data[$main]["children"];
                $handler    = $m[2];
            }
            else return $default;
        }
        
        $translation        = null;
        
        if (array_key_exists($handler,$data)) {
            if (array_key_exists($language,$data[$handler])) $translation = $data[$handler][$language];
        }
        elseif (array_key_exists($language,$data)) $translation = $data[$language];
        
        if ($translation) {
            if (array_key_exists("dehtml",$options) == false) $translation = htmlspecialchars($translation);
            
            return $translation;
        }
    }
    
    return $default ?? $placeholder;
},$output);

// optimize html
$hash   = md5($output);
$cache  = "/tmp/frontend." . $hash . ".html";

if (file_exists($cache) == false || filesize($cache) == false) {
    $minimizer = new voku\helper\HtmlMin();
    
    $minimizer->doRemoveComments();
    $minimizer->doSumUpWhitespace();
    $minimizer->doRemoveWhitespaceAroundTags();
    $minimizer->doOptimizeAttributes();
    $minimizer->doRemoveDeprecatedAnchorName();
    $minimizer->doRemoveDeprecatedScriptCharsetAttribute();
    $minimizer->doRemoveDeprecatedTypeFromScriptTag();
    $minimizer->doRemoveDeprecatedTypeFromStylesheetLink();
    $minimizer->doSortCssClassNames();
    $minimizer->doRemoveSpacesBetweenTags();
    $minimizer->doOptimizeViaHtmlDomParser();
    
    $output = $minimizer->minify($output);
    
    file_put_contents($cache,$output);
}
else $output = file_get_contents($cache);

// output
echo $output;