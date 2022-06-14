

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

$s 					= clear_json(pg_escape_string($_REQUEST["s"]));
$objeto_id 			= clear_json(pg_escape_string($_REQUEST["objeto_id"]));
$objeto_tipo_id 	= clear_json(pg_escape_string($_REQUEST["objeto_tipo_id"]));
$perfil_usuario_id 	= clear_json(pg_escape_string($_REQUEST["perfil_usuario_id"]));

switch ($mode) 
{
    case 0: 
        recurso_buscar($s);
        break;
    case 1:
        get_perfiles_recurso();
        break;
    case 2: 
        agregar_perfil_recurso();
        break;
    case 3:
        quitar_perfil_recurso();
        break;
    case 4: /* BUSCAR CAPAS */
         get_capas($s) ;
        break;
    case 5: /* capas del geovisor */
         get_capas_geovisor($geovisor_id);
        break;
    case 6: /* quitar capas del visor */
        quitar_capa_visor();
        break;

            
};


function geovisor_borrar()
{
	global $geovisor_id;
		
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);

	$query_string .="DELETE FROM mod_geovisores.geovisor WHERE geovisor_id=$geovisor_id RETURNING geovisor_id;";

	$query = pg_query($conn,$query_string);
	
	if(!$query)
	{
		$error_1 = clear_json(pg_last_error($conn));
		echo '{"status_code":"2","status":"No se pudo borrar el registro","error_desc":"'.$error_1.'"}';
	}
	else
	{
		$r = pg_fetch_assoc($query);
		echo '{"status_code":"0","status":"Ok","geovisor_id":"'. $r["geovisor_id"].'"}';
	};
	
	pg_close($conn);
	
};

function quitar_capa_visor()
{
    global	$geovisor_id;
	global	$layer_id;			
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string  = "DELETE FROM mod_geovisores.geovisor_capa_inicial WHERE $geovisor_id=geovisor_id AND layer_id=$layer_id RETURNING geovisor_id";
		
	$query = pg_query($conn,$query_string);
	
	if(!$query)
	{
		$error_1 = clear_json(pg_last_error($conn));
		
		echo '{"status_code":"1","status":"No se pudo eliminar los datos. ","error_desc":"'.$error_1.'"}';
	}
	else
	{
		$r = pg_fetch_assoc($query);
		echo '{"status_code":"0","status":"Ok","geovisor_id":"'. $geovisor_id.'"}';
	};
	
	pg_close($conn);
	
};



function agregar_perfil_recurso()
{
	global $objeto_id;
	global $objeto_tipo_id;
	global $perfil_usuario_id;
	
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string  = "INSERT INTO mod_login.permisos(objeto_id,tipo_objeto_id,perfil_usuario_id)VALUES(";
	$query_string  .= "$objeto_id,$objeto_tipo_id,$perfil_usuario_id)RETURNING objeto_id;";
		
	$query = pg_query($conn,$query_string);
	
	if(!$query)
	{
		$error_1 = clear_json(pg_last_error($conn));
		
		echo '{"status_code":"1","status":"No se pudo guardar los datos. ","error_desc":"'.$error_1.'"}';
	}
	else
	{
		$r = pg_fetch_assoc($query);
		echo '{"status_code":"0","status":"Ok","objeto_id":"'. $objeto_id.'"}';
	};
	
	pg_close($conn);
	
};



function quitar_perfil_recurso()
{
	global $objeto_id;
	global $objeto_tipo_id;
	global $perfil_usuario_id;
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string  = "DELETE FROM mod_login.permisos WHERE ";
	$query_string  .= "objeto_id=$objeto_id AND tipo_objeto_id=$objeto_tipo_id AND perfil_usuario_id=$perfil_usuario_id RETURNING objeto_id;";
		
	$query = pg_query($conn,$query_string);
	
	if(!$query)
	{
		$error_1 = clear_json(pg_last_error($conn));
		
		echo '{"status_code":"1","status":"No se pudo guardar los datos. ","error_desc":"'.$error_1.'"}';
	}
	else
	{
		$r = pg_fetch_assoc($query);
		echo '{"status_code":"0","status":"Ok","objeto_id":"'. $objeto_id.'"}';
	};
	
	pg_close($conn);
	
};

