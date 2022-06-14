


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


$ind_id					= clear_json(pg_escape_string($_REQUEST["ind_id"]));
$ind_titulo				= clear_json(pg_escape_string($_REQUEST["ind_titulo"]));
$ind_desc				= clear_json(pg_escape_string($_REQUEST["ind_desc"]));
$clase_id				= clear_json(pg_escape_string($_REQUEST["clase_id"]));
$template_id			= clear_json(pg_escape_string($_REQUEST["template_id"]));



$posicion			= clear_json(pg_escape_string($_REQUEST["posicion"]));		
$titulo				= clear_json(pg_escape_string($_REQUEST["titulo"]));
$desc				= clear_json(pg_escape_string($_REQUEST["desc"]));		
$ficha_metodo_path	= clear_json(pg_escape_string($_REQUEST["ficha_metodo_path"]));
$extent				= clear_json(pg_escape_string($_REQUEST["extent"]));
$tipo				= clear_json(pg_escape_string($_REQUEST["tipo"]));
$valor				= clear_json(pg_escape_string($_REQUEST["valor"]));

switch ($mode) 
{
    case 0: 
        panel_buscar($s);
        break;
    case 1: 
        panel_guardar();
        break;
    case 2: 
        item_buscar($s);
        break;
    case 3: 
        get_item_panel($ind_id);
        break;
    case 4: 
        panel_guardar_item();
        break;
    case 5: 
        panel_quitar_item();
        break;
    case 6: 
        borrar_panel();
        break;
   
};


function borrar_panel()
{
    global	$ind_id;

	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string  = "DELETE FROM  mod_indicadores.ind_panel WHERE $ind_id=ind_id RETURNING ind_id";
		
	$query = pg_query($conn,$query_string);
	
	if(!$query)
	{
		$error_1 = clear_json(pg_last_error($conn));
		
		echo '{"status_code":"1","status":"No se pudo eliminar los datos. ","error_desc":"'.$error_1.'"}';
	}
	else
	{
		$r = pg_fetch_assoc($query);
		echo '{"status_code":"0","status":"Ok","ind_id":"'. $ind_id.'"}';
	};
	
	pg_close($conn);
	
};

function panel_quitar_item()
{
	global $tipo;
	global $valor;
	global $ind_id;
		
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	switch ($tipo) 
	{
		case 0: /* Graficos */ 
        	$query_string  = "DELETE FROM mod_indicadores.ind_grafico WHERE ind_id=$ind_id AND grafico_id=$valor";
        break;
        case 1: /* Recursos */ 
			$query_string  = "DELETE FROM mod_indicadores.ind_recurso WHERE ind_id=$ind_id AND recurso_id=$valor";
        break;
        case 2: /* Capas */ 
			$query_string  = "DELETE FROM mod_indicadores.ind_capa WHERE ind_id=$ind_id AND layer_id=$valor";
        break;
        case 3: /* Tablas */ 
			$query_string  = "DELETE FROM mod_indicadores.ind_tabla WHERE ind_id=$ind_id AND ind_tabla_id=$valor";
        break;
    };

   //echo $query_string;
	
   $query = pg_query($conn,$query_string);
	
	if(!$query)
	{
		$error_1 = clear_json(pg_last_error($conn));
		echo '{"status_code":"2","status":"No se pudo agregar el registro","error_desc":"'.$error_1.'"}';
	}
	else
	{
		$r = pg_fetch_assoc($query);
		echo '{"status_code":"0","status":"Ok","ind_id":"'. $ind_id.'"}';
	};
	
	pg_close($conn);
	
};


