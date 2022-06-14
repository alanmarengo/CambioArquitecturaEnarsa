<?php

include("../pgconfig.php");
include("../tools.php");

$results = $_POST["results"];

$gids = array();

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$qs = array();

$out = "";

for ($i=0; $i<sizeof($results); $i++) {
	
	$sep = explode(";",$results[$i]);
	
	$layer_name = $sep[0];
	
	$query_string = "SELECT * FROM mod_geovisores.vw_layers WHERE layer_wms_layer = '" . $layer_name . "'";
	
	$query = pg_query($conn,$query_string);
	
	$data = pg_fetch_assoc($query);
	
	$query_string = "SELECT * FROM \"".$data["layer_schema"]."\".\"".$data["layer_table"]."\" WHERE id = " . $sep[1];
	
	$query = pg_query($conn,$query_string);
	
	$data = pg_fetch_assoc($query);
	
	$out .= "<p>" . $data["NOMBRE"] . "</p>";
	
}

echo $out;

?>