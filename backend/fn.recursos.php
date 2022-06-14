<?php

function format_text_json($str) {
	
	$bad = array("\n","\r","\"");
	
	$good = array("","","");
	
	return str_replace($bad,$good,$str);
	
}

function get_recurso_by_id($dt_id) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT * FROM sinia_recurso.vw_dt_busqueda WHERE dt_id = " . $dt_id;
	
	$query = pg_query($conn,$query_string);
	
	$r = pg_fetch_assoc($query);
		
	$json = "{";
	$json .= "\"dt_id\":" . $r["dt_id"] . ",";
	$json .= "\"tipo_cobertura_id\":\"" . $r["tipo_cobertura_id"] . "\",";
	$json .= "\"dt_titulo\":\"" . $r["dt_titulo"] . "\",";
	$json .= "\"dt_desc\":\"" . $r["dt_desc"] . "\",";
	$json .= "\"dt_fecha_d\":\"" . $r["dt_fecha_d"] . "\",";
	$json .= "\"dt_fecha_hasta\":\"" . $r["dt_fecha_hasta"] . "\",";
	$json .= "\"dt_autor\":\"" . $r["dt_autor"] . "\",";
	$json .= "\"dt_link_metadata\":\"" . $r["dt_link_metadata"] . "\",";
	$json .= "\"dt_link_ficha\":\"" . $r["dt_link_ficha"] . "\",";
	$json .= "\"dt_fecha_ultima_act\":\"" . $r["dt_fecha_ultima_act"] . "\",";
	$json .= "\"dt_tabla\":\"" . $r["dt_tabla"] . "\",";
	$json .= "\"dt_extent\":\"" . $r["dt_extent"] . "\",";
	$json .= "\"palabras_clave\":\"" . $r["palabras_clave"] . "\",";
	$json .= "\"dt_fuente\":\"" . $r["dt_fuente"] . "\",";
	$json .= "\"dt_link_interes\":\"" . $r["dt_link_interes"] . "\",";
	$json .= "\"dt_path_img_metada\":\"" . $r["dt_path_img_metada"] . "\"";
	$json .= "}";
	
	pg_close($conn);
	
	return $json;

}

function get_grafico_by_id($grafico_id) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT * FROM sinia_graficos.grafico WHERE grafico_id = " . $grafico_id;
	
	$query = pg_query($conn,$query_string);
	
	$r = pg_fetch_assoc($query);
		
	$json = "{";
	$json .= "\"grafico_id\":" . $r["grafico_id"] . ",";
	$json .= "\"tipo_grafico_id\":" . $r["tipo_grafico_id"] . ",";
	$json .= "\"grafico_titulo\":\"" . $r["grafico_titulo"] . "\",";
	$json .= "\"grafico_desc\":\"" . $r["grafico_desc"] . "\",";
	$json .= "\"grafico_tabla\":\"" . $r["grafico_tabla"] . "\",";
	$json .= "\"grafico_schema\":\"" . $r["grafico_schema"] . "\",";
	$json .= "\"grafico_col_etiqueta\":\"" . $r["grafico_col_etiqueta"] . "\",";
	$json .= "\"grafico_col_sector\":\"" . $r["grafico_col_sector"] . "\",";
	$json .= "\"grafico_col_valor\":\"" . $r["grafico_col_valor"] . "\"";
	$json .= "}";
	
	pg_close($conn);
	
	return $json;

}

function get_recurso_by_id($recurso_id) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT * FROM sinia_recursos.recurso WHERE recurso_id = " . $recurso_id;
	
	$query = pg_query($conn,$query_string);
	
	$r = pg_fetch_assoc($query);
		
	$json .= "{";
	$json .= "\"recurso_id\":" . $r["recurso_id"] . ",";
	$json .= "\"formato_id\":" . $r["formato_id"] . ",";
	$json .= "\"tipo_cobertura_id\":\"" . $r["tipo_cobertura_id"] . "\",";
	$json .= "\"tipo_recurso_id\":" . $r["tipo_recurso_id"] . ",";
	$json .= "\"recurso_titulo\":\"" . $r["recurso_titulo"] . "\",";
	$json .= "\"recurso_desc\":\"" . $r["recurso_desc"] . "\",";
	$json .= "\"recurso_path\":\"" . $r["recurso_path"] . "\",";
	$json .= "\"palabras_clave\":\"" . $r["palabras_clave"] . "\",";
	$json .= "\"recurso_fecha\":\"" . $r["recurso_fecha"] . "\",";
	$json .= "\"recurso_numero\":\"" . $r["recurso_numero"] . "\",";
	$json .= "\"recurso_fuente\":\"" . $r["recurso_fuente"] . "\"";
	$json .= "}";
	
	pg_close($conn);
	
	return $json;

}

