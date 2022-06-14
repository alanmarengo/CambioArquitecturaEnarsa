


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

$dt_id=						$_REQUEST["dt_id"];
$clase_id=					$_REQUEST["clase_id"];
$dt_titulo=					$_REQUEST["dt_titulo"];
$dt_desc=					$_REQUEST["dt_desc"];
$dt_table_source=			$_REQUEST["dt_table_source"];
$dt_geom_base_table=		$_REQUEST["dt_geom_base_table"];
$dt_geom_column_display=	$_REQUEST["dt_geom_column_display"];

$dt_cruce_id 				= $_REQUEST["dt_cruce_id"];
$dt_cruce_table				= $_REQUEST["dt_cruce_table"];
$dt_cruce_column_display 	= $_REQUEST["dt_cruce_column_display"];
$dt_cruce_etiqueta			= $_REQUEST["dt_cruce_etiqueta"];


$dt_variable_id			= $_REQUEST["dt_variable_id"];
$dt_variable_nombre		= $_REQUEST["dt_variable_nombre"];
$dt_variable_defincion	= $_REQUEST["dt_variable_defincion"];
$dt_variable_origen		= $_REQUEST["dt_variable_origen"];


switch ($mode) 
{
    case 0: 
        estadistico_buscar($s);
        break;
    case 1: 
        estadistico_guardar();
        break;
    case 2: 
        estadistico_borrar();
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

function quitar_capa_dt()
{
    global	$dt_cruce_id;

	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string  = "DELETE FROM mod_estadistica.dt_cruce WHERE $dt_cruce_id=dt_cruce_id RETURNING dt_cruce_id";
		
	$query = pg_query($conn,$query_string);
	
	if(!$query)
	{
		$error_1 = clear_json(pg_last_error($conn));
		
		echo '{"status_code":"1","status":"No se pudo eliminar los datos. ","error_desc":"'.$error_1.'"}';
	}
	else
	{
		$r = pg_fetch_assoc($query);
		echo '{"status_code":"0","status":"Ok","dt_cruce_id":"'. $dt_cruce_id.'"}';
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



function estadistico_guardar()
{
	global $dt_id;	
	global $clase_id;				
	global $dt_titulo;					
	global $dt_desc;				
	global $dt_table_source;			
	global $dt_geom_base_table;		
	global $dt_geom_column_display;
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	if($dt_id==-1)
	{
		$query_string = "INSERT INTO mod_estadistica.dt(clase_id,dt_titulo,dt_desc,dt_table_source,dt_geom_base_table,dt_geom_column_display)VALUES(";
		$query_string .= "$clase_id,";
		$query_string .= "'$dt_titulo',";
		$query_string .= "'$dt_desc',";
		$query_string .= "'$dt_table_source',";
		$query_string .= "'$dt_geom_base_table',";
		$query_string .= "'$dt_geom_column_display'";
		$query_string .= ")RETURNING dt_id;";
	
	}
	else
	{
		
		$query_string = "UPDATE mod_estadistica.dt SET ";
		$query_string .= "clase_id=$clase_id,";
		$query_string .= "dt_titulo='$dt_titulo',";
		$query_string .= "dt_desc='$dt_desc',";
		$query_string .= "dt_table_source='$dt_table_source',";
		$query_string .= "dt_geom_base_table='$dt_geom_base_table',";
		$query_string .= "dt_geom_column_display='$dt_geom_column_display'";
		$query_string .="WHERE dt_id=$dt_id RETURNING dt_id;";
	
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
		echo '{"status_code":"0","status":"Ok","dt_id":"'. $r["dt_id"].'"}';
	};
	
	pg_close($conn);
	
};




function estadistico_buscar($busqueda) 
{
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT * FROM  mod_estadistica.dt WHERE dt_titulo ILIKE '%$busqueda%' ORDER BY dt_titulo ASC";

	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) 
	{
		$json .= '{';
		$json .= '"dt_id":"'					. 	$r["dt_id"] .'",';
		$json .= '"clase_id":"'					. 	clear_json($r["clase_id"]) .'",';
		$json .= '"dt_titulo":"'				. 	clear_json($r["dt_titulo"]) .'",';
		$json .= '"dt_desc":"'					. 	clear_json($r["dt_desc"]) .'",';
		$json .= '"dt_table_source":"'			. 	clear_json($r["dt_table_source"]) .'",';
		$json .= '"dt_geom_base_table":"'		. 	clear_json($r["dt_geom_base_table"]) .'",';
		$json .= '"dt_geom_column_display":"'	. 	clear_json($r["dt_geom_column_display"]) .'"';
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
