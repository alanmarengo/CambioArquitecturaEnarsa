<?php

include("../pgconfig.php");

$query_id = $_POST["query_id"];

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$query_string = "SELECT 
st_xmin(st_expand(st_extent(st_transform(T.the_geom, 3857)), 200::double precision)::box3d) AS minx,
st_ymin(st_expand(st_extent(st_transform(T.the_geom, 3857)), 200::double precision)::box3d) AS miny,
st_xmax(st_expand(st_extent(st_transform(T.the_geom, 3857)), 200::double precision)::box3d) AS maxx,
st_ymax(st_expand(st_extent(st_transform(T.the_geom, 3857)), 200::double precision)::box3d) AS maxy
FROM mod_estadistica.get_mapeo($query_id) T";

$extent = pg_fetch_assoc(pg_query($conn,$query_string));

$json = "";

$json .= "{";
$json .= "\"minx\":\"" . $extent["minx"] . "\",";
$json .= "\"miny\":\"" . $extent["miny"] . "\",";
$json .= "\"maxx\":\"" . $extent["maxx"] . "\",";
$json .= "\"maxy\":\"" . $extent["maxy"] . "\"";
$json .= "}";

echo $json;

?>