function get_grilla_recursos($busqueda) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT * FROM mod_mediateca.recurso ORDER BY recurso_id ASC";
	
	if ($busqueda != "") {
		
		$query_string = "SELECT * FROM mod_mediateca.recurso WHERE recurso_titulo ILIKE '%" . $busqueda . "%' ORDER BY dt_id ASC";
	
	}
	
	//var_dump($postdata);
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "{\"dt\":[";
	
	while ($r = pg_fetch_assoc($query)) {
		
		$json .= "{";
		$json .= "\"dt_id\":" . $r["dt_id"] . ",";
		$json .= "\"tipo_cobertura_id\":\"" . $r["tipo_cobertura_id"] . "\",";
		$json .= "\"dt_titulo\":\"" . format_text_json($r["dt_titulo"]) . "\",";
		$json .= "\"dt_desc\":\"" . format_text_json($r["dt_desc"]) . "\",";
		$json .= "\"dt_fecha_d\":\"" . $r["dt_fecha_d"] . "\",";
		$json .= "\"dt_fecha_hasta\":\"" . $r["dt_fecha_hasta"] . "\",";
		$json .= "\"dt_autor\":\"" . $r["dt_autor"] . "\",";
		$json .= "\"dt_link_metadata\":\"" . $r["dt_link_metadata"] . "\",";
		$json .= "\"dt_link_ficha\":\"" . $r["dt_link_ficha"] . "\",";
		$json .= "\"dt_fecha_ultima_act\":\"" . $r["dt_fecha_ultima_act"] . "\",";
		$json .= "\"dt_tabla\":\"" . $r["dt_tabla"] . "\",";
		$json .= "\"dt_extent\":\"" . $r["dt_extent"] . "\",";
		$json .= "\"palabras_clave\":\"" . format_text_json($r["palabras_clave"]) . "\",";
		$json .= "\"dt_fuente\":\"" . format_text_json($r["dt_fuente"]) . "\",";
		$json .= "\"dt_link_interes\":\"" . $r["dt_link_interes"] . "\",";
		$json .= "\"dt_path_img_metada\":\"" . $r["dt_path_img_metada"] . "\"";
		$json .= "},";
		//var_dump($r);
		$entered = true;
	}
	
	if ($entered) {
		
		$json = substr($json,0,strlen($json)-1);
		
	}
	
	$json .= "]}";
	
	echo $json;
	
	pg_close($conn);

}

function get_grilla_dt_tabla($busqueda) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT table_schema,table_name FROM sinia_recurso.vw_dt_tabla WHERE table_schema = 'sinia_datos' GROUP BY table_schema,table_name ORDER BY table_name ASC limit 20";
	
	if ($busqueda != "") {
		
		$query_string = "SELECT table_schema,table_name FROM sinia_recurso.vw_dt_tabla WHERE table_schema = 'sinia_datos' AND table_name ILIKE '%" . $busqueda . "%' GROUP BY table_schema,table_name ORDER BY dt_tabla ASC";
	
	}
	
	//var_dump($postdata);
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "{\"dt\":[";
	
	while ($r = pg_fetch_assoc($query)) {
		
		$json .= "{";
		$json .= "\"table_schema\":\"" . $r["table_schema"] . "\",";
		$json .= "\"table_name\":\"" . $r["table_name"] . "\",";
		$json .= "\"dt_tabla\":\"" . $r["dt_tabla"] . "\"";
		$json .= "},";
		//var_dump($r);
		$entered = true;
	}
	
	if ($entered) {
		
		$json = substr($json,0,strlen($json)-1);
		
	}
	
	$json .= "]}";
	
	echo $json;
	
	pg_close($conn);

}