function geovisor_guardar()
{
	global $geovisor_id;
	global $geovisor_desc;
	global $geovisor_extent;
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	if($geovisor_id==-1)
	{
		$query_string = "INSERT INTO mod_geovisores.geovisor(geovisor_desc,geovisor_extent)VALUES(";
		$query_string .= "'$geovisor_desc',";
		$query_string .= "'$geovisor_extent'";
		$query_string .= ")RETURNING geovisor_id;";
	
	}
	else
	{
		
		$query_string = "UPDATE  mod_geovisores.geovisor SET ";
		$query_string .="geovisor_desc = '$geovisor_desc',";
		$query_string .="geovisor_extent = '$geovisor_extent' ";
		$query_string .="WHERE geovisor_id=$geovisor_id RETURNING geovisor_id;";
	
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
		echo '{"status_code":"0","status":"Ok","geovisor_id":"'. $r["geovisor_id"].'"}';
	};
	
	pg_close($conn);
	
};




function recurso_buscar($busqueda) 
{
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT DISTINCT * FROM  mod_catalogo.vw_catalogo_data WHERE recurso_titulo||recurso_desc ILIKE '%$busqueda%' ORDER BY recurso_titulo ASC limit 50";

	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) 
	{
		$json .= '{';
		$json .= '"origen":"'						. 	$r["origen"] .'",';
		$json .= '"recurso_titulo":"'				. 	clear_json($r["recurso_titulo"]) .'",';
		$json .= '"recurso_desc":"'					. 	clear_json($r["recurso_desc"]) .'",';
		$json .= '"recurso_categoria_desc":"'		. 	clear_json($r["recurso_categoria_desc"]) .'",';
		$json .= '"origen_id_especifico":"'			. 	clear_json($r["origen_id_especifico"]) .'",';
		$json .= '"preview":"../mediateca_preview.php?r='.$r["origen_id_especifico"].'&origen_id='.$r["origen_id"].'",';
		$json .= '"origen_id":"'					. 	clear_json($r["origen_id"]) .'"';
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

function get_capas($busqueda) 
{
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT layer_id,layer_desc,preview_titulo,preview_desc FROM mod_geovisores.layer WHERE layer_desc||preview_titulo ILIKE '%$busqueda%' ORDER BY layer_desc ASC";
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) {
		
		$json .= "{";
		$json .= "\"layer_id\":" . $r["layer_id"] . ",";
		$json .= "\"layer_desc\":\"" . clear_json($r["layer_desc"]) . "\",";
		$json .= "\"preview_titulo\":\"" . clear_json($r["preview_titulo"]) . "\",";
		$json .= "\"preview_desc\":\"" . clear_json($r["preview_desc"]) . "\"";
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

function get_perfiles_recurso() 
{
	global $objeto_id;
	global $objeto_tipo_id;
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT *,perfil_usuario_desc AS perfil FROM mod_login.permisos P INNER JOIN mod_login.perfil_usuario PU ";
	$query_string .= "ON P.perfil_usuario_id = PU.perfil_usuario_id WHERE ";
	$query_string .= "objeto_id=$objeto_id AND tipo_objeto_id=$objeto_tipo_id;";
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) {
		
		$json .= "{";
		$json .= "\"perfil\":\"" 			. $r["perfil"] . "\",";
		$json .= "\"perfil_usuario_id\":\"" . clear_json($r["perfil_usuario_id"]) . "\",";
		$json .= "\"objeto_id\":\"" 		. clear_json($r["objeto_id"]) . "\",";
		$json .= "\"objeto_tipo_id\":\"" 	. clear_json($r["tipo_objeto_id"]) . "\"";
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

