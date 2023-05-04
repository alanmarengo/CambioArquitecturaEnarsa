<?php

//include("../pgconfig.php");
//include("../login.php");

require_once(dirname(__FILE__,2).'/MICROSERVICIOS/MIC-GEOVISOR/CAPA-APLICACION/SERVICIOS/REPOSITORIO-SERVICIO.php');
require_once(dirname(__FILE__,2).'/MICROSERVICIOS/MIC-USUARIO/CAPA-APLICACION/SERVICIO/REPOSITORIO-SERVICIO.php');


if ((isset($_SESSION)) && (sizeof($_SESSION) > 0))
{
	$user_id = $_SESSION["user_info"]["user_id"];
}else $user_id = -1;
$geovid = $_POST["geovid"];

$servicio_geovisor = new RepositorioServicioGeovisor();
$servicio_usuario = new RepositorioServicioUsuario();


//$geovid = $_GET["geovid"];

//$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
//$conn = pg_connect($string_conn);

$query_string = 'SELECT * FROM "MIC-GEOVISORES".geovisor WHERE geovisor_id = ' . $geovid;

$data = $servicio_geovisor->get_consulta($query_string);


//$data = pg_fetch_assoc(pg_query($conn,$query_string));

$geoext = str_replace(array("[","]"),array("",""),$data[0]["geovisor_extent"]);

$geoext = explode(",",$geoext);

$json = "{";
$json .= "\"geovisor_id\":$geovid,";
$json .= "\"geovisor_desc\":\"" . $data[0]["geovisor_desc"] . "\",";
$json .= "\"geovisor_extent\":[" . $data[0]["geovisor_extent"] . "],";
$json .= "\"geovisor_extent_string\":\"" . $data[0]["geovisor_extent"] . "\",";
$json .= "\"minx\":\"" . $geoext[0] . "\",";
$json .= "\"maxx\":\"" . $geoext[1] . "\",";
$json .= "\"miny\":\"" . $geoext[2] . "\",";
$json .= "\"maxy\":\"" . $geoext[3] . "\",";
$json .= "\"data\":[";


// operatoria de lista de recursos restringidos 

$lista_recursos_restringidos = array(); 

if($user_id!=-1){
	$lista_recursos_restringidos = $servicio_usuario->get_recursos_restringidos_user($user_id);
}else{
	$lista_recursos_restringidos = $servicio_usuario->get_recursos_restringidos();
}

$extension_registros_restringidos = "  NOT IN ( " ; 

    // armo una cadena para usar como subconsulta en la query principal 
    for($x=0; $x<=count($lista_recursos_restringidos->detalle)-1; $x++)
    {       
       if($x==count($lista_recursos_restringidos->detalle)-1){
           
           $extension_registros_restringidos.=$lista_recursos_restringidos->detalle[$x]['objeto_id'].")";
       }else{
           $extension_registros_restringidos.=$lista_recursos_restringidos->detalle[$x]['objeto_id'].",";
       }       
    }

$query_string2 = 'SELECT * FROM "MIC-GEOVISORES".geovisor_capa_inicial CI WHERE CI.geovisor_id = '. $geovid ." AND CI.layer_id $extension_registros_restringidos;";

//$query2 = pg_query($conn,$query_string2);

//echo $query_string2; 

$query2 = $servicio_geovisor->get_consulta($query_string2);

foreach ($query2 as $r) {
	
	$json .= "{";
	$json .= "\"layer_id\":" . $r["layer_id"] . ",";
	$json .= "\"iniciar_visible\":\"" . $r["iniciar_visible"] . "\",";
	$json .= "\"iniciar_panel\":\"" . $r["iniciar_panel"] . "\"";
	$json .= "},";
	
}

$json = substr($json,0,strlen($json)-1);

$json .= "]}";

echo $json;

?>