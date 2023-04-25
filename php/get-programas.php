<?php

// include("../pgconfig.php");
// include("../tools.php");

require_once(dirname(__FILE__,2).'/MICROSERVICIOS/MIC-CATALOGO/CAPA-APLICACION/SERVICIO/REPOSITORIO-SERVICIO.php');


//header('Content-Type: application/json');

//$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
//$conn = pg_connect($string_conn);

$tema_id = false;

//$_GET["tema_id"] = 15;

if (isset($_GET["tema_id"])) {
	
	$tema_id = $_GET["tema_id"];
	
}

$json = "{\"programas\":[";


$query_string = <<<EOD
					SELECT pr.*,(SELECT string_agg(tema_id::text, ',')
					FROM "MIC-CATALOGO".temas_programas tp
					WHERE programa_id = pr.programa_id) AS temas_id 
	EOD;
	
	/*
	$query_string = "SELECT pr.*,";
	$query_string .= "(";
		$query_string .= "SELECT string_agg(tema_id::text, ',') ";
		$query_string .= "FROM mod_catalogo.temas_programas tp ";
		$query_string .= "WHERE programa_id = pr.programa_id";
	$query_string .= ") AS temas_id";   */

if ($tema_id) 
{
	//$query_string .= " FROM mod_catalogo.vw_programas_subprogramas pr WHERE programa_id_parent = -1  AND " . $tema_id . " IN (SELECT tema_id FROM mod_catalogo.temas_programas WHERE programa_id = pr.programa_id)";
	
	$query_string .= <<<EOD
	
			FROM "MIC-CATALOGO".vw_programas_subprogramas pr WHERE programa_id_parent = -1   
			AND pr.programa_id IN 
			(SELECT CASE WHEN programa_id_parent=-1 THEN programa_id ELSE programa_id_parent END AS programa_id_ 
			FROM "MIC-CATALOGO".vw_programas_subprogramas  
			WHERE programa_id IN(SELECT programa_id FROM "MIC-CATALOGO".temas_programas WHERE tema_id = $tema_id)) 

	EOD;
	
	/*
	$query_string .= " FROM mod_catalogo.vw_programas_subprogramas pr WHERE programa_id_parent = -1  ";
	$query_string .= " AND pr.programa_id IN (";
	$query_string .= " SELECT CASE WHEN programa_id_parent=-1 THEN programa_id ELSE programa_id_parent END AS programa_id_  ";
	$query_string .= " FROM mod_catalogo.vw_programas_subprogramas ";
	$query_string .= " WHERE programa_id IN(SELECT programa_id FROM mod_catalogo.temas_programas WHERE tema_id = $tema_id))"; */
	
}
else
{
	$query_string .= ' FROM "MIC-CATALOGO".vw_programas_subprogramas pr	WHERE programa_id_parent = -1 ';
}

$query_string .= " ORDER BY programa_id ASC, programa ASC";

// echo $query_string;

$servicio_catalogo = new RepositorioServicioCatalogo();

//$query = pg_query($conn,$query_string);

$r = $servicio_catalogo->get_consulta($query_string);

