<?php

include("../pgconfig.php");

$wkt = $_POST["wkt"];
$type = $_POST["type"];

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

if ($type == "LineString") {

	//$query_string = "SELECT ST_Length(ST_GeomFromText('".$wkt."')::geography,true) / 1000 AS km;";
	$query_string = "SELECT ST_Length(st_transform(ST_GeomFromText('".$wkt."',3857),4326)::geography,true) / 1000 AS km;";
	//echo $query_string;

}else{
	
	//$query_string = "SELECT ST_Perimeter(ST_GeomFromText('".$wkt."')) / 1000 AS km,ST_Area(ST_GeomFromText('".$wkt."')) / 1000 AS area;";
	
	//$query_string = "SELECT ST_Perimeter(ST_GeomFromText('".$wkt."')) / 1000 AS km,ST_Area(ST_Transform(ST_GeomFromText('".$wkt."',3857),4326)::geography) AS area;";
	
	$query_string = "SELECT ST_Perimeter(st_transform(ST_GeomFromText('".$wkt."',3857),4326)::geography) / 1000 AS km,ST_Area(ST_Transform(ST_GeomFromText('".$wkt."',3857),4326)::geography) AS area;";

	//echo "<!--$query_string-->";
	

}

$query = pg_query($conn,$query_string);

$data = pg_fetch_assoc($query);

$area = $data["area"];

$data = explode(".",$data["km"]);

$data = $data[0] . "." . substr($data[1],0,2);

if ($type == "LineString") {

	echo "<p>Distancia: " . $data . " Km.</p>";
	
}else{
	
	echo "<p>Área: " . $area . " m2.</p>";
	echo "<p>Perímetro: " . $data . " Km.</p>";
	
}

?>
