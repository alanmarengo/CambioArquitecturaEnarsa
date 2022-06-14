<?php

include("./pgconfig.php");

$ind_id = $_POST["ind_id"];
$pos = $_POST["pos"];

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$query_string = "SELECT * FROM mod_indicadores.vw_recursos WHERE ind_id = $ind_id AND posicion = $pos LIMIT 1";
//$query_string = "SELECT * FROM mod_indicadores.vw_recursos WHERE ind_id = 1 AND posicion = 1";

$query = pg_query($conn,$query_string);

$data = pg_fetch_assoc($query);

if ((empty($data["desc"])) || (is_null($data["desc"]))) 
{
	
	$desc = "Este indicador no posee una descripción asociada";
	
}
else
{
	
	$desc = $data["desc"];
	
};

//if ((empty(trim($data["ficha_metodo_path"]))) || (is_null(trim($data["ficha_metodo_path"])))) {
	
if ((empty($data["ficha_metodo_path"])) || (is_null($data["ficha_metodo_path"])) ) 
{
	$path = "javascript:alert('Este indicador no posee una ficha asociada');";
	
}
else
{
	
	$path = $data["ficha_metodo_path"];
	
};

//	$desc = $data["desc"];
//	$path = $data["ficha_metodo_path"];

$out = "{";
$out .= "\"titulo\":\"" . $data["titulo"] . "\",";
$out .= "\"desc\":\"" . $desc . "\",";
$out .= "\"ficha_metodo_path\":\"" . $path . "\"";
$out .= "}";

echo $out;

pg_close($conn);

?>
