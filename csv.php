<?php

include("./pgconfig.php");
include("./tools.php");

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=file.csv");

$q = $_GET["q"];

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$query_string = decrypt($q);

$query = pg_query($conn,$query_string);

//echo $query;

$csv = parseSQLToCSV($query);

echo $csv;

pg_close($conn);

?>