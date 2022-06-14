<?php

/*session_start();*/

header('Content-Type: application/json');

include("./pgconfig.php");
include("./login.php");

function clear_json($str) {
	
	$bad = array("\n","\r","\"");
	
	$good = array("","","");
	
	return str_replace($bad,$good,$str);
	
};

$mode 					= $_REQUEST["mode"];

$estacion_id			= clear_json(pg_escape_string($_REQUEST["estacion_id"]));
$tipo_estacion_id 		= clear_json(pg_escape_string($_REQUEST["tipo_estacion_id"]));
$solapa 				= clear_json(pg_escape_string($_REQUEST["solapa"]));
$categoria_parametro_id = clear_json(pg_escape_string($_REQUEST["categoria_parametro_id"]));

$parametro_id			= clear_json(pg_escape_string($_REQUEST["parametro_id"]));
$fd						= clear_json(pg_escape_string($_REQUEST["fd"]));
$fh						= clear_json(pg_escape_string($_REQUEST["fh"]));
$cod_temp				= clear_json(pg_escape_string($_REQUEST["cod_temp"]));

$tipo_estaciones		= clear_json(pg_escape_string($_REQUEST["tipo_estaciones"]));

$lista_estaciones		= clear_json(pg_escape_string($_REQUEST["lista_estaciones"]));/* Valores separados por coma */

if ((isset($_SESSION)) && (sizeof($_SESSION) > 0))
{
	$id_usuario = 1;
}else $id_usuario = -1; /* usuario publico, no hay perfil */

switch ($mode) 
{
    case 0:
		//http://observ.net/red_api.php?estacion_id=6&tipo_estacion_id=1&mode=0
        hidro_get_solapa_desc($estacion_id,$tipo_estacion_id);
        break;
    case 1: 
		//http://observ.net/red_api.php?estacion_id=9&tipo_estacion_id=4&mode=1
        aforo_get_solapa_desc($estacion_id);
        break;
    case 2:
		//http://observ.net/red_api.php?estacion_id=7&tipo_estacion_id=4&mode=2
        //hidro_get_solapa_datos_diarios($estacion_id,$tipo_estacion_id);
        hidro_get_solapa_datos_diarios($estacion_id,$categoria_parametro_id);
        break;   
    case 3:
		//http://observ.net/red_api.php?estacion_id=7&categoria_parametro_id=4&mode=3
		hidro_get_estacion_parametros($estacion_id,$categoria_parametro_id);
		break;
	case 4:
		//http://observ.net/red_api.php?estacion_id=7&categoria_parametro_id=4&parametro_id=5&fd=01/01/2020&fh=31/12/2020&mode=4
		hidro_get_solapa_datos_fechas($estacion_id,$categoria_parametro_id,$parametro_id,$fd,$fh);
		break;
	case 5:
		//http://observ.net/red_api.php?estacion_id=7&tipo_estacion_id=4&mode=5
		aforo_get_campañas();
		break;
	case 6:
		//http://observ.net/red_api.php?git
		aforo_get_solapa_datos_campaña($estacion_id,$cod_temp);
		break;
	case 7:
		//http://observ.net/red_api.php?estacion_id=9&mode=7
		aforo_get_solapa_hq($estacion_id);
		break;
	case 8:
		//http://observ.net/red_api.php?estacion_id=14&parametro_id=28&fd=01/01/2020&fh=31/12/2020&mode=8
		aforo_get_solapa_datos_fechas($estacion_id,$parametro_id,$fd,$fh);
		break;
	case 9:
		//http://observ.net/red_api.php?estacion_id=14&mode=9
		aforo_get_estacion_parametros($estacion_id);
		break;
	case 10:
		//http://observ.net/red_api.php?tipo_estaciones=0&mode=10 estaciones hidro
		//http://observ.net/red_api.php?tipo_estaciones=1&mode=10 estaciones aforo
		get_estaciones($tipo_estaciones);/*1=aforo; <>1 las demas */
		break;
	case 11:
		//http://observ.net/red_api.php?lista_estaciones=3,4&parametro_id=25&fd=01/01/2020&fh=31/12/2020&mode=11
		get_parametro_datos($lista_estaciones,$parametro_id,$fd,$fh);
		break;
	case 12:
		//http://observ.net/red_api.php?estacion_id=7&categoria_parametro_id=4&parametro_id=5&mode=12
		get_estacion_parametro_grafico_30_dias($estacion_id,$categoria_parametro_id,$parametro_id);
		break;
	case 13:
		//http://observ.net/red_api.php?estacion_id=7&categoria_parametro_id=4&parametro_id=5&mode=12
		get_parametros($tipo_estaciones);
		break;
	case 14:
		hidro_popup4_links($estacion_id);
		break;
	case 15:
		/***
		 * Para bloque 4
		 * ***/
		//http://observ.net/red_api.php?tipo_estaciones=1&mode=15&parametro_id=34
		//http://observ.net/red_api.php?tipo_estaciones=0&mode=15&parametro_id=24
		get_estaciones_segun_parametro($tipo_estaciones,$parametro_id);
		break;
		
};


