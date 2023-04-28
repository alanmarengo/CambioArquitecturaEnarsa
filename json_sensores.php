<?php

header('Content-Type: application/json');
require_once(dirname(__FILE__).'/MICROSERVICIOS/MIC-SENSORES/CAPA-APLICACION/SERVICIO/REPOSITORIO-SERVICIO.php');


//include("./pgconfig.php");

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

//$string_conn = "host=" . pg_server . " user=" . pg_user . " port=" . pg_portv . " password=" . pg_password . " dbname=" . pg_db;

//$conn = pg_connect($string_conn);

//$conn = pg_connect("host=localhost port=5432 dbname=ahrsc user=postgres password=plahe100%");

$SQL = " select * from datos.get_sensores_data_index();";

$servicio_sensores = new RepositorioServicioSensores();

//$recordset = pg_query($conn,$SQL);

//$result = $servicio_sensores->json_sensores();

//echo $SQL;
//$recordset = $servicio_sensores->get_consulta('set datestyle to "ISO, DMY"');

$recordset = $servicio_sensores->get_consulta($SQL);

function draw_tupla($row)
{
       echo '{';
       echo '"estacion":"'.$row["estacion"].'",';
       echo '"dato_nombre":"'.$row["dato_nombre"].'",';
       echo '"dato":"'.$row["dato"].'",';
       echo '"maximo":"'.$row["maximo"].'",';
       echo '"minimo":"'.$row["minimo"].'",';
       echo '"media":"'.$row["media"].'",';
       echo '"ultima_act":"'.$row["ultima_act"].'",';
       echo '"fecha_inicial":"'.$row["fecha_menos_30"].'",';
       echo '"unidad":"'.$row["unidad"].'",';
       echo '"tipo":"'.$row["tipo_sensor"].'"';
       echo '}';
       
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
