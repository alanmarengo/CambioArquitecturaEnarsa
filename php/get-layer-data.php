<?php

include("../pgconfig.php");

$layer_id = $_POST["layer_id"];

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$query_string = "SELECT layer_id,layer_desc,layer_wms_server,layer_wms_layer,layer_schema,layer_table FROM mod_geovisores.vw_layers WHERE layer_id = " . $layer_id . " LIMIT 1";

$query = pg_query($conn,$query_string);

$data = pg_fetch_assoc($query);

$json .= "{";
$json .= "\"layer_id\":" . $data["layer_id"] . ",";
$json .= "\"layer_desc\":\"" . $data["layer_desc"] . "\",";
$json .= "\"layer_wms_server\":\"" . $data["layer_wms_server"] . "\",";
$json .= "\"layer_wms_layer\":\"" . $data["layer_wms_layer"] . "\",";
$json .= "\"layer_schema\":\"" . $data["layer_schema"] . "\",";
$json .= "\"layer_table\":\"" . $data["layer_table"] . "\"";
$json .= "}";

echo $json;

?>