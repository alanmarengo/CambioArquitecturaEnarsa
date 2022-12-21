<?php

include("../pgconfig.php");
include("../tools.php");

header('Content-Type: application/json');

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$tema_id = false;

if (isset($_GET["tema_id"])) {
	
	$tema_id = $_GET["tema_id"];
	
}

$json = "{\"programas\":[";

$query_string = "SELECT pr.*,";
$query_string .= "(";
	$query_string .= "SELECT string_agg(tema_id::text, ',') ";
	$query_string .= "FROM mod_catalogo.temas_programas tp ";
	$query_string .= "WHERE programa_id = pr.programa_id";
$query_string .= ") AS temas_id";

if ($tema_id) 
{
	//$query_string .= " FROM mod_catalogo.vw_programas_subprogramas pr WHERE programa_id_parent = -1  AND " . $tema_id . " IN (SELECT tema_id FROM mod_catalogo.temas_programas WHERE programa_id = pr.programa_id)";
	$query_string .= " FROM mod_catalogo.vw_programas_subprogramas pr WHERE programa_id_parent = -1  ";
	$query_string .= " AND pr.programa_id IN (";
	$query_string .= " SELECT CASE WHEN programa_id_parent=-1 THEN programa_id ELSE programa_id_parent END AS programa_id_  ";
	$query_string .= " FROM mod_catalogo.vw_programas_subprogramas ";
	$query_string .= " WHERE programa_id IN(SELECT programa_id FROM mod_catalogo.temas_programas WHERE tema_id = $tema_id))";
	
}
else
{
	$query_string .= " FROM mod_catalogo.vw_programas_subprogramas pr WHERE programa_id_parent = -1  ";
}

$query_string .= " ORDER BY programa_id ASC, programa ASC";

$query = pg_query($conn,$query_string);

