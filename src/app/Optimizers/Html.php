<?php

namespace App\Optimizers;

use \voku\helper\HtmlMin;

class Html {
    function __invoke($html) {
        $hash   = md5($html);
        $cache  = "/tmp/frontend." . $hash . ".html";
        
        if (true || file_exists($cache) == false || filesize($cache) == false) {
            $minimizer = new HtmlMin();
            
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
            
            $output = $minimizer->minify($html);
            
            $output = preg_replace("#\s+#"," ",$output);
            $output = str_replace(array("> @","} @"," </style>"),array(">@","}@","</style>"),$output);
            
            // remove unnessesary quotes around attribute values
            //$output = preg_replace("#( [a-z]+=)\"([^\"'`=<>\s]+?)\"([ >])#i","$1$2$3",$output);
            
            file_put_contents($cache,$output);
        }
        else $output = file_get_contents($cache);
        
        return $output;
    }
}