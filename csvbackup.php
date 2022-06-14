<?php

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=file.csv");

include_once("./tools.php");

$csv = $_REQUEST['csv'];

echo $csv;


?>
