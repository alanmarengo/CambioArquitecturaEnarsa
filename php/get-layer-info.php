<?php

include("../pgconfig.php");
include("../tools.php");

$results = $_POST["results"];

$layer_names = array();
$layer_desc = array();
$estudios_id = array();
$gids = array();

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

for ($i=0; $i<sizeof($results); $i++) {
	
	$sep = explode(";",$results[$i]);
	
	$qs_name = "SELECT layer_desc,cod_oficial FROM mod_geovisores.vw_layers WHERE layer_wms_layer = '" . $sep[0] . "' LIMIT 1";
	$qs_query = pg_query($conn,$qs_name);
	$qs_name_data = pg_fetch_assoc($qs_query);
	$layer_d = $qs_name_data["layer_desc"];
	$cod_oficial = $qs_name_data["cod_oficial"];
	
	array_push($layer_desc,$layer_d);
	array_push($layer_names,$sep[0]);
	array_push($estudios_id,$cod_oficial);
	
	if (!$gids[$sep[0]]) {
		
		$gids[$sep[0]] = array();
		
	}
	
	array_push($gids[$sep[0]],$sep[1]);
	
}

$layer_names = array_unique($layer_names);

$layer_names = array_values($layer_names);

$html = "";

for ($i=0; $i<sizeof($layer_names); $i++) {
	
	$query_string = "SELECT DISTINCT layer_id,layer_metadata_url,layer_schema,layer_table FROM mod_geovisores.vw_layers WHERE layer_wms_layer = '" . $layer_names[$i] . "' LIMIT 1";
	
	$query = pg_query($conn,$query_string);

	$data = pg_fetch_assoc($query);

	$layer_id = $data["layer_id"];
	$schema = $data["layer_schema"];
	$table= $data["layer_table"];
	
	$query_string2 = "SELECT * FROM \"$schema\".\"$table\" WHERE id IN (" . implode(",",$gids[$layer_names[$i]]) . ")";
	
	$query2 = pg_query($conn,$query_string2);
	
	$query_count = pg_num_rows($query2);
	
	$metadata_url = $data["metadata_url"];
	$target = " target=\"_blank\"";
					
	if ($metadata_url == "") {
						
		$metadata_url = "javascript:alert('Esta capa no posee metadatos asociados');";
		$target = "";
						
	}
	
	$html .= "<div class=\"popup-layer-node jus-between\" data-state=\"0\">";
		$html .= "<div class=\"popup-layer-node-icons ml-15\">";
			$html .= "<div class=\"layer-icon\" title=\"Ver/Ocultar\">";
				$html .= "<a href=\"#\" onclick=\"geomap.map.togglePopupLayers(this)\"><img src=\"./images/geovisor/icons/popup-layer-closed.png\" data-inactive=\"./images/geovisor/icons/popup-layer-closed.png\"
				data-active=\"./images/geovisor/icons/popup-layer-opened.png\"></a>";
			$html .= "</div>";
		$html .= "</div>";
		$html .= "<a href=\"#\" class=\"layer-label\" style=\"cursor:text\" alt=\"" . $layer_desc[$i] . "\">" . $layer_desc[$i] . "</a>";
		$html .= "<div class=\"popup-layer-node-icons\">";
			/*$html .= "<div class=\"layer-icon\">";
				$html .= "<a href=\"" . $metadata_url . "\"" . $target . "><img src=\"./images/geovisor/icons/popup-layer-info-inactive.png\" data-inactive=\"./images/geovisor/icons/popup-layer-info-inactive.png\"
				data-active=\"./images/geovisor/icons/popup-layer-info-active.png\"></a>";
			$html .= "</div>";*/
			$html .= "<div class=\"layer-icon\" title=\"Descargar datos en CSV\">";
				$html .= "<a href=\"./csv.php?q=".encrypt(str_replace("geom,","",$query_string2))."\"><img src=\"./images/geovisor/icons/popup-layer-download-inactive.png\" data-inactive=\"./images/geovisor/icons/popup-layer-download-inactive.png\"
				data-active=\"./images/geovisor/icons/popup-layer-download-active.png\"></a>";
			$html .= "</div>";
			$html .= "<div class=\"layer-icon\" title=\"Ver Recursos Asociados\">";
				$html .= "<a href=\"./mediateca.php?mode=10&mode_id=".$layer_id."&solapa=0&o=0\" target=\"_blank\"><img src=\"./images/geovisor/icons/popup-layer-recurso-inactive.png\" data-inactive=\"./images/geovisor/icons/popup-layer-recurso-inactive.png\"
				data-active=\"./images/geovisor/icons/popup-layer-recurso-active.png\"></a>";
				/*&mode_label=".$layer_desc[$i]."*/
				/*$html .= "<a href=\"./mediateca.php?mode=-1&solapa=0&o=0&s=".$estudios_id[$i]."\" target=\"_blank\"><img src=\"./images/geovisor/icons/popup-layer-recurso-inactive.png\" data-inactive=\"./images/geovisor/icons/popup-layer-recurso-inactive.png\"
				data-active=\"./images/geovisor/icons/popup-layer-recurso-active.png\"></a>";*/
			$html .= "</div>";
		$html .= "</div>";
	$html .= "</div>";

	$html .= "<div style=\"display:none;\" class=\"popup-layer-content\">";	
	
	while($r = pg_fetch_assoc($query2)) {
		
		$html .= "<table class=\"popup-table gfi-info-table\" cellpadding=\"5\">";
		
		$hasData = false;
		
		foreach ($r as $item => $value){
			
			if(( strpos( $item, "geom" ) === false) && ( $item != "id" ) && (strpos( $item, "cod_" ) === false) && ( $item != "origen") && ( $item != "fec_bbdd")) {
			
				$html .= "<tr>";
				$html .= "<td>" . str_replace("_"," ",$item) . "</td>";
				$html .= "<td>" . $value . "</td>";
				$html .= "</tr>";
				
				$hasData = true;
			
			}
		
		}
		
		if (!$hasData) {
			
			$html .= "<tr><td><p>Este registro no posee columnas habilitadas para mostrar.</p></td></tr>";
			
		}
	
		$html .= "</table>";
		$html .= "<hr>";
		
	}
	
	$html .= "</div>";

}

echo $html;

?>