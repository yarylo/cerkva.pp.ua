<?php $time = 0;if (isset($_SERVER["HTTP_IF_MODIFIED_SINCE"]) && strtotime($_SERVER["HTTP_IF_MODIFIED_SINCE"]) >= $time) {header("HTTP/1.1 304 Not Modified", true);header("Last-Modified: " . date("D M j G:i:s T Y", $time), true);header("Content-type: text/css", true);die();}else{header("Last-Modified: " . date("D M j G:i:s T Y", $time), true);header("Cache-Control: must-revalidate", true);header("Content-type: text/css", true);}if (extension_loaded("zlib") && (ini_get("output_handler") != "ob_gzhandler")) {ini_set("zlib.output_compression", 1);}readfile("/home/u311510689/public_html/wp-content/cache/css/static/0c002751da92ef827b4b96d8fe5086b9.css");