$puntero = 0;
while($r) {		
		
	$tema_json = "";
	
	$temas_id = explode(",",$r[$puntero]["temas_id"]);
	for ($i=0; $i<sizeof($temas_id); $i++) { $temas_id[$i] = trim($temas_id[$i]); }
	
	$query_tema_id_string = 'SELECT tema_id,tema_nombre FROM "MIC-CATALOGO".temas WHERE tema_id IN('. implode(",",$temas_id) .")";
	#$query_tema_id = pg_query($conn,$query_tema_id_string);

	//REEMPLACE EL CODIGO COMENTADO MAS ABAJO POR ESTE BLOQUE DE CODIGO
	
	//echo $query_tema_id_string;

	//$result = pg_query($conn,$query_tema_id_string);
	
	$result = $servicio_catalogo->get_consulta($query_tema_id_string);

	if (!$result) {
	//		 $tema_json .= "{";
	//                 $tema_json .= "\"id\":0,";
	//                 $tema_json .= "\"nombre\":\"\"";
	//                 $tema_json .= "},";
	}else{
		$arr = $result;
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
	$json .= "\"programa_id\":\"" . $r[$puntero]["programa_id"] . "\",";
	$json .= "\"id\":\"" . $r[$puntero]["id"] . "\",";
	$json .= "\"name\":\"" . $r[$puntero]["programa"] . "\",";
	$json .= "\"temas\":[" . $tema_json . "],";
	$json .= "\"data\":{";
		$json .= "\"Área temática\":\"" . $r[$puntero]["rubro"] . "\",";
		$json .= "\"Tema\":\"" . $r[$puntero]["categoria"] . "\",";
		$json .= "\"Responsable de Ejecución\":\"" . "\","; //. $r[$puntero]["resp_ejecucion"] . falta agregar este dato cuando la vista este completa 
		//$json .= "\"Etapa\":\"" . $r["etapa"] . "\",";
		$json .= "\"Instituciones intervinientes\":\"" . $r[$puntero]["instituciones_interv"] . "\",";
		$json .= "\"Responsable&nbsp;del&nbsp;estudio&nbsp;más&nbsp;reciente\":\"" . $r[$puntero]["responsable"] . "\",";
		/*$json .= "\"Estado\":\"" . $r[$puntero]["estado"] . "\",";*/
		$json .= "\"Descripción\":\"" . $r[$puntero]["descripcion"] . "\",";
		$json .= "\"Recursos Asociados\":\"<a href='" . $r[$puntero]["recursos_asociados"] . "' target='_blank' ><img height='24' width='24' src='./images/icono-mediateca-relleno.png' alt='Ver recursos asociados'/> </a> \"";
	$json .= "}";
	$json .= ",\"subprogramas\":[";


	



	$sp_query_string = <<<EOD

					SELECT pr.*,(SELECT string_agg(tema_id::text, ',') 
					FROM "MIC-CATALOGO".temas_programas tp 
					WHERE programa_id = pr.programa_id) AS temas_id 
	EOD;

		/*
	$sp_query_string = "SELECT pr.*,";
	$sp_query_string .= "(";
		$sp_query_string .= "SELECT string_agg(tema_id::text, ',') ";
		$sp_query_string .= "FROM mod_catalogo.temas_programas tp ";
		$sp_query_string .= "WHERE programa_id = pr.programa_id";
	$sp_query_string .= ") AS temas_id"; */
	//$sp_query_string .= " FROM mod_catalogo.vw_programas_subprogramas pr WHERE programa_id_parent = " . $r[$puntero]["programa_id"] . " ORDER BY programa_id ASC, programa ASC";
	
	if ($tema_id) 
	{
		$sp_query_string .= <<<EOD

							FROM "MIC-CATALOGO".vw_programas_subprogramas pr 
							WHERE programa_id_parent =  {$r[$puntero]["programa_id"]}
							AND pr.programa_id IN (SELECT programa_id FROM "MIC-CATALOGO".temas_programas WHERE tema_id = 11)
							ORDER BY programa_id ASC, programa ASC
		EOD;

		/*
		$sp_query_string .= " FROM mod_catalogo.vw_programas_subprogramas pr WHERE programa_id_parent = " . $r[$puntero]["programa_id"];
		$sp_query_string .= " AND pr.programa_id IN (SELECT programa_id FROM mod_catalogo.temas_programas WHERE tema_id = $tema_id) ";
		$sp_query_string .= " ORDER BY programa_id ASC, programa ASC"; */
	}
	else
	{
		$sp_query_string .= ' FROM "MIC-CATALOGO".vw_programas_subprogramas pr WHERE programa_id_parent = ' . $r[$puntero]["programa_id"] . " ORDER BY programa_id ASC, programa ASC";
	};

	echo $sp_query_string;
	
	//$sp_query = pg_query($conn,$sp_query_string);
	
	$result_sp = $servicio_catalogo->get_consulta($sp_query_string);

	$has_sp = false;

	if($result_sp)
	{
		foreach($result_sp as $sp) 
		{	
			$has_sp = true;
			
			/*******************************************************************************/
			
			$tema_json_suprograma = "";
		
			$temas_id_sp = explode(",",$sp["temas_id"]);
			for ($i=0; $i<sizeof($temas_id_sp); $i++) { $temas_id_sp[$i] = trim($temas_id_sp[$i]); }
		
			$subpro_tema_id_string = 'SELECT tema_id,tema_nombre FROM "MIC-CATALOGO".temas WHERE tema_id IN('.implode(",",$temas_id_sp).")";
			
			//$subpro_query_tema_id = pg_query($conn,$subpro_tema_id_string);
			
			$result_tema = $servicio_catalogo->get_consulta($subpro_query_tema_id);

			foreach ($result_tema as $tsp) 
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
	}
	
	


	//	$json .= "\"id\":\"" . $r["id"] . "\",";
	if ($has_sp) { $json = substr($json,0,strlen($json)-1); }
	
	$json .= "]";
	$has_sp_str = $has_sp ? 'true' : 'false';
	$json .= ",\"Hassp\":".$has_sp_str;
	$json .= "},";





	$puntero++;

}

$json = substr($json,0,strlen($json)-1);
$json .= "]}";

echo $json;

//pg_close($conn);

?>
