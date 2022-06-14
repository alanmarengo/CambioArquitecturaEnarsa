<?php


include_once('./pgconfig.php');


function draw_tab_datos($dt_id)
{
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
	$conn = pg_connect($string_conn);

	$buffer = '';
	
	$SQL = "SELECT dt_tabla FROM sinia_dataset.dt WHERE dt_id=$dt_id limit 1";

	$recordset = pg_query($conn,$SQL);

	$row = pg_fetch_assoc($recordset);

	//echo pg_last_error($conn);

	$SQL = "SELECT * FROM ".$row['dt_tabla'];

	$recordset = pg_query($conn,$SQL);
		

	$buffer .= '"tab_datos":'.SQL_JSON($recordset);
	
	pg_close($conn);

	return $buffer;
	
};

function draw_tab_graficos($dt_id)
{
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
	$conn = pg_connect($string_conn);
	
	$fflag = false;

	$buffer = '';
	
	$SQL  = "SELECT G.grafico_id,DG.orden,G.grafico_titulo,G.grafico_desc ";
	$SQL .= "FROM sinia_dataset.dt_grafico DG INNER JOIN sinia_graficos.grafico G ON DG.grafico_id=G.grafico_id ";
        $SQL .= "WHERE dt_id=$dt_id order by orden asc;";

	$recordset = pg_query($conn,$SQL);

	$row = pg_fetch_assoc($recordset);
	
	$buffer = '"tab_graficos":[';
	
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
		$buffer .= '"id":"'	.$row['grafico_id'].'",';
		$buffer .= '"nombre":"'	.$row['grafico_titulo'].'",';
		$buffer .= '"desc":"'	.$row['grafico_desc'].'",';
		$buffer .= '"link":"./get_grafico.php?grafico_id='.$row['grafico_id'].'"';
		$buffer .= '}';

		$row =  pg_fetch_assoc($recordset);
	};
	
	$buffer .= ']';
	
	pg_close($conn);

	return $buffer;
	
};

function draw_tab_geovisor($dt_id)
{
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
	$conn = pg_connect($string_conn);

	$buffer = '';
	
	$SQL = "SELECT COUNT(*) AS total_capas FROM sinia_dataset.dt_layer WHERE dt_id=$dt_id";

	$recordset = pg_query($conn,$SQL);

	$row = pg_fetch_assoc($recordset);


	if($row['total_capas']>0)
	{
		$tc = $row['total_capas'];
	}
	else
	{
		$tc = 0;
	};
	
	$buffer = '"tab_geovisor":{"total_Capas":"'.$tc.'","link":"./ext_geovisor.php?dt_id='.$dt_id.'"}';	

	pg_close($conn);

	return $buffer;
};

function draw_tab_metadatos($dt_id)
{
	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
	$conn = pg_connect($string_conn);
	
	$fflag = false;

	$buffer = '';
	
	//$SQL  = "SELECT dt_fecha_d,dt_fecha_hasta,dt_link_metadata,dt_fecha_ultima_act,dt_fuente,dt_link_interes,dt_path_img_metada ";
	$SQL  = "SELECT dt_fecha_d,dt_fecha_hasta,dt_link_metadata,dt_fecha_ultima_act,dt_fuente,dt_link_interes,dt_path_img_metada,dt_titulo,dt_desc ";
	$SQL .= "FROM sinia_dataset.dt WHERE dt_id=$dt_id;";

	$recordset = pg_query($conn,$SQL);

	$row = pg_fetch_assoc($recordset);
	
	$buffer .= '"tab_metadatos":{';
	$buffer .= '"fecha_desde":"'		.$row['dt_fecha_d'].'",';
	$buffer .= '"fecha_hasta":"'		.$row['dt_fecha_hasta'].'",';
	$buffer .= '"fecha_ultima_act":"'	.$row['dt_fecha_ultima_act'].'",';
	$buffer .= '"fuente":"'			.$row['dt_fuente'].'",';
	$buffer .= '"link_interes":"'		.$row['dt_link_interes'].'",';
	$buffer .= '"image":"'			.$row['dt_path_img_metada'].'",';
	$buffer .= '"titulo":"'			.$row['dt_titulo'].'",';
	$buffer .= '"descripcion":"'		.$row['dt_desc'].'",';
	$buffer .= '"link_url_metadatos":"'	.$row['dt_link_metadata'].'"';
	$buffer .= '}';

	pg_close($conn);

	return $buffer;
	
};


function get_tabs($dt_id)
{
	$buffer = '{';
	
	$buffer .= draw_tab_datos($dt_id).',';
	$buffer .= draw_tab_graficos($dt_id).',';
	$buffer .= draw_tab_geovisor($dt_id).',';
	$buffer .= draw_tab_metadatos($dt_id);

	$buffer .= '}';

	echo $buffer;
};




function SQL_JSON($recordset)
{
			
            		$json = '';	
			$json.= "{";
				
 			$TotalColum = pg_num_fields($recordset);
 
  			$json.= '"columnas":[';
  
  			for ($index = 0; $index < $TotalColum; $index++) 
  			{
				if($index<>0) {$json.= ",";}; 
				$fieldname = pg_field_name($recordset, $index);
				$json.= '"'.$fieldname.'"';
  			};
  
  			$json.= "],";//Fin Columnas
  
  			$json.= '"recordset":[';
  
  			$flagFirstSeparator = true;
  
  			while ($row = pg_fetch_row($recordset)) 
  			{
  	
				if($flagFirstSeparator)
   				{
   	 			 $json.= "[";
   	 			 $flagFirstSeparator = false;
   				}else $json.= ",[";
   
  				for ($index = 0; $index < $TotalColum; $index++) 
  				{
  					if($index<>0) {$json.= ",";}; 
 	 				$json.= '"'.$row[$index].'"';
  				};
  				
				$json.= "]";
  			};
  
  			$json.= ']';//FIN Recordset
  
  			$json.= "}";
			
			return ($json);
				
};



//get_tabs($dt_id);

?>

