/*************** MODO 0 HIDROMETRICAS ************/

function hidro_get_solapa_desc($estacion_id,$tipo_estacion_id)
{
	//http://observ.net/red_api.php?estacion_id=6&tipo_estacion_id=1&mode=0
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	//mod_sensores.vp_tab_descaforos_pga1 y mod_sensores.vp_tab_deschidroambiental_pga1
	
	$query_string    = "SELECT *";
	$query_string   .= " FROM mod_sensores.vp_tab_deschidroambiental_pga1 ";
	$query_string   .= "WHERE estacion_id::bigint=$estacion_id AND tipo_estacionid::bigint=$tipo_estacion_id;";
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) 
	{
		
		$json .= '{';
		$json .= '"tab":"Hidro - descripcion",';
		$json .= '"estacion_id":"' 		. clear_json($r["estacion_id"]) . '",';
		$json .= '"tipo_estacion_id":"' 	. clear_json($r["tipo_estacionid"]) . '",';
		$json .= '"estacion":"' 		. clear_json($r["estacion"]) . '",';
		$json .= '"foto_estacion":"' 	. clear_json($r["foto_estacion"]) . '",';
		$json .= '"tipo":"' 			. clear_json($r["tipo"]) . '",';
		$json .= '"lat":"' 				. clear_json($r["lat"]) . '",';
		$json .= '"long":"' 			. clear_json($r["long"]) . '",';
		$json .= '"localizacion":"' 	. clear_json($r["localizacion"]) . '",';
		$json .= '"id_orig":"' 			. clear_json($r["id_orig"]) . '",';
		$json .= '"parametros":"' 		. clear_json($r["parametros"]) . '",';
		$json .= '"inicio_opera":"' 	. clear_json($r["inicio_opera"]) . '",';
		$json .= '"objetivo":"' 		. clear_json($r["objetivo"]) . '",';
		$json .= '"proveedor":"' 		. clear_json($r["proveedor"]) . '",';
		$json .= '"categoria_parametros":' . get_estacion_categorias_parametros($estacion_id) . '';
		
		$json .= "},";

		$entered = true;
	}
	
	if($entered) 
	{
		$json = substr($json,0,strlen($json)-1);
	};
	
	$json .= "]";
	
	echo $json;
	
	pg_close($conn);
	
};

function hidro_get_estacion_parametros($estacion_id,$categoria_parametro_id)
{
	global $id_usuario;
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string    = "SELECT parametro_id,parametro_desc||parametro_unidad AS parametro ";
	$query_string   .= " FROM mod_sensores.vw_red_monitoreo ";
	$query_string   .= " WHERE estacion_id=$estacion_id AND categoria_parametro_id=$categoria_parametro_id ";
	
	if($id_usuario==-1)/* Si no esta logeado */
	{
		$query_string   .= " AND parametro_id NOT IN(1,2,3) "; /* Ninguna Bateria*/
	};
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) 
	{
		
		$json .= '{';
		$json .= '"parametro_id":"' 		. clear_json($r["parametro_id"]) . '",';
		$json .= '"parametro_nombre":"' 	. clear_json($r["parametro"]) . '"';
		$json .= "},";

		$entered = true;
	}
	
	if($entered) 
	{
		$json = substr($json,0,strlen($json)-1);
	};
	
	$json .= "]";
	
	echo $json;
	
	pg_close($conn);
	
};

