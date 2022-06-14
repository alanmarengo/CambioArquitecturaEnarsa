


<?php

/*
include("../login.php"); 

if (isset($_SESSION)) 
{
	if (sizeof($_SESSION) == 0) 
	{
		die('{"status_code":"5","status":"No tiene permisos para realizar esta acción","error_desc":"No tiene permisos para realizar esta acción"}');
	};
}
else
{
	die('{"status_code":"4","status":"Usuario no valido","error_desc":"Usuario no valido"}');
};*/


header('Content-Type: application/json');

include("../pgconfig.php");

function clear_json($str) {
	
	$bad = array("\n","\r","\"");
	
	$good = array("","","");
	
	return str_replace($bad,$good,$str);
	
}

$mode 	= $_REQUEST["mode"];

$s 		= clear_json(pg_escape_string($_REQUEST["s"]));

$grafico_id	 			= clear_json(pg_escape_string($_REQUEST["grafico_id"]));
$grafico_tipo_id		= clear_json(pg_escape_string($_REQUEST["grafico_tipo_id"]));		
$grafico_desc			= clear_json(pg_escape_string($_REQUEST["grafico_desc"]));		
$grafico_titulo			= clear_json(pg_escape_string($_REQUEST["grafico_titulo"]));	
$grafico_data_schema	= clear_json(pg_escape_string($_REQUEST["grafico_data_schema"]));		
$grafico_data_tabla		= clear_json(pg_escape_string($_REQUEST["grafico_data_tabla"]));
$color= clear_json(pg_escape_string($_REQUEST["color"]));

switch ($mode) 
{
    case 0: 
        grafico_buscar($s);
        break;
    case 1: 
        grafico_guardar();
        break;
    case 2: 
        borrar_grafico();
        break;
    case 3: 
        agregar_capa_dt();
        break;
    case 4: 
         get_cruces($dt_id);
        break;
    case 5: /* capas del geovisor */
         get_capas_geovisor($geovisor_id);
        break;
    case 6: /* quitar capas del visor */
        quitar_capa_dt();
        break;
    case 7: /* quitar capas del visor */
        registrar_variables();
        break;
    case 8: /* quitar capas del visor */
        get_variables($dt_id);
        break;
    case 9: 
          editar_variables();
        break;
    case 10: 
          borrar_variables();
        break;
        
      

};



function registrar_variables()
{
	global $dt_id;
	global $dt_titulo;
	global $dt_table_source;
		
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);

	$query_string .= " DELETE FROM mod_estadistica.dt_variable WHERE dt_id_ref=$dt_id;";
    $query_string .= " INSERT INTO mod_estadistica.dt_variable(dt_id_ref, dt_variable_id_original, dt_variable_cod_var, dt_variable_nombre, dt_variable_defincion,dt_variable_origen)";
	$query_string .= " SELECT DISTINCT $dt_id AS dataset_id,-1 AS dt_variable_id_original,\"indicador\",\"indicador\" ,\"indicador\" ,'$dt_titulo' AS dt_variable_origen";
	$query_string .= " FROM $dt_table_source;";

	$query = pg_query($conn,$query_string);
	
	if(!$query)
	{
		$error_1 = clear_json(pg_last_error($conn));
		echo '{"status_code":"2","status":"No se pudo borrar el registro","error_desc":"'.$error_1.'"}';
	}
	else
	{
		$r = pg_fetch_assoc($query);
		echo '{"status_code":"0","status":"Ok","dt_id":"'. $r["dt_id"].'"}';
	};
	
	pg_close($conn);
	
};

function estadistico_borrar()
{
	global $dt_id;
		
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);

	$query_string .="DELETE FROM mod_estadistica.dt WHERE dt_id=$dt_id RETURNING dt_id;";

	$query = pg_query($conn,$query_string);
	
	if(!$query)
	{
		$error_1 = clear_json(pg_last_error($conn));
		echo '{"status_code":"2","status":"No se pudo borrar el registro","error_desc":"'.$error_1.'"}';
	}
	else
	{
		$r = pg_fetch_assoc($query);
		echo '{"status_code":"0","status":"Ok","dt_id":"'. $r["dt_id"].'"}';
	};
	
	pg_close($conn);
	
};

function borrar_grafico()
{
    global	$grafico_id;

	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string  = "DELETE FROM  mod_graficos.grafico WHERE $grafico_id=grafico_id RETURNING grafico_id";
		
	$query = pg_query($conn,$query_string);
	
	if(!$query)
	{
		$error_1 = clear_json(pg_last_error($conn));
		
		echo '{"status_code":"1","status":"No se pudo eliminar los datos. ","error_desc":"'.$error_1.'"}';
	}
	else
	{
		$r = pg_fetch_assoc($query);
		echo '{"status_code":"0","status":"Ok","grafico_id":"'. $grafico_id.'"}';
	};
	
	pg_close($conn);
	
};



