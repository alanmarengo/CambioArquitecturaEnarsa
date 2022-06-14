<?php

include("../pgconfig.php");
include("../login.php");
if ((isset($_SESSION)) && (sizeof($_SESSION) > 0))
{
	$user_id = $_SESSION["user_info"]["user_id"];
}else $user_id = -1;
$geovid = $_POST["geovid"];
//$geovid = $_GET["geovid"];

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$query_string = "SELECT * FROM mod_geovisores.geovisor WHERE geovisor_id = " . $geovid;

$data = pg_fetch_assoc(pg_query($conn,$query_string));

$geoext = str_replace(array("[","]"),array("",""),$data["geovisor_extent"]);

$geoext = explode(",",$geoext);

$query_string2 = "SELECT * FROM mod_geovisores.geovisor_capa_inicial CI WHERE CI.geovisor_id = " . $geovid ."AND mod_login.check_permisos_new(0, CI.layer_id, $user_id)";

$query2 = pg_query($conn,$query_string2);

$json = "{";
$json .= "\"geovisor_id\":$geovid,";
$json .= "\"geovisor_desc\":\"" . $data["geovisor_desc"] . "\",";
$json .= "\"geovisor_extent\":[" . $data["geovisor_extent"] . "],";
$json .= "\"geovisor_extent_string\":\"" . $data["geovisor_extent"] . "\",";
$json .= "\"minx\":\"" . $geoext[0] . "\",";
$json .= "\"maxx\":\"" . $geoext[1] . "\",";
$json .= "\"miny\":\"" . $geoext[2] . "\",";
$json .= "\"maxy\":\"" . $geoext[3] . "\",";
$json .= "\"data\":[";

while ($r = pg_fetch_assoc($query2)) {
	
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