function get_estacion_categorias_parametros($estacion_id)
{
	//http://observ.net/red_api.php?estacion_id=9&tipo_estacion_id=4&mode=1
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	//mod_sensores.vp_tab_descaforos_pga1 y mod_sensores.vp_tab_deschidroambiental_pga1
	
	$query_string   = "SELECT DISTINCT categoria_parametro_id,categoria_parametro_desc FROM mod_sensores.vw_red_monitoreo ";
	$query_string  .= "WHERE estacion_id=$estacion_id;";
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) 
	{
		
		$json .= '{';
		$json .= '"categoria_parametro_id":"' . clear_json($r["categoria_parametro_id"]) . '",';
		$json .= '"categoria_parametro_desc":"' . clear_json($r["categoria_parametro_desc"]) . '"';
		$json .= "},";

		$entered = true;
	}
	
	if($entered) 
	{
		$json = substr($json,0,strlen($json)-1);
	};
	
	$json .= "]";
	
	pg_close($conn);
	
	return $json;
	
};




/*************** MODO 1 AFORO ************/

function aforo_get_solapa_desc($estacion_id)
{
	//http://observ.net/red_api.php?estacion_id=9&tipo_estacion_id=4&mode=1
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	//mod_sensores.vp_tab_descaforos_pga1 y mod_sensores.vp_tab_deschidroambiental_pga1
	
	$query_string   = "SELECT * FROM mod_sensores.vp_tab_descaforos_pga1 ";
	$query_string  .= "WHERE id_aforo=$estacion_id;";
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) 
	{
		
		$json .= '{';
		$json .= '"tab":"Aforo - descripcion",';
		$json .= '"id":"' 					. clear_json($r["id"]) . '",';
		$json .= '"id_aforo":"' 			. clear_json($r["id_aforo"]) . '",';
		$json .= '"foto_estacion":"' 		. clear_json($r["foto_estacion"]) . '",';
		$json .= '"seccion":"' 				. clear_json($r["seccion"]) . '",';
		$json .= '"lat":"' 					. clear_json($r["lat"]) . '",';
		$json .= '"long":"' 				. clear_json($r["long"]) . '",';
		$json .= '"met_aforo":"' 			. clear_json($r["met_aforo"]) . '",';
		$json .= '"met_vert":"' 			. clear_json($r["met_vert"]) . '",';
		$json .= '"inicio_camp":"' 			. clear_json($r["inicio_camp"]) . '",';
		$json .= '"proveedor":"' 			. clear_json($r["proveedor"]) . '"';
		$json .= "},";

		$entered = true;
	}
	
	if($entered) 
	{
		$json = substr($json,0,strlen($json)-1);
	};
	
	$json .= "]";
	
	echo $json;
	
	pg_close($conn);
	
};


/*************** MODO 2 hidrometricas ************/