function agregar_capa_dt()
{
    
	global $dt_cruce_id;
	global $dt_id; 
	global $dt_cruce_table;
	global $dt_cruce_column_display; 
	global $dt_cruce_etiqueta;
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string  = "INSERT INTO mod_estadistica.dt_cruce(dt_id,dt_cruce_table,dt_cruce_column_display,dt_cruce_etiqueta)VALUES(";
	$query_string  .= "$dt_id,'$dt_cruce_table','$dt_cruce_column_display','$dt_cruce_etiqueta')RETURNING dt_cruce_id;";
		
	$query = pg_query($conn,$query_string);
	
	if(!$query)
	{
		$error_1 = clear_json(pg_last_error($conn));
		
		echo '{"status_code":"1","status":"No se pudo guardar los datos. ","error_desc":"'.$error_1.'"}';
	}
	else
	{
		$r = pg_fetch_assoc($query);
		echo '{"status_code":"0","status":"Ok","dt_cruce_id":"'. $dt_cruce_id.'"}';
	};
	
	pg_close($conn);
	
};



function grafico_guardar()
{
	global $grafico_id;	
	global $grafico_tipo_id;				
	global $grafico_desc;					
	global $grafico_titulo;				
	global $grafico_data_schema;			
	global $grafico_data_tabla;		

	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	if($grafico_id==-1)
	{
		$query_string = "INSERT INTO mod_graficos.grafico(grafico_tipo_id,grafico_desc,grafico_titulo,grafico_data_schema,grafico_data_tabla,color)VALUES(";
		$query_string .= "$grafico_tipo_id,";
		$query_string .= "'$grafico_desc',";
		$query_string .= "'$grafico_titulo',";
		$query_string .= "'$grafico_data_schema',";
		$query_string .= "'$grafico_data_tabla'";
		$query_string .= "'$color'";
		$query_string .= ")RETURNING grafico_id;";
	
	}
	else
	{
		
		$query_string = "UPDATE mod_graficos.grafico SET ";
		$query_string .= "grafico_tipo_id=$grafico_tipo_id,";
		$query_string .= "grafico_desc='$grafico_desc',";
		$query_string .= "grafico_titulo='$grafico_titulo',";
		$query_string .= "grafico_data_schema='$grafico_data_schema',";
		$query_string .= "grafico_data_tabla='$grafico_data_tabla'";
		$query_string .= "color='$color'";
		$query_string .=" WHERE grafico_id=$grafico_id RETURNING grafico_id;";
	
	};
    
	$query = pg_query($conn,$query_string);
	
	if(!$query)
	{
		$error_1 = clear_json(pg_last_error($conn));
		echo '{"status_code":"1","status":"No se puedo guardar","error_desc":"'.$error_1.'"}';
	}
	else
	{
		$r = pg_fetch_assoc($query);
		echo '{"status_code":"0","status":"Ok","grafico_id":"'. $r["grafico_id"].'"}';
	};
	
	pg_close($conn);
	
};




function grafico_buscar($busqueda) 
{
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT * FROM  mod_graficos.grafico WHERE grafico_desc||grafico_titulo ILIKE '%$busqueda%' ORDER BY grafico_desc ASC";

	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) 
	{
		$json .= '{';
		$json .= '"grafico_id":"'					. 	$r["grafico_id"] .'",';
		$json .= '"grafico_tipo_id":"'					. 	clear_json($r["grafico_tipo_id"]) .'",';
		$json .= '"grafico_desc":"'				. 	clear_json($r["grafico_desc"]) .'",';
		$json .= '"grafico_titulo":"'					. 	clear_json($r["grafico_titulo"]) .'",';
		$json .= '"grafico_data_schema":"'			. 	clear_json($r["grafico_data_schema"]) .'",';
		$json .= '"grafico_data_tabla":"'		. 	clear_json($r["grafico_data_tabla"]) .'"';
		$json .= "},";
		

		$entered = true;
	}
	
	if ($entered) 
	{
		$json = substr($json,0,strlen($json)-1);
	};
	
	$json .= "]";
	
	echo $json;
	
	pg_close($conn);

};

