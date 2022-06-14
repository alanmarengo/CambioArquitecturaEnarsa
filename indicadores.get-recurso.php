<?php

include("./pgconfig.php");

$ind_id = $_POST["ind_id"];
$pos = $_POST["pos"];

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$query_string = "SELECT *,(select extent from mod_indicadores.ind_capa where ind_id=$ind_id and posicion=$pos limit 1)as ext FROM mod_indicadores.vw_recursos WHERE ind_id = $ind_id AND posicion = $pos";
//$query_string = "SELECT * FROM mod_indicadores.vw_recursos WHERE ind_id = 1 AND posicion = 1";

$query = pg_query($conn,$query_string);

$layer_id = array();
$layer_name = array();
$layer_server = array();
$layer_extent = '';/*Fix*/

$sliderItem = array();
$sliderId = null;
$tabla_fuente = null;

$type = "noresource";

while($r = pg_fetch_assoc($query)) {
	
	$titulo_ind = $r["titulo"];
	$desc_ind = $r["desc"];
	
	switch($r["resource_type"]) {
		
		case "capa":
		$type = "capa";
		array_push($layer_id,$r["resource_id"]);
		array_push($layer_name,$r["layer_name"]);
		array_push($layer_server,$r["layer_server"]);
		$layer_extent = $r["ext"]; /*Fix*/
		break;
		
		case "tabla":
		$type = "tabla";
		$tabla_fuente = $r["tabla_fuente"]; 
		$query_string = "SELECT * FROM " . $r["tabla_fuente"];
		$query_tabla = pg_query($conn,$query_string);
/* 		while($row=pg_fetch_assoc($query_tabla)){
			$tabla_id = $row['ind_tabla_id'];
        } */
/* 		$query_string2 = "SELECT * FROM mod_indicadores.ind_tabla WHERE mod_indicadores.ind_tabla.ind_tabla_fuente = '$tabla_fuente'";
		$result2 = pg_query($conn, $query_string2);
        while($row=pg_fetch_assoc($result2)){
			$tabla_fuente = $row['ind_tabla_id'];
        } */

		$firstCur = true;
		$columns = array();
		$data = "";
		
		while($s = pg_fetch_assoc($query_tabla)) {

			if ($firstCur) {

				foreach($s as $colname => $val) {

					if (strpos($colname,"geom") === false) {

						array_push($columns,$colname);

					}

				}

			}
			
			$data .= "[";
			
			foreach($s as $colname => $val) {
				
				if (strpos($colname,"geom") === false) {
				
					$data .= "\"" . $s[$colname] . "\",";
				
				}
				
			}
			
			$data = substr($data,0,strlen($data)-1);
			$data .= "],";
			
			$firstCur = false;
			
		}
		
		$data = substr($data,0,strlen($data)-1);		
		
		break;
		
		case "grafico":	
		$type = "grafico";
		
		$query_string = "SELECT * FROM mod_graficos.grafico WHERE grafico_id = " . $r["resource_id"];
		$query_grafico = pg_query($conn,$query_string);
		$data = pg_fetch_assoc($query_grafico);
		

        $query_color="SELECT * FROM mod_graficos.grafico_color where grafico_id= " . $r["resource_id"];
		$query_color_AUX="SELECT row_to_json(T)::text AS r FROM($query_color)T ";
		$RESULT_COLOR=pg_query($conn,$query_color_AUX);
	
        $query_sector_visibilidad="SELECT * FROM mod_graficos.grafico_sector_visibilidad where grafico_id= " . $r["resource_id"];
		$query_sector_AUX="SELECT row_to_json(T)::text AS r FROM($query_sector_visibilidad)T ";
		$RESULT_SECTOR=pg_query($conn,$query_sector_AUX);
      
		$RecordList=array();
		while($row_color=pg_fetch_row($RESULT_COLOR)){
			$objeto= json_decode($row_color[0]);
			array_push($RecordList,$objeto);
		}

		$RecordListSector=array();
		while($row_sector=pg_fetch_row($RESULT_SECTOR)){
			$objeto= json_decode($row_sector[0]);
			array_push($RecordListSector,$objeto);
		}

 



		$g_tipo = $data["grafico_tipo"];
		$g_titulo = $data["grafico_titulo"];
		$g_desc = $data["grafico_desc"];
		$g_data_schema = $data["grafico_data_schema"];
		$g_data_tabla = $data["grafico_data_tabla"];		
		switch ($g_data_tabla) {

			case "scatter":

				$scatter = true;
				
				$query_grafico_data_string = "SELECT * FROM \"" . $g_data_schema . "\".\"" . $g_data_tabla . "\"";
				$query_grafico_data = pg_query($conn,$query_grafico_data_string);
				
				$axis = array();
				$values = array();
				$type = array();
				$color = array();

				$valtext = "[[";

				$first = true;

				while ($s = pg_fetch_assoc($query_grafico_data)) {

					if ($first) { $val = $s["type"]; }
					
					array_push($axis,$s["axis"]);
					//array_push($values,"[" . $s["values"] . "]");
					array_push($type,$s["type"]);
					array_push($color,$s["color"]);

					$valtext .= "[" . $s["values"] . "],";

					if ($val != $s["type"]) {

						$valtext = substr($valtext,0,strlen($valtext)-1);

						$valtext .= "],[";

						$val = $s["type"];

					}

					$first = false;

				}

				$valtext = substr($valtext,0,strlen($valtext)-1);

				$valtext .= "]]";

				$axis = explode(",",$axis[0]);
				$axis = array_unique($axis);
				
				$data_out = "{";
				$data_out .= "\"type\":\"grafico\",";
				$data_out .= "\"ind_titulo\":\"" . $titulo_ind . "\",";
				$data_out .= "\"ind_desc\":\"" . $desc_ind . "\",";
				$data_out .= "\"grafico_id\":" . $data["grafico_id"] . ",";
				$data_out .= "\"grafico_tipo_id\":" . $data["grafico_tipo_id"] . ",";
				$data_out .= "\"titulo\":\"" . $g_titulo . "\",";
				$data_out .= "\"desc\":\"" . $g_desc . "\",";
				$data_out .= "\"axis\":[\"" . implode("\",\"",array_unique($axis)) . "\"],";
				$data_out .= "\"color\":[\"" . implode("\",\"",array_unique($color)) . "\"],";
				$data_out .= "\"values\":$valtext,";
				$data_out .= "\"serietype\":[\"" . implode("\",\"",array_unique($type)) . "\"]";
				$data_out .= "}";

				echo $data_out;

			break;

			case 'windbar':

				$query_grafico_data_string = "SELECT * FROM \"" . $g_data_schema . "\".\"" . $g_data_tabla . "\"";
				$query_grafico_data = pg_query($conn,$query_grafico_data_string);

				$intensidad = array();
				$direccion = array();
				$fecha = array();
				//$color = null;
				$first = true;

				while ($s = pg_fetch_assoc($query_grafico_data)) {
					
					array_push($intensidad,$s["viento_intensidad"]);
					array_push($direccion,$s["viento_direccion"]);
					array_push($fecha,$s["fecha"]);
					
					$first = false;

				}

/* 				while($row_color=pg_fetch_row($RESULT_COLOR)){
					$objeto= json_decode($row_color[0]);
					array_push($color,$objeto);
				} */
				
				$colorViento = null;
				$colorGrafico= null;
				
				$iC = 0;
				foreach($RecordList as $RL){
					switch($RL->sector){
						case 'viento':
							$colorViento  = $RL->color;
						break; 						
						case 'grafico': 
							$colorGrafico = $RL->color;
						break;
					}
						
				}


				$data_out = "{";
				$data_out .= "\"type\":\"grafico\",";
				$data_out .= "\"ind_titulo\":\"" . $titulo_ind . "\",";
				//$data_out .= "\"color\":[" . implode(",",$color) . "],";
				$data_out .= "\"color_viento\":\"" . $colorViento . "\",";
				$data_out .= "\"color_grafico\":\"" . $colorGrafico . "\",";
				$data_out .= "\"ind_desc\":\"" . $desc_ind . "\",";
				$data_out .= "\"grafico_id\":" . $data["grafico_id"] . ",";
				$data_out .= "\"grafico_tipo_id\":" . $data["grafico_tipo_id"] . ",";
				$data_out .= "\"titulo\":\"" . $g_titulo . "\",";
				$data_out .= "\"desc\":\"" . $g_desc . "\",";
				$data_out .= "\"intensidad\":[" . implode(",",$intensidad) . "],";
				$data_out .= "\"direccion\":[" . implode(",",$direccion) . "],";
				$data_out .= "\"fecha\":[\"" . implode("\",\"",$fecha) . "\"]";
				$data_out .= "}";


			break;
			
			case 'bubble':

				$query_grafico_data_string = "SELECT * FROM \"" . $g_data_schema . "\".\"" . $g_data_tabla . "\"";
				$query_grafico_data = pg_query($conn,$query_grafico_data_string);

				$etiqueta = array();
				$sector = array();
				$valorArr = array();

				$first = true;

				while ($s = pg_fetch_assoc($query_grafico_data)) {

					if ($first) {

						$etiqueta = $s["etiqueta"];
						$sector = $s["sector"];

					}
					
					array_push($valorArr,$s["valor"]);

					$first = false;

				}
				
				$data_out = "{";
				$data_out .= "\"type\":\"grafico\",";
				$data_out .= "\"ind_titulo\":\"" . $titulo_ind . "\",";
				$data_out .= "\"ind_desc\":\"" . $desc_ind . "\",";
				$data_out .= "\"grafico_id\":" . $data["grafico_id"] . ",";
				$data_out .= "\"grafico_tipo_id\":" . $data["grafico_tipo_id"] . ",";
				$data_out .= "\"titulo\":\"" . $g_titulo . "\",";
				$data_out .= "\"desc\":\"" . $g_desc . "\",";
				$data_out .= "\"unidad\":\"" . $unidad . "\",";
				$data_out .= "\"etiquetas\":" . $etiqueta . ",";
				$data_out .= "\"sector\":\"" . $sector . "\",";
				$data_out .= "\"valor\":[" . implode(",",$valorArr) . "]";
				$data_out .= "}";

			break;
			
			default:
				
				$query_grafico_data_string = "SELECT * FROM \"" . $g_data_schema . "\".\"" . $g_data_tabla . "\"";
				$query_grafico_data = pg_query($conn,$query_grafico_data_string);
				
				$sector = "-1";
				$labels = array();
				$labelUnique = array();
				$sectorArr = array();
				$seriesArr = array();
				$typeArr = array();
				$unitArr = array();
				$curInd = -1;
				$unidad = "";
				$color=null;
				$visibilidad=true;
				
				while ($s = pg_fetch_assoc($query_grafico_data)) {
					
					$unidad = $s["unidad"];

					array_push($labelUnique,$s["etiqueta"]);
					
					if ($sector != $s["sector"]) {
						
						$curInd++;
						
						$labels[$curInd] = $s["etiqueta"];
						$sectorArr[$curInd] = $s["sector"];
						if (isset($s["unit"])) { $typeArr[$curInd] = $s["type"]; }
						if (isset($s["type"])) { $unitArr[$curInd] = $s["unit"]; }
						$seriesArr[$curInd] = array();
						
						$sector = $s["sector"];
						
					}
					
					//array_push($seriesArr[$curInd],$s["valor"]);
					if($s["valor"]=='')
					{
						$valor_control = 'null';
					}else $valor_control = $s["valor"];
					array_push($seriesArr[$curInd],$valor_control);
					
				}
				
				$data_string = "";
				$string_color = "";
				for ($i=0; $i<sizeof($sectorArr); $i++) {
					foreach($RecordList as $RL){
						if($RL->sector==$sectorArr[$i]){
							$color=$RL->color;						
						}else{
							//$color=null;
						}

						if($color == null){
							$string_color = "";
						}else{
							$string_color = "\"color\":\"" . $color . "\",";
						}
						
					}

					foreach($RecordListSector as $RLS){
						if($RLS->sector==$sectorArr[$i]){
							if($RLS->visible == false){
								$visibilidad=0;
								break;
							}
							$visibilidad=$RLS->visible;
							break;
						}
						
					}
					
					$data_string .= "{";
					$data_string .= "\"name\":\"" . $sectorArr[$i] . "\",";
					$data_string .= $string_color;
					$data_string .= "\"visibilidad_sector\":\"" . $visibilidad . "\",";
					if (isset($typeArr[$i])) { $data_string .= "\"type\":\"" . $typeArr[$i] . "\","; }
					if (isset($unitArr[$i])) { $data_string .= "\"unit\":\"" . $unitArr[$i] . "\","; }
				
					if(sizeof($seriesArr[$i]) > 1) {
						
						$data_string .= "\"data\":[" . implode(",",$seriesArr[$i]) . "]";
						
					}else{
						
						$data_string .= "\"y\":" . implode(",",$seriesArr[$i]);
						
					}
					
					$data_string .= "},";
				
					$color=null;
				}

				$labelUnique = array_unique($labelUnique);
				
				$data_string = substr($data_string,0,strlen($data_string)-1);		
				
				$data_out = "{";
				$data_out .= "\"type\":\"grafico\",";
				$data_out .= "\"ind_titulo\":\"" . $titulo_ind . "\",";
				$data_out .= "\"ind_desc\":\"" . $desc_ind . "\",";
				$data_out .= "\"grafico_id\":" . $data["grafico_id"] . ",";
				$data_out .= "\"grafico_tipo_id\":" . $data["grafico_tipo_id"] . ",";
				$data_out .= "\"titulo\":\"" . $g_titulo . "\",";
				$data_out .= "\"desc\":\"" . $g_desc . "\",";
				$data_out .= "\"unidad\":\"" . $unidad . "\",";
				$data_out .= "\"etiquetas\":[\"" . implode("\",\"",$labels) . "\"],";
				$data_out .= "\"etiquetasUnique\":[\"" . implode("\",\"",$labelUnique) . "\"],";
				$data_out .= "\"data\":[" . $data_string . "]";
				$data_out .= "}";

			break;

		}
		
		break;
		
		case "recurso":	
		$type = "recurso";
		$sliderId = $r["resource_id"];
		array_push($sliderItem,$r["slide_path"]);
		
		break;
		
	}
	
}

