<?php

include("../pgconfig.php");

$lon = $_POST["lon"];
$lat = $_POST["lat"];

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$query_string = "SELECT * FROM mod_geovisores.get_coord(100001,$lon,$lat)";
$query = pg_query($conn,$query_string);
$data = pg_fetch_assoc($query);
$lon100001 = $data["nlon"];
$lat100001 = $data["nlat"];

$query_string = "SELECT * FROM mod_geovisores.get_coord(100002,$lon,$lat)";
$query = pg_query($conn,$query_string);
$data = pg_fetch_assoc($query);
$lon100002 = $data["nlon"];
$lat100002 = $data["nlat"];

$query_string = "SELECT * FROM mod_geovisores.get_coord(100003,$lon,$lat)";
$query = pg_query($conn,$query_string);
$data = pg_fetch_assoc($query);
$lon100003 = $data["nlon"];
$lat100003 = $data["nlat"];

$json = "{";

$json .= "\"coord100001\":{\"lon\":\"$lon100001\",\"lat\":\"$lat100001\",\"label\":\"Condor Cliff\"},";
$json .= "\"coord100002\":{\"lon\":\"$lon100002\",\"lat\":\"$lat100002\",\"label\":\"Barrancosa\"},";
$json .= "\"coord100003\":{\"lon\":\"$lon100003\",\"lat\":\"$lat100003\",\"label\":\"Lambert\"}";

$json .= "}";

echo $json;

?>