function hidro_get_solapa_datos_diarios($estacion_id,$tipo_categoria_parametro_id)
{
	global $id_usuario;
	
	//http://observ.net/red_api.php?estacion_id=7&tipo_estacion_id=4&mode=2
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string   = "SELECT * FROM mod_sensores.get_estacion_datos_diarios($estacion_id,$tipo_categoria_parametro_id) ";
	
	if($id_usuario==-1)/* Si no esta logeado */
	{
		$query_string   .= " WHERE parametro_id NOT IN(1,2,3) "; /* Ninguna Bateria*/
	};
	
	$query_string  .= "ORDER BY parametro_nombre ASC;";
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = '{"datos_diarios":[';
	
	while ($r = pg_fetch_assoc($query)) 
	{
		
		$json .= '{';
		$json .= '"tab":"Hidro - datos diarios",';
		$json .= '"estacion_id":"' 		. clear_json($r["estacion_id"]) . '",';
		$json .= '"estacion_tipo":"' 	. clear_json($r["estacion_tipo"]) . '",';
		$json .= '"parametro_id":"' 	. clear_json($r["parametro_id"]) . '",';
		$json .= '"parametro_nombre":"' . clear_json($r["parametro_nombre"]) . '",';
		$json .= '"ultimo_dato":"' 		. clear_json($r["ultimo_dato"]) . '",';
		$json .= '"min_dato":"' 		. clear_json($r["min_dato"]) . '",';
		$json .= '"med_dato":"' 		. clear_json($r["med_dato"]) . '",';
		$json .= '"max_dato":"' 		. clear_json($r["max_dato"]) . '",';
		$json .= '"fecha_dato":"' 		. clear_json($r["fecha_dato"]) . '",';
		$json .= '"url_grafico":"' 		. clear_json($r["url_grafico"]) . '"';
		$json .= "},";

		$entered = true;
	}
	
	if($entered) 
	{
		$json = substr($json,0,strlen($json)-1);
	};
	
	$json .= "]";
	
	$query_string   = "SELECT * FROM  mod_sensores.get_estacion_datos_diarios_dv($estacion_id,$tipo_categoria_parametro_id) ";
	$query_string  .= "ORDER BY parametro_nombre ASC;";
	
	$query = pg_query($conn,$query_string);
	
	$r = pg_fetch_assoc($query);
	
	if (pg_num_rows($query)>0)
	{
	
	$json .= ",";
	$json .= '"DV":';
	
	$json .= '{';
	$json .= '"tab":"datos direccion del viento",';
	$json .= '"estacion_id":"' 		. clear_json($r["estacion_id"]) . '",';
	$json .= '"estacion_tipo":"' 	. clear_json($r["estacion_tipo"]) . '",';
	$json .= '"parametro_id":"' 	. clear_json($r["parametro_id"]) . '",';
	$json .= '"parametro_nombre":"' . clear_json($r["parametro_nombre"]) . '",';
	$json .= '"ultimo_dato":"' 		. clear_json($r["ultimo_dato"]) . '",';
	$json .= '"fecha_dato":"' 		. clear_json($r["fecha_dato"]) . '",';
	$json .= '"dv_moda":"' 		. clear_json($r["dv_moda"]) . '"';
	$json .= "}";
	
	};
	
	$json .= "}";

	
	echo $json;
	
	pg_close($conn);
	
};

function hidro_get_solapa_datos_fechas($estacion_id,$tipo_categoria_parametro_id,$parametro_id,$fd,$fh)
{
	//http://observ.net/red_api.php?estacion_id=7&categoria_parametro_id=4&parametro_id=5&fd=01/01/2020&fh=31/12/2020&mode=4
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string   = "SELECT * FROM mod_sensores.get_estacion_datos_fechas($estacion_id::bigint,$parametro_id::bigint,$tipo_categoria_parametro_id::bigint,'$fd'::timestamp with time zone,'$fh'::timestamp with time zone) ";
	$query_string  .= "ORDER BY parametro_nombre ASC;";
	
	//echo $query_string;
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) 
	{
		
		$json .= '{';
		$json .= '"tab":"Hidro - consultar datos",';
		$json .= '"estacion_id":"' 		. clear_json($r["estacion_id"]) . '",';
		$json .= '"categoria_parametro_id":"' 	. clear_json($r["categoria_parametro_id"]) . '",';
		$json .= '"parametro_id":"' 	. clear_json($r["parametro_id"]) . '",';
		$json .= '"parametro_nombre":"' . clear_json($r["parametro_nombre"]) . '",';
		$json .= '"min_dato":"' 		. clear_json($r["min_valor"]) . '",';
		$json .= '"med_dato":"' 		. clear_json($r["med_valor"]) . '",';
		$json .= '"max_dato":"' 		. clear_json($r["max_valor"]) . '",';
		$json .= '"url_grafico":"' 		. './get_grafico.php?definir=0' . '"';
		$json .= "},";

		$entered = true;
	}
	
	if($entered) 
	{
		$json = substr($json,0,strlen($json)-1);
	};
	
	$json .= "]";
	
	echo $json;
	
	pg_close($conn);
	
};