function get_grilla_dt_columnas($table_schema,$table_name,$busqueda) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT * FROM sinia_recurso.vw_dt_tabla WHERE table_schema = '" . $table_schema . "' AND table_name = '" . $table_name . "' ORDER BY dt_tabla ASC limit 30";
	
	if ($busqueda != "") {
		
		$query_string = "SELECT * FROM sinia_recurso.vw_dt_tabla WHERE table_schema = '" . $table_schema . "' AND table_name = '" . $table_name . "' AND column_name ILIKE '%" . $busqueda . "%' ORDER BY column_name ASC";
	
	}
	
	
	
	//var_dump($postdata);
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "{\"dt\":[";
	$json .= "{";
	$json .= "\"table_schema\":\"Sin Especificar\",";
	$json .= "\"table_name\":\"Sin Especificar\",";
	$json .= "\"column_name\":\"\"";
	$json .= "},";
	
	while ($r = pg_fetch_assoc($query)) {
		
		$json .= "{";
		$json .= "\"table_schema\":\"" . $r["table_schema"] . "\",";
		$json .= "\"table_name\":\"" . $r["table_name"] . "\",";
		$json .= "\"column_name\":\"" . $r["column_name"] . "\"";
		$json .= "},";
		//var_dump($r);
		$entered = true;
	}
	
	if ($entered) {
		
		$json = substr($json,0,strlen($json)-1);
		
	}
	
	$json .= "]}";
	
	echo $json;
	
	pg_close($conn);

}

function get_grilla_dt_graficos($dt_id) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT * FROM sinia_recurso.vw_lista_graficos WHERE dt_id = " . $dt_id . " ORDER BY grafico_id ASC";
	
	//var_dump($postdata);
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "{\"data\":[";
	
	while ($r = pg_fetch_assoc($query)) {
		
		$json .= "{";
		$json .= "\"dt_id\":" . $r["dt_id"] . ",";
		$json .= "\"grafico_id\":" . $r["grafico_id"] . ",";
		$json .= "\"grafico_titulo\":\"" . format_text_json($r["grafico_titulo"]) . "\",";
		$json .= "\"grafico_desc\":\"" . format_text_json($r["grafico_desc"]) . "\"";
		$json .= "},";
		//var_dump($r);
		$entered = true;
	}
	
	if ($entered) {
		
		$json = substr($json,0,strlen($json)-1);
		
	}
	
	$json .= "]}";
	
	echo $json;
	
	pg_close($conn);

}

function get_grilla_graficos($busqueda) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT grafico_id,grafico_titulo FROM sinia_graficos.grafico";
	
	if ($busqueda != "") {
		
		$query_string = "SELECT * FROM sinia_graficos.grafico WHERE grafico_titulo ILIKE '%" . $busqueda . "%' ORDER BY grafico_id ASC";
	
	}
	
	//var_dump($postdata);
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "{\"data\":[";
	
	while ($r = pg_fetch_assoc($query)) {
		
		$json .= "{";
		$json .= "\"grafico_id\":" . $r["grafico_id"] . ",";
		$json .= "\"grafico_titulo\":\"" . format_text_json($r["grafico_titulo"]) . "\"";
		$json .= "},";
		//var_dump($r);
		$entered = true;
	}
	
	if ($entered) {
		
		$json = substr($json,0,strlen($json)-1);
		
	}
	
	$json .= "]}";
	
	echo $json;
	
	pg_close($conn);

}

