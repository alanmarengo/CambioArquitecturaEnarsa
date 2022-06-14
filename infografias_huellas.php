<?php

	include_once("./pgconfig.php");

	$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;

	$con = pg_connect($string_conn);
	
	$SQL  = "SELECT r.recurso_path_url,f.desc,f.tema,r.recurso_id,lower(right(r.recurso_path_url,3))AS extension,''::text AS categoria, ";
	$SQL .= "CASE  ";
	$SQL .= "	WHEN f.tema = 'Infografía Arqueología' THEN 1  ";
	$SQL .= "	WHEN f.tema = 'Infografía Paleontología' THEN 2 ";
	$SQL .= "	WHEN f.tema = 'Infografía Geología' THEN 3 ";
	$SQL .= "END AS orden ";
	$SQL .= "FROM  mod_mediateca.recurso r INNER JOIN mod_mediateca.fotos_participacion f ";
	$SQL .= "ON f.recurso_id::bigint=r.recurso_id ";
	$SQL .= "WHERE f.tema IN ('Infografía Arqueología','Infografía Paleontología','Infografía Geología') ";
	$SQL .= "ORDER BY orden ASC;";
	

	$recordset = pg_query($con,$SQL);

	function draw_tupla_info($row)
	{
		   echo '[';
		   echo '"'.$row[0].'",'; /* infografia caja */
		   echo '"'.$row[0].'"';  /* infografia popup, en este caso es la misma columna */
		   echo ']';
		   
		   return true;
	};

	$fflag = false;

	echo "infografias = [";

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
	  
	  draw_tupla_info($row);
	  
	  $row = pg_fetch_row($recordset);//NEXT
	};

	echo "];";


	pg_close($con);


?>