function aforo_get_campañas()
{
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string   = "SELECT * FROM mod_sensores.red_aforos_campania ";
	$query_string  .= "ORDER BY anio,mes DESC;";
	
	//echo $query_string;
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = '{"campañas":[';
	
	while ($r = pg_fetch_assoc($query)) 
	{
		
		$json .= '{';
		$json .= '"tab":"Aforo - datos campaña",';
		$json .= '"anio":"' 		. clear_json($r["anio"]) . '",';
		$json .= '"mes":"' 			. clear_json($r["mes"]) . '",';
		$json .= '"cod_temp":"' 	. clear_json($r["cod_temp"]) . '"';
		$json .= "},";

		$entered = true;
	};
	
	if($entered) 
	{
		$json = substr($json,0,strlen($json)-1);
	};
	
	$json .= "],";
	
	$query_string   = "SELECT DISTINCT anio FROM mod_sensores.red_aforos_campania ";
	$query_string  .= "ORDER BY anio DESC;";
	
	//echo $query_string;
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json .= '"años":[';
	
	while ($r = pg_fetch_assoc($query)) 
	{
		
		$json .= '{';
		$json .= '"tab":"Aforo - datos campaña años",';
		$json .= '"anio":"' 		. clear_json($r["anio"]) . '"';
		$json .= "},";

		$entered = true;
	};
	
	if($entered) 
	{
		$json = substr($json,0,strlen($json)-1);
	};
	
	$json .= "]}";
	
	echo $json;
	
	pg_close($conn);
	
};


function aforo_get_solapa_datos_campaña($estacion_id,$cod_temp)
{
	// http://observ.net/red_api.php?estacion_id=14&cod_temp=1810&mode=6
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string   = "SELECT * FROM mod_sensores.get_aforo_estacion_datos_campaña($estacion_id::bigint,$cod_temp::bigint); ";
	
	//echo $query_string;
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) 
	{
		
		$json .= '{';
		$json .= '"tab":"Aforo - datos campaña",';
		$json .= '"fecha_campania":"' 				. clear_json($r["fecha_campania"]) . '",';
		$json .= '"altura_rio":"' 					. clear_json($r["altura_rio"]) . '",';
		$json .= '"caudal_liq":"' 					. clear_json($r["caudal_liq"]) . '",';
		$json .= '"con_med_frac_fina":"' 			. clear_json($r["con_med_frac_fina"]) . '",';
		$json .= '"con_med_frac_gruesa":"' 			. clear_json($r["con_med_frac_gruesa"]) . '",';
		$json .= '"trans_frac_fina":"' 				. clear_json($r["trans_frac_fina"]) . '",';
		$json .= '"trans_frac_gruesa":"' 			. clear_json($r["trans_frac_gruesa"]) . '",';
		$json .= '"link_grafico":"' 				. clear_json($r["path_grafico"]) . '",'; 
		$json .= '"link_informe_campaña":"' 		. clear_json($r["path_informe_campaña"]) . '",';
		$json .= '"link_audio_visual":"' 			. clear_json($r["link_registro_audiovisual"]) . '"';
		$json .= "},";

		$entered = true;
	}
	
	if($entered) 
	{
		$json = substr($json,0,strlen($json)-1);
	};
	
	$json .= "]";
	
	echo $json;
	
	pg_close($conn);
	
};


function aforo_get_solapa_hq($estacion_id)
{
	//http://observ.net/red_api.php?estacion_id=14&cod_temp=1810&mode=6
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string   = "SELECT * FROM mod_sensores.aforos_hq WHERE estacion_id::bigint=$estacion_id; ";
	
	//echo $query_string;
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) 
	{
		
		$json .= '{';
		$json .= '"tab":"Aforo - curva hq",';
		$json .= '"cero_escala":"' 					. clear_json($r["cero_escala"]) . '",';
		$json .= '"cero_escala_unidad":"' 			. clear_json($r["unidad_cero"]) . '",';
		$json .= '"q_path":"' 						. clear_json($r["q_path"]) . '"';
		$json .= "},";

		$entered = true;
	}
	
	if($entered) 
	{
		$json = substr($json,0,strlen($json)-1);
	};
	
	$json .= "]";
	
	echo $json;
	
	pg_close($conn);
	
};

