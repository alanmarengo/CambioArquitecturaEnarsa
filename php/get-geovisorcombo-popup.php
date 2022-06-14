<?php

include("../pgconfig.php");
include("../tools.php");

$lon = $_POST["lon"];
$lat = $_POST["lat"];

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);



?>