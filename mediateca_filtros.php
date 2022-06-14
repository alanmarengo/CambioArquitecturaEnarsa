<?php

header('Content-Type: application/json');

include("./pgconfig.php");

/*
 * {
 *  [
 *                  {
 *                      "filtro_nombre":'',
 *                      "filtro_id":0,
 *                      "valor_id":
 *                      "valor_desc":
 *                      "parent_filtro_id":
 *                      "parent_valor_id":
 *                  }
 *                  ,
 *                  {
 *                      "filtro_nombre":'',
 *                      "filtro_id":0,
 *                      "valor_id":
 *                      "valor_desc":
 *                      "parent_filtro_id":
 *                      "parent_valor_id":
 *                  }
 *                  ,
 *                  n..
 *   ]
 * }
 * */

//$conn = pg_connect("host=localhost port=5432 dbname=ahrsc user=postgres password=plahe100%");

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;
	
$conn = pg_connect($string_conn);

$SQL = "SELECT * FROM mod_catalogo.vw_filtros_values ORDER BY filtro_id,valor_desc ASC";

$recordset = pg_query($conn,$SQL);

function draw_tupla($row)
{
       echo '{';
       echo '"filtro_nombre":"'.$row[0].'",';
       echo '"filtro_id":"'.$row[1].'",';
       echo '"valor_id":"'.$row[2].'",';
       echo '"valor_desc":"'.$row[3].'",';
       echo '"parent_filtro_id":"'.$row[4].'",';
       echo '"parent_valor_id":"'.$row[5].'"';
       echo '}';
       
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