function get_grilla_graficos_abm($busqueda) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT * FROM sinia_graficos.grafico";
	
	if ($busqueda != "") {
		
		$query_string = "SELECT * FROM sinia_graficos.grafico WHERE grafico_titulo ILIKE '%" . $busqueda . "%' ORDER BY grafico_id ASC";
	
	}
	
	//var_dump($postdata);
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "{\"data\":[";
	
	while ($r = pg_fetch_assoc($query)) {
		
		$json .= "{";
		$json .= "\"grafico_id\":" . $r["grafico_id"] . ",";
		$json .= "\"tipo_grafico_id\":" . $r["tipo_grafico_id"] . ",";
		$json .= "\"grafico_titulo\":\"" . format_text_json($r["grafico_titulo"]) . "\",";
		$json .= "\"grafico_desc\":\"" . format_text_json($r["grafico_desc"]) . "\",";
		$json .= "\"grafico_tabla\":\"" . $r["grafico_tabla"] . "\",";
		$json .= "\"grafico_schema\":\"" . $r["grafico_schema"] . "\",";
		$json .= "\"grafico_col_etiqueta\":\"" . $r["grafico_col_etiqueta"] . "\",";
		$json .= "\"grafico_col_sector\":\"" . $r["grafico_col_sector"] . "\",";
		$json .= "\"grafico_col_valor\":\"" . $r["grafico_col_valor"] . "\"";
		$json .= "},";
		//var_dump($r);
		$entered = true;
	}
	
	if ($entered) {
		
		$json = substr($json,0,strlen($json)-1);
		
	}
	
	$json .= "]}";
	
	echo $json;
	
	pg_close($conn);

}

function get_grilla_recursos_abm($busqueda) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT * FROM sinia_recursos.recurso";
	
	if ($busqueda != "") {
		
		$query_string = "SELECT * FROM sinia_recursos.recurso WHERE recurso_titulo ILIKE '%" . $busqueda . "%' ORDER BY recurso_id ASC";
	
	}
	
	//var_dump($postdata);
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "{\"data\":[";
	
	while ($r = pg_fetch_assoc($query)) {
		
		$json .= "{";
		$json .= "\"recurso_id\":" . $r["recurso_id"] . ",";
		$json .= "\"formato_id\":" . $r["formato_id"] . ",";
		$json .= "\"tipo_cobertura_id\":\"" . $r["tipo_cobertura_id"] . "\",";
		$json .= "\"tipo_recurso_id\":" . $r["tipo_recurso_id"] . ",";
		$json .= "\"recurso_titulo\":\"" . format_text_json($r["recurso_titulo"]) . "\",";
		$json .= "\"recurso_desc\":\"" . format_text_json($r["recurso_desc"]) . "\",";
		$json .= "\"recurso_path\":\"" . $r["recurso_path"] . "\",";
		$json .= "\"palabras_clave\":\"" . format_text_json($r["palabras_clave"]) . "\",";
		$json .= "\"recurso_fecha\":\"" . $r["recurso_fecha"] . "\",";
		$json .= "\"recurso_numero\":\"" . $r["recurso_numero"] . "\",";
		$json .= "\"recurso_fuente\":\"" . format_text_json($r["recurso_fuente"]) . "\"";
		$json .= "},";
		//var_dump($r);
		$entered = true;
	}
	
	if ($entered) {
		
		$json = substr($json,0,strlen($json)-1);
		
	}
	
	$json .= "]}";
	
	echo $json;
	
	pg_close($conn);

}

function get_grilla_dt_layers($dt_id) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT * FROM sinia_recurso.vw_lista_layers WHERE dt_id = " . $dt_id . " ORDER BY layer_id ASC";
	
	//var_dump($postdata);
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "{\"data\":[";
	
	while ($r = pg_fetch_assoc($query)) {
		
		$json .= "{";
		$json .= "\"dt_id\":" . $r["dt_id"] . ",";
		$json .= "\"layer_id\":" . $r["layer_id"] . ",";
		$json .= "\"layer_titulo\":\"" . format_text_json($r["layer_titulo"]) . "\",";
		$json .= "\"orden\":" . test_empty_var($r["orden"],"-1",$r["orden"]);
		$json .= "},";
		//var_dump($r);
		$entered = true;
	}
	
	if ($entered) {
		
		$json = substr($json,0,strlen($json)-1);
		
	}
	
	$json .= "]}";
	
	echo $json;
	
	pg_close($conn);

}

