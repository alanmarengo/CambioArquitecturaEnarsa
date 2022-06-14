<?php
    function clear_json_rec($str) 
    {
	
		$bad = array("\n","\r","\"");
	
		$good = array("","","");
	
		return str_replace($bad,$good,$str);
	
	};

	function get_grilla($param,$table) {
		
		$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
		$conn = pg_connect($string_conn);
		
		$s=$param['busqueda'];
		
		$query_string = "SELECT * FROM mod_mediateca.recurso WHERE recurso_titulo||recurso_desc ILIKE '%$s%' order by recurso_id DESC limit 1000";
		
		$col_types = get_column_types($table);
		
		/*
		$where = "";
		
		foreach ($param as $keyname => $val) {
						
			if (is_column_integer($col_types[$keyname])) { 
			
				$val = parse_empty_int($val,-1);
			
				$where .= " AND $keyname = $val";
			
			}else{
				
				$valtest = strtolower($val);
				$where .= " AND lower($keyname) LIKE '%$valtest%'";
				
			}
			
		}
		
		$query_string .= $where;
		* */
		
		$query = pg_query($conn,$query_string);
		
		//echo pg_last_error($conn);
		
		$entered = false;
		
		$json = "{\"data\":[";
		
		while ($r = pg_fetch_assoc($query)) {
			
			$json .= "{";
		
			foreach ($r as $keyname => $val) {
				
				$slash = "\""; 
				
				if (is_column_integer($col_types[$keyname])) { 
				
					$slash = ""; 
					
					$val = parse_empty_int($val,-1); 
					
				}
				
				$json .= "\"" . $keyname . "\":" . $slash . clear_json_rec($val) . $slash . ",";
				
			}
			
			$json = substr($json,0,strlen($json)-1);
			
			$json .= "},";
			
			$entered = true;
			
		}
		
		if ($entered) {
			
			$json = substr($json,0,strlen($json)-1);
			
		}
		
		$json .= "]}";
		
		return $json;
		
	}
	
	function get_new_id($table,$id_name,$extra_fields,$extra_values) { // text,text,array,array
		
		$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
		$conn = pg_connect($string_conn);
		
		if ((!$extra_fields) && (!$extra_values)) {
		
			$query_string = "INSERT INTO $table ($id_name) VALUES (null) RETURNING $id_name";
		
		}else{
			
			$query_string = "INSERT INTO $table (" . implode(",",$extra_fields) . ") VALUES (" . implode(",",$extra_values) . ") RETURNING $id_name";
			
		}
		
		$query = pg_query($conn,$query_string);
		$data = pg_fetch_assoc($query);
		
		return "{\"$id_name\":" . $data[$id_name] . "}";
		
	}
	
	function get_item_by_id($table,$id_name,$id_value) { // text,text,array,array
		
		$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
		$conn = pg_connect($string_conn);
		
		$query_string = "SELECT * FROM $table WHERE $id_name = $id_value";
		
		$query = pg_query($conn,$query_string);
		
		$n_registros = pg_num_rows($query);
		
		if ($n_registros > 0) {
		
			$r = pg_fetch_assoc($query);
				
			$json = "{";
		
			foreach ($r as $keyname => $val) {
				
				$slash = "\""; if (is_numeric($val)) { $slash = ""; }
				
				$json .= "\"" . $keyname . "\":" . $slash . utf8_encode($val) . $slash . ",";
				
			}
				
			$json = substr($json,0,strlen($json)-1);
				
			$json .= "}";
		
		}else{
			
			$json = "{}";
			
		}
		
		return $json;
		
	}
	
	function save_item($postdata,$table) { // text,text,array,array
		
		$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
		$conn = pg_connect($string_conn);
		
		$column_types = get_column_types($table);
		
		$query_string = "UPDATE $table SET ";
		
		foreach ($postdata as $keyname => $val) {
			
			if (($keyname != "id_name") && ($keyname != "id")) {
			
				$slash = get_column_slash($column_types[$keyname]);
				$val = get_column_integer_value($column_types[$keyname],$val);
				$query_string .= $keyname . " = " . $slash . $val . $slash . ",";
		
			}
		
		}
		
		$query_string = substr($query_string,0,strlen($query_string)-1);
		
		$query_string .= " WHERE " . $postdata["id_name"] . " = " . $postdata[$postdata["id_name"]];
		
		if (pg_query($conn,$query_string)) {
			
			echo "{\"status\":1,\"msg\":\"Se ha guardado este elemento con éxito\"}";
			
		}else{
			
			echo "{\"status\":0,\"msg\":\"Se produjo un error al guardar este elemento\"}" . $query_string;
			
		}
		
	}
	
	function delete_item($postdata,$table) { // text,text,array,array
		
		$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
		$conn = pg_connect($string_conn);
		
		$column_types = get_column_types("productos");
		
		$query_string = "DELETE FROM $table WHERE " . $postdata["id_name"] . " = " . $postdata["id"];
		
		if (pg_query($conn,$query_string)) {
			
			echo "{\"status\":1,\"msg\":\"Se ha eliminado este elemento con éxito\"}";
			
		}else{
			
			echo "{\"status\":0,\"msg\":\"Se produjo un error al eliminar este elemento\"}";
			
		}
		
	}
	
	function get_column_types($table) {
		
		$source = explode(".",$table);
		
		$schema = $source[0];
		$table = $source[1];
		
		$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
		$conn = pg_connect($string_conn);
		
		$col_types_query_string = "SELECT column_name AS col_name, data_type AS col_type FROM information_schema.columns WHERE table_schema = '$schema' AND table_name = '$table'";

		$col_types_query = pg_query($conn,$col_types_query_string);
		
		$columns = array();
		
		while ($r = pg_fetch_assoc($col_types_query)) {
				
			$columns[$r["col_name"]] = $r["col_type"];
			
		}
		
		return $columns;
		
	}
	
	function is_column_integer($col_type) {
		
		if (
			($col_type == "int") || 
			($col_type == "tinyint") || 
			($col_type == "smallint") || 
			($col_type == "bigint") || 
			($col_type == "double") || 
			($col_type == "bool") || 
			($col_type == "boolean")
		) {
			return true;
			
		}else{
			
			return false;
			
		}
		
	}
	
	function get_column_slash($col_type) {
		
		if (
			($col_type == "int") || 
			($col_type == "tinyint") || 
			($col_type == "smallint") || 
			($col_type == "bigint") || 
			($col_type == "double") || 
			($col_type == "bool") || 
			($col_type == "boolean")
		) {
			return "";
			
		}else{
			
			return "'";
			
		}
		
	}
	
	function get_column_integer_value($col_type,$val) {
		
		if (
			($col_type == "int") || 
			($col_type == "tinyint") || 
			($col_type == "smallint") || 
			($col_type == "bigint") || 
			($col_type == "double") || 
			($col_type == "date")
		) {
			
			if (empty($val)) {
				
				if ($col_type == "date") {
					
					return "1970-01-01";
					
				}else{
				
					return -1;
				
				}
				
			}else{
				
				return $val;
				
			}
			
		}else{
			
			return $val;
			
		}
		
	}
	
	function get_table_by_filename($script_filename) {

		$temp = explode("/",$script_filename);
		$temp = explode("-",$temp[sizeof($temp)-1]);
		
		$table = $temp[0];

		return $table;

	}

	function parse_empty_int($val,$alt_val) {
		
		if (empty($val)) {
			
			return $alt_val;
			
		}else{
			
			return $val;
			
		}
		
	}

?>