function aforo_get_solapa_datos_fechas($estacion_id,$parametro_id,$fd,$fh)
{
	//http://observ.net/red_api.php?estacion_id=14&parametro_id=28&fd=01/01/2020&fh=31/12/2020&mode=8
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string   = "SELECT * FROM mod_sensores.get_estacion_aforo_datos_fechas($estacion_id::bigint,$parametro_id::bigint,'$fd'::timestamp with time zone,'$fh'::timestamp with time zone) ";
	$query_string  .= "ORDER BY parametro_nombre ASC;";
	
	//echo $query_string;
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) 
	{
		
		$json .= '{';
		$json .= '"tab":"Aforo - consultar datos fechas",';
		$json .= '"estacion_id":"' 		. clear_json($r["estacion_id"]) . '",';
		$json .= '"parametro_id":"' 	. clear_json($r["parametro_id"]) . '",';
		$json .= '"parametro_nombre":"' . clear_json($r["parametro_nombre"]) . '",';
		$json .= '"min_dato":"' 		. clear_json($r["min_valor"]) . '",';
		$json .= '"med_dato":"' 		. clear_json($r["med_valor"]) . '",';
		$json .= '"max_dato":"' 		. clear_json($r["max_valor"]) . '",';
		$json .= '"url_grafico":"' 		. './get_grafico.php?definir=0' . '"';
		$json .= "},";

		$entered = true;
	}
	
	if($entered) 
	{
		$json = substr($json,0,strlen($json)-1);
	};
	
	$json .= "]";
	
	echo $json;
	
	pg_close($conn);
	
};




function aforo_get_estacion_parametros($estacion_id)
{
	global $id_usuario;
	//http://observ.net/red_api.php?estacion_id=14&mode=9
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string    = "SELECT parametro_id,parametro_desc||parametro_unidad AS parametro ";
	$query_string   .= " FROM mod_sensores.vw_red_monitoreo ";
	$query_string   .= " WHERE estacion_id=$estacion_id ";
	
	
	
	if($id_usuario==-1)/* Si no esta logeado */
	{
		$query_string   .= " AND parametro_id NOT IN(1,2,3) "; /* Ninguna Bateria*/
	};
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) 
	{
		
		$json .= '{';
		$json .= '"parametro_id":"' 		. clear_json($r["parametro_id"]) . '",';
		$json .= '"parametro_nombre":"' 	. clear_json($r["parametro"]) . '"';
		$json .= "},";

		$entered = true;
	}
	
	if($entered) 
	{
		$json = substr($json,0,strlen($json)-1);
	};
	
	$json .= "]";
	
	echo $json;
	
	pg_close($conn);
	
};



function get_estaciones($tipo_estaciones)/* Si son hidrometricas o de aforo */
{
	//http://observ.net/red_api.php?tipo_estaciones=0&mode=10
	//http://observ.net/red_api.php?tipo_estaciones=1&mode=10
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	if($tipo_estaciones=='1')/* AFORO */
	{
		$query_string    = "SELECT DISTINCT estacion_id,estacion_nombre ";
		$query_string   .= " FROM mod_sensores.vw_red_monitoreo ";
		$query_string   .= " WHERE tipo_estacion_desc='Aforo';";
		
		$tipo_est = 'Aforo';
	}
	else /* HIDRO */
	{
		$query_string    = "SELECT DISTINCT estacion_id,estacion_nombre ";
		$query_string   .= " FROM mod_sensores.vw_red_monitoreo ";
		$query_string   .= " WHERE tipo_estacion_desc<>'Aforo';";
		
		$tipo_est = 'Hidro';
	};
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) 
	{
		
		$json .= '{';
		$json .= '"estacion_id":"' 		. clear_json($r["estacion_id"]) . '",';
		$json .= '"estacion_nombre":"' 	. clear_json($r["estacion_nombre"]) . '",';
		$json .= '"tipo":"' 			. $tipo_est . '"';
		$json .= "},";

		$entered = true;
	}
	
	if($entered) 
	{
		$json = substr($json,0,strlen($json)-1);
	};
	
	$json .= "]";
	
	echo $json;
	
	pg_close($conn);
	
};