function get_grilla_layers($busqueda) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT layer_id,layer_titulo FROM sinia_geovisor.layer ORDER BY layer_id ASC";
	
	if ($busqueda != "") {
		
		$query_string = "SELECT layer_id,layer_titulo FROM sinia_geovisor.layer WHERE layer_titulo ILIKE '%" . $busqueda . "%' ORDER BY layer_id ASC";
	
	}
	
	//var_dump($postdata);
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "{\"data\":[";
	
	while ($r = pg_fetch_assoc($query)) {
		
		$json .= "{";
		$json .= "\"layer_id\":" . $r["layer_id"] . ",";
		$json .= "\"layer_titulo\":\"" . format_text_json($r["layer_titulo"]) . "\"";
		$json .= "},";
		//var_dump($r);
		$entered = true;
	}
	
	if ($entered) {
		
		$json = substr($json,0,strlen($json)-1);
		
	}
	
	$json .= "]}";
	
	echo $json;
	
	pg_close($conn);

}

function get_grilla_dt_subtemas($dt_id) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT * FROM sinia_recurso.vw_lista_subtemas WHERE dt_id = " . $dt_id . " ORDER BY subtema_id ASC";
	
	//var_dump($postdata);
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "{\"data\":[";
	
	while ($r = pg_fetch_assoc($query)) {
		
		$json .= "{";
		$json .= "\"dt_id\":" . $r["dt_id"] . ",";
		$json .= "\"subtema_id\":" . $r["subtema_id"] . ",";
		$json .= "\"subtema_titulo\":\"" . format_text_json($r["subtema_titulo"]) . "\"";
		$json .= "},";
		//var_dump($r);
		$entered = true;
	}
	
	if ($entered) {
		
		$json = substr($json,0,strlen($json)-1);
		
	}
	
	$json .= "]}";
	
	echo $json;
	
	pg_close($conn);

}

function get_grilla_dt_rec_subtemas($recurso_id) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT * FROM sinia_recursos.vw_lista_subtemas WHERE recurso_id = " . $recurso_id . " ORDER BY recurso_id ASC";
	
	//var_dump($postdata);
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "{\"data\":[";
	
	while ($r = pg_fetch_assoc($query)) {
		
		$json .= "{";
		$json .= "\"recurso_id\":" . $r["recurso_id"] . ",";
		$json .= "\"subtema_id\":" . $r["subtema_id"] . ",";
		$json .= "\"subtema_titulo\":\"" . format_text_json($r["subtema_titulo"]) . "\"";
		$json .= "},";
		//var_dump($r);
		$entered = true;
	}
	
	if ($entered) {
		
		$json = substr($json,0,strlen($json)-1);
		
	}
	
	$json .= "]}";
	
	echo $json;
	
	pg_close($conn);

}

function get_grilla_subtemas($busqueda) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT subtema_id,subtema_titulo FROM sinia_catalogo.subtema ORDER BY subtema_id ASC";
	
	if ($busqueda != "") {
		
		$query_string = "SELECT subtema_id,subtema_titulo FROM sinia_catalogo.subtema WHERE subtema_titulo ILIKE '%" . $busqueda . "%' ORDER BY subtema_id ASC";
	
	}
	
	//var_dump($postdata);
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "{\"data\":[";
	
	while ($r = pg_fetch_assoc($query)) {
		
		$json .= "{";
		$json .= "\"subtema_id\":" . $r["subtema_id"] . ",";
		$json .= "\"subtema_titulo\":\"" . format_text_json($r["subtema_titulo"]) . "\"";
		$json .= "},";
		//var_dump($r);
		$entered = true;
	}
	
	if ($entered) {
		
		$json = substr($json,0,strlen($json)-1);
		
	}
	
	$json .= "]}";
	
	echo $json;
	
	pg_close($conn);

}

function get_grilla_coberturas() {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT * FROM sinia_catalogo.tipo_cobertura";
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "{\"tipo_cobertura\":[";
	
	while ($r = pg_fetch_assoc($query)) {
		
		$json .= "{";
		$json .= "\"tipo_cobertura_id\":" . $r["tipo_cobertura_id"] . ",";
		$json .= "\"tipo_cobertura_desc\":\"" . format_text_json($r["tipo_cobertura_desc"]) . "\"";
		$json .= "},";
		//var_dump($r);
		$entered = true;
	}
	
	if ($entered) {
		
		$json = substr($json,0,strlen($json)-1);
		
	}
	
	$json .= "]}";
	
	echo $json;
	
	pg_close($conn);

}

