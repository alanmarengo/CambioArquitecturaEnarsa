<?php

include("./pgconfig.php");

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;

 $con = pg_connect($string_conn);

	$SQL  = "SELECT r.recurso_path_url,f.desc,f.tema,r.recurso_id,lower(right(r.recurso_path_url,3))AS extension FROM  mod_mediateca.recurso r INNER JOIN mod_mediateca.fotos_participacion f ";
	$SQL .= "ON f.recurso_id::bigint=r.recurso_id ";
	$SQL .= "WHERE f.tema='Participación y gestión pública' ";
	$SQL .= "ORDER BY f.tema ASC";

	$recordset = pg_query($con,$SQL);

	function draw_tupla($row)
	{
		   if ($row[4]!='mp4')
		   {
			  $tmedia = 'jpg'; 
		   }
		   else 
		   {
			   $tmedia = $row[4];
		   };
		   
		   
		   echo '{';
		   echo '"media_url":"'.$row[0].'",';
		   //echo '"media_tipo":"jpg",';
		   //echo '"media_tipo":"'.$row[4].'",';
		   echo '"media_tipo":"'.$tmedia.'",';
		   echo '"texto":"'.$row[1].'",';
		   echo '"url":"#",';
		   echo '"tag":"",';
		   echo '"tema":"'.$row[2].'"';
		   echo '}';
		   
		   return true;
	};

	$fflag = false;

	echo "var data1 = [";

	$row = pg_fetch_row($recordset);

	while($row) 
	{
	  if ($fflag)
	  {
		  echo ',';
	  }
	  else
	  {
		  $fflag = true;
	  };
	  
	  draw_tupla($row);
	  
	  $row = pg_fetch_row($recordset);//NEXT
	};

	echo "];";



	$SQL  = "SELECT r.recurso_path_url,f.desc,f.tema,r.recurso_id,lower(right(r.recurso_path_url,3))AS extension FROM  mod_mediateca.recurso r INNER JOIN mod_mediateca.fotos_participacion f ";
	$SQL .= "ON f.recurso_id::bigint=r.recurso_id ";
	$SQL .= "WHERE f.tema='Pueblos Originarios' ";
	$SQL .= "ORDER BY f.tema ASC";

	$recordset = pg_query($con,$SQL);

	$fflag = false;

	echo "var data2 = [";

	$row = pg_fetch_row($recordset);

	while($row) 
	{
	  if ($fflag)
	  {
		  echo ',';
	  }
	  else
	  {
		  $fflag = true;
	  };
	  
	  draw_tupla($row);
	  
	  $row = pg_fetch_row($recordset);//NEXT
	};

	echo "];";

	pg_close($con);


?>

