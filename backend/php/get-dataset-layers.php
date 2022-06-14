<?php

	include("../pgconfig.php");
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	$query_string = "SELECT *,COALESCE(orden,0)AS orden_control FROM sinia_geovisor.vw_dt_layer WHERE dt_id = " . $_POST["dt_id"];
	
	$query = pg_query($conn,$query_string);
	
	$data = "{\"layers\":[";
	
	while ($r = pg_fetch_assoc($query)) {
		
		$data .= "{";
		
		$data .= "\"dt_id\":" . $r["dt_id"] . ",";
		$data .= "\"orden\":" . $r["orden_control"] . ",";
		$data .= "\"layer_id\":" . $r["layer_id"] . ",";
		$data .= "\"tipo_geom_id\":" . $r["tipo_geom_id"] . ",";
		$data .= "\"layer_titulo\":\"" . $r["layer_titulo"] . "\",";
		$data .= "\"layer_desc\":\"" . $r["layer_desc"] . "\",";
		$data .= "\"layer_wms_layer\":\"" . $r["layer_wms_layer"] . "\",";
		$data .= "\"layer_wms_server\":\"" . $r["layer_wms_server"] . "\",";
		$data .= "\"layer_link_metadato\":\"" . $r["layer_link_metadato"] . "\",";
		$data .= "\"layer_autor\":\"" . $r["layer_autor"] . "\",";
		$data .= "\"layer_schema\":\"" . $r["layer_schema"] . "\",";
		$data .= "\"layer_table\":\"" . $r["layer_table"] . "\",";
		$data .= "\"layer_fecha\":\"" . $r["layer_fecha"] . "\",";
		$data .= "\"layer_palabras_clave\":\"" . $r["layer_palabras_clave"] . "\",";
		$data .= "\"layer_fuente\":\"" . $r["layer_fuente"] . "\"";
		
		$data .= "},";
		
	}
	
	$data = substr($data,0,strlen($data)-1);
	
	$data .= "]}";
	
	echo $data;
	
?>
