<?php

//include("../pgconfig.php");

require_once(dirname(__FILE__,2).'/MICROSERVICIOS/MIC-GEOVISOR/CAPA-APLICACION/SERVICIOS/REPOSITORIO-SERVICIO.php');

$_POST["tema_id"] = 3;
$tema_id = $_POST["tema_id"];

$layers_id = array();

//$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
//$conn = pg_connect($string_conn);

$query_string_temas_capas = "SELECT * FROM mic_catalogo_fdw.temas_capas WHERE tema_id = $tema_id ;";

//$query = pg_query($conn,$query_string);

$servicio_geovisor = new RepositorioServicioGeovisor();

$result_temas_capas = $servicio_geovisor->get_consulta($query_string_temas_capas);

foreach($result_temas_capas as $r)
{	
	array_push($layers_id,$r["layer_id"]);
	
}

$layers_id = array_unique($layers_id);

$layers_id = array_values($layers_id);

$query_string_layers= 'SELECT DISTINCT layer_id,layer_desc,layer_wms_server,layer_wms_layer,layer_schema,layer_table FROM "MIC-GEOVISORES".vw_layers WHERE layer_id IN('.implode(",",$layers_id) . ")";

//$query = pg_query($conn,$query_string);
$result_layers = $servicio_geovisor->get_consulta($query_string_layers);

$gl_query_string = "SELECT geovisor FROM mic_catalogo_fdw.temas WHERE tema_id = " . $tema_id;

$result_gl =$servicio_geovisor->get_consulta($gl_query_string);

//$gl_query = pg_query($conn,$gl_query_string);

//$gl = pg_fetch_assoc($gl_query);

$json = "{\"geovisor_link\":\"" . $result_gl[0]["geovisor"] . "\",\"layers\":[";

$entered = false;

foreach($result_layers as $data) {

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