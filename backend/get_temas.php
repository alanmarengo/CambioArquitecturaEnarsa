<?php

include_once('./pgconfig.php');

function draw_datasets($subtema_id)
{
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
	$conn = pg_connect($string_conn);

	$fflag = false;

	$buffer = '';
	
	$SQL = "SELECT dt_id,dt_titulo FROM sinia_dataset.vw_datasets WHERE subtema_id=$subtema_id";

	$recordset = pg_query($conn,$SQL);

	$row = pg_fetch_assoc($recordset);

	//echo pg_last_error($conn);

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
		$buffer .= '"id":"'	.$row['dt_id'].'",';
		$buffer .= '"nombre":"'	.$row['dt_titulo'].'"';
		$buffer .= '}';

		$row =  pg_fetch_assoc($recordset);
	};
	
	
	pg_close($conn);

	return $buffer;
	
};


function get_temas($tema_id)
{
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
	$conn = pg_connect($string_conn);

	$fflag = false;
	
	//$SQL = "SELECT DISTINCT tema_id,tema_nombre,tema_desc,tema_img_path,subtema_id,subtema_titulo,tema_ui_id 
	//FROM sinia_dataset.vw_datasets WHERE tema_ui_id=$tema_id";

	//$SQL = "SELECT DISTINCT tema_id,tema_nombre,tema_desc,tema_img_path,subtema_id,subtema_titulo,tema_ui_id ";
	//$SQL .= "FROM sinia_dataset.vw_datasets WHERE tema_id=$tema_id";

	$SQL = "SELECT DISTINCT tema_id,tema_nombre,tema_desc,tema_img_path,subtema_id,subtema_titulo,tema_ui_id ";
	$SQL .= "FROM sinia_dataset.vw_temas_ficha WHERE tema_id=$tema_id";

	$recordset = pg_query($conn,$SQL);

	$row = pg_fetch_assoc($recordset);

	$tt = pg_query($conn,"select * from sinia_catalogo.vw_temas_total WHERE tema_id=$tema_id limit 1;");

	$row_t = pg_fetch_assoc($tt);
	//echo pg_last_error($conn);

	$buffer = '{';
	$buffer .= '"id":"'		.$row['tema_id'].'",';
	$buffer .= '"nombre":"'		.$row['tema_nombre'].'",';
	$buffer .= '"info":{';
	$buffer .= '"titulo":"'		.$row['tema_nombre'].'",';
	$buffer .= '"descripcion":"'	.$row['tema_desc'].'",';
	$buffer .= '"imagen":"'		.$row['tema_img_path'].'",';
	$buffer .= '"datasets":"'	.$row_t['total_datasets'].'",';
	$buffer .= '"mapas":"'		.$row_t['total_mapas'].'",';
	$buffer .= '"recursos":"'	.$row_t['total_recursos'].'",';
	$buffer .= '"id_db":"'		.$row['tema_id'].'"';
	$buffer .= '},';

	$buffer .= '"subtemas":[';

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
		$buffer .= '"id":"'	.$row['subtema_id'].'",';
		$buffer .= '"nombre":"'	.$row['subtema_titulo'].'",';
		$buffer .= '"datasets":[';
		$buffer .= draw_datasets($row['subtema_id']);
		$buffer .= ']';
		$buffer .= '}';

		$row =  pg_fetch_assoc($recordset);
	};

	$buffer .= ']';
	$buffer .= '}';
	
	
	pg_close($conn);

	echo $buffer;
	
};		 

?>

















