<?php

//include("../pgconfig.php");
require_once("./wms_tools.php");

require_once(dirname(__FILE__,2).'/MICROSERVICIOS/MIC-GEOVISOR/CAPA-APLICACION/SERVICIOS/REPOSITORIO-SERVICIO.php');


$_POST['layer_id'] = 919;
$layer_id = $_POST["layer_id"];



//$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
//$conn = pg_connect($string_conn);

$query_string = 'SELECT layer_database,layer_schema,layer_table,layer_wms_layer FROM "MIC-GEOVISORES".vw_layers WHERE layer_id = '. $layer_id . " LIMIT 1;";

//$query = pg_query($conn,$query_string);

//$data = pg_fetch_assoc($query);

$servicio_geovidor_layer_extent = new RepositorioServicioGeovisor();

$data = $servicio_geovidor_layer_extent->get_consulta($query_string);


$query_string2 = "SELECT 
st_xmin(st_expand(st_extent(st_transform(T.geom, 3857)), 200::double precision)::box3d) AS minx,
st_ymin(st_expand(st_extent(st_transform(T.geom, 3857)), 200::double precision)::box3d) AS miny,
st_xmax(st_expand(st_extent(st_transform(T.geom, 3857)), 200::double precision)::box3d) AS maxx,
st_ymax(st_expand(st_extent(st_transform(T.geom, 3857)), 200::double precision)::box3d) AS maxy
FROM ". trim($data[0]["layer_schema"]) . "." . ($data[0]["layer_table"]) . " T";

//echo $query_string2;

//$extent = pg_fetch_assoc(pg_query($conn,$query_string));

$extent = $servicio_geovidor_layer_extent->get_consulta_ahrsc($query_string2);

$json = "";

$json .= "{";
$json .= "\"minx\":\"" . $extent[0]["minx"] . "\",";
$json .= "\"miny\":\"" . $extent[0]["miny"] . "\",";
$json .= "\"maxx\":\"" . $extent[0]["maxx"] . "\",";
$json .= "\"maxy\":\"" . $extent[0]["maxy"] . "\"";
$json .= "}";

if($extent[0]["minx"]=='') //Algo fue mal, intentamos obtener en extent desde el servicio WMS
{
	$json = wms_get_layer_extent(trim($data[0]["layer_wms_layer"]));
};

echo $json;

?>