function get_parametros($tipo_estaciones)/* Si son hidrometricas o de aforo */
{
	//http://observ.net/red_api.php?tipo_estaciones=0&mode=13
	//http://observ.net/red_api.php?tipo_estaciones=1&mode=13
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	if($tipo_estaciones=='1')/* AFORO */
	{
		$query_string    = "SELECT DISTINCT parametro_id,parametro_desc ";
		$query_string   .= " FROM mod_sensores.vw_red_monitoreo ";
		$query_string   .= " WHERE tipo_estacion_desc='Aforo' ";
		
		$tipo_est = 'Aforo';
	}
	else /* HIDRO */
	{
		$query_string    = "SELECT DISTINCT parametro_id,parametro_desc ";
		$query_string   .= " FROM mod_sensores.vw_red_monitoreo ";
		$query_string   .= " WHERE tipo_estacion_desc<>'Aforo' ";
		
		$tipo_est = 'Hidro';
	};
	
	global $id_usuario;
	
	if($id_usuario==-1)/* Si no esta logeado */
	{
		$query_string   .= " AND parametro_id NOT IN(1,2,3) "; /* Ninguna Bateria*/
	};
	
	$query_string   .= " ORDER BY parametro_desc ASC;";
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) 
	{
		
		$json .= '{';
		$json .= '"parametro_id":"' 		. clear_json($r["parametro_id"]) . '",';
		$json .= '"parametro_desc":"' 	. clear_json($r["parametro_desc"]) . '",';
		$json .= '"tipo":"' 			. $tipo_est . '"';
		$json .= "},";

		$entered = true;
	}
	
	if($entered) 
	{
		$json = substr($json,0,strlen($json)-1);
	};
	
	$json .= "]";
	
	echo $json;
	
	pg_close($conn);
	
};



function get_parametro_datos($lista_estaciones,$parametro_id,$fd,$fh)
{
	//http://observ.net/red_api.php?lista_estaciones=3,4&parametro_id=25&fd=01/01/2020&fh=31/12/2020&mode=11
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);

	$query_string    = "SELECT * ";
	$query_string   .= " FROM mod_sensores.get_parametro_datos('$lista_estaciones'::text,$parametro_id::bigint,'$fd'::timestamp with time zone,'$fh'::timestamp with time zone) ";
	$query_string   .= " ORDER BY estacion_nombre ASC;";
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) 
	{
		
		$json .= '{';
		$json .= '"estacion_id":"' 		. clear_json($r["estacion_id"]) . '",';
		$json .= '"estacion_nombre":"' 	. clear_json($r["estacion_nombre"]) . '",';
		$json .= '"min_dato":"' 		. clear_json($r["min_dato"]) . '",';
		$json .= '"med_dato":"' 		. clear_json($r["med_dato"]) . '",';
		$json .= '"max_dato":"' 		. clear_json($r["max_dato"]) . '"';
		$json .= "},";

		$entered = true;
	}
	
	if($entered) 
	{
		$json = substr($json,0,strlen($json)-1);
	};
	
	$json .= "]";
	
	echo $json;
	
	pg_close($conn);
	
};