$out = "";

switch($type) {
	
	case "capa":
	$out .= "{";
	$out .= "\"type\":\"layer\",";
	$out .= "\"ind_btn\":\"" . $layer_id[0] . "\",";
	$out .= "\"ind_titulo\":\"" . $titulo_ind . "\",";
	$out .= "\"ind_desc\":\"" . $desc_ind . "\",";
	$out .= "\"layers\":[\"".implode("\",\"",$layer_name)."\"],";
	$out .= "\"extent\":\"".$layer_extent."\","; /*FIX Borrar en caso de falla */
	$out .= "\"layers_server\":[\"".implode("\",\"",$layer_server)."\"]";
	$out .= "}";
	break;
	
	case "tabla":
	$out .= "{";
	$out .= "\"type\":\"table\",";
	$out .= "\"ind_btn\":\"" . $tabla_fuente  . "\",";
	$out .= "\"ind_titulo\":\"" . $titulo_ind . "\",";
	$out .= "\"ind_desc\":\"" . $desc_ind . "\",";
	$out .= "\"columns\":[\"". implode("\",\"",$columns)."\"],";
	$out .= "\"data\":[". $data . "]";
	$out .= "}";
	break;
	
	case "grafico":
	if ($scatter) { echo $data_out; }
	$out = $data_out;
	break;
	
	case "recurso":
	$out .= "{";
	$out .= "\"type\":\"slider\",";
	$out .= "\"ind_titulo\":\"" . $titulo_ind . "\",";
	$out .= "\"ind_desc\":\"" . $desc_ind . "\",";
	$out .= "\"recurso_id\":\"" . $sliderId . "\",";
	$out .= "\"images\":[\"".implode("\",\"",$sliderItem)."\"]";
	$out .= "}";
	break;
	
	case "noresource":
	$out .= "{";
	$out .= "\"type\":\"noresource\",";
	$out .= "\"noresource\":true";
	$out .= "}";
	break;
	
}

echo $out;


?>
