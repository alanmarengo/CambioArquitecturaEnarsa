<?php



header('Content-Type: application/json');

include("./pgconfig.php");

$tema_id_ = $_REQUEST["tema_id"];

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;

$conn = pg_connect($string_conn);

$SQL = "SELECT tema_id,tema_nombre,tema_desc,tema_ficha_path,geovisor,geovisor_mini,recursos_asociados FROM mod_catalogo.temas WHERE tema_id=$tema_id_";

$recordset = pg_query($conn,$SQL);

function draw_tupla($row)
{
       echo '{';
       echo '"tema_id":"'.$row[0].'",';
       echo '"tema_nombre":"'.$row[1].'",';
       echo '"tema_desc":"'.$row[2].'",';
       echo '"tema_ficha_path":"'.$row[3].'",';
       echo '"tema_geovisor":"'.$row[4].'",';
       echo '"tema_minigeovisor":"'.$row[5].'",';
       echo '"tema_recursos_asociados":"'.$row[6].'",';
       echo '"tema_imagenes":';draw_imagenes();
       echo '}';
       
       return true;
};

function draw_imagenes()
{
      	global $conn;
	global $tema_id_;
	
	$SQL = "SELECT tema_id,recurso_path_url,recurso_id FROM mod_catalogo.vw_temas_imagenes WHERE tema_id=$tema_id_";
      
	$recordset = pg_query($conn,$SQL);
	
	$fflag = false;

	echo "[";

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
  
  		echo "\"".limpiar_global($row[1])."\"";
  
  		$row = pg_fetch_row($recordset);//NEXT
	};

	echo "]";

      return true;
};

$fflag = false;

echo "[";

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

echo "]";

pg_close($conn);


?>