function panel_guardar_item()
{
	global $posicion;
	global $titulo;
	global $desc;		
	global $ficha_metodo_path;
	global $extent;
	global $tipo;
	global $valor;
	global $ind_id;
		
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	switch ($tipo) 
	{
		case 0: /* Graficos */ 
			$query_string  = " INSERT INTO mod_indicadores.ind_grafico(ind_id,posicion,titulo,\"desc\",ficha_metodo_path,grafico_id)VALUES";
        	$query_string .= " ($ind_id,$posicion,'$titulo','$desc','$ficha_metodo_path',$valor)RETURNING ind_id;";
        break;
        case 1: /* Recursos */ 
			$query_string  = " INSERT INTO mod_indicadores.ind_recurso(ind_id,posicion,titulo,\"desc\",ficha_metodo_path,recurso_id)VALUES";
			$query_string .= " ($ind_id,$posicion,'$titulo','$desc','$ficha_metodo_path',$valor)RETURNING ind_id;";
        break;
        case 2: /* Capas */ 
			$query_string  = " INSERT INTO mod_indicadores.ind_capa(ind_id,posicion,titulo,\"desc\",ficha_metodo_path,layer_id,extent)VALUES";
			$query_string .= " ($ind_id,$posicion,'$titulo','$desc','$ficha_metodo_path',$valor,'$extent')RETURNING ind_id;";
        break;
        case 3: /* Tablas */ 
			$query_string  = " INSERT INTO mod_indicadores.ind_tabla(ind_id,posicion,titulo,\"desc\",ficha_metodo_path,ind_tabla_fuente)VALUES";
			$query_string .= " ($ind_id,$posicion,'$titulo','$desc','$ficha_metodo_path','$valor')RETURNING ind_id;";
        break;
    };

   //echo $query_string;
	
   $query = pg_query($conn,$query_string);
	
	if(!$query)
	{
		$error_1 = clear_json(pg_last_error($conn));
		echo '{"status_code":"2","status":"No se pudo agregar el registro","error_desc":"'.$error_1.'"}';
	}
	else
	{
		$r = pg_fetch_assoc($query);
		echo '{"status_code":"0","status":"Ok","ind_id":"'. $r["ind_id"].'"}';
	};
	
	pg_close($conn);
	
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



function panel_guardar()
{
	global	$ind_id;
	global	$ind_titulo;
	global	$ind_desc;
	global	$clase_id;
	global	$template_id;
		
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	if($ind_id==-1)
	{
		$query_string = "INSERT INTO mod_indicadores.ind_panel(ind_titulo,ind_desc,clase_id,template_id)VALUES(";
		$query_string .= "'$ind_titulo',";
		$query_string .= "'$ind_desc',";
		$query_string .= "$clase_id,";
		$query_string .= "$template_id";
		$query_string .= ")RETURNING ind_id;";
	
	}
	else
	{
		
		$query_string = "UPDATE mod_indicadores.ind_panel SET ";
		$query_string .= "ind_titulo='$ind_titulo',";
		$query_string .= "ind_desc='$ind_desc',";
		$query_string .= "clase_id=$clase_id,";
		$query_string .= "template_id=$template_id";
		$query_string .=" WHERE ind_id=$ind_id RETURNING ind_id;";
	
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
		echo '{"status_code":"0","status":"Ok","ind_id":"'. $r["ind_id"].'"}';
	};
	
	pg_close($conn);
	
};



function item_buscar($busqueda) 
{
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT * FROM mod_indicadores.vw_items WHERE titulo||descripcion ILIKE '%$busqueda%' ORDER BY titulo ASC";

	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) 
	{
		$json .= '{';
		$json .= '"tipo_desc":"'			. 	$r["tipo_desc"] .'",';
		$json .= '"titulo":"'				. 	clear_json($r["titulo"]) .'",';
		$json .= '"descripcion":"'			. 	clear_json($r["descripcion"]) .'",';
		$json .= '"valor":"'				. 	clear_json($r["valor"]) .'",';
		$json .= '"tipo":"'					. 	clear_json($r["tipo"]) .'"';
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


function get_item_panel($ind_id) 
{
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT * FROM mod_indicadores.vw_items_panel WHERE ind_id=$ind_id ORDER BY posicion,tipo_desc,titulo ASC";

	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) 
	{
		$json .= '{';
		$json .= '"ind_id":"'				. 	$r["ind_id"] .'",';
		$json .= '"valor":"'				. 	clear_json($r["valor"]) .'",';
		$json .= '"tipo_desc":"'			. 	clear_json($r["tipo_desc"]) .'",';
		$json .= '"posicion":"'				. 	clear_json($r["posicion"]) .'",';
		$json .= '"titulo":"'				. 	clear_json($r["titulo"]) .'",';
		$json .= '"desc":"'					. 	clear_json($r["desc"]) .'",';
		$json .= '"tipo":"'					. 	clear_json($r["tipo"]) .'",';
		$json .= '"ficha_metodo_path":"'	. 	clear_json($r["ficha_metodo_path"]) .'"';
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




function panel_buscar($busqueda) 
{
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string = "SELECT * FROM mod_indicadores.ind_panel WHERE ind_titulo||ind_desc ILIKE '%$busqueda%' ORDER BY ind_titulo ASC";

	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) 
	{
		$json .= '{';
		$json .= '"ind_id":"'					. 	$r["ind_id"] .'",';
		$json .= '"ind_titulo":"'				. 	clear_json($r["ind_titulo"]) .'",';
		$json .= '"ind_desc":"'			. 	clear_json($r["ind_desc"]) .'",';
		$json .= '"clase_id":"'			. 	clear_json($r["clase_id"]) .'",';
		$json .= '"template_id":"'		. 	clear_json($r["template_id"]) .'"';
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


function cambiar_pass()
{
	global $user_id;
	global $pass;
	global $passc;

	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	if($pass==$passc)
	{
		$conn = pg_connect($string_conn);
		
		$query_string = "UPDATE mod_login.user_data SET ";
		$query_string .="user_pass = md5('$pass') ";
		$query_string .="WHERE user_id=$user_id RETURNING user_id;";
		
		//echo $query_string;

		$query = pg_query($conn,$query_string);
		
		if(!$query)
		{
			$error_1 = clear_json(pg_last_error($conn));
			echo '{"status_code":"2","status":"No se pudo cargar el registro","error_desc":"'.$error_1.'"}';
		}
		else
		{
			$r = pg_fetch_assoc($query);
			echo '{"status_code":"0","status":"Ok","user_id":"'. $r["user_id"].'"}';
		};
		
		pg_close($conn);
	}
	else
	{
		echo '{"status_code":"3","status":"Las contraseñas no coinciden.","error_desc":"Las contraseñas no coinciden."}';
	};
};

function cambiar_pass_old() 
{
	global $user_id;
	global $passw;
	global $passwc;
	
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

