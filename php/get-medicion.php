<?php

//include("../pgconfig.php");

require_once(dirname(__FILE__,2).'/MICROSERVICIOS/MIC-GEOVISOR/CAPA-APLICACION/SERVICIOS/REPOSITORIO-SERVICIO.php');

$_POST["wkt"] = 'POLYGON((-7856386.23101514 -6113904.726182583,-7755237.072887988 -6203815.088962278,-7680311.713408106 -6113904.726182583,-7773968.284140151 -6042725.746145464,-7856386.23101514 -6113904.726182583))';
$_POST["type"] = 'Polygon';

$wkt = $_POST["wkt"];
$type = $_POST["type"];

//$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
//$conn = pg_connect($string_conn);

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

//echo $query_string; exit;
//$query = pg_query($conn,$query_string);

//$data = pg_fetch_assoc($query);
$servicio_geovisor = New RepositorioServicioGeovisor();

$data = $servicio_geovisor->get_consulta_ahrsc($query_string);

$area = $data[0]["area"];

$data = explode(".",$data[0]["km"]);

$data = $data[0][0] . "." . substr($data[0][1],0,2);

if ($type == "LineString") {

	echo "<p>Distancia: " . $data . " Km.</p>";
	
}else{
	
	echo "<p>Área: " . $area . " m2.</p>";
	echo "<p>Perímetro: " . $data . " Km.</p>";
	
}

?>