function get_new_dt_id() {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	//$n_registros_act = pg_num_rows(pg_query($conn,"SELECT * FROM sinia_recurso.dt"));
		
	$query_string = "INSERT INTO sinia_recurso.dt (tipo_cobertura_id) VALUES (6) RETURNING dt_id";
	
	//$query_string = "INSERT INTO sinia_recurso.dt (dt_id,tipo_cobertura_id) VALUES ((SELECT MAX(dt_id)+1 AS dt_id FROM sinia_recurso.dt),6) RETURNING dt_id";
	
	$query = pg_query($conn,$query_string);
	
	$data = pg_fetch_assoc($query);
	
	return "{\"dt_id\":" . $data["dt_id"] . "}";
	
}

function get_new_grafico_id() {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
		
	$query_string = "INSERT INTO sinia_graficos.grafico (tipo_grafico_id) VALUES (20) RETURNING grafico_id";	
	
	$query = pg_query($conn,$query_string);
	
	$data = pg_fetch_assoc($query);
	
	return "{\"grafico_id\":" . $data["grafico_id"] . "}";
	
}

function get_new_recurso_id() {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
		
	$query_string = "INSERT INTO sinia_recursos.recurso (formato_id,tipo_cobertura_id,tipo_recurso_id) VALUES (10,6,6) RETURNING recurso_id";
	
	$query = pg_query($conn,$query_string);
	
	$data = pg_fetch_assoc($query);
	
	return "{\"recurso_id\":" . $data["recurso_id"] . "}";
	
}

function save_dt($postdata) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "UPDATE sinia_recurso.dt SET ";
	
	$query_string .= " dt_titulo = '" . $postdata["dt_titulo"] . "',";
	$query_string .= " tipo_cobertura_id = " . $postdata["tipo_cobertura_id"] . ",";
	$query_string .= " dt_desc = '" . $postdata["dt_desc"] . "',";
	$query_string .= " dt_fecha_d = " . test_empty_var($postdata["dt_fecha_d"],"NULL","'". $postdata["dt_fecha_d"] . "'") . ",";
	$query_string .= " dt_fecha_hasta = " . test_empty_var($postdata["dt_fecha_hasta"],"NULL","'". $postdata["dt_fecha_hasta"] . "'","NULL") . ",";
	$query_string .= " dt_autor = '" . $postdata["dt_autor"] . "',";
	$query_string .= " dt_link_metadata = '" . $postdata["dt_link_metadata"] . "',";
	$query_string .= " dt_link_ficha = '" . $postdata["dt_link_ficha"] . "',";
	$query_string .= " dt_fecha_ultima_act = " . test_empty_var($postdata["dt_fecha_ultima_act"],"NULL","'". $postdata["dt_fecha_ultima_act"] . "'","NULL") . ",";
	$query_string .= " dt_tabla = 'sinia_datos." . $postdata["dt_tabla"] . "',";
	$query_string .= " dt_extent = '" . $postdata["dt_extent"] . "',";
	$query_string .= " palabras_clave = '" . $postdata["palabras_clave"] . "',";
	$query_string .= " dt_fuente = '" . $postdata["dt_fuente"] . "',";
	$query_string .= " dt_link_interes = '" . $postdata["dt_link_interes"] . "',";
	$query_string .= " dt_path_img_metada = '" . $postdata["dt_path_img_metada"] . "'";
	
	$query_string .= " WHERE dt_id = " . $postdata["dt_id"];
	//echo $query_string;
	
	if (pg_query($conn,$query_string)) {
		
		return "{\"status\":1,\"msg\":\"El recurso ha sido guardado con éxito.\"}";
		
	}else {
		
		return "{\"status\":0,\"msg\":\"Se produjo un error al eliminar este recurso.\"}";
		
	}
	
}

