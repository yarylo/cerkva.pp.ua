<?php $time = 0;if (isset($_SERVER["HTTP_IF_MODIFIED_SINCE"]) && strtotime($_SERVER["HTTP_IF_MODIFIED_SINCE"]) >= $time) {header("HTTP/1.1 304 Not Modified", true);header("Last-Modified: " . date("D M j G:i:s T Y", $time), true);header("Content-type: text/javascript", true);die();}else{header("Last-Modified: " . date("D M j G:i:s T Y", $time), true);header("Cache-Control: must-revalidate", true);header("Content-type: text/javascript", true);}if (extension_loaded("zlib") && (ini_get("output_handler") != "ob_gzhandler")) {ini_set("zlib.output_compression", 1);}readfile("/home/u311510689/public_html/wp-content/cache/js/static/c83468e67e01bfd0a1bb5ee1f7b9e3f1.js");