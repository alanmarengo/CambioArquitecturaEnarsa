<?php

	include_once('./pgconfig.php');
	
	header('Content-Type: application/json');


	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
	$conn = pg_connect($string_conn);

	$SQL  = "SELECT * FROM sinia_catalogo.vw_temas_total";
	
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
		$buffer .= '"numero":"'		.$row['tema_id'].'",';
		$buffer .= '"nombre":"'		.$row['tema_nombre'].'",';
		$buffer .= '"datasets":"'	.$row['total_datasets'].'",';
		$buffer .= '"mapas":"'		.$row['total_mapas'].'",';
		$buffer .= '"recursos":"'	.$row['total_recursos'].'"';
		$buffer .= '}';

		$row =  pg_fetch_assoc($recordset);
	};
	
	
	$buffer .= ']';
	
	pg_close($conn);

	echo $buffer;
	

?>