function save_grafico($postdata) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "UPDATE sinia_graficos.grafico SET ";
	
	$query_string .= " tipo_grafico_id = " . $postdata["tipo_grafico_id"] . ",";
	$query_string .= " grafico_titulo = '" . $postdata["grafico_titulo"] . "',";
	$query_string .= " grafico_desc = '" . $postdata["grafico_desc"] . "',";
	$query_string .= " grafico_tabla = '" . $postdata["grafico_tabla"] . "',";
	$query_string .= " grafico_schema = 'sinia_datos',";
	$query_string .= " grafico_col_etiqueta = '" . $postdata["grafico_col_etiqueta"] . "',";
	$query_string .= " grafico_col_sector = '" . $postdata["grafico_col_sector"] . "',";
	$query_string .= " grafico_col_valor = '" . $postdata["grafico_col_valor"] . "'";
	
	$query_string .= " WHERE grafico_id = " . $postdata["grafico_id"];
	//echo $query_string;
	
	if (pg_query($conn,$query_string)) {
		
		return "{\"status\":1,\"msg\":\"El gráfico ha sido guardado con éxito.\"}";
		
	}else {
		
		return "{\"status\":0,\"msg\":\"Se produjo un error al eliminar este gráfico.\"}";
		
	}
	
}

function save_recurso($postdata) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "UPDATE sinia_recursos.recurso SET ";
	
	$query_string .= " formato_id = " . $postdata["formato_id"] . ",";
	$query_string .= " tipo_cobertura_id = " . $postdata["tipo_cobertura_id"] . ",";
	$query_string .= " tipo_recurso_id = " . $postdata["tipo_recurso_id"] . ",";
	$query_string .= " recurso_titulo = '" . $postdata["recurso_titulo"] . "',";
	$query_string .= " recurso_desc = '" . $postdata["recurso_desc"] . "',";
	$query_string .= " recurso_path = '" . $postdata["recurso_path"] . "',";
	$query_string .= " palabras_clave = '" . $postdata["palabras_clave"] . "',";
	$query_string .= " recurso_fecha = " . test_empty_var($postdata["recurso_fecha"],"NULL","'". $postdata["recurso_fecha"] . "'") . ",";
	$query_string .= " recurso_numero = '" . $postdata["recurso_numero"] . "',";
	$query_string .= " recurso_fuente = '" . $postdata["recurso_fuente"] . "'";
	
	$query_string .= " WHERE recurso_id = " . $postdata["recurso_id"];
	//echo $query_string;
	
	if (pg_query($conn,$query_string)) {
		
		return "{\"status\":1,\"msg\":\"El recurso ha sido guardado con éxito.\"}";
		
	}else {
		
		return "{\"status\":0,\"msg\":\"Se produjo un error al eliminar este recurso.\"}";
		
	}
	
}

function delete_dt($dt_id) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "DELETE FROM sinia_recurso.dt WHERE dt_id = " . $dt_id;
	
	if (pg_query($conn,$query_string)) {
		
		return "{\"status\":1,\"msg\":\"El recurso ha sido eliminado con éxito.\"}";
		
	}else {
		
		return "{\"status\":0,\"msg\":\"Se produjo un error al eliminar este recurso.\"}";
		
	}
	
}

function delete_grafico($grafico_id) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "DELETE FROM sinia_graficos.grafico WHERE grafico_id = " . $grafico_id;
	
	if (pg_query($conn,$query_string)) {
		
		return "{\"status\":1,\"msg\":\"El gráfico ha sido eliminado con éxito.\"}";
		
	}else {
		
		return "{\"status\":0,\"msg\":\"Se produjo un error al eliminar este gráfico.\"}";
		
	}
	
}

function delete_recurso($recurso_id) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "DELETE FROM sinia_recursos.recurso WHERE recurso_id = " . $recurso_id;
	
	if (pg_query($conn,$query_string)) {
		
		return "{\"status\":1,\"msg\":\"El recurso ha sido eliminado con éxito.\"}";
		
	}else {
		
		return "{\"status\":0,\"msg\":\"Se produjo un error al eliminar este recurso.\"}";
		
	}
	
}

function add_grafico($dt_id,$grafico_id) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "INSERT INTO sinia_recurso.dt_grafico (dt_id,grafico_id) VALUES (".$dt_id.",".$grafico_id.")";
	
	if (pg_query($conn,$query_string)) {
		
		return "{\"status\":1,\"msg\":\"El gráfico ha sido asignado con éxito.\"}";
		
	}else {
		
		return "{\"status\":0,\"msg\":\"Gráfico ya asignado.\"}";
		
	}
	
}