while($r = pg_fetch_assoc($query)) {		
		
	$tema_json = "";
	
	$temas_id = explode(",",$r["temas_id"]);
	for ($i=0; $i<sizeof($temas_id); $i++) { $temas_id[$i] = trim($temas_id[$i]); }
	
	$query_tema_id_string = "SELECT tema_id,tema_nombre FROM mod_catalogo.temas WHERE tema_id IN('" . implode("','",$temas_id) . "')";
	#$query_tema_id = pg_query($conn,$query_tema_id_string);

//REEMPLACE EL CODIGO COMENTADO MAS ABAJO POR ESTE BLOQUE DE CODIGO
	$result = pg_query($conn,$query_tema_id_string);
	if (!$result) {
//		 $tema_json .= "{";
//                 $tema_json .= "\"id\":0,";
//                 $tema_json .= "\"nombre\":\"\"";
//                 $tema_json .= "},";
	}else{
		$arr = pg_fetch_all($result);
		//$tema_json .= "{ \"Result\": \"OK\"},";
		foreach($arr AS $t){
			$tema_json .= "{";
                	$tema_json .= "\"id\":" . $t["tema_id"] . ",";
                	$tema_json .= "\"nombre\":\"" . $t["tema_nombre"] . "\"";
                	$tema_json .= "},";
		}
	}
//====================================================
//SECTOR COMENTADO DE CODIGO ANTERIOR NO FUNCIONA EN PHP 8
/*	while($t=pg_fetch_row($result[0])){
		$tema_json .= "{";
		$tema_json .= "\"id\":" . $t["tema_id"] . ",";
		$tema_json .= "\"nombre\":\"" . $t["tema_nombre"] . "\"";
		$tema_json .= "},";		
	}
*/
//==================================
	$tema_json = substr($tema_json,0,strlen($tema_json)-1);
		
	$json .= "{";
	$json .= "\"programa_id\":\"" . $r["programa_id"] . "\",";
	$json .= "\"id\":\"" . $r["id"] . "\",";
	$json .= "\"name\":\"" . $r["programa"] . "\",";
	$json .= "\"temas\":[" . $tema_json . "],";
	$json .= "\"data\":{";
		$json .= "\"Área temática\":\"" . $r["rubro"] . "\",";
		$json .= "\"Tema\":\"" . $r["categoria"] . "\",";
		$json .= "\"Responsable de Ejecución\":\"" . $r["resp_ejecucion"] . "\",";
		//$json .= "\"Etapa\":\"" . $r["etapa"] . "\",";
		$json .= "\"Instituciones intervinientes\":\"" . $r["instituciones_interv"] . "\",";
		$json .= "\"Responsable&nbsp;del&nbsp;estudio&nbsp;más&nbsp;reciente\":\"" . $r["responsable"] . "\",";
		/*$json .= "\"Estado\":\"" . $r["estado"] . "\",";*/
		$json .= "\"Descripción\":\"" . $r["descripcion"] . "\",";
		$json .= "\"Recursos Asociados\":\"<a href='" . $r["recursos_asociados"] . "' target='_blank' ><img height='24' width='24' src='./images/icono-mediateca-relleno.png' alt='Ver recursos asociados'/> </a> \"";
	$json .= "}";
	$json .= ",\"subprogramas\":[";
	
	$sp_query_string = "SELECT pr.*,";
	$sp_query_string .= "(";
		$sp_query_string .= "SELECT string_agg(tema_id::text, ',') ";
		$sp_query_string .= "FROM mod_catalogo.temas_programas tp ";
		$sp_query_string .= "WHERE programa_id = pr.programa_id";
	$sp_query_string .= ") AS temas_id";
	//$sp_query_string .= " FROM mod_catalogo.vw_programas_subprogramas pr WHERE programa_id_parent = " . $r["programa_id"] . " ORDER BY programa_id ASC, programa ASC";
	if ($tema_id) 
	{
		$sp_query_string .= " FROM mod_catalogo.vw_programas_subprogramas pr WHERE programa_id_parent = " . $r["programa_id"];
		$sp_query_string .= " AND pr.programa_id IN (SELECT programa_id FROM mod_catalogo.temas_programas WHERE tema_id = $tema_id) ";
		$sp_query_string .= " ORDER BY programa_id ASC, programa ASC";
	}
	else
	{
		$sp_query_string .= " FROM mod_catalogo.vw_programas_subprogramas pr WHERE programa_id_parent = " . $r["programa_id"] . " ORDER BY programa_id ASC, programa ASC";
	};
	
	
	$sp_query = pg_query($conn,$sp_query_string);
	
	$has_sp = false;
	
	while($sp = pg_fetch_assoc($sp_query)) {
	
		$has_sp = true;
		
		/*******************************************************************************/
		
		$tema_json_suprograma = "";
	
		$temas_id_sp = explode(",",$sp["temas_id"]);
		for ($i=0; $i<sizeof($temas_id_sp); $i++) { $temas_id_sp[$i] = trim($temas_id_sp[$i]); }
	
		$subpro_tema_id_string = "SELECT tema_id,tema_nombre FROM mod_catalogo.temas WHERE tema_id IN('" . implode("','",$temas_id_sp) . "')";
		$subpro_query_tema_id = pg_query($conn,$subpro_tema_id_string);
	
		while ($tsp = pg_fetch_assoc($subpro_query_tema_id)) 
		{
		
			$tema_json_suprograma .= "{";
			$tema_json_suprograma .= "\"id\":" . $tsp["tema_id"] . ",";
			$tema_json_suprograma .= "\"nombre\":\"" . $tsp["tema_nombre"] . "\"";
			$tema_json_suprograma .= "},";
		
		};
	
		$tema_json_suprograma = substr($tema_json_suprograma,0,strlen($tema_json_suprograma)-1);
		
		/*******************************************************************************/
	
		$json .= "{";
		$json .= "\"programa_id\":\"" . $sp["programa_id"] . "\",";
		$json .= "\"id\":\"" . $sp["id"] . "\",";
		$json .= "\"name\":\"" . $sp["programa"] . "\",";
		/*$json .= "\"temas\":[" . $tema_json . "],";*/
		$json .= "\"temas\":[" . $tema_json_suprograma . "],";
		$json .= "\"data\":{";
			$json .= "\"Área temática\":\"" . $sp["rubro"] . "\",";
			$json .= "\"Tema\":\"" . $sp["categoria"] . "\",";
			$json .= "\"Responsable de Ejecución\":\"" . $sp["resp_ejecucion"] . "\",";
			$json .= "\"Instituciones intervinientes\":\"" . $sp["instituciones_interv"] . "\",";
			$json .= "\"Responsable&nbsp;del&nbsp;estudio&nbsp;más&nbsp;reciente\":\"" . $sp["responsable"] . "\",";
			/*$json .= "\"Estado\":\"" . $sp["estado"] . "\",";*/
			$json .= "\"Descripción\":\"" . $sp["descripcion"] . "\",";
			

			if ($r["recursos_asociados"]!='NULL')
			{
				$json .= "\"Recursos Asociados\":\"<a href='" . $sp["recursos_asociados"] . "' target='_blank' ><img height='24' width='24' src='./images/icono-mediateca-relleno.png' alt='Ver recursos asociados'/> </a> \"";
			}
			else
			{
				$json .= "\"Recursos Asociados\":\"Sin recursos asociados.\"";
			};
			//$json .= "\"Rubro\":\"" . $sp["rubro"] . "\",";
			//$json .= "\"Categoría\":\"" . $sp["categoria"] . "\",";
			//$json .= "\"Etapa\":\"" . $sp["etapa"] . "\",";
			//$json .= "\"Instituciones intervinientes\":\"" . $sp["instituciones_interv"] . "\",";
			//$json .= "\"Responsable\":\"" . $sp["respons_nom"] . "\"";
			$json .= "}";
		$json .= "},";
	
	}
//	$json .= "\"id\":\"" . $r["id"] . "\",";
	if ($has_sp) { $json = substr($json,0,strlen($json)-1); }
	
	$json .= "]";
	$has_sp_str = $has_sp ? 'true' : 'false';
	$json .= ",\"Hassp\":".$has_sp_str;
	$json .= "},";
}

$json = substr($json,0,strlen($json)-1);
$json .= "]}";

echo $json;

pg_close($conn);

?>