function get_estacion_parametro_grafico_30_dias($estacion_id,$tipo_categoria_parametro_id,$parametro_id)
{
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string   = "SELECT * FROM mod_sensores.get_estacion_parametro_grafico_30_dias($estacion_id,$tipo_categoria_parametro_id,$parametro_id,30) ";
	$query_string  .= "ORDER BY fecha ASC;";

	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) 
	{
		
		$json .= '{';
		$json .= '"tab":"Hidro - datos graficos ultimos 30 dias",';
		$json .= '"estacion_id":"' 		. clear_json($r["estacion_id"]) . '",';
		$json .= '"estacion_tipo":"' 	. clear_json($r["estacion_tipo"]) . '",';
		$json .= '"parametro_id":"' 	. clear_json($r["parametro_id"]) . '",';
		$json .= '"parametro_nombre":"' . clear_json($r["parametro_nombre"]) . '",';
		$json .= '"min_dato":"' 		. clear_json($r["min_dato"]) . '",';
		$json .= '"med_dato":"' 		. clear_json($r["med_dato"]) . '",';
		$json .= '"max_dato":"' 		. clear_json($r["max_dato"]) . '",';
		$json .= '"dia":"' 				. clear_json($r["dia"]) . '",';
		$json .= '"fecha":"' 			. clear_json($r["fecha"]) . '"';
		$json .= "},";

		$entered = true;
	}
	
	if($entered) 
	{
		$json = substr($json,0,strlen($json)-1);
	};
	
	$json .= "]";
	
	echo $json;
	
	pg_close($conn);
	
};




function hidro_popup4_links($estacion_id)
{
	//http://observ.net/red_api.php?estacion_id=7&categoria_parametro_id=4&parametro_id=5&fd=01/01/2020&fh=31/12/2020&mode=4
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	$query_string   = "SELECT * FROM mod_sensores.popup4_hidro_links WHERE estacion_id::bigint=$estacion_id ";
	$query_string  .= "ORDER BY tipo_id,tipo_desc,link_titulo ASC;";
	
	//echo $query_string;
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) 
	{
		
		$json .= '{';
		$json .= '"tab":"Hidro - popup4 links",';
		$json .= '"estacion_id":"' 		. clear_json($r["estacion_id"]) . '",';
		$json .= '"categoria_parametro_id":"' 	. clear_json($r["categoria_parametro_id"]) . '",';
		$json .= '"link":"' 			. clear_json($r["link"]) . '",';
		$json .= '"link_titulo":"' 		. clear_json($r["link_titulo"]) . '",';
		$json .= '"tipo_id":"' 			. clear_json($r["tipo_id"]) . '",';
		$json .= '"tipo_desc":"' 		. clear_json($r["tipo_desc"]) . '"';
		$json .= "},";

		$entered = true;
	}
	
	if($entered) 
	{
		$json = substr($json,0,strlen($json)-1);
	};
	
	$json .= "]";
	
	echo $json;
	
	pg_close($conn);
	
};


function get_estaciones_segun_parametro($tipo_estaciones,$parametro_id)/* Si son hidrometricas o de aforo */
{
	//http://observ.net/red_api.php?tipo_estaciones=1&mode=15&parametro_id=34
	//http://observ.net/red_api.php?tipo_estaciones=0&mode=15&parametro_id=24
	
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	
	if($tipo_estaciones=='1')/* AFORO */
	{
		$query_string    = "SELECT DISTINCT estacion_id,estacion_nombre ";
		$query_string   .= " FROM mod_sensores.vw_red_monitoreo ";
		$query_string   .= " WHERE tipo_estacion_desc='Aforo' AND parametro_id=$parametro_id;";
		
		$tipo_est = 'Aforo';
	}
	else /* HIDRO */
	{
		$query_string    = "SELECT DISTINCT estacion_id,estacion_nombre ";
		$query_string   .= " FROM mod_sensores.vw_red_monitoreo ";
		$query_string   .= " WHERE tipo_estacion_desc<>'Aforo' AND parametro_id=$parametro_id;";
		
		$tipo_est = 'Hidro';
	};
	
	$query = pg_query($conn,$query_string);
	
	$entered = false;
	
	$json = "[";
	
	while ($r = pg_fetch_assoc($query)) 
	{
		
		$json .= '{';
		$json .= '"estacion_id":"' 		. clear_json($r["estacion_id"]) . '",';
		$json .= '"estacion_nombre":"' 	. clear_json($r["estacion_nombre"]) . '",';
		$json .= '"tipo":"' 			. $tipo_est . '"';
		$json .= "},";

		$entered = true;
	}
	
	if($entered) 
	{
		$json = substr($json,0,strlen($json)-1);
	};
	
	$json .= "]";
	
	echo $json;
	
	pg_close($conn);
	
};

?>
