

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

$geovisor_id			=$_REQUEST['geovisor_id'];
$geovisor_desc			=$_REQUEST['geovisor_desc'];
$geovisor_extent		=$_REQUEST['geovisor_extent'];

$layer_id				=$_REQUEST['layer_id'];
$iniciar_visible		=$_REQUEST['iniciar_visible'];		

switch ($mode) 
{
    case 0: /* BUSCAR CAPAS */
        geovisor_buscar($s);
        break;
    case 1: /* NUEVA/ACTUALIZAR CAPA */
        geovisor_guardar();
        break;
    case 2: /* BORRAR CAPA */
        geovisor_borrar();
        break;
    case 3: /* AGREGAR A capas del visor */
        agregar_capa_visor();
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



function agregar_capa_visor()
{
    global	$geovisor_id;
	global	$layer_id;			
	global	$iniciar_visible;	
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string  = "INSERT INTO mod_geovisores.geovisor_capa_inicial(geovisor_id,layer_id,iniciar_visible)VALUES(";
	$query_string  .= "$geovisor_id,$layer_id,'$iniciar_visible')RETURNING geovisor_id;";
		
	$query = pg_query($conn,$query_string);
	
	if(!$query)
	{
		$error_1 = clear_json(pg_last_error($conn));
		
		echo '{"status_code":"1","status":"No se pudo guardar los datos. ","error_desc":"'.$error_1.'"}';
	}
	else
	{
		$r = pg_fetch_assoc($query);
		echo '{"status_code":"0","status":"Ok","geovisor_id":"'. $geovisor_id.'"}';
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




function geovisor_buscar($busqueda) 
{
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT * FROM  mod_geovisores.geovisor WHERE geovisor_desc ILIKE '%$busqueda%' ORDER BY geovisor_desc ASC";

	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) 
	{
		$json .= '{';
		$json .= '"geovisor_id":"'					. 	$r["geovisor_id"] .'",';
		$json .= '"geovisor_desc":"'				. 	clear_json($r["geovisor_desc"]) .'",';
		$json .= '"geovisor_extent":"'				. 	clear_json($r["geovisor_extent"]) .'"';
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
