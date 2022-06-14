<?php

include("../mdeconfig.php");
					
$conn = pg_connect("host=" . pgserver . " user=" . pguser . " port=" . pgport . " password=" . pgpassword . " dbname=mde");

$wkt = $_GET["wkt"];

$wkt_qs = "SELECT * FROM mde.get_perfil_topografico('$wkt');";

$minmax = "SELECT MIN(altura) as min, MAX(altura) as max FROM mde.get_perfil_topografico('$wkt');";

$minmaxr = pg_fetch_assoc(pg_query($conn,$minmax));

$min = $minmaxr["min"];
$max = $minmaxr["max"];

$query = pg_query($conn,$wkt_qs);

$distance = 0;

$json = "{\"data\":[";

$points = array();

while ($r = pg_fetch_assoc($query)) {
	
	$json .= "[".$r["distancia"].",".$r["altura"]."],";
	array_push($points,$r["punto"]);
	/*$json .= "\"altura\":\"".$r["altura"]."\",";
	$json .= "\"distancia\":\"".$r["distancia"]."\",";
	$json .= "\"punto\":\"".$r["punto"]."\",";
	$json .= "\"distancia_total\":\"".$r["distancia_total"]."\"";
	
	$json .= "},";*/
	
	$distance = $r["distancia_total"];
	
}

$distance = $distance / 1000;
$distance = explode(".",$distance);
$distance = $distance[0] . "." . substr($distance[1],0,2);

$json = substr($json,0,strlen($json)-1);
$json .= "],\"distancia_total\":\"".$distance."\",\"min\":\"".$min."\",\"max\":\"".$max."\",\"points\":[\"".implode("\",\"",$points)."\"]}";

echo $json;

pg_close($conn);


?>