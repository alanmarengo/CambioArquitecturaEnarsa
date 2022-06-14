<?php

include("../pgconfig.php");

$query_id = $_POST["query_id"];

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$query_string = "SELECT dt_mapeo_query FROM mod_estadistica.dt_mapeo WHERE dt_mapeo_id = $query_id";

$query = pg_query($conn,$query_string);

$data = pg_fetch_assoc($query);

echo $data["dt_mapeo_query"];

?>