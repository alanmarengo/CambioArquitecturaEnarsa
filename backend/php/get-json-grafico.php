<?php

	include("../pgconfig.php");

	$grafico_id = $_REQUEST["grafico_id"];

	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
		
	$conn = pg_connect($string_conn);
	$query_string = "SELECT * FROM sinia_graficos.grafico WHERE grafico_id = " . $_GET["grafico_id"];
	
	$query_grafico = pg_query($conn,$query_string);
	$data = pg_fetch_assoc($query_grafico);
	
	$g_tipo = $data["tipo_grafico_id"];
	$g_titulo = $data["grafico_titulo"];
	$g_desc = $data["grafico_desc"];
	$g_data_schema = $data["grafico_schema"];
	$g_data_tabla = $data["grafico_tabla"];
	
	//$query_grafico_data_string = "SELECT * FROM \"" . $g_data_schema . "\".\"" . $g_data_tabla . "\"";
	$query_grafico_data_string = "SELECT * FROM sinia_graficos.get_grafico_datos($grafico_id);";
	
	$query_grafico_data = pg_query($conn,$query_grafico_data_string);
	
	$sector = "-1";
	$labels = array();
	$sectorArr = array();
	$seriesArr = array();
	$curInd = -1;
	$unidad = "";
	
	while ($s = pg_fetch_assoc($query_grafico_data)) {
		
		$unidad = $s["unidad"];
		
		if ($sector != $s["sector"]) {
			
			$curInd++;
			
			$labels[$curInd] = $s["etiqueta"];
			$sectorArr[$curInd] = $s["sector"];
			$seriesArr[$curInd] = array();
			
			$sector = $s["sector"];
			
		}
		
		array_push($seriesArr[$curInd],$s["valor"]);
		
	}
	
	$data_string = "";
	
	for ($i=0; $i<sizeof($sectorArr); $i++) {
		
		$data_string .= "{";
		$data_string .= "\"name\":\"" . $sectorArr[$i] . "\",";
	
		if(sizeof($seriesArr[$i]) > 1) {
			
			$data_string .= "\"data\":[" . implode(",",$seriesArr[$i]) . "]";
			
		}else{
			
			$data_string .= "\"y\":" . implode(",",$seriesArr[$i]);
			
		}
		
		$data_string .= "},";
	
	}
	
	$data_string = substr($data_string,0,strlen($data_string)-1);		
	
	$data_out = "{";
	$data_out .= "\"type\":\"grafico\",";
	$data_out .= "\"ind_titulo\":\"" . $titulo_ind . "\",";
	$data_out .= "\"ind_desc\":\"" . $desc_ind . "\",";
	$data_out .= "\"grafico_id\":" . $data["grafico_id"] . ",";
	$data_out .= "\"grafico_tipo_id\":" . $data["tipo_grafico_id"] . ",";
	$data_out .= "\"titulo\":\"" . $g_titulo . "\",";
	$data_out .= "\"desc\":\"" . $g_desc . "\",";
	$data_out .= "\"unidad\":\"" . $unidad . "\",";
	$data_out .= "\"etiquetas\":[\"" . implode("\",\"",$labels) . "\"],";
	$data_out .= "\"data\":[" . $data_string . "]";
	$data_out .= "}";
	
	echo $data_out;
	
?>
