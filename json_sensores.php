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

$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;

$conn = pg_connect($string_conn);

//$conn = pg_connect("host=localhost port=5432 dbname=ahrsc user=postgres password=plahe100%");

$SQL = "SELECT estacion, dato_nombre, dato, maximo, minimo, to_char(media::float, 'FM999999990.00') as media, ultima_act,unidad,tipo_sensor,(ultima_act::date-30) AS fecha_menos_30 FROM mod_sensores.vw_sensores_data_index WHERE dato IS NOT NULL ORDER BY estacion ASC";

$recordset = pg_query($conn,$SQL);

function draw_tupla($row)
{
       echo '{';
       echo '"estacion":"'.$row[0].'",';
       echo '"dato_nombre":"'.$row[1].'",';
       echo '"dato":"'.$row[2].'",';
       echo '"maximo":"'.$row[3].'",';
       echo '"minimo":"'.$row[4].'",';
       echo '"media":"'.$row[5].'",';
       echo '"ultima_act":"'.$row[6].'",';
       echo '"fecha_inicial":"'.$row[9].'",';
       echo '"unidad":"'.$row[7].'",';
       echo '"tipo":"'.$row[8].'"';
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
