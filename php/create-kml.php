<?php

$kml = $_POST["kml"];

$filename = "../cache/temp_".rand(0,1000000).".kml";
//$filenameReturn = "./kml/temp_".rand(0,1000000).".kml";

$file = fopen($filename,"a");
fwrite($file,$kml);
fclose($file);

echo "{\"fileurl\":\"" . $filename . "\"}";


?>