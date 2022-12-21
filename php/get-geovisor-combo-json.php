<?php

include("../pgconfig.php");

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$sections = array("AHRSC","Presidente Néstor Kichner","Gobernador Jorge Cepernic","Obras Complementarias");
$id_geovisor = array(100,200,300,400);

$lists = array();
$lists[0] = "841";
/* $lists[1] = "851,821,823,818,819,820,824,822,848,850,906"; */
$lists[1] = "851,821,823,1101,820,824,822,848,906,1105";
/* $lists[2] = "852,827,829,825,826,828,847,849,905"; */
$lists[2] = "852,827,829,1100,826,828,847,905,1106";
/* $lists[3] = "815,853,854,892"; */
$lists[3] = "815,853,854";

$json = "[";

for ($i=0; $i<sizeof($sections); $i++) {
	
	$query_string = "SELECT * FROM mod_geovisores.vw_layers WHERE layer_id IN(" . $lists[$i] . ") ORDER BY preview_titulo ASC";
	
	$query = pg_query($conn,$query_string);
	
	$json .= "{";
	$json .= "\"index\":" . $i . ",";
	$json .= "\"label\":\"" . $sections[$i] . "\",";
	$json .= "\"id_geovisor\":\"" . $id_geovisor[$i] . "\",";
	//$json .= "\"qs\":\"" . $query_string . "\",";
	$json .= "\"layers\":[";
	
	while($r = pg_fetch_assoc($query)) {
		
		$json .= "{";
		$json .= "\"layer_id\":" . $r["layer_id"] . ",";
		$json .= "\"schema\":\"" . $r["layer_schema"] . "\",";
		$json .= "\"layer\":\"" . $r["layer_wms_layer"] . "\",";
		$json .= "\"server\":\"" . $r["layer_wms_server"] . "\",";
		$json .= "\"componente\":\"" . $r["preview_titulo"] . "\"";
		$json .= "},";
		
	}

	$json = substr($json,0,strlen($json)-1);
	
	$json .= "]";
	$json .= "},";
	
}

$json = substr($json,0,strlen($json)-1) . "]";

echo $json;