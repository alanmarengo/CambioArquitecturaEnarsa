<?php

include("../pgconfig.php");

$layer_id = $_POST["layer_id"];

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$table = $_POST["table"];
$lon = $_POST["lon"];
$lat = $_POST["lat"];

$query_string = "SELECT * FROM $table WHERE ST_Within(geom,ST_SetSRID(ST_Buffer(ST_GeomFromText('POINT($lon $lat)'), 0.9),4326));";

$query = pg_query($conn,$query_string);

$first = true;
$mt = "20px;";

switch($table) {
	
	case "socio.vp_geo_msrco_reunionescomuunidad_pga1":
	
	$title = "Reuniones con la Comunidad";
	$html = "<p style='color:#31cbfd; margin-top:20px; font-weight:700; text-transform:uppercase;'>" . $title . "</p>";

	while ($r = pg_fetch_assoc($query)) {
		
		if (!$first) { $html .= "<hr>"; }
		
		$html .= "<p style=\"margin-top:$mt;\"><strong>Fecha: </strong>" . $r["FECHA"] . "</p>";
		$html .= "<p><strong>Lugar de Encuentro: </strong>" . $r["LUGAR_ENCUENTRO"] . "</p>";
		$html .= "<p><strong>Modalidad: </strong>" . $r["MODALIDAD_ENCUENTRO"] . "</p>";
		$html .= "<p><strong>Temática: </strong>" . $r["TEMATICA_ENCUENTRO"] . "</p>";

		$first = false;
		$mt = "0";
		
	}
	
	break;
	
	case "socio.vp_geo_msrpo_reunionespueblosoriginarios_pga1":
	
	$title = "Pueblos Originarios";
	$html = "<p style='color:#31cbfd; margin-top:20px; font-weight:700; text-transform:uppercase;'>" . $title . "</p>";
	
	while ($r = pg_fetch_assoc($query)) {
		
		if (!$first) { $html .= "<hr>"; }
		
		$html .= "<p style=\"margin-top:$mt;\"><strong>Fecha: </strong>" . $r["FECHA"] . "</p>";
		$html .= "<p><strong>Actividad: </strong>" . $r["ACTIVIDAD"] . "</p>";
		$html .= "<p><strong>Ubicación: </strong>" . $r["UBICACION"] . "</p>";
		$html .= "<p><strong>Cantidad de Asistentes: </strong>" . $r["CANTIDAD_ASISTENTES"] . "</p>";

		$first = false;
		$mt = "0";
		
	}
	
	break;
	
	case "socio.vp_geo_msrco_artinsititicional_pga1":
	
	$title = "Articulaciones Institucionales";
	$html = "<p style='color:#31cbfd; margin-top:20px; font-weight:700; text-transform:uppercase;'>" . $title . "</p>";
	
	while ($r = pg_fetch_assoc($query)) {
		
		if (!$first) { $html .= "<hr>"; }
		
		//$html .= "<p style=\"margin-top:$mt;\"><strong>Fecha: </strong>" . $r["nombre"] . "</p>"; 
		$html .= "<p style=\"margin-top:$mt;\"><strong>Nombre/Institución: </strong>" . $r["nombre"] . "</p>";
		$html .= "<p><strong>Ubicación: </strong>" . $r["loc"] . "</p>";
		//$html .= "<p><strong>Sitio Web: </strong>" . $r["pagweb"] . "</p>";
		$html .= "<p><strong>Descripción: </strong>" . $r["descripcion"] . "</p>";
		$html .= "<p><strong>Función: </strong>" . $r["funcion"] . "</p>";
		//$html .= "<p><strong>Categoría: </strong>" . $r["categ"] . "</p>";
		//$html .= "<p><strong>Subcategoría: </strong>" . $r["subcateg"] . "</p>";

		$first = false;
		$mt = "0";
		
	}	
	
	break;
	
}

if ($first) {
	
	echo "<p>No se registraron datos para el punto clickeado</p>";
	
}else{

	echo $html;

}

?>