function unlink_grafico($dt_id,$grafico_id) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "DELETE FROM sinia_recurso.dt_grafico WHERE dt_id = ".$dt_id." AND grafico_id = ".$grafico_id;
	
	if (pg_query($conn,$query_string)) {
		
		return "{\"status\":1,\"msg\":\"El gráfico ha sido desvinculado con éxito.\"}";
		
	}else {
		
		return "{\"status\":0,\"msg\":\"Se produjo un error al desvincular este gráfico.\"}";
		
	}
	
}

function add_layer($dt_id,$layer_id) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "INSERT INTO sinia_recurso.dt_layer (dt_id,layer_id) VALUES (".$dt_id.",".$layer_id.")";
	
	if (pg_query($conn,$query_string)) {
		
		return "{\"status\":1,\"msg\":\"La capa ha sido asignada con éxito.\"}";
		
	}else {
		
		return "{\"status\":0,\"msg\":\"Capa ya asignada.\"}";
		
	}
	
}

function edit_layer_order($dt_id,$layer_id,$order) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "UPDATE sinia_recurso.dt_layer SET orden = " .$order. " WHERE dt_id = " .$dt_id. " AND layer_id = " .$layer_id;
	
	if (pg_query($conn,$query_string)) {
		
		return "{\"status\":1,\"msg\":\"La capa ha sido editada con éxito.\"}";
		
	}else {
		
		return "{\"status\":0,\"msg\":\"Error al asignar orden para esta capa.\"}";
		
	}
	
}

function unlink_layer($dt_id,$layer_id) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "DELETE FROM sinia_recurso.dt_layer WHERE dt_id = ".$dt_id." AND layer_id = ".$layer_id;
	
	if (pg_query($conn,$query_string)) {
		
		return "{\"status\":1,\"msg\":\"La capa ha sido desvinculada con éxito.\"}";
		
	}else {
		
		return "{\"status\":0,\"msg\":\"Se produjo un error al desvincular esta capa.\"}";
		
	}
	
}

function add_subtema($dt_id,$subtema_id) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "INSERT INTO sinia_recurso.dt_subtem(dt_id,subtema_id) VALUES (".$dt_id.",".$subtema_id.")";
	
	if (pg_query($conn,$query_string)) {
		
		return "{\"status\":1,\"msg\":\"El subtema ha sido asignado con éxito.\"}";
		
	}else {
		
		return "{\"status\":0,\"msg\":\"Subtema ya asignado.\"}";
		
	}
	
}

function add_rec_subtema($recurso_id,$subtema_id) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "INSERT INTO sinia_recursos.recurso_subtema VALUES (".$subtema_id.",".$recurso_id.")";
	
	if (pg_query($conn,$query_string)) {
		
		return "{\"status\":1,\"msg\":\"El subtema ha sido asignado con éxito.\"}";
		
	}else {
		
		return "{\"status\":0,\"msg\":\"Subtema ya asignado.\"}";
		
	}
	
}

function unlink_subtema($dt_id,$subtema_id) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "DELETE FROM sinia_recurso.dt_subtem WHERE dt_id = ".$dt_id." AND subtema_id = ".$subtema_id;
	
	if (pg_query($conn,$query_string)) {
		
		return "{\"status\":1,\"msg\":\"El subtema ha sido desvinculado con éxito.\"}";
		
	}else {
		
		return "{\"status\":0,\"msg\":\"Se produjo un error al desvincular este subtema.\"}";
		
	}
	
}

function unlink_rec_subtema($recurso_id,$subtema_id) {
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "DELETE FROM sinia_recursos.recurso_subtema WHERE recurso_id = ".$recurso_id." AND subtema_id = ".$subtema_id;
	
	if (pg_query($conn,$query_string)) {
		
		return "{\"status\":1,\"msg\":\"El subtema ha sido desvinculado con éxito.\"}";
		
	}else {
		
		return "{\"status\":0,\"msg\":\"Se produjo un error al desvincular este subtema.\"}";
		
	}
	
}

?>
