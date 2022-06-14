<?php

	include_once('./pgconfig.php');
	
	header('Content-Type: application/json');

	$origen_id 		= $_REQUEST['origen_id'];
	$origen_id_propio 	= $_REQUEST['origen_id_propio'];
	//$tema_id		= $_REQUEST['tema_id']; /* No se requiere más */

	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
	$conn = pg_connect($string_conn);

	switch($origen_id)
	{
		case /* DST */ 2: 
				$SQL  = "SELECT T.tema_id,T.tema_nombre,DST.subtema_id::BIGINT,S.subtema_titulo FROM sinia_dataset.dt_subtem DST ";
				$SQL .= "INNER JOIN sinia_catalogo.subtema S ON S.subtema_id=DST.subtema_id ";
				$SQL .= "INNER JOIN sinia_catalogo.tema T ON S.tema_id=t.tema_id ";
				$SQL .= "WHERE dt_id=$origen_id_propio"; /* AND S.tema_id=$tema_id"; */ break;
		case /* GIS */ 3: 
				$SQL  = "SELECT T.tema_id,T.tema_nombre,DST.subtema_id::BIGINT,S.subtema_titulo FROM sinia_geovisor.layer_subtema DST ";
				$SQL .= "INNER JOIN sinia_catalogo.subtema S ON S.subtema_id=DST.subtema_id ";
				$SQL .= "INNER JOIN sinia_catalogo.tema T ON S.tema_id=t.tema_id ";
				$SQL .= "WHERE layer_id=$origen_id_propio"; /* AND S.tema_id=$tema_id"; */ break;
	
	};

	$fflag = false;

	$buffer = '[';
	
	$recordset = pg_query($conn,$SQL);

	$row = pg_fetch_assoc($recordset);

	//echo pg_last_error($conn);
	//echo $SQL;

	while($row)
	{

		if ($fflag)
  		{
      			$buffer .= ',';
  		}
  		else
  		{
      			$fflag = true;
  		};		

  		$buffer .= '{';
		$buffer .= '"tema_id":"'	.$row['tema_id'].'",';
		$buffer .= '"tema_titulo":"'	.$row['tema_nombre'].'",';
		$buffer .= '"subtema_id":"'	.$row['subtema_id'].'",';
		$buffer .= '"subtema_titulo":"'	.$row['subtema_titulo'].'"';
		$buffer .= '}';

		$row =  pg_fetch_assoc($recordset);
	};
	
	
	$buffer .= ']';
	
	pg_close($conn);

	echo $buffer;
	

?>







