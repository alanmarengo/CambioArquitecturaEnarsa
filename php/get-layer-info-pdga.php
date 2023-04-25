<?php

require_once(dirname(__FILE__,2).'/MICROSERVICIOS/MIC-GEOVISOR/CAPA-APLICACION/SERVICIOS/REPOSITORIO-SERVICIO.php');

//include("../pgconfig.php");
include("../tools.php");

// $results = $_POST["results"];

$layer_id_arr = array();
$layer_desc_arr = array();

//$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
//$conn = pg_connect($string_conn);
/*
for ($i=0; $i<sizeof($results); $i++) {
	
	$sep = explode(";",$results[$i]);
	
	$qs_name = "SELECT layer_id,layer_desc FROM mod_geovisores.vw_layers WHERE trim(layer_wms_layer) = '" . trim($sep[0]) . "' LIMIT 1";
	$qs_query = pg_query($conn,$qs_name);
	$qs_name_data = pg_fetch_assoc($qs_query);
	$layer_id = $qs_name_data["layer_id"];
	$layer_desc = $qs_name_data["layer_desc"];
	
	array_push($layer_id_arr,$layer_id);
	array_push($layer_desc_arr,$layer_desc);
	
}*/

$layer_id_arr = array(873,937,938,939,875);
$layer_title_arr = array(
	"Provincia Santa Cruz",
	"Subcuenca Alta Del Río Santa Cruz",
	"Subcuenca Media Y Baja Del Río Santa Cruz",
	"Estuario Río Santa Cruz",
	"Áreas De Obra De Los Aprovechamientos Hidroeléctricos Del Río Santa Cruz"
);

//$layer_id_arr = array_values($layer_id_arr);

$html = "";

for ($i=0; $i<sizeof($layer_id_arr); $i++) {
	
	$query_string = 'SELECT DISTINCT layer_id,layer_desc FROM "MIC-GEOVISORES".vw_layers WHERE layer_id = '. $layer_id_arr[$i]. ' LIMIT 1;';
	
	//$query = pg_query($conn,$query_string);

	//$data = pg_fetch_assoc($query);

	$servicio_geovisor = new RepositorioServicioGeovisor();

	$data = $servicio_geovisor->get_consulta($query_string);


	$layer_id = $data[0]["layer_id"];
	$layer_desc = $data[0]["layer_desc"];
	
	$query_string2 = "SELECT * FROM mic_catalogo_fdw.vw_visor_pg_programas WHERE layer_id = " . $layer_id . " ORDER BY programa ASC";
	
	// $query2 = pg_query($conn,$query_string2);
	
	// $query_count = pg_num_rows($query2);

	
	$query2 = $servicio_geovisor->get_consulta($query_string2);
	$query_count = count($query2);

	$metadata_url = "";
	
	if(isset($data["metadata_url"]))
	{
		$metadata_url = $data["metadata_url"];
	}
	
	$target = " target=\"_blank\"";
					
	if ($metadata_url == "") {
						
		$metadata_url = "javascript:alert('Esta capa no posee metadatos asociados');";
		$target = "";
						
	}
	
	$html .= "<div class=\"popup-layer-node jus-between\" data-state=\"0\" data-layer=\"".$layer_id."\" data-index=\"".$i."\">";
		$html .= "<div class=\"popup-layer-node-icons ml-15\">";
			$html .= "<div class=\"layer-icon\" title=\"Ver/Ocultar\">";
				$html .= "<a href=\"javascript:void(0);\" onclick=\"geomap.map.togglePopupLayers(this);\"><img src=\"./images/geovisor/icons/popup-layer-closed.png\" data-inactive=\"./images/geovisor/icons/popup-layer-closed.png\"
				data-active=\"./images/geovisor/icons/popup-layer-opened.png\"></a>";
			$html .= "</div>";
		$html .= "</div>";
		$html .= "<a href=\"#\" class=\"layer-label\" style=\"cursor:text\" alt=\"" . $layer_title_arr[$i] . "\">" . $layer_title_arr[$i] . "</a>";
	$html .= "</div>";
	
	$html .= "<div style=\"display:none;\" class=\"popup-layer-content\">";	
		
		$html .= "<table class=\"popup-table gfi-info-table\" cellpadding=\"5\">";
				
			$html .= "<tr>";
			$html .= "<th>Programas Asociados</th>";
			$html .= "</tr>";
	

			foreach($query2 as $programa)
			{
				$html .= "<tr>";
				$html .= "<td>" . $programa["programa"] . "</td>";
				$html .= "</tr>";
				
			}

				/*
			while($r = pg_fetch_assoc($query2)) {
					
				$html .= "<tr>";
				$html .= "<td>" . $r["programa"] . "</td>";
				$html .= "</tr>";
				
			} */
	
		$html .= "</table>";
	$html .= "</div>";

}

echo $html;

?>