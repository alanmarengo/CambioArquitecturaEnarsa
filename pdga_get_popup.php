<?php

header('Content-Type: application/json');

//include("./pgconfig.php");
require_once(dirname(__FILE__).'/MICROSERVICIOS/MIC-CATALOGO/CAPA-APLICACION/SERVICIO/REPOSITORIO-SERVICIO.php');


$_REQUEST["tema_id"] = 3;

//global $tema_id_;
$tema_id_ = $_REQUEST["tema_id"];

//$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;

//$conn = pg_connect($string_conn);

$SQL = 'SELECT tema_id,tema_nombre,tema_desc,tema_ficha_path,geovisor,geovisor_mini,recursos_asociados 
        FROM "MIC-CATALOGO".temas WHERE tema_id='.$tema_id_;

//global $servicio_catalogo;
$servicio_catalogo = new RepositorioServicioCatalogo();

//$recordset = pg_query($conn,$SQL);

$recordset = $servicio_catalogo->get_consulta($SQL);



function draw_tupla($row)
{
       echo '{';
       echo '"tema_id":"'.$row["tema_id"].'",';
       echo '"tema_nombre":"'.$row["tema_nombre"].'",';
       echo '"tema_desc":"'.$row["tema_desc"].'",';
       echo '"tema_ficha_path":"'.$row["tema_ficha_path"].'",';
       echo '"tema_geovisor":"'.$row["geovisor"].'",';
       echo '"tema_minigeovisor":"'.$row["geovisor_mini"].'",';
       echo '"tema_recursos_asociados":"'.$row["recursos_asociados"].'",';
       echo '"tema_imagenes":';draw_imagenes($row["tema_id"]);
       echo '}';
       
       return true;
};

function draw_imagenes($tema_id_)
{

    //global $conn;
	  //global $tema_id_;
	
	$SQL_img = 'SELECT tema_id,recurso_path_url,recurso_id FROM "MIC-CATALOGO".vw_temas_imagenes WHERE tema_id='.$tema_id_;
      
	//$recordset = pg_query($conn,$SQL);
	
	$fflag = false;

	echo "[";
  
  $recordset_img = $servicio_catalogo->get_consulta($SQL_img);

	$row = pg_fetch_row($recordset_img);

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
  
  		echo "\"".limpiar_global($row[1])."\"";
  
  		$row = pg_fetch_row($recordset);//NEXT
	};

	echo "]";

      return true;
};

$fflag = false;

echo "[";

//$row = pg_fetch_row($recordset);

foreach($recordset as $row) 
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
  
  //$row = pg_fetch_row($recordset);//NEXT
};

echo "]";

//pg_close($conn);


?>
