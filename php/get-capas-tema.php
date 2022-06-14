<?php

include("../pgconfig.php");

$tema_id = $_POST["tema_id"];

$layers_id = array();

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$query_string = "SELECT * FROM mod_catalogo.temas_capas WHERE tema_id = " . $tema_id;

$query = pg_query($conn,$query_string);

while($r = pg_fetch_assoc($query)) {
	
	array_push($layers_id,$r["layer_id"]);
	
}

$layers_id = array_unique($layers_id);

$layers_id = array_values($layers_id);

$query_string = "SELECT DISTINCT layer_id,layer_desc,layer_wms_server,layer_wms_layer,layer_schema,layer_table FROM mod_geovisores.vw_layers WHERE layer_id IN(" . implode(",",$layers_id) . ")";

$query = pg_query($conn,$query_string);

$gl_query_string = "SELECT geovisor FROM mod_catalogo.temas WHERE tema_id = " . $tema_id;

$gl_query = pg_query($conn,$gl_query_string);

$gl = pg_fetch_assoc($gl_query);

$json = "{\"geovisor_link\":\"" . $gl["geovisor"] . "\",\"layers\":[";

$entered = false;

while ($data = pg_fetch_assoc($query)) {

	$entered = true;

	$json .= "{";
	$json .= "\"layer_id\":" . $data["layer_id"] . ",";
	$json .= "\"layer_desc\":\"" . $data["layer_desc"] . "\",";
	$json .= "\"layer_wms_server\":\"" . $data["layer_wms_server"] . "\",";
	$json .= "\"layer_wms_layer\":\"" . $data["layer_wms_layer"] . "\",";
	$json .= "\"layer_schema\":\"" . $data["layer_schema"] . "\",";
	$json .= "\"layer_table\":\"" . $data["layer_table"] . "\"";
	$json .= "},";

}

if ($entered) {

	$json = substr($json,0,strlen($json)-1) . "]}";

}else{
	
	$json = $json . "]}";
	
}

echo $json;

?>