function editar_variables() 
{
	global $dt_variable_id;
	global $dt_variable_nombre;
	global $dt_variable_defincion;
	global $dt_variable_origen;
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string  = "UPDATE mod_estadistica.dt_variable  SET ";
	$query_string .= "dt_variable_nombre='$dt_variable_nombre',";
	$query_string .= "dt_variable_defincion='$dt_variable_defincion',";
	$query_string .= "dt_variable_origen='$dt_variable_origen'";
	$query_string .= " WHERE dt_variable_id =$dt_variable_id RETURNING dt_variable_id;";

	$query = pg_query($conn,$query_string);
	
	if(!$query)
	{
		$error_1 = clear_json(pg_last_error($conn));
		echo '{"status_code":"1","status":"No se puedo guardar","error_desc":"'.$error_1.'"}';
	}
	else
	{
		$r = pg_fetch_assoc($query);
		echo '{"status_code":"0","status":"Ok","dt_variable_id":"'. $r["dt_variable_id"].'"}';
	};
		
	
	pg_close($conn);

};

function borrar_variables() 
{
	global $dt_variable_id;
		
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string .= "DELETE FROM  mod_estadistica.dt_variable WHERE dt_variable_id =$dt_variable_id RETURNING dt_variable_id;";

	$query = pg_query($conn,$query_string);
	
	if(!$query)
	{
		$error_1 = clear_json(pg_last_error($conn));
		echo '{"status_code":"1","status":"No se puedo guardar","error_desc":"'.$error_1.'"}';
	}
	else
	{
		$r = pg_fetch_assoc($query);
		echo '{"status_code":"0","status":"Ok","dt_variable_id":"'. $r["dt_variable_id"].'"}';
	};
		
	
	pg_close($conn);

};

function get_variables($dt_id) 
{
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT * FROM mod_estadistica.dt_variable WHERE dt_id_ref =$dt_id ORDER BY dt_variable_nombre ASC";

	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) 
	{
		
		$json .= "{";
		$json .= "\"dt_variable_id\":" 				. $r["dt_variable_id"] . ",";
		$json .= "\"dt_id_ref\":" 						. $r["dt_id_ref"] . ",";
		$json .= "\"dt_variable_cod_var\":\"" 		. $r["dt_variable_cod_var"] . "\",";
		$json .= "\"dt_variable_nombre\":\"" 		. clear_json($r["dt_variable_nombre"]) . "\",";
		$json .= "\"dt_variable_defincion\":\"" 	. clear_json($r["dt_variable_defincion"]) . "\",";
		$json .= "\"dt_variable_origen\":\"" 		. clear_json($r["dt_variable_origen"]) . "\"";
		$json .= "},";
		//var_dump($r);
		$entered = true;
	}
	
	if ($entered) {
		
		$json = substr($json,0,strlen($json)-1);
		
	}
	
	$json .= "]";
	
	echo $json;
	
	pg_close($conn);

};

function get_cruces($dt_id) 
{
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT * FROM mod_estadistica.dt_cruce WHERE dt_id =$dt_id ORDER BY dt_cruce_table ASC";

	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) 
	{
		
		$json .= "{";
		$json .= "\"dt_cruce_id\":" 				. $r["dt_cruce_id"] . ",";
		$json .= "\"dt_id\":" 						. $r["dt_id"] . ",";
		$json .= "\"dt_cruce_table\":\"" 		. clear_json($r["dt_cruce_table"]) . "\",";
		$json .= "\"dt_cruce_column_display\":\"" 	. clear_json($r["dt_cruce_column_display"]) . "\",";
		$json .= "\"dt_cruce_etiqueta\":\"" 		. clear_json($r["dt_cruce_etiqueta"]) . "\"";
		$json .= "},";
		//var_dump($r);
		$entered = true;
	}
	
	if ($entered) {
		
		$json = substr($json,0,strlen($json)-1);
		
	}
	
	$json .= "]";
	
	echo $json;
	
	pg_close($conn);

};

function get_capas_geovisor($geovisor_id) 
{
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "select *,";
	$query_string .= "(SELECT layer_desc FROM mod_geovisores.layer L WHERE L.layer_id=G.layer_id)AS nombre_capa ";
	$query_string .= "FROM mod_geovisores.geovisor_capa_inicial G WHERE geovisor_id=$geovisor_id;";
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) {
		
		$json .= "{";
		$json .= "\"geovisor_id\":" . $r["geovisor_id"] . ",";
		$json .= "\"layer_id\":\"" . clear_json($r["layer_id"]) . "\",";
		$json .= "\"nombre_capa\":\"" . clear_json($r["nombre_capa"]) . "\",";
		$json .= "\"iniciar_visible\":\"" . clear_json($r["iniciar_visible"]) . "\"";
		$json .= "},";
		//var_dump($r);
		$entered = true;
	}
	
	if ($entered) {
		
		$json = substr($json,0,strlen($json)-1);
		
	}
	
	$json .= "]";
	
	echo $json;
	
	pg_close($conn);

};






?>

